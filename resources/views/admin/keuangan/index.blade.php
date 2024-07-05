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
                            <h2>Data Keuangan</h2>
                            <!-- Form untuk menambahkan dan mengedit data -->
                            <form method="POST" action="{{ route('admin.keuangan.store') }}" id="dataForm">
                                @csrf
                                <input type="hidden" id="formMethod" name="_method" value="POST">
                                <input type="hidden" id="editId" name="id">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="transaction_date">Tanggal Transaksi</label>
                                        <input type="date" class="form-control" id="transaction_date"
                                            name="transaction_date" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="omset">Omset</label>
                                        <input type="text" class="form-control" id="omset" name="omset" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="purchasing">Purchasing</label>
                                        <input type="text" class="form-control" id="purchasing" name="purchasing"
                                            required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="tenagaKerja">Tenaga Kerja</label>
                                        <input type="text" class="form-control" id="tenagaKerja" name="tenaga_kerja"
                                            required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pln">PLN/Listrik</label>
                                        <input type="text" class="form-control" id="pln" name="pln" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="akomodasi">Akomodasi</label>
                                        <input type="text" class="form-control" id="akomodasi" name="akomodasi" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="sewaAlat">Sewa alat</label>
                                        <input type="text" class="form-control" id="sewaAlat" name="sewa_alat" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="profit">Profit</label>
                                        <input type="text" class="form-control" id="profit" name="profit" required>
                                    </div>
                                    <div class="form-group col-md-3 align-self-end">
                                        <button type="submit" class="btn btn-primary" id="submitButton">Tambah
                                            Data</button>
                                    </div>
                                </div>
                            </form>

                            <div class="d-flex justify-content-end align-items-end mb-4 mr-2">
                                <form id="searchForm" method="GET" action="{{ route('admin.keuangan.index') }}"
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
                                            <td>{{ $data->omset }}</td>
                                            <td>{{ $data->purchasing }}</td>
                                            <td>{{ $data->tenaga_kerja }}</td>
                                            <td>{{ $data->pln }}</td>
                                            <td>{{ $data->akomodasi }}</td>
                                            <td>{{ $data->sewa_alat }}</td>
                                            <td>{{ $data->profit }}</td>
                                            <td>
                                                <form action="{{ route('admin.keuangan.destroy', $data->id) }}"
                                                    method="POST" class="delete-form" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-danger delete-btn">Hapus</button>
                                                </form>

                                                <button class="btn btn-primary editButton"
                                                    data-id="{{ $data->id }}">Edit</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {!! $dataKeuangan->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dataForm = document.getElementById('dataForm');
            const submitButton = document.getElementById('submitButton');
            const formMethod = document.getElementById('formMethod');
            const editId = document.getElementById('editId');
            const dataFields = {
                transaction_date: document.getElementById('transaction_date'),
                omset: document.getElementById('omset'),
                purchasing: document.getElementById('purchasing'),
                tenaga_kerja: document.getElementById('tenagaKerja'),
                pln: document.getElementById('pln'),
                akomodasi: document.getElementById('akomodasi'),
                sewa_alat: document.getElementById('sewaAlat'),
                profit: document.getElementById('profit')
            };

            document.querySelectorAll('.editButton').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    fetch(`/admin/keuangan/${id}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            Object.keys(dataFields).forEach(key => {
                                dataFields[key].value = data[key];
                            });
                            formMethod.value = 'PUT';
                            dataForm.action = `/admin/keuangan/${id}`;
                            editId.value = id;
                            submitButton.textContent = 'Update Data';
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            dataForm.addEventListener('reset', function() {
                formMethod.value = 'POST';
                dataForm.action = '{{ route('admin.keuangan.store') }}';
                editId.value = '';
                submitButton.textContent = 'Tambah Data';
            });
        });
    </script>
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
@endsection
