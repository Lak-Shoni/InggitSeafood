<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Keuangan;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Transaksi_Bahan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Keuangan::query();
        $notifications = Notification::where('is_read', false)->get();
        $unreadNotificationsCount = $notifications->count();

        // Sorting
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('order', 'asc'));
        }

        // Date range filtering
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        $dataKeuangan = $query->paginate(10); // Adjust the number of items per page as needed

        return view('admin.keuangan.index', compact('dataKeuangan', 'notifications', 'unreadNotificationsCount'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'omset' => 'required|numeric',
            'purchasing' => 'required|numeric',
            'tenaga_kerja' => 'required|numeric',
            'pln' => 'required|numeric',
            'akomodasi' => 'required|numeric',
            'sewa_alat' => 'required|numeric',
            'profit' => 'required|numeric',
        ]);

        Keuangan::create($request->all());

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Data keuangan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        return response()->json($keuangan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'omset' => 'required|numeric',
            'purchasing' => 'required|numeric',
            'tenaga_kerja' => 'required|numeric',
            'pln' => 'required|numeric',
            'akomodasi' => 'required|numeric',
            'sewa_alat' => 'required|numeric',
            'profit' => 'required|numeric',
        ]);

        $keuangan = Keuangan::findOrFail($id);
        $keuangan->update($request->all());

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Data keuangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Data keuangan berhasil dihapus.');
    }
    public function getOmset($date)
    {
        // Hitung total pendapatan penjualan pada tanggal tersebut
        $omset = Order::where('payment_status', 'paid')
            ->whereDate('created_at', $date)
            ->sum('total_price');

        return response()->json($omset);
    }

    public function getPurchasing($date){
        $inventarisPurchasing = Inventory::whereDate('tanggal_pembelian',$date)->sum('total_harga');
        $bahanPurchasing = Transaksi_Bahan::whereDate('tanggal_transaksi',$date)->sum('total_harga');

        $totalPurchasing = $inventarisPurchasing+$bahanPurchasing;

        return response()->json($totalPurchasing);

    }


    public function generateMonthlyReportPDF(Request $request)
    {
        $month = $request->input('month', date('m')); // Ambil bulan dari request atau gunakan bulan saat ini
        $year = $request->input('year', date('Y')); // Ambil tahun dari request atau gunakan tahun saat ini

        // Ambil data keuangan berdasarkan bulan dan tahun dari transaction_date
        $dataKeuangan = Keuangan::whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->get();

        // Buat PDF dengan menggunakan view 'admin.keuangan.rekapBulanan'
        $pdf = PDF::loadView('admin.keuangan.rekapBulanan', compact('dataKeuangan', 'month', 'year'));

        // Download PDF dengan nama file yang sesuai
        return $pdf->download("rekap_bulanan_{$year}_{$month}.pdf");
    }
}
