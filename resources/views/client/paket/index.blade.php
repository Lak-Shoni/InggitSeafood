@extends('layout.client')

@section('title', 'Daftar Paket')
@section('content')
    <style>
        .container h1 {
            font-family: 'Arial', sans-serif;
            font-size: 2rem;
            color: #333;
        }

        .list-group-item a {
            color: #01562C;
            text-decoration: none;
        }

        .list-group-item a:hover {
            text-decoration: underline;
        }

        .card {
            
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            background: #fff;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            /* box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1); */
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            border-radius: 10px 10px 0 0;
            padding: 10px 20px 0 20px;
            /* margin-left: 30px; */
            object-fit: cover;
            /* border: 4px solid #fff;   */
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
            background-color: #01562C;
            color: #fff;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-block:hover {
            background-color: #013d1f;
        }

        .list-group-item a {
            text-decoration: none;
            color: #343a40;
        }

        .list-group-item a:hover {
            color: #01562C;
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

        .custom-title {
            font-size: 2.5rem;
            color: #ffffff !important;
            text-align: center;
            padding: 20px 0;
            margin: 0;
            background-color: #01562C;
            font-family: 'Roboto', sans-serif;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
    </style>
    <div class="container mt-5">
        <h1 class="mb-4 custom-title w-100">Daftar Paket</h1>
        <div class="row">
            <div class="col-md-3">
                <button class="btn btn-primary filter-icon" style="background-color: #01562C;" onclick="toggleFilter()">
                    Filter <i class="fas fa-filter"></i>
                </button>
                <ul class="list-group filter-section">
                    <li class="list-group-item">
                        <a href="{{ url('/paket') }}">Semua</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center" data-toggle="collapse"
                        data-target="#prasmanan-list" aria-expanded="false" aria-controls="prasmanan-list">
                        <div>
                            <i class="fas fa-utensils"></i> Prasmanan
                        </div>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
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
                    <li class="list-group-item d-flex justify-content-between align-items-center" data-toggle="collapse"
                        data-target="#katering-list" aria-expanded="false" aria-controls="katering-list">
                        <div>
                            <i class="fas fa-concierge-bell"></i> Katering
                        </div>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
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
                <div class="row">
                    @foreach ($pakets as $paket)
                        <div class="col-md-4 mb-4 px-2">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('storage/images/' . $paket->gambar_paket) }}" class="card-img-top"
                                    alt="{{ $paket->nama_paket }}">
                                <div class="card-body">
                                    <h5 class="card-title font-weight-bold">{{ $paket->nama_paket }}</h5>
                                    <p class="card-text">{{ $paket->isi_paket }}</p>
                                    <p class="card-text text-danger"><strong>Harga: Rp.
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
                <div class="d-flex justify-content-center m-3">
                    {!! $pakets->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}
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

        document.addEventListener('DOMContentLoaded', function() {
            const collapsibleItems = document.querySelectorAll('.list-group-item[data-toggle="collapse"]');

            collapsibleItems.forEach(item => {
                const dropdownIcon = item.querySelector('.dropdown-icon');
                const targetId = item.getAttribute('data-target');

                item.addEventListener('click', function() {
                    const isCollapsed = this.getAttribute('aria-expanded') === 'true';

                    if (isCollapsed) {
                        dropdownIcon.classList.remove('fa-chevron-up');
                        dropdownIcon.classList.add('fa-chevron-down');
                    } else {
                        dropdownIcon.classList.remove('fa-chevron-down');
                        dropdownIcon.classList.add('fa-chevron-up');
                    }
                });

                $(targetId).on('hidden.bs.collapse', function() {
                    dropdownIcon.classList.remove('fa-chevron-up');
                    dropdownIcon.classList.add('fa-chevron-down');
                });

                $(targetId).on('shown.bs.collapse', function() {
                    dropdownIcon.classList.remove('fa-chevron-down');
                    dropdownIcon.classList.add('fa-chevron-up');
                });
            });
        });

        function toggleFilter() {
            const filterSection = document.querySelector('.filter-section');
            filterSection.style.display = filterSection.style.display === 'none' ? 'block' : 'none';
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
@endsection
