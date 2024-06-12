@extends('layout.admin')

@section('content')
    <div class="container">
        <h1>Add Inventory</h1>
        <form method="POST" action="{{ route('admin.inventories.store') }}">
            @csrf
            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang">
            </div>
            <div class="form-group">
                <label for="kategori">Kategori:</label>
                <input type="text" class="form-control" id="kategori" name="kategori">
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah">
            </div>
            <div class="form-group">
                <label for="satuan">Satuan:</label>
                <input type="text" class="form-control" id="satuan" name="satuan">
            </div>
            <div class="form-group">
                <label for="kondisi">Kondisi:</label>
                <input type="text" class="form-control" id="kondisi" name="kondisi">
            </div>
            <div class="form-group">
                <label for="tanggal_pembelian">Tanggal Pembelian:</label>
                <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian">
            </div>
            <div class="form-group">
                <label for="harga_satuan">Harga Satuan:</label>
                <input type="number" class="form-control" id="harga_satuan" name="harga_satuan">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
