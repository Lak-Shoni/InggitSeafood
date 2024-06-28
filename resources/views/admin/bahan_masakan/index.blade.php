@extends('layout.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h1>Daftar Bahan Masakan</h1>
                            </div>
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            
                            <form method="POST" action="{{ route('admin.bahan_masakan.store') }}">
                                @csrf
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="nama_bahan">Nama Bahan:</label>
                                        <input type="text" class="form-control" id="nama_bahan" name="nama_bahan">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </form>
                            <div class="d-flex justify-content-end">
                                <form method="GET" action="{{ route('admin.bahan_masakan.index') }}" class="form-inline mb-2">
                                    <div class="form-group mb-2">
                                        <label for="search" class="mr-2">Cari berdasarkan nama:</label>
                                        <input type="name" class="form-control" id="search" name="search"
                                            value="{{ request('search') }}">
                                        </div>                            
                                        <button type="submit" class="btn btn-primary  mb-2 ml-2">Cari</button>
                                </form>
                            </div>
                            <div class="col-12">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <a
                                                    href="{{ route('admin.bahan_masakan.index', ['sort_by' => 'id', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                    ID
                                                    @if (request('sort_by') == 'id')
                                                        <i
                                                            class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                    @else
                                                        <i class="fas fa-sort"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>
                                                <a
                                                    href="{{ route('admin.bahan_masakan.index', ['sort_by' => 'nama_bahan', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                    Nama Bahan
                                                    @if (request('sort_by') == 'nama_bahan')
                                                        <i
                                                            class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                    @else
                                                        <i class="fas fa-sort"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataBody">
                                        @foreach ($bahanMasakan as $bahan)
                                            <tr>
                                                <td>{{ $bahan->id }}</td>
                                                <td>
                                                    <a
                                                        href="{{ route('admin.bahan_masakan.show', $bahan->id) }}">{{ $bahan->nama_bahan }}</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.bahan_masakan.destroy', $bahan->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger ">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <div class="d-flex justify-content-center">
                                {!! $bahanMasakan->appends(request()->query())->links() !!}
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
