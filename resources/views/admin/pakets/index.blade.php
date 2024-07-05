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
                                <h1>Daftar Paket</h1>

                            </div>
                            @if (session('success'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: '{{ session('success') }}',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                </script>
                            @endif
                            <div class="d-flex justify-content-between align-items-end mb-4">
                                <a href="{{ route('admin.pakets.create') }}" class="btn btn-primary mb-2">Tambah paket</a>
                                <form id="searchForm" method="GET" action="{{ route('admin.pakets.index') }}"
                                    class="form-inline">
                                    <div class="form-group mb-2 position-relative">
                                        <label for="search" class="mr-2">Cari berdasarkan nama:</label>
                                        <input type="text" class="form-control" id="search" name="search"
                                            value="{{ request('search') }}">
                                        <span id="clearSearch" class="position-absolute"
                                            style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; display: none;">&times;</span>
                                    </div>
                                </form>
                            </div>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <a
                                                href="{{ route('admin.pakets.index', ['sort_by' => 'jenis_paket', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Jenis Paket
                                                @if (request('sort_by') == 'jenis_paket')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.pakets.index', ['sort_by' => 'nama_paket', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Nama paket
                                                @if (request('sort_by') == 'nama_paket')
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
                                            Isi paket
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.pakets.index', ['sort_by' => 'harga_paket', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Harga paket
                                                @if (request('sort_by') == 'harga_paket')
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
                                    @foreach ($pakets as $paket)
                                        <tr>
                                            <td>{{ $paket->jenis_paket }}</td>
                                            <td>{{ $paket->nama_paket }}</td>
                                            <td><img src="{{ asset('storage/images/' . $paket->gambar_paket) }}"
                                                    alt="{{ $paket->nama_paket }}" width="50"></td>
                                            <td>{{ $paket->isi_paket }}</td>
                                            <td>{{ $paket->harga_paket }}</td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <a href="{{ route('admin.pakets.edit', $paket->id) }}"
                                                        class="btn btn-warning mr-2">Edit</a>
                                                    <form action="{{ route('admin.pakets.destroy', $paket->id) }}"
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
                                {!! $pakets->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}
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
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                const deleteBtn = form.querySelector('.delete-btn');

                deleteBtn.addEventListener('click', function(event) {
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const clearSearch = document.getElementById('clearSearch');
            const searchForm = document.getElementById('searchForm');
            const dataBody = document.getElementById('dataBody');

            // Show clear icon if search input is not empty
            if (searchInput.value) {
                clearSearch.style.display = 'block';
            }

            // Listen for input changes
            searchInput.addEventListener('input', function() {
                const query = this.value;

                // Show clear icon if search input is not empty
                clearSearch.style.display = query ? 'block' : 'none';

                // Make AJAX request to search
                fetch(`{{ route('admin.pakets.index') }}?search=${query}`)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newBody = doc.getElementById('dataBody').innerHTML;
                        dataBody.innerHTML = newBody;
                    });
            });

            // Clear search input when clear icon is clicked
            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                clearSearch.style.display = 'none';
                searchInput.dispatchEvent(new Event('input'));
            });
        });
    </script>
@endsection
