@extends('layout.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h2>Tambah Inventaris</h2>
                            <form method="POST" action="{{ route('admin.inventories.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="nama_barang">Nama Barang:</label>
                                            <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                                        </div>
                                        <div class="mb-3">
                                            <label for="kategori">Kategori:</label>
                                            <input type="text" class="form-control" id="kategori" name="kategori">
                                        </div>
                                        <div class="mb-3">
                                            <label for="jumlah">Jumlah:</label>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah">
                                        </div>
                                        <div class="mb-3">
                                            <label for="satuan">Satuan:</label>
                                            <input type="text" class="form-control" id="satuan" name="satuan">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="kondisi">Kondisi:</label>
                                            <input type="text" class="form-control" id="kondisi" name="kondisi">
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_pembelian">Tanggal Pembelian:</label>
                                            <input type="date" class="form-control" id="tanggal_pembelian"
                                                name="tanggal_pembelian">
                                        </div>
                                        <div class="mb-3">
                                            <label for="harga_satuan">Harga Satuan:</label>
                                            <input type="number" class="form-control" id="harga_satuan"
                                                name="harga_satuan">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-2">Tambah</button>
                                </div>
                            </form>
                        </div>
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
