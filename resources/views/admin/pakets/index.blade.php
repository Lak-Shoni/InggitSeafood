@extends('layout.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
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

                            @if ($pakets->isEmpty())
                                <button class="btn btn-success mb-2" data-toggle="modal" data-target="#addPaketModal">Tambah
                                    Paket</button>
                                <div class="col-12 text-center">
                                    <img src="{{ asset('img/no-menu-found.png') }}" alt="Menu tidak ditemukan"
                                        style="max-width: 300px;" class="img-fluid mb-3">
                                    <h5 class="text-muted" style="margin-top: -60px;">Oops! Daftar Paket Kosong.</h5>
                                    <p class="text-muted">Kamu belum memiliki paket untuk saat ini. Silakan buat paket baru</p>
                                </div>
                            @else
                                <div class="d-flex justify-content-between align-items-end mb-4">
                                    <button class="btn btn-success mb-2" data-toggle="modal"
                                        data-target="#addPaketModal">Tambah
                                        Paket</button>
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
                                @php
                                    function formatRupiah($number)
                                    {
                                        return 'Rp ' . number_format($number, 0, ',', '.');
                                    }
                                @endphp

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
                                            <th>Gambar</th>
                                            <th>Isi paket</th>
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
                                                <td>{{ formatRupiah($paket->harga_paket) }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-start">
                                                        <button class="btn btn-primary mr-2 edit-btn"
                                                            data-id="{{ $paket->id }}" data-toggle="modal"
                                                            data-target="#editPaketModal">Edit</button>
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
                            @endif
                            <div class="d-flex justify-content-center m-3">
                                {!! $pakets->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Paket Modal -->
    <div class="modal fade" id="addPaketModal" tabindex="-1" role="dialog" aria-labelledby="addPaketModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addPaketForm" action="{{ route('admin.pakets.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPaketModalLabel">Tambah Paket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="jenis_paket">Jenis Paket</label>
                            <select name="jenis_paket" class="form-control" id="jenis_paket" required>
                                <option value="">Pilih jenis</option>
                                @foreach ($jenis as $data)
                                    <option value="{{ $data->nama_jenis }}">{{ $data->nama_jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_paket">Nama Paket</label>
                            <input type="text" class="form-control" id="nama_paket" name="nama_paket" required>
                        </div>
                        <div class="form-group">
                            <label for="gambar_paket">Gambar Paket</label>
                            <input type="file" class="form-control" id="gambar_paket" name="gambar_paket" required>
                        </div>
                        <div class="form-group">
                            <label for="isi_paket">Isi Paket</label>
                            <textarea class="form-control" id="isi_paket" name="isi_paket" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="harga_paket">Harga Paket</label>
                            <input type="number" inputmode="numeric" class="form-control" id="harga_paket"
                                name="harga_paket" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Paket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Paket Modal -->
    <div class="modal fade" id="editPaketModal" tabindex="-1" role="dialog" aria-labelledby="editPaketModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editPaketForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPaketModalLabel">Edit Paket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_jenis_paket">Jenis Paket</label>
                            <select name="jenis_paket" class="form-control" id="edit_jenis_paket" required>
                                @if ($pakets->isEmpty())
                                    <option value="">Pilih Jenis</option>
                                    @foreach ($jenis as $data)
                                    @endforeach
                                @else
                                    <option value="">Pilih Jenis</option>
                                    @foreach ($jenis as $data)
                                        <option value="{{ $data->nama_jenis }}"
                                            {{ $paket->jenis_paket == $data->id ? 'selected' : '' }}>
                                            {{ $data->nama_jenis }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_nama_paket">Nama Paket</label>
                            <input type="text" class="form-control" id="edit_nama_paket" name="nama_paket" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_gambar_paket">Gambar Paket</label>
                            <input type="file" class="form-control" id="edit_gambar_paket" name="gambar_paket">
                        </div>
                        <div class="form-group">
                            <label for="edit_isi_paket">Isi Paket</label>
                            <textarea class="form-control" id="edit_isi_paket" name="isi_paket" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_harga_paket">Harga Paket</label>
                            <input type="number" inputmode="numeric" class="form-control" id="edit_harga_paket"
                                name="harga_paket" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

            const editButtons = document.querySelectorAll('.edit-btn');
            const editForm = document.getElementById('editPaketForm');
            const editPaketModal = $('#editPaketModal');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    fetch(`/admin/pakets/${id}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            editForm.action = `/admin/pakets/${id}`;
                            editForm.querySelector('#edit_jenis_paket').value = data
                                .jenis_paket;
                            editForm.querySelector('#edit_nama_paket').value = data.nama_paket;
                            editForm.querySelector('#edit_isi_paket').value = data.isi_paket;
                            editForm.querySelector('#edit_harga_paket').value = data
                                .harga_paket;
                        });
                });
            });
        });

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

                fetch(`{{ route('admin.pakets.index') }}?search=${query}`)
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
@endsection
