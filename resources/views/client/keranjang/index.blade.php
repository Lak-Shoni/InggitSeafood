@extends('layout.client')

@section('title', 'Keranjang')
@section('content')

    <div class="container mt-5">
        <h1>Keranjang Belanja</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carts as $cart)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input cart-checkbox" style="transform: scale(1.5);" value="{{ $cart->id }}">
                            {{ $cart->menu->nama_menu }}
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary decrement" data-id="{{ $cart->id }}" type="button">-</button>
                                </div>
                                <input type="text" class="form-control quantity" data-id="{{ $cart->id }}" value="{{ $cart->quantity }}" readonly style="width: 1px; text-align: center;">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary increment" data-id="{{ $cart->id }}" type="button">+</button>
                                </div>
                            </div>
                        </td>
                        <td>{{ $cart->menu->harga_menu }}</td>
                        <td class="total" data-id="{{ $cart->id }}">{{ $cart->menu->harga_menu * $cart->quantity }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <form action="{{ route('cart.delete', $cart->id) }}" method="POST" class="d-inline ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
    </div>

    <script>
        $(document).ready(function() {
            $('#order-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var selectedCarts = [];
                $('.cart-checkbox:checked').each(function() {
                    selectedCarts.push($(this).val());
                });

                if (selectedCarts.length === 0) {
                    alert('Pilih setidaknya satu menu untuk membuat pesanan.');
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

            $('.cart-checkbox').change(function() {
                updateGrandTotal();
            });

            function updateCart(id, quantity) {
                $.ajax({
                    url: '{{ url("/cart/update") }}/' + id,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        quantity: quantity
                    },
                    success: function(response) {
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
                    grandTotal += parseFloat($(`.total[data-id=${id}]`).text());
                });
                $('#grand-total').text(grandTotal);
            }
        });
    </script>

@endsection
