@extends('layout.admin')

@section('content')
<div class="ml-2">
  <h1>Barang Keluar</h1>
  <form action="{{ route('admin.bahan_masakan.store_barang_keluar', $bahanMasakan->id) }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="barangKeluar">Jumlah Barang Keluar</label>
      <input type="number" class="form-control" id="barangKeluar" name="barang_keluar" required>
    </div>
    <div class="form-group">
      <label for="tanggalTransaksi">Tanggal Transaksi</label>
      <input type="date" class="form-control" id="tanggalTransaksi" name="tanggal_transaksi" required>
    </div>
    <button type="submit" class="btn btn-warning">Submit</button>
  </form>
</div>
@endsection
