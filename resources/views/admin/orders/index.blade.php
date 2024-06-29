@extends('layout.admin')

@section('title', 'Daftar Pesanan')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h1>Daftar Pesanan</h1>
                            <div class="d-flex justify-content-end">
                                <form method="GET" action="{{ route('admin.orders.index') }}" class="form-inline mb-2">
                                    <div class="form-group mb-2">
                                        <label for="search" class="mr-2">Cari berdasarkan Kode:</label>
                                        <input type="name" class="form-control" id="search" name="search"
                                            value="{{ request('search') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary  mb-2 ml-2">Cari</button>
                                </form>
                            </div>
                            <br>
                            <table id="example2" class="table table-bordered table-hover">
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

                                                    @case('selesai')
                                                        <span class="badge badge-success">Selesai</span>
                                                    @break

                                                    @case('kirim')
                                                        <span class="badge badge-info">Sedang Dikirim</span>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <span>
                                                    @if ($order->payment_status != 'paid')
                                                        <a href="{{ url('/order/lunas/' . $order->id) }}"
                                                            class="btn btn-success"><i
                                                                class="fa-solid fa-money-bills"></i></a>
                                                    @endif
                                                    @if ($order->order_status != 'selesai')
                                                        @if ($order->order_status != 'terima')
                                                            @if ($order->order_status != 'kirim')
                                                                <a href="{{ url('/order/kirim/' . $order->id) }}"
                                                                    class="btn btn-info"><i
                                                                        class="fa-solid fa-paper-plane"></i></a>
                                                            @endif
                                                        @endif
                                                        <a href="{{ url('/order/selesai/' . $order->id) }}"
                                                            class="btn btn-success"><i class="fa-solid fa-check"></i></a>
                                                    @endif
                                                    <button class="btn btn-primary detail_pesanan" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal"
                                                        data-id="{{ $order->id }}">Detail</button>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {!! $orders->appends(request()->query())->links() !!}
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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Konten detail pesanan akan dimuat di sini menggunakan Ajax -->
                        <h2>hai</h2>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.detail_pesanan').on('click', function() {
                var orderId = $(this).data('id');
                // Lakukan Ajax request untuk mendapatkan detail pesanan
                $.ajax({
                    url: '/order/detail/' + orderId,
                    method: 'GET',
                    success: function(data) {
                        $('.modal-body').html(data);
                    }
                });
            });
        });
    </script>
@endsection
