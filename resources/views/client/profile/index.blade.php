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
                        </ul>
                        {{-- <div class="text-center mt-3">
                        <a href="{{ route('editProfile') }}" class="btn btn-primary">Edit Profile</a>
                    </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="col-md-12">
            <h3>Riwayat Pesanan</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id Pesanan</th>
                            <th>Tanggal Pesanan</th>
                            <th>Waktu Pengiriman</th>
                            <th>Metode Pembayaran</th>
                            <th>Status Pembayaran</th>
                            <th>Status Pesanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    {{ $order->id }}
                                </td>
                                <td>
                                    {{ $order->created_at }}
                                </td>
                                <td>
                                    {{ $order->delivery_time }}
                                </td>
                                <td>
                                    <?php
                                    if ($order->payment_method == 'bayar_langsung') {
                                        echo 'Bayar Langsung';
                                    } elseif ($order->payment_method == 'bayar_ditempat') {
                                        echo 'Bayar di Tempat';
                                    } elseif ($order->payment_method == 'bayar_dengan_tenggat_waktu') {
                                        echo 'Bayar dengan Tenggat Waktu';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($order->payment_status == 'pending') {
                                        echo '<span class="badge badge-warning">Pending</span>';
                                    } elseif ($order->payment_status == 'paid') {
                                        echo '<span class="badge badge-success">Lunas</span>';
                                    } elseif ($order->payment_status == 'failed') {
                                        echo '<span class="badge badge-danger">Gagal</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($order->order_status == 'proses') {
                                        echo '<span class="badge badge-warning">Sedang Diproses</span>';
                                    } elseif ($order->order_status == 'selesai') {
                                        echo '<span class="badge badge-success">Selesai</span>';
                                    } elseif ($order->order_status == 'kirim') {
                                        echo '<span class="badge badge-info">Sedang Dikirim</span>';
                                    }
                                    ?>

                                </td>
                                <td>
                                    <span>
                                        <button class="btn btn-primary detail_pesanan" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" data-id="{{ $order->id }}">Detail</button>
                                    </span>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>

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
                        console.log(response)
                        // $('#exampleModal').modal(); 
                        // if (response.success) {
                        //     $(`.quantity[data-id=${id}]`).val(quantity);
                        //     $(`.total[data-id=${id}]`).text(response.total);
                        // }
                        var html = '';
                        html = ``;
                        $('modal_body').html(html);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

        });
    </script>
@endsection
