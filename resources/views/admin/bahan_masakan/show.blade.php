@extends('layout.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Content -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h1>Detail Bahan Masakan</h1>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="bahanDropdown">Pilih Bahan Masakan:</label>
                                    <select id="bahanDropdown" class="form-control" onchange="location = this.value;">
                                        @foreach ($bahanMasakanList as $bahan)
                                            <option value="{{ route('admin.bahan_masakan.show', $bahan->id) }}"
                                                {{ $bahan->id == $selectedBahan->id ? 'selected' : '' }}>
                                                {{ $bahan->nama_bahan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button class="btn btn-success mb-2" data-toggle="modal"
                                    data-target="#bahanMasukModal">Bahan Masuk</button>
                                <button class="btn btn-warning mb-2" data-toggle="modal"
                                    data-target="#bahanKeluarModal">Bahan Keluar</button>
                            </div>

                            <div class="d-flex justify-content-end align-items-end mb-4 mr-2">
                                <form id="searchForm" method="GET"
                                    action="{{ route('admin.bahan_masakan.show', $selectedBahan->id) }}"
                                    class="form-inline">
                                    <div class="form-group mb-2 position-relative">
                                        <label for="start_date" class="mr-2">Pilih tanggal:</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ request('start_date') }}">
                                    </div>
                                    <div class="form-group mb-2 position-relative">
                                        <label for="end_date" class="mr-2 ml-2">-</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="{{ request('end_date') }}">
                                        <span id="clearSearch" class="position-absolute"
                                            style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; display: none;">&times;</span>
                                    </div>
                                </form>
                            </div>

                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal Transaksi</th>
                                        <th>Bahan Masuk</th>
                                        <th>Bahan Keluar</th>
                                        <th>Jumlah Bahan</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody id="dataBody">
                                    @foreach ($transaksiList as $transaksi)
                                        <tr>
                                            <td>{{ $transaksi->tanggal_transaksi }}</td>
                                            <td>{{ $transaksi->bahan_masuk }}</td>
                                            <td>{{ $transaksi->bahan_keluar }}</td>
                                            <td>{{ $transaksi->jumlah_bahan }}</td>
                                            <td>{{ $bahan->satuan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center m-3">
                                {!! $transaksiList->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Bahan Masuk -->
    <div class="modal fade" id="bahanMasukModal" tabindex="-1" role="dialog" aria-labelledby="bahanMasukModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="bahanMasukForm" action="{{ route('admin.bahan_masakan.bahan_masuk', $selectedBahan->id) }}"
                    method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="bahanMasukModalLabel">Tambah Bahan Masuk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bahan_masuk">Jumlah Bahan Masuk</label>
                            <input type="number" class="form-control" id="bahan_masuk" name="bahan_masuk" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_transaksi_masuk">Tanggal Transaksi</label>
                            <input type="date" class="form-control" id="tanggal_transaksi_masuk" name="tanggal_transaksi"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Bahan Keluar -->
    <div class="modal fade" id="bahanKeluarModal" tabindex="-1" role="dialog" aria-labelledby="bahanKeluarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="bahanKeluarForm" action="{{ route('admin.bahan_masakan.bahan_keluar', $selectedBahan->id) }}"
                    method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="bahanKeluarModalLabel">Tambah Bahan Keluar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bahan_keluar">Jumlah Bahan Keluar</label>
                            <input type="number" class="form-control" id="bahan_keluar" name="bahan_keluar" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_transaksi_keluar">Tanggal Transaksi</label>
                            <input type="date" class="form-control" id="tanggal_transaksi_keluar"
                                name="tanggal_transaksi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const clearSearch = document.getElementById('clearSearch');
            const dataBody = document.getElementById('dataBody');
            const selectedBahanId = '{{ $selectedBahan->id }}';

            if (startDateInput.value || endDateInput.value) {
                clearSearch.style.display = 'block';
            }

            [startDateInput, endDateInput].forEach(input => {
                input.addEventListener('input', function() {
                    const startDate = startDateInput.value;
                    const endDate = endDateInput.value;
                    clearSearch.style.display = startDate || endDate ? 'block' : 'none';
                    fetchData(startDate, endDate);
                });
            });

            clearSearch.addEventListener('click', function() {
                startDateInput.value = '';
                endDateInput.value = '';
                clearSearch.style.display = 'none';
                fetchData();
            });

            function fetchData(startDate = '', endDate = '') {
                const url = startDate || endDate ?
                    `{{ route('admin.bahan_masakan.show', $selectedBahan->id) }}?start_date=${startDate}&end_date=${endDate}` :
                    `{{ route('admin.bahan_masakan.show', $selectedBahan->id) }}`;

                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newBody = doc.getElementById('dataBody').innerHTML;
                        dataBody.innerHTML = newBody;
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            document.getElementById('bahanMasukForm').addEventListener('submit', function(event) {
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
                            $('#bahanMasukModal').modal('hide');
                            fetchData();
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

            document.getElementById('bahanKeluarForm').addEventListener('submit', function(event) {
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
                            $('#bahanKeluarModal').modal('hide');
                            fetchData();
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
@endsection
