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
                                <h1>Daftar Menu</h1>

                            </div>
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <div class="d-flex justify-content-between align-items-end mb-4">
                                <a href="{{ route('admin.menus.create') }}" class="btn btn-primary mb-2">Tambah Menu</a>
                                <form method="GET" action="{{ route('admin.menus.index') }}" class="form-inline">
                                    <div class="form-group mb-2">
                                        <label for="search" class="mr-2">Cari berdasarkan nama:</label>
                                        <input type="text" class="form-control" id="search" name="search"
                                            value="{{ request('search') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2 ml-2">Cari</button>
                                </form>
                            </div>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <a
                                                href="{{ route('admin.menus.index', ['sort_by' => 'kategori_paket', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Kategori Paket
                                                @if (request('sort_by') == 'kategori_paket')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.menus.index', ['sort_by' => 'nama_menu', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Nama Menu
                                                @if (request('sort_by') == 'nama_menu')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            Gambar
                                        </th>
                                        <th>
                                            Isi Menu
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.menus.index', ['sort_by' => 'harga_menu', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Harga Menu
                                                @if (request('sort_by') == 'harga_menu')
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
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td>{{ $menu->kategori_paket }}</td>
                                            <td>{{ $menu->nama_menu }}</td>
                                            <td><img src="{{ asset('storage/images/' . $menu->gambar_menu) }}"
                                                    alt="{{ $menu->nama_menu }}" width="50"></td>
                                            <td>{{ $menu->isi_menu }}</td>
                                            <td>{{ $menu->harga_menu }}</td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <a href="{{ route('admin.menus.edit', $menu->id) }}"
                                                        class="btn btn-warning mr-2">Edit</a>
                                                    <form action="{{ route('admin.menus.destroy', $menu->id) }}"
                                                        method="POST" class="delete-form" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-danger delete-btn">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {!! $menus->appends(request()->query())->links() !!}
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
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          const deleteForms = document.querySelectorAll('.delete-form');
  
          deleteForms.forEach(form => {
              const deleteBtn = form.querySelector('.delete-btn');
  
              deleteBtn.addEventListener('click', function (event) {
                  event.preventDefault();
                  Swal.fire({
                      title: 'Hapus Item?',
                      text: "Apakah kamu ingin menghapus item ini?",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      cancelButtonText: 'Tidak',
                      confirmButtonText: 'Iya'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          form.submit();
                      }
                  });
              });
          });
      });
  </script>
@endsection
