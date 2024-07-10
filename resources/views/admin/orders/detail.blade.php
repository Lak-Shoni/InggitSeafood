<div>
    <h5>Kode Pesanan: {{ $order->order_code }}</h5>
    <p>Tanggal Pesanan: {{ $order->created_at }}</p>
    <p>Waktu Pengiriman: {{ $order->delivery_time }}</p>
    <p>Metode Pembayaran: {{ $order->payment_method }}</p>
    <p>Status Pembayaran: {{ $order->payment_status }}</p>
    <p>Status Pesanan: {{ $order->order_status }}</p>
    <h6>Items:</h6>
    <ul>
        @foreach ($order->orderItems as $item)
            <li>{{ $item->name }} - {{ $item->quantity }} pcs</li>
        @endforeach
    </ul>
</div>
