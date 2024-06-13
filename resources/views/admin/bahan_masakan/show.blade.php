@extends('layout.admin')

@section('content')
<div class="ml-2">
  <h1>Detail Bahan Masakan</h1>
  <div class="form-group">
    <label for="bahanDropdown">Pilih Bahan Masakan:</label>
    <select id="bahanDropdown" class="form-control" onchange="location = this.value;">
      @foreach($bahanMasakanList as $bahan)
        <option value="{{ route('admin.bahan_masakan.show', $bahan->id) }}" {{ $bahan->id == $selectedBahan->id ? 'selected' : '' }}>
          {{ $bahan->nama_barang }}
        </option>
      @endforeach
    </select>
  </div>

  <a href="{{ route('admin.bahan_masakan.barang_masuk', $selectedBahan->id) }}" class="btn btn-success mb-2">Barang Masuk</a>
  <a href="{{ route('admin.bahan_masakan.barang_keluar', $selectedBahan->id) }}" class="btn btn-warning mb-2">Barang Keluar</a>

  <table id="transaksiTable" class="table table-bordered table-hover mt-4">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Tanggal Transaksi</th>
        <th>Barang Masuk</th>
        <th>Barang Keluar</th>
        <th>Barang Sisa</th>
      </tr>
    </thead>
    <tbody>
      @foreach($transaksiList as $transaksi)
        <tr>
          <td>{{ $selectedBahan->nama_barang }}</td>
          <td>{{ $transaksi->tanggal_transaksi }}</td>
          <td>{{ $transaksi->barang_masuk }}</td>
          <td>{{ $transaksi->barang_keluar }}</td>
          <td>{{ $transaksi->barang_sisa }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
