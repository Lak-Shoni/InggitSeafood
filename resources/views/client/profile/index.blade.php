@extends('layout.client')

@section('title', 'Profile')
@section('content')
    <style>
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .custom-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .custom-table td {
            background-color: #fff;
        }

        .custom-table tr:hover td {
            background-color: #f1f1f1;
        }

        .order-details {
            padding: 20px;
        }

        .order-details h4 {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-card {
            width: 100%;
            max-width: 600px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-card-header {
            background-color: #01562C;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .profile-card-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .profile-card-body {
            padding: 20px;
        }

        .profile-card-body ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .profile-card-body li {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .profile-card-body li:last-child {
            border-bottom: none;
        }

        .profile-card-body li strong {
            display: inline-block;
            width: 120px;
        }

        .btn-edit-profile {
            background-color: #01562C;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
    <div class="container mt-5">
        <div class="profile-container">
            <div class="profile-card">
                <div class="profile-card-header">
                    <h1>Hello {{ auth()->user()->nama }}</h1>
                </div>
                <div class="profile-card-body">
                    <ul>
                        <li><strong>Nama:</strong> {{ $user->nama }}</li>
                        <li><strong>No Telpon:</strong> {{ $user->no_telpon }}</li>
                        <li><strong>Alamat:</strong> {{ $user->alamat }}</li>
                        <li><strong>Total Hutang:</strong> Rp. {{ number_format($hutang, 0, ',', '.') }}</li>
                    </ul>
                    <div class="text-center mt-3">
                        <a href="{{ route('profile.edit') }}" class="btn-edit-profile">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="col-md-12">
            <h3>Riwayat Pesanan</h3>
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
                                href="{{ route('profile', ['sort_by' => 'id', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                Kode Pesanan
                                @if (request('sort_by') == 'id')
                                    <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('profile', ['sort_by' => 'created_at', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                Tanggal Pesanan
                                @if (request('sort_by') == 'created_at')
                                    <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('profile', ['sort_by' => 'delivery_time', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                Waktu Pengiriman
                                @if (request('sort_by') == 'delivery_time')
                                    <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('profile', ['sort_by' => 'payment_method', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                Metode Pembayaran
                                @if (request('sort_by') == 'payment_method')
                                    <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('profile', ['sort_by' => 'payment_status', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                Status Pembayaran
                                @if (request('sort_by') == 'payment_status')
                                    <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('profile', ['sort_by' => 'order_status', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                Status Pesanan
                                @if (request('sort_by') == 'order_status')
                                    <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        @if ($order->user_id == Auth::id())
                            <tr>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->delivery_time }}</td>
                                <td>
                                    @if ($order->payment_method == 'bayar_langsung')
                                        Bayar Langsung
                                    @elseif ($order->payment_method == 'bayar_ditempat')
                                        Bayar di Tempat
                                    @elseif ($order->payment_method == 'bayar_dengan_tenggat_waktu')
                                        Bayar dengan Tenggat Waktu
                                    @endif
                                </td>
                                <td>
                                    @if ($order->payment_status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif ($order->payment_status == 'paid')
                                        <span class="badge badge-success">Lunas</span>
                                    @elseif ($order->payment_status == 'failed')
                                        <span class="badge badge-danger">Gagal</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->order_status == 'proses')
                                        <span class="badge badge-warning">Sedang Diproses</span>
                                    @elseif ($order->order_status == 'selesai')
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif ($order->order_status == 'kirim')
                                        <span class="badge badge-info">Sedang Dikirim</span>
                                    @elseif ($order->order_status == 'terima')
                                        <span class="badge badge-info">Diterima</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="display: flex; gap: 10px;">
                                        @if ($order->order_status != 'proses' && $order->order_status != 'selesai')
                                            @if ($order->order_status != 'terima')
                                                <a href="{{ url('/order/terima/' . $order->id) }}" class="btn btn-success">
                                                    Terima
                                                </a>
                                            @endif
                                        @endif
                                        <a href="{{ route('orders.pdf', $order->id) }}" class="btn btn-success">
                                            <i class="fa-solid fa-file-pdf"></i> Download Invoice
                                        </a>
                                        <button class="btn btn-primary detail_pesanan" data-bs-toggle="modal"
                                            data-bs-target="#orderDetailModal"
                                            data-id="{{ $order->id }}">Detail</button>
                                    </span>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center m-3">
                {!! $orders->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}
            </div>

        </div>
    </div>

    <!-- Modal -->
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
                    {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button> --}}
                    <button type="button" class="btn btn-primary">Oke</button>
                </div>
            </div>
        </div>
    </div>

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

                        function formatRupiah(number) {
                            return 'Rp ' + number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g,
                                '.');
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
                        html += '<tr><th>Total Harga</th><td>' + formatRupiah(response.total_price) +
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
                            html += '<td>' + formatRupiah((item.total_per_item)) + '</td>';
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
@endsection
