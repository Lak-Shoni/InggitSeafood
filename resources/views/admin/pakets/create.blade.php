@extends('layout.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">                        
                        <h2>Tambah paket</h2>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin.pakets.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="jenis_paket">jenis Paket</label>
                                    <select name="jenis_paket" class="form-control" required>
                                        <option value="">Pilih jenis</option>
                                        @foreach($jenis as $data)
                                            <option value="{{ $data->nama_jenis}}">{{ $data->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama_paket">Nama paket</label>
                                    <input type="text" name="nama_paket" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="gambar_paket">Gambar paket</label>
                                    <input type="file" name="gambar_paket" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="isi_paket">Isi paket</label>
                                    <textarea name="isi_paket" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="harga_paket">Harga paket</label>
                                    <input type="number" name="harga_paket" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success">Tambah</button>
                            </div>
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
