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
    public function index(Request $request)
    {

        $query = BahanMasakan::query();

        // Sorting
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('order', 'asc'));
        }

        // Searching
        if ($request->has('search')) {
            $query->where('nama_bahan', 'like', '%' . $request->search . '%');
        }

        $bahanMasakan = $query->paginate(10); // Sesuaikan dengan jumlah data per halaman

        return view('admin.bahan_masakan.index', compact('bahanMasakan'))
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
        ]);

        $bahanMasakan = new BahanMasakan([
            'nama_bahan' => $request->get('nama_bahan'),
            'bahan_masuk' => 0,
            'bahan_keluar' => 0,
            'bahan_sisa' => 0,
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
            'bahan_sisa' => 'required|integer',
        ]);

        $bahanMasakan = BahanMasakan::findOrFail($id);
        $bahanMasakan->nama_bahan = $request->get('nama_bahan');
        $bahanMasakan->bahan_masuk = $request->get('bahan_masuk');
        $bahanMasakan->bahan_keluar = $request->get('bahan_keluar');
        $bahanMasakan->bahan_sisa = $request->get('bahan_sisa');
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

    public function storeBahanMasuk(Request $request, $id)
    {
        $request->validate([
            'bahan_masuk' => 'required|integer',
            'tanggal_transaksi' => 'required|date',
        ]);

        $bahanMasakan = BahanMasakan::findOrFail($id);
        $bahanMasakan->bahan_masuk += $request->bahan_masuk;
        $bahanMasakan->bahan_sisa += $request->bahan_masuk;

        $transaksi = new Transaksi([
            'bahan_masakan_id' => $bahanMasakan->id,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'bahan_masuk' => $request->bahan_masuk,
            'bahan_keluar' => 0,
            'bahan_sisa' => $bahanMasakan->bahan_sisa,
        ]);

        $bahanMasakan->save();
        $transaksi->save();

        return redirect()->route('admin.bahan_masakan.show', $bahanMasakan->id)->with('success', 'Bahan masuk recorded!');
    }

    public function storeBahanKeluar(Request $request, $id)
    {
        $request->validate([
            'bahan_keluar' => 'required|integer',
            'tanggal_transaksi' => 'required|date',
        ]);

        $bahanMasakan = BahanMasakan::findOrFail($id);
        $bahanMasakan->bahan_keluar += $request->bahan_keluar;
        $bahanMasakan->bahan_sisa -= $request->bahan_keluar;

        $transaksi = new Transaksi([
            'bahan_masakan_id' => $bahanMasakan->id,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'bahan_masuk' => 0,
            'bahan_keluar' => $request->bahan_keluar,
            'bahan_sisa' => $bahanMasakan->bahan_sisa,
        ]);

        $bahanMasakan->save();
        $transaksi->save();

        return redirect()->route('admin.bahan_masakan.show', $bahanMasakan->id)->with('success', 'Bahan keluar recorded!');
    }
}
