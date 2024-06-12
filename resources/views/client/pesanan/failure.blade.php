<!-- resources/views/client/pesanan/failure.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Gagal</title>
</head>
<body>
    <h1>Pembayaran Gagal</h1>
    <p>{{ session('error') }}</p>
    <a href="{{ route('cart.show') }}">Kembali ke Keranjang</a>
</body>
</html>
