@extends('layout.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <h2>Edit paket</h2>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin.pakets.update', $paket->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="jenis_paket">jenis Paket</label>
                                    <select name="jenis_paket" class="form-control" required>
                                        <option value="">Pilih jenis</option>
                                        @foreach($jenis as $data)
                                            <option value="{{ $data->nama_jenis }}" {{ $paket->jenis_paket == $data->id ? 'selected' : '' }}>{{ $data->nama_jenis}}</option>
                                        @endforeach
                                    </select>            
                                </div>                                
                                <div class="form-group">
                                    <label for="nama_paket">Nama paket</label>
                                    <input type="text" name="nama_paket" class="form-control" value="{{ $paket->nama_paket }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="gambar_paket">Gambar paket</label>
                                    <input type="file" name="gambar_paket" class="form-control">
                                    <img src="{{ asset('storage/images/' . $paket->gambar_paket) }}" alt="{{ $paket->nama_paket }}" width="100">
                                </div>
                                <div class="form-group">
                                    <label for="isi_paket">Isi paket</label>
                                    <textarea name="isi_paket" class="form-control" required>{{ $paket->isi_paket }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="harga_paket">Harga paket</label>
                                    <input type="number" name="harga_paket" class="form-control" value="{{ $paket->harga_paket }}" required>
                                </div>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                            <br>
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
