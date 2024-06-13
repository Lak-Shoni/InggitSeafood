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
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
