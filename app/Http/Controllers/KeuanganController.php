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

    // Searching
    if ($request->has('search')) {
        $query->where('transaction_date', 'like', '%' . $request->search . '%');
    }

    $dataKeuangan = $query->paginate(10); // Sesuaikan dengan jumlah data per halaman

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
