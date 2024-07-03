@extends('layout.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h1>Daftar Bahan Masakan</h1>
                            </div>
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('admin.bahan_masakan.store') }}">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="nama_bahan">Nama Bahan:</label>
                                        <input type="text" class="form-control" id="nama_bahan" name="nama_bahan"
                                            value="{{ old('nama_bahan') }}" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="satuan">Satuan:</label>
                                        <input type="text" class="form-control" id="satuan" name="satuan"
                                            value="{{ old('satuan') }}" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </form>

                            <div class="d-flex justify-content-end align-items-end mb-4 mr-2">
                                <form id="searchForm" method="GET" action="{{ route('admin.bahan_masakan.index') }}"
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
                                            <th>Satuan</th>
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
                                                <td>{{ $bahan->satuan }}</td>
                                                <td>
                                                    {{-- <form action="{{ route('admin.bahan_masakan.destroy', $bahan->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger ">Hapus</button>
                                                    </form> --}}
                                                    <form action="{{ route('admin.bahan_masakan.destroy', $bahan->id) }}" method="POST" class="delete-form"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger delete-btn">Hapus</button>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const clearSearch = document.getElementById('clearSearch');
            const searchForm = document.getElementById('searchForm');
            const dataBody = document.getElementById('dataBody');

            if (searchInput.value) {
                clearSearch.style.display = 'block';
            }

            searchInput.addEventListener('input', function() {
                const query = this.value;

                clearSearch.style.display = query ? 'block' : 'none';

                fetch(`{{ route('admin.bahan_masakan.index') }}?search=${query}`)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newBody = doc.getElementById('dataBody').innerHTML;
                        dataBody.innerHTML = newBody;
                    });
            });

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
@endsection
