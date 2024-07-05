@extends('layout.client')

@section('title', 'Profile')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Hello {{ auth()->user()->nama }}</h1>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Nama:</strong> {{ $user->nama }}
                            </li>
                            <li class="list-group-item">
                                <strong>No Telpon:</strong> {{ $user->no_telpon }}
                            </li>
                            <li class="list-group-item">
                                <strong>Alamat:</strong> {{ $user->alamat }}
                            </li>
                            <li class="list-group-item">
                                <strong>Total Hutang:</strong> Rp. {{ number_format($hutang, 0, ',', '.') }}
                            </li>
                        </ul>
                        <div class="text-center mt-3">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                        </div>
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
                                        @if ($order->order_status != 'terima')
                                            <a href="{{ url('/order/terima/' . $order->id) }}" class="btn btn-success"><i
                                                    class="fa-solid fa-check"></i></a>
                                        @endif
                                        <a href="{{ route('orders.pdf', $order->id) }}" class="btn btn-success">
                                            <i class="fa-solid fa-file-pdf"></i> Download Invoice
                                        </a>
                                        <button class="btn btn-primary detail_pesanan" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" data-id="{{ $order->id }}">Detail</button>
                                    </span>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            {!! $orders->appends(request()->query())->links() !!}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    success: function(response) {
                        console.log(response);
                        var html = '<p>Kode Pesanan: ' + response.order_code + '</p>';
                        html += '<p>Tanggal Pesanan: ' + response.created_at + '</p>';
                        html += '<p>Waktu Pengiriman: ' + response.delivery_time + '</p>';
                        html += '<p>Metode Pembayaran: ' + response.payment_method + '</p>';
                        html += '<p>Status Pembayaran: ' + response.payment_status + '</p>';
                        html += '<p>Status Pesanan: ' + response.order_status + '</p>';
                        // Add more fields as necessary
                        $('#modal_body').html(html);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
