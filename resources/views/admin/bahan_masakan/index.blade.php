@extends('layout.admin')

@section('content')
<div class="ml-2">
  <h1>Bahan Masakan</h1>
  <a href="{{ route('admin.bahan_masakan.create') }}" class="btn btn-primary mb-4">Add Bahan Masakan</a>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Barang</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bahanMasakan as $bahan)
                                    <tr>
                                        <td>{{ $bahan->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.bahan_masakan.show', $bahan->id) }}">{{ $bahan->nama_barang }}</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.bahan_masakan.destroy', $bahan->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
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
