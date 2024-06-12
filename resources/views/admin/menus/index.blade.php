@extends('layout.admin')


@section('content')
<div class="ml-2">
  <h1>Menu List</h1>
  <a href="{{ route('admin.menus.create') }}" class="btn btn-primary mb-4">Add New Menu</a>

</div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
                        <th>Kategori Paket</th>
                        <th>Nama Menu</th>
                        <th>Gambar</th>
                        <th>Isi Menu</th>
                        <th>Harga</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $menu)
                            <tr>
                                <td>{{ $menu->kategori_paket }}</td>
                                <td>{{ $menu->nama_menu }}</td>
                                <td><img src="{{ asset('storage/images/' . $menu->gambar_menu) }}" alt="{{ $menu->nama_menu }}" width="50"></td>
                                <td>{{ $menu->isi_menu }}</td>
                                <td>{{ $menu->harga_menu }}</td>
                                <td>
                                    <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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
