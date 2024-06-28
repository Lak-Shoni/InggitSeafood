<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::query();

        // Sorting
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('order', 'asc'));
        }

        // Searching
        if ($request->has('search')) {
            $query->where('nama_menu', 'like', '%' . $request->search . '%');
        }

        $menus = $query->paginate(10); // Sesuaikan dengan jumlah data per halaman

        return view('admin.menus.index', compact('menus'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
       
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_paket' => 'required',
            'nama_menu' => 'required',
            'gambar_menu' => 'required|image',
            'isi_menu' => 'required',
            'harga_menu' => 'required|numeric',
        ]);

        $path = $request->file('gambar_menu')->store('public/images');

        Menu::create([
            'kategori_paket' => $request->kategori_paket,
            'nama_menu' => $request->nama_menu,
            'gambar_menu' => basename($path),
            'isi_menu' => $request->isi_menu,
            'harga_menu' => $request->harga_menu,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menus.show', compact('menu'));
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_paket' => 'required',
            'nama_menu' => 'required',
            'gambar_menu' => 'image',
            'isi_menu' => 'required',
            'harga_menu' => 'required|numeric',
        ]);

        $menu = Menu::findOrFail($id);

        if ($request->hasFile('gambar_menu')) {
            $path = $request->file('gambar_menu')->store('public/images');
            $menu->gambar_menu = basename($path);
        }

        $menu->kategori_paket = $request->kategori_paket;
        $menu->nama_menu = $request->nama_menu;
        $menu->isi_menu = $request->isi_menu;
        $menu->harga_menu = $request->harga_menu;

        $menu->save();

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
    }
}
