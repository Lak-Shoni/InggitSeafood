<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BahanMasakan;
use App\Models\Notification;
use App\Models\Transaksi;

class BahanMasakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = BahanMasakan::query();
        $notifications = Notification::where('is_read', false)->get();
        $unreadNotificationsCount = $notifications->count();

        // Sorting
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('order', 'asc'));
        }

        // Searching
        if ($request->has('search')) {
            $query->where('nama_bahan', 'like', '%' . $request->search . '%');
        }

        $bahanMasakan = $query->paginate(10); // Sesuaikan dengan jumlah data per halaman

        return view('admin.bahan_masakan.index', compact('bahanMasakan','notifications','unreadNotificationsCount'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'satuan' => 'required|string|max:255'
        ]);

        $bahanMasakan = new BahanMasakan([
            'nama_bahan' => $request->get('nama_bahan'),
            'satuan' => $request->get('satuan'),
            'bahan_masuk' => 0,
            'bahan_keluar' => 0,
            'jumlah_bahan' => 0,
        ]);
        $bahanMasakan->save();

        return response()->json([
            'success' => true,
            'message' => 'Bahan Masakan berhasil ditambahkan.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        $selectedBahan = BahanMasakan::findOrFail($id);
        $bahanMasakanList = BahanMasakan::all();
        $notifications = Notification::where('is_read', false)->get();
        $unreadNotificationsCount = $notifications->count();
        $query = Transaksi::where('bahan_masakan_id', $id);

        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('order', 'asc'));
        }

        // Date range filtering
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date]);
        }

        $transaksiList = $query->paginate(10);

        return view('admin.bahan_masakan.show', compact('selectedBahan', 'bahanMasakanList', 'transaksiList','notifications','unreadNotificationsCount'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }



    public function bahanMasuk($id)
    {
        $bahanMasakan = BahanMasakan::findOrFail($id);
        return view('admin.bahan_masakan.bahan_masuk', compact('bahanMasakan'));
    }

    public function bahanKeluar($id)
    {
        $bahanMasakan = BahanMasakan::findOrFail($id);
        return view('admin.bahan_masakan.bahan_keluar', compact('bahanMasakan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'bahan_masuk' => 'required|integer',
            'bahan_keluar' => 'required|integer',
            'jumlah_bahan' => 'required|integer',
        ]);

        $bahanMasakan = BahanMasakan::findOrFail($id);
        $bahanMasakan->nama_bahan = $request->get('nama_bahan');
        $bahanMasakan->bahan_masuk = $request->get('bahan_masuk');
        $bahanMasakan->bahan_keluar = $request->get('bahan_keluar');
        $bahanMasakan->jumlah_bahan = $request->get('jumlah_bahan');
        $bahanMasakan->save();

        return redirect()->route('admin.bahan_masakan.index')->with('success', 'Bahan Masakan Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bahanMasakan = BahanMasakan::findOrFail($id);
        $bahanMasakan->delete();

        return redirect()->route('admin.bahan_masakan.index')->with('success', 'Bahan Masakan Berhasil Dihapus');
    }

    public function storeBahanMasuk(Request $request, $id)
    {
        $request->validate([
            'bahan_masuk' => 'required|integer',
            'tanggal_transaksi' => 'required|date',
        ]);

        $bahanMasakan = BahanMasakan::findOrFail($id);
        $bahanMasakan->bahan_masuk += $request->bahan_masuk;
        $bahanMasakan->jumlah_bahan += $request->bahan_masuk;

        $transaksi = new Transaksi([
            'bahan_masakan_id' => $bahanMasakan->id,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'bahan_masuk' => $request->bahan_masuk,
            'bahan_keluar' => 0,
            'jumlah_bahan' => $bahanMasakan->jumlah_bahan,
        ]);

        $bahanMasakan->save();
        $transaksi->save();

        return response()->json(['success' => true, 'message' => 'Bahan Masakan Berhasil Dimasukkan']);
    }

    public function storeBahanKeluar(Request $request, $id)
    {
        $request->validate([
            'bahan_keluar' => 'required|integer',
            'tanggal_transaksi' => 'required|date',
        ]);

        $bahanMasakan = BahanMasakan::findOrFail($id);
        $bahanMasakan->bahan_keluar += $request->bahan_keluar;
        $bahanMasakan->jumlah_bahan -= $request->bahan_keluar;

        $transaksi = new Transaksi([
            'bahan_masakan_id' => $bahanMasakan->id,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'bahan_masuk' => 0,
            'bahan_keluar' => $request->bahan_keluar,
            'jumlah_bahan' => $bahanMasakan->jumlah_bahan,
        ]);

        $bahanMasakan->save();
        $transaksi->save();

        return response()->json(['success' => true, 'message' => 'Bahan Masakan Berhasil Dikeluarkan']);
    }
}
