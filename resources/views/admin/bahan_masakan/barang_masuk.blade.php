@extends('layout.admin')

@section('content')
<div class="ml-2">
  <h1>Barang Masuk</h1>
  <form action="{{ route('admin.bahan_masakan.store_barang_masuk', $bahanMasakan->id) }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="barangMasuk">Jumlah Barang Masuk</label>
      <input type="number" class="form-control" id="barangMasuk" name="barang_masuk" required>
    </div>
    <div class="form-group">
      <label for="tanggalTransaksi">Tanggal Transaksi</label>
      <input type="date" class="form-control" id="tanggalTransaksi" name="tanggal_transaksi" required>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
  </form>
</div>
@endsection
