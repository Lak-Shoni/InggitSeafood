@extends('layout.admin')

@section('content')
    <h1>Edit Menu</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="kategori_paket">Kategori Paket</label>
            <input type="text" name="kategori_paket" class="form-control" value="{{ $menu->kategori_paket }}" required>
        </div>
        <div class="form-group">
            <label for="nama_menu">Nama Menu</label>
            <input type="text" name="nama_menu" class="form-control" value="{{ $menu->nama_menu }}" required>
        </div>
        <div class="form-group">
            <label for="gambar_menu">Gambar Menu</label>
            <input type="file" name="gambar_menu" class="form-control">
            <img src="{{ asset('storage/images/' . $menu->gambar_menu) }}" alt="{{ $menu->nama_menu }}" width="100">
        </div>
        <div class="form-group">
            <label for="isi_menu">Isi Menu</label>
            <textarea name="isi_menu" class="form-control" required>{{ $menu->isi_menu }}</textarea>
        </div>
        <div class="form-group">
            <label for="harga_menu">Harga Menu</label>
            <input type="number" name="harga_menu" class="form-control" value="{{ $menu->harga_menu }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
