@extends('layout.admin')

@section('title', 'Daftar Pesanan')
@section('content')
<div class="container mt-5">
    <h1>Daftar Pesanan</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>Waktu Pengiriman</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Total Harga</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->nama }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->delivery_time }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>{{ $order->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
