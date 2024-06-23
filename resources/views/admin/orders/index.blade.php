@extends('layout.admin')

@section('title', 'Daftar Pesanan')
@section('content')
<div class="container mt-5">
    <h1>Daftar Pesanan</h1>
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

                        <?php if($order->payment_status != 'paid'){?>
                        <a href="{{ url('/order/lunas/'.$order->id) }}" class="btn btn-success rounded-circle"><i class="fa-solid fa-money-bills"></i></a>
                        <?php }?>
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
                            <?php if($order->order_status != 'selesai'){?>
                                <?php if($order->order_status != 'kirim'){?>
                                <a href="{{ url('/order/kirim/'.$order->id) }}" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></a>
                                <?php }?>
                                <a href="{{ url('/order/selesai/'.$order->id) }}" class="btn btn-success"><i class="fa-solid fa-check"></i></a>
                            <?php }?>
                            {{-- <button class="btn btn-primary detail_pesanan" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" data-id="{{ $order->id }}">Detail</button> --}}
                        </span>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
