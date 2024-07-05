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

                                <a href="{{ route('admin.bahan_masakan.bahan_masuk', $selectedBahan->id) }}"
                                    class="btn btn-success mb-2">Bahan Masuk</a>
                                <a href="{{ route('admin.bahan_masakan.bahan_keluar', $selectedBahan->id) }}"
                                    class="btn btn-warning mb-2">Bahan Keluar</a>
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
                                        <th>
                                            <a
                                                href="{{ route('admin.bahan_masakan.show', ['bahan_masakan' => $selectedBahan->id, 'sort_by' => 'tanggal_transaksi', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Tanggal Transaksi
                                                @if (request('sort_by') == 'tanggal_transaksi')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const clearSearch = document.getElementById('clearSearch');
            const dataBody = document.getElementById('dataBody');
            const selectedBahanId = '{{ $selectedBahan->id }}'; // Add this line to get the selected bahan id

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
        });
    </script>
@endsection
