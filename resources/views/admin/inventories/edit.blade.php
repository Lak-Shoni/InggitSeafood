@extends('layout.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">                
                        <h2>Edit Inventaris</h2>
                        <form method="POST" action="{{ route('admin.inventories.update', $inventory->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nama_barang">Nama Barang:</label>
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $inventory->nama_barang }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori">Kategori:</label>
                                        <input type="text" class="form-control" id="kategori" name="kategori" value="{{ $inventory->kategori }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah:</label>
                                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $inventory->jumlah }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="satuan">Satuan:</label>
                                        <input type="text" class="form-control" id="satuan" name="satuan" value="{{ $inventory->satuan }}">
                                    </div>                    
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="kondisi">Kondisi:</label>
                                        <input type="text" class="form-control" id="kondisi" name="kondisi" value="{{ $inventory->kondisi }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_pembelian">Tanggal Pembelian:</label>
                                        <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" value="{{ $inventory->tanggal_pembelian }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_satuan">Harga Satuan:</label>
                                        <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" value="{{ $inventory->harga_satuan }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
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
