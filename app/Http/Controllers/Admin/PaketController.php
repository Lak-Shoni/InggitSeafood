<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jenis_Paket;
use App\Models\Notification;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        $query = Paket::query();
        $jenis = Jenis_Paket::all();
        $notifications = Notification::where('is_read', false)->get();
        $unreadNotificationsCount = $notifications->count();

        // Sorting
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('order', 'asc'));
        }

        // Searching
        if ($request->has('search')) {
            $query->where('nama_paket', 'like', '%' . $request->search . '%');
        }

        $pakets = $query->paginate(5); // Sesuaikan dengan jumlah data per halaman

        return view('admin.pakets.index', compact('pakets', 'jenis','unreadNotificationsCount','notifications'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        $jenis = Jenis_Paket::all();
        return view('admin.pakets.create', compact('jenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_paket' => 'required',
            'nama_paket' => 'required',
            'gambar_paket' => 'required|image',
            'isi_paket' => 'required',
            'harga_paket' => 'required|numeric',
        ]);

        $path = $request->file('gambar_paket')->store('public/images');

        Paket::create([
            'jenis_paket' => $request->jenis_paket,
            'nama_paket' => $request->nama_paket,
            'gambar_paket' => basename($path),
            'isi_paket' => $request->isi_paket,
            'harga_paket' => $request->harga_paket,
        ]);

        return redirect()->route('admin.pakets.index')->with('success', 'Paket Berhasil Ditambahkan');
    }

    public function show($id)
    {
        $paket = Paket::findOrFail($id);
        return view('admin.pakets.show', compact('paket'));
    }


    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return response()->json($paket);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_paket' => 'required',
            'nama_paket' => 'required',
            'gambar_paket' => 'image',
            'isi_paket' => 'required',
            'harga_paket' => 'required|numeric',
        ]);

        $paket = Paket::findOrFail($id);

        if ($request->hasFile('gambar_paket')) {
            $path = $request->file('gambar_paket')->store('public/images');
            $paket->gambar_paket = basename($path);
        }

        $paket->jenis_paket = $request->jenis_paket;
        $paket->nama_paket = $request->nama_paket;
        $paket->isi_paket = $request->isi_paket;
        $paket->harga_paket = $request->harga_paket;

        $paket->save();

        return redirect()->route('admin.pakets.index')->with('success', 'Paket Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        $paket = paket::findOrFail($id);
        $paket->delete();

        return redirect()->route('admin.pakets.index')->with('success', 'Paket Berhasil Dihapus');
    }
}
