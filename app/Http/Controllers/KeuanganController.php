<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index(Request $request)
{
    $query = Keuangan::query();

    // Sorting
    if ($request->has('sort_by')) {
        $query->orderBy($request->sort_by, $request->get('order', 'asc'));
    }

    // Date range filtering
    if ($request->has('start_date') && $request->has('end_date')) {
        $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
    }

    $dataKeuangan = $query->paginate(10); // Adjust the number of items per page as needed

    return view('admin.keuangan.index', compact('dataKeuangan'))
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
                         ->with('success', 'Data keuangan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();

        return redirect()->route('admin.keuangan.index')
                         ->with('success', 'Data keuangan berhasil dihapus.');
    }
}
