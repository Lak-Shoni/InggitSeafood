@extends('layout.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Modal for Adding/Editing Data -->
            <!-- Modal -->
            <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="dataModalLabel">Tambah Data Keuangan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="dataForm" method="POST">
                                @csrf
                                <input type="hidden" id="formMethod" name="_method" value="POST">
                                <input type="hidden" id="editId" name="id">
                                <div class="form-group">
                                    <label for="transaction_date">Tanggal Transaksi</label>
                                    <input type="date" class="form-control" id="transaction_date" name="transaction_date"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="tenagaKerja">Tenaga Kerja</label>
                                    <input type="number" inputmode="numeric" class="form-control" id="tenagaKerja"
                                        name="tenaga_kerja" required>
                                </div>
                                <div class="form-group">
                                    <label for="pln">PLN</label>
                                    <input type="number" inputmode="numeric" class="form-control" id="pln"
                                        name="pln" required>
                                </div>
                                <div class="form-group">
                                    <label for="akomodasi">Akomodasi</label>
                                    <input type="number" inputmode="numeric" class="form-control" id="akomodasi"
                                        name="akomodasi" required>
                                </div>
                                <div class="form-group">
                                    <label for="sewaAlat">Sewa Alat</label>
                                    <input type="number" inputmode="numeric" class="form-control" id="sewaAlat"
                                        name="sewa_alat" required>
                                </div>
                                <div class="form-group">
                                    <label for="purchasing">Purchasing</label>
                                    <input type="number" inputmode="numeric" class="form-control" id="purchasing"
                                        name="purchasing" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="omset">Omset</label>
                                    <input type="number" inputmode="numeric" class="form-control" id="omset"
                                        name="omset" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="profit">Profit</label>
                                    <input type="number" inputmode="numeric" class="form-control" id="profit"
                                        name="profit" readonly>
                                </div>
                                <button type="submit" id="submitButton" class="btn btn-primary">Tambah Data</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="printModalLabel">Cetak Rekap Keuangan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.keuangan.download_pdf') }}" method="GET">
                                <div class="d-flex">
                                    <div class="form-group col-4">
                                        <label for="month">Bulan</label>
                                        <select name="month" id="month" class="form-control">
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ $m == date('m') ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="year">Tahun</label>
                                        <select name="year" id="year" class="form-control">
                                            @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                                <option value="{{ $y }}"
                                                    {{ $y == date('Y') ? 'selected' : '' }}>
                                                    {{ $y }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Cetak Rekap Keuangan PDF</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


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
                                <h2>Data Keuangan</h2>

                                <button class="btn btn-success mb-3" data-toggle="modal" data-target="#dataModal"
                                    id="addDataButton">Tambah Data</button>
                                <button class="btn btn-success mb-3" data-toggle="modal" data-target="#printModal"
                                    id="printButton">Cetak Rekap Keuangan</button>

                                @if ($dataKeuangan->isEmpty())
                                    <div class="col-12 text-center">
                                        <img src="{{ asset('img/no-keuangan.png') }}" alt="Menu tidak ditemukan"
                                            style="max-width: 300px;" class="img-fluid mb-3">
                                        <h5 class="text-muted" style="margin-top: -50px;">Oops! Data Keuangan Kosong.</h5>
                                        <p class="text-muted">Belum ada transaksi keuangan</p>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-end align-items-end mb-4 mr-2">
                                        <form id="searchForm" method="GET" action="{{ route('admin.keuangan.index') }}"
                                            class="form-inline">
                                            <div class="form-group mb-2 position-relative">
                                                <label for="start_date" class="mr-2">Pilih tanggal:</label>
                                                <input type="date" class="form-control" id="start_date"
                                                    name="start_date" value="{{ request('start_date') }}">
                                            </div>
                                            <div class="form-group mb-2 position-relative">
                                                <label for="end_date" class="mr-2 ml-2">-</label>
                                                <input type="date" class="form-control" id="end_date"
                                                    name="end_date" value="{{ request('end_date') }}">
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
                                                        href="{{ route('admin.keuangan.index', ['sort_by' => 'transaction_date', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                        Tanggal Transaksi
                                                        @if (request('sort_by') == 'transaction_date')
                                                            <i
                                                                class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                        @else
                                                            <i class="fas fa-sort"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th>
                                                    <a
                                                        href="{{ route('admin.keuangan.index', ['sort_by' => 'omset', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                        Omset
                                                        @if (request('sort_by') == 'omset')
                                                            <i
                                                                class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                        @else
                                                            <i class="fas fa-sort"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th>
                                                    <a
                                                        href="{{ route('admin.keuangan.index', ['sort_by' => 'purchasing', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                        Purchasing
                                                        @if (request('sort_by') == 'purchasing')
                                                            <i
                                                                class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                        @else
                                                            <i class="fas fa-sort"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th>
                                                    <a
                                                        href="{{ route('admin.keuangan.index', ['sort_by' => 'tenaga_kerja', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                        Tenaga Kerja
                                                        @if (request('sort_by') == 'tenaga_kerja')
                                                            <i
                                                                class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                        @else
                                                            <i class="fas fa-sort"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th>
                                                    <a
                                                        href="{{ route('admin.keuangan.index', ['sort_by' => 'pln', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                        PLN/Listrik
                                                        @if (request('sort_by') == 'pln')
                                                            <i
                                                                class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                        @else
                                                            <i class="fas fa-sort"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th>
                                                    <a
                                                        href="{{ route('admin.keuangan.index', ['sort_by' => 'akomodasi', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                        Akomodasi
                                                        @if (request('sort_by') == 'akomodasi')
                                                            <i
                                                                class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                        @else
                                                            <i class="fas fa-sort"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th>
                                                    <a
                                                        href="{{ route('admin.keuangan.index', ['sort_by' => 'sewa_alat', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                        Sewa Alat
                                                        @if (request('sort_by') == 'sewa_alat')
                                                            <i
                                                                class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                        @else
                                                            <i class="fas fa-sort"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th>
                                                    <a
                                                        href="{{ route('admin.keuangan.index', ['sort_by' => 'profit', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                        Profit
                                                        @if (request('sort_by') == 'profit')
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
                                            @foreach ($dataKeuangan as $data)
                                                <tr>
                                                    <td>{{ $data->transaction_date }}</td>
                                                    <td>{{ formatRupiah($data->omset) }}</td>
                                                    <td>{{ formatRupiah($data->purchasing) }}</td>
                                                    <td>{{ formatRupiah($data->tenaga_kerja) }}</td>
                                                    <td>{{ formatRupiah($data->pln) }}</td>
                                                    <td>{{ formatRupiah($data->akomodasi) }}</td>
                                                    <td>{{ formatRupiah($data->sewa_alat) }}</td>
                                                    <td>{{ formatRupiah($data->profit) }}</td>
                                                    <td>
                                                        <form action="{{ route('admin.keuangan.destroy', $data->id) }}"
                                                            method="POST" class="delete-form" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-danger delete-btn">Hapus</button>
                                                        </form>

                                                        <button class="btn btn-primary btn editButton"
                                                            data-id="{{ $data->id }}" data-toggle="modal"
                                                            data-target="#dataModal">Edit</button>


                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                <div class="d-flex justify-content-center">
                                    {!! $dataKeuangan->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const clearSearch = document.getElementById('clearSearch');
            const dataBody = document.getElementById('dataBody');

            // Show clear icon if search inputs are not empty
            if (startDateInput.value || endDateInput.value) {
                clearSearch.style.display = 'block';
            }

            // Listen for input changes
            [startDateInput, endDateInput].forEach(input => {
                input.addEventListener('input', function() {
                    const startDate = startDateInput.value;
                    const endDate = endDateInput.value;

                    // Show clear icon if search inputs are not empty
                    clearSearch.style.display = startDate || endDate ? 'block' : 'none';

                    // Make AJAX request to search
                    fetchData(startDate, endDate);
                });
            });

            // Clear search inputs when clear icon is clicked
            clearSearch.addEventListener('click', function() {
                startDateInput.value = '';
                endDateInput.value = '';
                clearSearch.style.display = 'none';
                fetchData(); // Fetch all data when inputs are cleared
            });

            function fetchData(startDate = '', endDate = '') {
                const url = startDate || endDate ?
                    `{{ route('admin.keuangan.index') }}?start_date=${startDate}&end_date=${endDate}` :
                    `{{ route('admin.keuangan.index') }}`;

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
    <script>
        $(document).ready(function() {
            // Initialize the modal with empty fields
            $('#addDataButton').click(function() {
                $('#dataModalLabel').text('Tambah Data Keuangan');
                $('#dataForm').attr('action', '{{ route('admin.keuangan.store') }}');
                $('#formMethod').val('POST');
                $('#dataForm')[0].reset();
                $('#submitButton').text('Tambah Data');
            });

            // Populate the modal with data when editing
            $('.editButton').click(function() {
                var id = $(this).data('id');
                $.get('/admin/keuangan/' + id + '/edit', function(data) {
                    $('#dataModalLabel').text('Edit Data Keuangan');
                    $('#dataForm').attr('action', '/admin/keuangan/' + id);
                    $('#formMethod').val('PUT');
                    $('#editId').val(data.id);
                    $('#transaction_date').val(data.transaction_date);
                    $('#omset').val(data.omset);
                    $('#purchasing').val(data.purchasing);
                    $('#tenagaKerja').val(data.tenaga_kerja);
                    $('#pln').val(data.pln);
                    $('#akomodasi').val(data.akomodasi);
                    $('#sewaAlat').val(data.sewa_alat);
                    $('#profit').val(data.profit);
                    $('#submitButton').text('Simpan Perubahan');
                    calculateFinancials();
                });
            });

            // Calculate omset, purchasing, and profit automatically when relevant fields change
            $('#transaction_date, #tenagaKerja, #pln, #akomodasi, #sewaAlat').on('input change', function() {
                calculateFinancials();
            });

            function calculateFinancials() {
                var transactionDate = $('#transaction_date').val();
                var tenagaKerja = parseFloat($('#tenagaKerja').val()) || 0;
                var pln = parseFloat($('#pln').val()) || 0;
                var akomodasi = parseFloat($('#akomodasi').val()) || 0;
                var sewaAlat = parseFloat($('#sewaAlat').val()) || 0;

                if (transactionDate) {
                    // Get omset
                    $.get('/admin/keuangan/getOmset/' + transactionDate, function(omset) {
                        $('#omset').val(omset);

                        $.get('/admin/keuangan/getPurchasing/' + transactionDate)
                            .done(function(purchasing) {
                                // $('#purchasing').val(purchasing);
                                $('#purchasing').val(purchasing);
        
                                // Calculate profit
                                var totalExpenses = purchasing + tenagaKerja + pln + akomodasi +
                                    sewaAlat;
                                var profit = omset - totalExpenses;
        
                                $('#profit').val(profit);
                            })
                            .fail(function() {
                                alert('Gagal mengambil data purchasing. Coba lagi nanti.');
                            });

                        // Get purchasing
                        // $.get('/admin/keuangan/getPurchasing/' + transactionDate, function(purchasing) {
                        // });
                    });
                }
            }
        });
    </script>

@endsection
