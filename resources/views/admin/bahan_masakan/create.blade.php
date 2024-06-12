@extends('layout.admin')

@section('content')
    <div class="container">
        <h1>Add Bahan Masakan</h1>
        <form method="POST" action="{{ route('admin.bahan_masakan.store') }}">
            @csrf
            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang">
            </div>
            <div class="form-group">
                <label for="barang_masuk">Barang Masuk:</label>
                <input type="number" class="form-control" id="barang_masuk" name="barang_masuk">
            </div>
            <div class="form-group">
                <label for="barang_keluar">Barang Keluar:</label>
                <input type="number" class="form-control" id="barang_keluar" name="barang_keluar">
            </div>
            <div class="form-group">
                <label for="barang_sisa">Barang Sisa:</label>
                <input type="number" class="form-control" id="barang_sisa" name="barang_sisa">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
