@extends('layout.admin')

@section('title', 'Daftar Pesanan')
@section('content')
    <style>
        table {
            table-layout: fixed;
            width: 100%;
        }

        th,
        td {
            width: 14.28%;
            /* Karena ada 7 kolom, maka 100% dibagi 7 */
            text-align: left;
        }

        .order-actions .btn {
            margin-bottom: 0.5rem;
        }



        .custom-pagination .page-item {
            margin: 0 5px;
        }

        .custom-pagination .page-item .page-link {
            color: #007bff;
            border-radius: 50%;
            padding: 10px 15px;
            border: none;
        }

        .custom-pagination .page-item.active .page-link {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .custom-pagination .page-item.disabled .page-link {
            color: #6c757d;
        }

        .custom-pagination .page-link {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .custom-pagination .page-link:hover {
            background-color: #0056b3;
            color: white;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h1>Daftar Pesanan</h1>
                            <div class="d-flex justify-content-end align-items-end mb-4 mr-2">
                                <form id="searchForm" method="GET" action="{{ route('admin.orders.index') }}"
                                    class="form-inline">
                                    <div class="form-group mb-2 position-relative">
                                        <label for="search" class="mr-2">Cari berdasarkan kode:</label>
                                        <input type="text" class="form-control" id="search" name="search"
                                            value="{{ request('search') }}">
                                        <span id="clearSearch" class="position-absolute"
                                            style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; display: none;">&times;</span>
                                    </div>
                                </form>
                            </div>

                            <table id="example2" class="table table-bordered table-hover">
                                <colgroup>
                                    <col style="width: 8%;">
                                    <col style="width: 10%;">
                                    <col style="width: 15%;">
                                    <col style="width: 17%;">
                                    <col style="width: 16%;">
                                    <col style="width: 12%;">
                                    <col style="width: 14%;">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>
                                            <a
                                                href="{{ route('admin.orders.index', ['sort_by' => 'id', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Kode Pesanan
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
                                                href="{{ route('admin.orders.index', ['sort_by' => 'created_at', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Tanggal Pesanan
                                                @if (request('sort_by') == 'created_at')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.orders.index', ['sort_by' => 'delivery_time', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Waktu Pengiriman
                                                @if (request('sort_by') == 'delivery_time')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.orders.index', ['sort_by' => 'payment_method', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Metode Pembayaran
                                                @if (request('sort_by') == 'payment_method')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.orders.index', ['sort_by' => 'payment_status', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Status Pembayaran
                                                @if (request('sort_by') == 'payment_status')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.orders.index', ['sort_by' => 'order_status', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                                Status Pesanan
                                                @if (request('sort_by') == 'order_status')
                                                    <i
                                                        class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @else
                                                    <i class="fas fa-sort"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="dataBody">
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_code }}</td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>{{ $order->delivery_time }}</td>
                                            <td>
                                                @switch($order->payment_method)
                                                    @case('bayar_langsung')
                                                        Bayar Langsung
                                                    @break

                                                    @case('bayar_ditempat')
                                                        Bayar di Tempat
                                                    @break

                                                    @case('bayar_dengan_tenggat_waktu')
                                                        Bayar dengan Tenggat Waktu
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($order->payment_status)
                                                    @case('pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @break

                                                    @case('paid')
                                                        <span class="badge badge-success">Lunas</span>
                                                    @break

                                                    @case('failed')
                                                        <span class="badge badge-danger">Gagal</span>
                                                    @break
                                                @endswitch


                                            </td>
                                            <td>
                                                @switch($order->order_status)
                                                    @case('proses')
                                                        <span class="badge badge-warning">Sedang Diproses</span>
                                                    @break

                                                    @case('terima')
                                                    <span class="badge badge-primary">Sudah Diterima</span>
                                                    @break

                                                    @case('selesai')
                                                        <span class="badge badge-success">Selesai</span>
                                                    @break

                                                    @case('kirim')
                                                        <span class="badge badge-info">Sedang Dikirim</span>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column order-actions">
                                                    @if ($order->payment_status != 'paid')
                                                        <a href="{{ url('/order/lunas/' . $order->id) }}"
                                                            class="btn btn-success">Lunas</a>
                                                    @endif
                                                    @if ($order->order_status != 'selesai')
                                                        @if ($order->order_status != 'terima')
                                                            @if ($order->order_status != 'kirim')
                                                                <a href="{{ url('/order/kirim/' . $order->id) }}"
                                                                    class="btn btn-info">Kirim</a>
                                                            @endif
                                                        @endif
                                                        <a href="{{ url('/order/selesai/' . $order->id) }}"
                                                            class="btn btn-success">Selesai</a>
                                                    @endif
                                                    <button class="btn btn-primary detail_pesanan" data-bs-toggle="modal"
                                                        data-bs-target="#orderDetailModal"
                                                        data-id="{{ $order->id }}">Detail</button>
                                                </div>
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center m-3">
                                {!! $orders->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}
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
        <div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderDetailModalLabel">Detail Pesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal_body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Modal -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.detail_pesanan').click(function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ url('/order/detail') }}/' + id,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response); // Cek response di console log

                        // Fungsi untuk memformat tanggal dan waktu
                        function formatDateTime(dateTimeStr) {
                            var options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            };
                            var date = new Date(dateTimeStr);
                            return date.toLocaleString('id-ID', options);
                        }

                        function formatPaymentMethod(method) {
                            return method.replace(/_/g, ' ').replace(/\b\w/g, function(l) {
                                return l.toUpperCase()
                            });
                        }

                        var html = '<div class="order-details">';
                        html += '<h4>Detail Pesanan</h4>';
                        html += '<table class="custom-table">';
                        html += '<tr><th>Kode Pesanan</th><td>' + response.order_code +
                            '</td></tr>';
                        html += '<tr><th>Nama User</th><td>' + response.user.nama +
                            '</td></tr>';
                        html += '<tr><th>No Telpon</th><td>' + response.user.no_telpon +
                            '</td></tr>';
                        html += '<tr><th>Total Harga</th><td>' + response.total_price +
                            '</td></tr>';
                        html += '<tr><th>Alamat</th><td>' + response.address + '</td></tr>';
                        html += '<tr><th>Nama Instansi</th><td>' + response.partner_name +
                            '</td></tr>';
                        html += '<tr><th>Waktu Pengiriman</th><td>' + formatDateTime(response
                            .delivery_time) + '</td></tr>';
                        html += '<tr><th>Metode Pembayaran</th><td>' + formatPaymentMethod(
                                response.payment_method) +
                            '</td></tr>';
                        html += '<tr><th>Batas Pembayaran</th><td>' + formatDateTime(response
                            .due_date) + '</td></tr>';
                        html += '<tr><th>Catatan</th><td>' + (response.notes ? response.notes :
                            '-') + '</td></tr>';
                        html += '<tr><th>Status Pesanan</th><td>' + response.order_status +
                            '</td></tr>';
                        html += '<tr><th>Status Pembayaran</th><td>' + response.payment_status +
                            '</td></tr>';
                        html += '</table>';

                        html += '<h4>Items</h4>';
                        html += '<table class="custom-table">';
                        html += '<tr><th>Nama Paket</th><th>Jumlah</th><th>Harga</th></tr>';
                        response.items.forEach(function(item) {
                            html += '<tr>';
                            html += '<td>' + item.nama_paket + '</td>';
                            html += '<td>' + item.quantity + '</td>';
                            html += '<td>' + (item.total_per_item) + '</td>';
                            html += '</tr>';
                        });
                        html += '</table>';
                        html += '</div>';

                        $('#modal_body').html(html);
                        $('#orderDetailModal').modal('show'); // Show the modal
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
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
                fetch(`{{ route('admin.orders.index') }}?search=${query}`)
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
