@extends('layout.client')

@section('title', 'Daftar Paket')
@section('content')
<style>
    .list-group-item a {
        text-decoration: none;
        color: #343a40;
    }

    .list-group-item a:hover {
        color: #007bff;
    }

    .list-group-item {
        cursor: pointer;
    }

    .nested-list {
        padding-left: 1.5rem;
    }

    .filter-icon {
        display: none;
    }

    @media (max-width: 768px) {
        .filter-icon {
            display: block;
            margin-bottom: 1rem;
        }

        .filter-section {
            display: none;
        }

        .filter-section.show {
            display: block;
        }
    }
</style>
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Paket</h1>
        <div class="row">        
            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-primary filter-icon" onclick="toggleFilter()">Filter <i class="fas fa-filter"></i></button>
                    <ul class="list-group filter-section">
                        <li class="list-group-item">
                            <a href="{{ url('/paket') }}">Semua</a>
                        </li>
                        <li class="list-group-item" data-toggle="collapse" data-target="#prasmanan-list" aria-expanded="false" aria-controls="prasmanan-list">
                            <i class="fas fa-utensils"></i> Prasmanan <span class="badge badge-primary">{{ $jenis->where('is_prasmanan', 1)->count() }}</span>
                        </li>
                        <ul class="list-group collapse nested-list" id="prasmanan-list">
                            @foreach ($jenis as $data)
                                @if ($data->is_prasmanan)
                                    <li class="list-group-item">
                                        <a href="{{ url('/paket?jenis_id=' . $data->nama_jenis) }}">{{ $data->nama_jenis }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <li class="list-group-item" data-toggle="collapse" data-target="#katering-list" aria-expanded="false" aria-controls="katering-list">
                            <i class="fas fa-concierge-bell"></i> Katering <span class="badge badge-primary">{{ $jenis->where('is_prasmanan', 0)->count() }}</span>
                        </li>
                        <ul class="list-group collapse nested-list" id="katering-list">
                            @foreach ($jenis as $data)
                                @if (!$data->is_prasmanan)
                                    <li class="list-group-item">
                                        <a href="{{ url('/paket?jenis_id=' . $data->nama_jenis) }}">{{ $data->nama_jenis }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </ul>
                </div>
            <!-- Main content area for packages -->
            <div class="col-md-9">
                <h2>Paket</h2>
                <div class="row">
                    @foreach ($pakets as $paket)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('storage/images/' . $paket->gambar_paket) }}" class="card-img-top"
                                    alt="{{ $paket->nama_paket }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $paket->nama_paket }}</h5>
                                    <p class="card-text">{{ $paket->isi_paket }}</p>
                                    <p class="card-text"><strong>Harga: Rp.
                                            {{ number_format($paket->harga_paket, 0, ',', '.') }}</strong></p>
                                    <form class="add-to-cart-form" data-paket-id="{{ $paket->id }}">
                                        @csrf
                                        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                                        <button type="submit" class="btn btn-primary btn-block">Tambah ke
                                            Keranjang</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.add-to-cart-form').submit(function(event) {
                event.preventDefault();

                var form = $(this);

                $.ajax({
                    url: '{{ route('cart.add') }}',
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.notif !== undefined) {
                            // Update the cart badge count
                            $('#cart-badge').text(response.notif);
                        }

                        Swal.fire({
                            title: "Sukses",
                            text: "Pesanan berhasil ditambahkan ke keranjang",
                            icon: "success",
                            showDenyButton: false,
                            showCancelButton: true,
                            cancelButtonText: `Tambah Pesanan Lain`,
                            confirmButtonText: `Lihat Keranjang`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to the cart page
                                window.location.href = `{{ route('cart.show') }}`;
                            }
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan. Silakan coba lagi.",
                            icon: "error",
                        });
                    }
                });
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
        function toggleFilter() {
            const filterSection = document.querySelector('.filter-section');
            filterSection.style.display = filterSection.style.display === 'none' ? 'block' : 'none';
        }
    </script>

    <style>
        .container h1 {
            font-family: 'Arial', sans-serif;
            font-size: 2rem;
            color: #333;
        }

        .list-group-item a {
            color: #007bff;
            text-decoration: none;
        }

        .list-group-item a:hover {
            text-decoration: underline;
        }

        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-title {
            font-family: 'Arial', sans-serif;
            font-size: 1.25rem;
            color: #333;
        }

        .card-text {
            font-family: 'Arial', sans-serif;
            color: #666;
        }

        .btn-block {
            width: 100%;
            font-size: 1rem;
            padding: 0.5rem;
        }
    </style>
@endsection
