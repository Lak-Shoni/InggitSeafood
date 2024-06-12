@extends('layout.client')

@section('title', 'Daftar Menu')
@section('content')    
    
    <div class="container mt-5">
        <h1>Menu Katering</h1>

        <div id="alert-container"></div>

        <div class="row">
            @foreach($menus as $menu)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset('storage/images/' . $menu->gambar_menu) }}" class="card-img-top" alt="{{ $menu->nama_menu }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $menu->nama_menu }}</h5>
                            <p class="card-text">{{ $menu->isi_menu }}</p>
                            <p class="card-text"><strong>Harga: </strong>{{ $menu->harga_menu }}</p>
                            <form class="add-to-cart-form" data-menu-id="{{ $menu->id }}">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.add-to-cart-form').submit(function(event) {
                event.preventDefault();

                var form = $(this);
                var menuId = form.data('menu-id');

                $.ajax({
                    url: '{{ route("cart.add") }}',
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        var alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            'Menu berhasil ditambahkan ke keranjang.' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span>' +
                            '</button>' +
                            '</div>';
                        $('#alert-container').html(alertHtml);
                    },
                    error: function(xhr) {
                        var alertHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            'Terjadi kesalahan. Silakan coba lagi.' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span>' +
                            '</button>' +
                            '</div>';
                        $('#alert-container').html(alertHtml);
                    }
                });
            });
        });
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
