@extends('layout.admin')

@section('content')
    {{-- <div class="ml-2">
        <h1>Inventories</h1>
        <a href="{{ route('admin.inventories.create') }}" class="btn btn-primary mb-4">Add Inventory</a>
    </div> --}}

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
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
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h2>Inventories</h2>
                            </div>
                            <div class="d-flex justify-content-between align-items-end mb-4">
                                <a href="{{ route('admin.inventories.create') }}" class="btn btn-primary mb-2">Tambah
                                    Inventaris</a>
                                <form id="searchForm" method="GET" action="{{ route('admin.inventories.index') }}"
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
                                                href="{{ route('admin.inventories.index', ['sort_by' => 'id', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
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
                                                href="{{ route('admin.inventories.index', ['sort_by' => 'nama_barang', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Nama Barang
                                                @if (request('sort_by') == 'nama_barang')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.inventories.index', ['sort_by' => 'kategori', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Kategori
                                                @if (request('sort_by') == 'kategori')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.inventories.index', ['sort_by' => 'jumlah', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Jumlah
                                                @if (request('sort_by') == 'jumlah')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.inventories.index', ['sort_by' => 'satuan', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Satuan
                                                @if (request('sort_by') == 'satuan')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.inventories.index', ['sort_by' => 'kondisi', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Kondisi
                                                @if (request('sort_by') == 'kondisi')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.inventories.index', ['sort_by' => 'tanggal_pembelian', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Tanggal Pembelian
                                                @if (request('sort_by') == 'tanggal_pembelian')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.inventories.index', ['sort_by' => 'harga_satuan', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Harga Satuan
                                                @if (request('sort_by') == 'harga_satuan')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.inventories.index', ['sort_by' => 'total_harga', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Total Harga
                                                @if (request('sort_by') == 'total_harga')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.inventories.index', ['sort_by' => 'tanggal_pembaruan_terakhir', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Tanggal Pembaruan Terakhir
                                                @if (request('sort_by') == 'tanggal_pembaruan_terakhir')
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
                                    @foreach ($inventories as $inventory)
                                        <tr>
                                            <td>{{ $inventory->id }}</td>
                                            <td>{{ $inventory->nama_barang }}</td>
                                            <td>{{ $inventory->kategori }}</td>
                                            <td>{{ $inventory->jumlah }}</td>
                                            <td>{{ $inventory->satuan }}</td>
                                            <td>{{ $inventory->kondisi }}</td>
                                            <td>{{ $inventory->tanggal_pembelian }}</td>
                                            <td>{{ $inventory->harga_satuan }}</td>
                                            <td>{{ $inventory->total_harga }}</td>
                                            <td>{{ $inventory->tanggal_pembaruan_terakhir }}</td>
                                            <td>

                                                <div style="display: flex; gap: 10px;">
                                                    <a href="{{ route('admin.inventories.edit', $inventory->id) }}"
                                                        class="btn btn-warning">Edit</a>
                                                    <form action="{{ route('admin.inventories.destroy', $inventory->id) }}"
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
                            <div class="d-flex justify-content-center m-3">
                                {!! $inventories->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}
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
                fetch(`{{ route('admin.inventories.index') }}?search=${query}`)
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
    <!-- /.content -->
@endsection
