@extends('layout.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
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
                                <h2>Inventaris</h2>
                            </div>
                            <div class="d-flex justify-content-between align-items-end mb-4">
                                <button class="btn btn-success mb-2" data-toggle="modal"
                                    data-target="#addInventoryModal">Tambah Inventaris</button>
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
                                            <td>{{ formatRupiah($inventory->harga_satuan) }}</td>
                                            <td>{{ formatRupiah($inventory->total_harga) }}</td>
                                            <td>{{ $inventory->tanggal_pembaruan_terakhir }}</td>
                                            <td>
                                                <div style="display: flex; gap: 10px;">
                                                    <button class="btn btn-primary edit-btn" data-id="{{ $inventory->id }}"
                                                        data-toggle="modal" data-target="#editInventoryModal">Edit</button>


                                                    <form action="{{ route('admin.inventories.destroy', $inventory->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus inventaris ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {!! $inventories->appends(request()->query())->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Inventaris -->
        <div class="modal fade" id="addInventoryModal" tabindex="-1" role="dialog"
            aria-labelledby="addInventoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addInventoryModalLabel">Tambah Inventaris</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('admin.inventories.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang:</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori:</label>
                                <input type="text" class="form-control" id="kategori" name="kategori" required>
                            </div>
                            <div class="form-group">
                                <label for="jumlah">Jumlah:</label>
                                <input type="text" inputmode="numeric" class="form-control" id="jumlah"
                                    name="jumlah" required>
                            </div>
                            <div class="form-group">
                                <label for="satuan">Satuan:</label>
                                <input type="text" class="form-control" id="satuan" name="satuan" required>
                            </div>
                            <div class="form-group">
                                <label for="kondisi">Kondisi:</label>
                                <input type="text" class="form-control" id="kondisi" name="kondisi" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_pembelian">Tanggal Pembelian:</label>
                                <input type="date" class="form-control" id="tanggal_pembelian"
                                    name="tanggal_pembelian" required>
                            </div>
                            <div class="form-group">
                                <label for="harga_satuan">Harga Satuan:</label>
                                <input type="text" inputmode="numeric" class="form-control" id="harga_satuan"
                                    name="harga_satuan" required>
                            </div>
                            <div class="form-group">
                                <label for="total_harga">Total Harga:</label>
                                <input type="text" inputmode="numeric" class="form-control" id="total_harga"
                                    name="total_harga" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit Inventaris -->
        <div class="modal fade" id="editInventoryModal" tabindex="-1" role="dialog"
            aria-labelledby="editInventoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editInventoryModalLabel">Edit Inventaris</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" id="editInventoryForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit_nama_barang">Nama Barang:</label>
                                <input type="text" class="form-control" id="edit_nama_barang" name="nama_barang"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="edit_kategori">Kategori:</label>
                                <input type="text" class="form-control" id="edit_kategori" name="kategori" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_jumlah">Jumlah:</label>
                                <input type="text" inputmode="numeric" class="form-control" id="edit_jumlah"
                                    name="jumlah" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_satuan">Satuan:</label>
                                <input type="text" class="form-control" id="edit_satuan" name="satuan" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_kondisi">Kondisi:</label>
                                <input type="text" class="form-control" id="edit_kondisi" name="kondisi" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_tanggal_pembelian">Tanggal Pembelian:</label>
                                <input type="date" class="form-control" id="edit_tanggal_pembelian"
                                    name="tanggal_pembelian" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_harga_satuan">Harga Satuan:</label>
                                <input type="text" inputmode="numeric" class="form-control" id="edit_harga_satuan"
                                    name="harga_satuan" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_total_harga">Total Harga:</label>
                                <input type="text" inputmode="numeric" class="form-control" id="edit_total_harga"
                                    name="total_harga" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var jumlahInput = document.getElementById('jumlah');
            var hargaSatuanInput = document.getElementById('harga_satuan');
            var totalHargaInput = document.getElementById('total_harga');

            function updateTotalHarga() {
                var jumlah = parseFloat(jumlahInput.value) || 0;
                var hargaSatuan = parseFloat(hargaSatuanInput.value) || 0;
                totalHargaInput.value = jumlah * hargaSatuan;
            }

            jumlahInput.addEventListener('input', updateTotalHarga);
            hargaSatuanInput.addEventListener('input', updateTotalHarga);

            var editJumlahInput = document.getElementById('edit_jumlah');
            var editHargaSatuanInput = document.getElementById('edit_harga_satuan');
            var editTotalHargaInput = document.getElementById('edit_total_harga');

            function updateEditTotalHarga() {
                var jumlah = parseFloat(editJumlahInput.value) || 0;
                var hargaSatuan = parseFloat(editHargaSatuanInput.value) || 0;
                editTotalHargaInput.value = jumlah * hargaSatuan;
            }

            editJumlahInput.addEventListener('input', updateEditTotalHarga);
            editHargaSatuanInput.addEventListener('input', updateEditTotalHarga);

            // Form search
            var searchInput = document.getElementById('search');
            var clearSearchBtn = document.getElementById('clearSearch');

            searchInput.addEventListener('input', function() {
                if (searchInput.value.trim() === '') {
                    clearSearchBtn.style.display = 'none';
                } else {
                    clearSearchBtn.style.display = 'inline';
                }
            });

            clearSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                document.getElementById('searchForm').submit();
            });

            document.querySelectorAll('.edit-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');

                    fetch(`/admin/inventories/${id}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('editInventoryForm').setAttribute('action',
                                `/admin/inventories/${id}`);
                            document.getElementById('edit_nama_barang').value = data
                                .nama_barang;
                            document.getElementById('edit_kategori').value = data.kategori;
                            document.getElementById('edit_jumlah').value = data.jumlah;
                            document.getElementById('edit_satuan').value = data.satuan;
                            document.getElementById('edit_kondisi').value = data.kondisi;
                            document.getElementById('edit_tanggal_pembelian').value = data
                                .tanggal_pembelian;
                            document.getElementById('edit_harga_satuan').value = data
                                .harga_satuan;
                            document.getElementById('edit_total_harga').value = data
                                .total_harga;
                        })
                        .catch(error => console.error('Error fetching inventory:', error));
                });
            });

        });
    </script>
@endsection
