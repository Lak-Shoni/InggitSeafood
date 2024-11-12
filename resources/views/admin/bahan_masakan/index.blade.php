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

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if ($bahanMasakan->isEmpty())
                                <button class="btn btn-success" data-toggle="modal" data-target="#tambahBahanModal">Tambah
                                    Bahan Masakan</button>
                                <div class="col-12 text-center">
                                    <img src="{{ asset('img/bahan_masakan.png') }}" alt="Menu tidak ditemukan"
                                        style="max-width: 300px;" class="img-fluid mb-3">
                                    <h5 class="text-muted" style="margin-top: -60px;">Oops! Bahan Masakan Kosong.</h5>
                                    <p class="text-muted">kamu belum memiliki bahan masakan untuk saat ini. Silakan tambah
                                        bahan masakan baru
                                    </p>
                                </div>
                            @else
                                <div class="d-flex justify-content-between align-items-end mb-4">
                                    <button class="btn btn-success" data-toggle="modal"
                                        data-target="#tambahBahanModal">Tambah
                                        Bahan Masakan</button>
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
                                                    <td>{{ $bahan->nama_bahan }}</td>
                                                    <td>{{ $bahan->satuan }}</td>
                                                    <td>
                                                        <form action="{{ route('admin.bahan_masakan.show', $bahan->id) }}"
                                                            method="GET" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary">Detail</button>
                                                        </form>
                                                        <form
                                                            action="{{ route('admin.bahan_masakan.destroy', $bahan->id) }}"
                                                            method="POST" class="delete-form" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger delete-btn">Hapus</button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center m-3">
                                    {!! $bahanMasakan->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Tambah Bahan Masakan -->
    <div class="modal fade" id="tambahBahanModal" tabindex="-1" role="dialog" aria-labelledby="tambahBahanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="tambahBahanForm" action="{{ route('admin.bahan_masakan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahBahanModalLabel">Tambah Bahan Masakan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_bahan">Nama Bahan:</label>
                            <input type="text" class="form-control" id="nama_bahan" name="nama_bahan" required>
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan:</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

            document.getElementById('tambahBahanForm').addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#tambahBahanModal').modal('hide');
                            fetch(`{{ route('admin.bahan_masakan.index') }}`)
                                .then(response => response.text())
                                .then(html => {
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');
                                    const newBody = doc.getElementById('dataBody').innerHTML;
                                    dataBody.innerHTML = newBody;
                                });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
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
