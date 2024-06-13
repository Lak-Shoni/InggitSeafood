<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanMasakan;
use App\Models\Transaksi;

class BahanMasakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bahanMasakan = BahanMasakan::all();
        return view('admin.bahan_masakan.index', compact('bahanMasakan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bahan_masakan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
        ]);

        $bahanMasakan = new BahanMasakan([
            'nama_barang' => $request->get('nama_barang'),
            'barang_masuk' => 0,
            'barang_keluar' => 0,
            'barang_sisa' => 0,
        ]);
        $bahanMasakan->save();

        return redirect()->route('admin.bahan_masakan.index')->with('success', 'Bahan masakan saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $selectedBahan = BahanMasakan::findOrFail($id);
        $bahanMasakanList = BahanMasakan::all();
        $transaksiList = Transaksi::where('bahan_masakan_id', $id)->get();
        return view('admin.bahan_masakan.show', compact('selectedBahan', 'bahanMasakanList', 'transaksiList'));
    }

    public function barangMasuk($id)
    {
        $bahanMasakan = BahanMasakan::findOrFail($id);
        return view('admin.bahan_masakan.barang_masuk', compact('bahanMasakan'));
    }

    public function barangKeluar($id)
    {
        $bahanMasakan = BahanMasakan::findOrFail($id);
        return view('admin.bahan_masakan.barang_keluar', compact('bahanMasakan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bahanMasakan = BahanMasakan::findOrFail($id);
        return view('admin.bahan_masakan.edit', compact('bahanMasakan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'barang_masuk' => 'required|integer',
            'barang_keluar' => 'required|integer',
            'barang_sisa' => 'required|integer',
        ]);

        $bahanMasakan = BahanMasakan::findOrFail($id);
        $bahanMasakan->nama_barang = $request->get('nama_barang');
        $bahanMasakan->barang_masuk = $request->get('barang_masuk');
        $bahanMasakan->barang_keluar = $request->get('barang_keluar');
        $bahanMasakan->barang_sisa = $request->get('barang_sisa');
        $bahanMasakan->save();

        return redirect()->route('admin.bahan_masakan.index')->with('success', 'Bahan masakan updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bahanMasakan = BahanMasakan::findOrFail($id);
        $bahanMasakan->delete();

        return redirect()->route('admin.bahan_masakan.index')->with('success', 'Bahan masakan deleted!');
    }

    public function storeBarangMasuk(Request $request, $id)
{
    $request->validate([
        'barang_masuk' => 'required|integer',
        'tanggal_transaksi' => 'required|date',
    ]);

    $bahanMasakan = BahanMasakan::findOrFail($id);
    $bahanMasakan->barang_masuk += $request->barang_masuk;
    $bahanMasakan->barang_sisa += $request->barang_masuk;

    $transaksi = new Transaksi([
        'bahan_masakan_id' => $bahanMasakan->id,
        'tanggal_transaksi' => $request->tanggal_transaksi,
        'barang_masuk' => $request->barang_masuk,
        'barang_keluar' => 0,
        'barang_sisa' => $bahanMasakan->barang_sisa,
    ]);

    $bahanMasakan->save();
    $transaksi->save();

    return redirect()->route('admin.bahan_masakan.show', $bahanMasakan->id)->with('success', 'Barang masuk recorded!');
}

public function storeBarangKeluar(Request $request, $id)
{
    $request->validate([
        'barang_keluar' => 'required|integer',
        'tanggal_transaksi' => 'required|date',
    ]);

    $bahanMasakan = BahanMasakan::findOrFail($id);
    $bahanMasakan->barang_keluar += $request->barang_keluar;
    $bahanMasakan->barang_sisa -= $request->barang_keluar;

    $transaksi = new Transaksi([
        'bahan_masakan_id' => $bahanMasakan->id,
        'tanggal_transaksi' => $request->tanggal_transaksi,
        'barang_masuk' => 0,
        'barang_keluar' => $request->barang_keluar,
        'barang_sisa' => $bahanMasakan->barang_sisa,
    ]);

    $bahanMasakan->save();
    $transaksi->save();

    return redirect()->route('admin.bahan_masakan.show', $bahanMasakan->id)->with('success', 'Barang keluar recorded!');
}
}
