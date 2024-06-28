<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventory::query();

        // Sorting
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('order', 'asc'));
        }

        // Searching
        if ($request->has('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $inventories = $query->paginate(10); // Sesuaikan dengan jumlah data per halaman

        return view('admin.inventories.index', compact('inventories'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inventories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required|integer',
            'satuan' => 'required',
            'kondisi' => 'required',
            'tanggal_pembelian' => 'required|date',
            'harga_satuan' => 'required|numeric',
        ]);

        $inventory = new Inventory([
            'nama_barang' => $request->get('nama_barang'),
            'kategori' => $request->get('kategori'),
            'jumlah' => $request->get('jumlah'),
            'satuan' => $request->get('satuan'),
            'kondisi' => $request->get('kondisi'),
            'tanggal_pembelian' => $request->get('tanggal_pembelian'),
            'harga_satuan' => $request->get('harga_satuan'),
            'total_harga' => $request->get('harga_satuan') * $request->get('jumlah'),
            'tanggal_pembaruan_terakhir' => now(),
        ]);
        $inventory->save();

        return redirect()->route('admin.inventories.index')->with('success', 'Inventory saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('admin.inventories.show', compact('inventory'));
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('admin.inventories.edit', compact('inventory'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required|integer',
            'satuan' => 'required',
            'kondisi' => 'required',
            'tanggal_pembelian' => 'required|date',
            'harga_satuan' => 'required|numeric',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->nama_barang = $request->get('nama_barang');
        $inventory->kategori = $request->get('kategori');
        $inventory->jumlah = $request->get('jumlah');
        $inventory->satuan = $request->get('satuan');
        $inventory->kondisi = $request->get('kondisi');
        $inventory->tanggal_pembelian = $request->get('tanggal_pembelian');
        $inventory->harga_satuan = $request->get('harga_satuan');
        $inventory->total_harga = $request->get('harga_satuan') * $request->get('jumlah');
        $inventory->tanggal_pembaruan_terakhir = now();
        $inventory->save();

        return redirect()->route('admin.inventories.index')->with('success', 'Inventory updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('admin.inventories.index')->with('success', 'Inventory deleted!');
    }
}
