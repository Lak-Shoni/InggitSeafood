@extends('layout.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h1>Detail Bahan Masakan</h1>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="bahanDropdown">Pilih Bahan Masakan:</label>
                                    <select id="bahanDropdown" class="form-control" onchange="location = this.value;">
                                        @foreach ($bahanMasakanList as $bahan)
                                            <option value="{{ route('admin.bahan_masakan.show', $bahan->id) }}"
                                                {{ $bahan->id == $selectedBahan->id ? 'selected' : '' }}>
                                                {{ $bahan->nama_bahan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <a href="{{ route('admin.bahan_masakan.bahan_masuk', $selectedBahan->id) }}"
                                    class="btn btn-success mb-2">Bahan Masuk</a>
                                <a href="{{ route('admin.bahan_masakan.bahan_keluar', $selectedBahan->id) }}"
                                    class="btn btn-warning mb-2">Bahan Keluar</a>
                            </div>

                            <table id="transaksiTable" class="table table-bordered table-hover mt-4">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Bahan Masuk</th>
                                        <th>Bahan Keluar</th>
                                        <th>Bahan Sisa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksiList as $transaksi)
                                        <tr>
                                            <td>{{ $selectedBahan->nama_bahan }}</td>
                                            <td>{{ $transaksi->tanggal_transaksi }}</td>
                                            <td>{{ $transaksi->bahan_masuk }}</td>
                                            <td>{{ $transaksi->bahan_keluar }}</td>
                                            <td>{{ $transaksi->bahan_sisa }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
