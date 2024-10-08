@extends('layout.client')

@section('title', 'Keranjang')
@section('content')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .custom-title {
            font-size: 2.5rem;
            /* Mengatur ukuran font */
            color: #ffffff !important;
            /* Warna teks menjadi putih agar kontras dengan background */
            text-align: center;
            /* Mengatur perataan teks */
            padding: 20px 0;
            /* Padding atas dan bawah */
            margin: 0;
            /* Margin bawah */
            background-color: #01562C;
            /* Warna latar belakang */

            /* Membuat sudut rounded */
            font-family: 'Roboto', sans-serif;
            /* Font family */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            /* Efek shadow */
        }
    </style>

    <div class="container mt-5">
        <h1 class="mb-4 custom-title w-100">Keranjang Belanja</h1>

        {{-- @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif --}}
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
        @if ($carts->isEmpty())
            <div class="col-12 text-center">
                <img src="{{ asset('img/cart-no-found0.png') }}" alt="Menu tidak ditemukan" style="max-width: 300px;"
                    class="img-fluid mb-3">
                <h5 class="text-muted">Oops! Keranjang Kosong.</h5>
                <p class="text-muted">Kamu belum memasukkan paket ke dalam keranjang. <a href="{{ route('client.paket.index') }}" style="font-weight: 600">Lihat Paket Disini</a></p>
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Paket</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($carts as $cart)
                        <tr>
                            <td>
                                <input type="checkbox" class="cart-checkbox mr-2" style="transform: scale(2);"
                                    value="{{ $cart->id }}" data-id="{{ $cart->id }}">
                                {{ ucwords($cart->paket->nama_paket) }}
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary decrement" data-id="{{ $cart->id }}"
                                            type="button">-</button>
                                    </div>
                                    <input type="input" class="form-control quantity" data-id="{{ $cart->id }}"
                                        value="{{ $cart->quantity }}" style="width: 1px; text-align: center;">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary increment" data-id="{{ $cart->id }}"
                                            type="button">+</button>
                                    </div>
                                </div>
                            </td>
                            <td>Rp. {{ number_format($cart->paket->harga_paket, 0, ',', '.') }}</td>
                            <td class="total" data-id="{{ $cart->id }}">Rp.
                                {{ number_format($cart->paket->harga_paket * $cart->quantity, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <form action="{{ route('cart.delete', $cart->id) }}" method="POST" class="delete-form"
                                        style="display:inline;">
                                        @csrf

                                        <button type="button" class="btn btn-danger delete-btn">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-right">
                <h4>Total Harga Semua Pesanan: <span id="grand-total"></span></h4>
                <form id="order-form" action="{{ route('checkout.form') }}" method="GET">
                    @csrf
                    <input type="hidden" name="cart_ids" id="cart-ids">
                    <input type="hidden" name="grand_total" id="grand-total-input">
                    <button type="submit" class="btn btn-success">Buat Pesanan</button>
                </form>
            </div>
            @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                const deleteBtn = form.querySelector('.delete-btn');

                deleteBtn.addEventListener('click', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Hapus Item?',
                        text: "Apakah kamu ingin menghapus item ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Tidak',
                        confirmButtonText: 'Iya'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#order-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var selectedCarts = [];
                $('.cart-checkbox:checked').each(function() {
                    selectedCarts.push($(this).val());
                });

                if (selectedCarts.length === 0) {
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Pilih setidaknya satu paket untuk membuat pesanan.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $('#cart-ids').val(selectedCarts.join(',')); // Set value of hidden input
                $('#grand-total-input').val($('#grand-total').text()); // Set value of grand total input

                // Submit the form
                this.submit();
            });

            $('.increment').click(function() {
                var id = $(this).data('id');
                var quantity = parseInt($(`.quantity[data-id=${id}]`).val()) + 1;
                updateCart(id, quantity);
            });

            $('.decrement').click(function() {
                var id = $(this).data('id');
                var quantity = parseInt($(`.quantity[data-id=${id}]`).val()) - 1;
                if (quantity < 1) {
                    quantity = 1;
                }
                updateCart(id, quantity);
            });

            $('.quantity').on('keyup', function() {
                var id = $(this).data('id');
                var quantity = parseInt($(`.quantity[data-id=${id}]`).val());
                if (quantity < 1) {
                    quantity = 1;
                }
                updateCart(id, quantity);
            });

            $('.cart-checkbox').change(function() {
                var id = $(this).data('id');
                var quantity = parseInt($(`.quantity[data-id=${id}]`).val());
                updateCart(id, quantity);
            });

            function updateCart(id, quantity) {
                $.ajax({
                    url: '{{ url('/cart/update') }}/' + id,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        quantity: quantity
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.success) {
                            $(`.quantity[data-id=${id}]`).val(quantity);
                            $(`.total[data-id=${id}]`).text(response.total);
                            updateGrandTotal();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            function updateGrandTotal() {
                var grandTotal = 0;
                $('.cart-checkbox:checked').each(function() {
                    var id = $(this).val();
                    var total = $(`.total[data-id=${id}]`).text();
                    total = total.replaceAll("Rp. ", "")
                    total = parseFloat(total.replaceAll(".", ""))
                    grandTotal += total;
                    console.log(total);
                    console.log(grandTotal);
                });
                var format = grandTotal.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                format = format.replaceAll(",", ".")
                $('#grand-total').text('Rp. ' + format);
            }
        });
    </script>

@endsection
