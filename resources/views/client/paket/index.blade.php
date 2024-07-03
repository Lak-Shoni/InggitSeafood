@extends('layout.client')

@section('title', 'Daftar Paket')
@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Paket</h1>
        <div class="row">
            <div class="col-md-3">
                <h2>Kategori</h2>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ url('/paket') }}">Semua</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ url('/paket?is_prasmanan=1') }}">Prasmanan</a>
                        <ul>
                            @foreach ($jenis as $data)
                                @if ($data->is_prasmanan)
                                    <li class="list-group-item">
                                        <a href="{{ url('/paket?jenis_id=' . $data->nama_jenis) }}">{{ $data->nama_jenis }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ url('/paket?is_prasmanan=0') }}">Katering</a>
                        <ul>
                            @foreach ($jenis as $data)
                                @if (!$data->is_prasmanan)
                                    <li class="list-group-item">
                                        <a href="{{ url('/paket?jenis_id=' . $data->nama_jenis) }}">{{ $data->nama_jenis }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <h2>Paket</h2>
                <div class="row">
                    @foreach ($pakets as $paket)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                
                                <img src="{{ asset('storage/images/' . $paket->gambar_paket) }}" class="card-img-top" alt="{{ $paket->nama_paket }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $paket->nama_paket }}</h5>
                                    <p class="card-text">{{ $paket->isi_paket }}</p>
                                    <p class="card-text">Price: ${{ $paket->harga_paket }}</p>
                                    <form class="add-to-cart-form" data-paket-id="{{ $paket->id }}">
                                        @csrf
                                        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                                        <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

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
@endsection
{{-- @extends('layout.client')

@section('title', 'Daftar Paket')
@section('content')

    <head>
        <link id="rtl-link" rel="stylesheet" type="text/css" href="{{ asset('css/template-shop/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/template-shop/ion.rangeSlider.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/template-shop/font-awesome.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/template-shop/feather-icon.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/template-shop/animate.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/template-shop/slick/slick.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/template-shop/slick/slick-theme.css') }}">
        <link id="color-link" rel="stylesheet" type="text/css" href="{{ asset('css/template-shop/demo4.css') }}">
    </head>
    <style>
        .accordion-button {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0.75rem 1.25rem;
            margin: 0;
            font-size: 1rem;
            font-weight: 400;
            text-align: left;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            cursor: pointer;
        }

        .accordion-button:not(.collapsed) {
            color: #0d6efd;
            background-color: #e7f1ff;
        }

        .accordion-collapse {
            display: none;
        }

        .accordion-collapse.show {
            display: block;
        }
    </style>

    <section class="section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 category-side col-md-4">
                    <div class="category-option">
                        <div class="button-close mb-3">
                            <button class="btn p-0"><i data-feather="arrow-left"></i> Close</button>
                        </div>
                        <div class="accordion category-name" id="accordionExample">
                            <div class="accordion-item category-rating">
                                <h2 class="accordion-header" id="headingAll">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseAll">
                                        Semua
                                    </button>
                                </h2>
                                <div id="collapseAll" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body category-scroll">
                                        <ul class="category-list">
                                            <li>
                                                <div class="form-check ps-0 custome-form-check">
                                                    <input class="checkbox_animated check-it" id="all" name="paket"
                                                        value="all" type="checkbox" checked>
                                                    <label class="form-check-label" for="all">Semua</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item category-rating">
                                <h2 class="accordion-header" id="headingPrasmanan">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsePrasmanan">
                                        Prasmanan
                                    </button>
                                </h2>
                                <div id="collapsePrasmanan" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body category-scroll">
                                        <ul class="category-list">
                                            @foreach ($jenis as $data)
                                                @if ($data->is_prasmanan)
                                                    <li>
                                                        <div class="form-check ps-0 custome-form-check">
                                                            <input class="checkbox_animated check-it"
                                                                id="jenis{{ $data->id }}" name="jenis"
                                                                value="{{ $data->nama_jenis }}" type="checkbox">
                                                            <label class="form-check-label"
                                                                for="jenis{{ $data->id }}">{{ $data->nama_jenis }}</label>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item category-rating">
                                <h2 class="accordion-header" id="headingKatering">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseKatering">
                                        Katering
                                    </button>
                                </h2>
                                <div id="collapseKatering" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body category-scroll">
                                        <ul class="category-list">
                                            @foreach ($jenis as $data)
                                                @if (!$data->is_prasmanan)
                                                    <li>
                                                        <div class="form-check ps-0 custome-form-check">
                                                            <input class="checkbox_animated check-it"
                                                                id="jenis{{ $data->id }}" name="jenis"
                                                                value="{{ $data->nama_jenis }}" type="checkbox">
                                                            <label class="form-check-label"
                                                                for="jenis{{ $data->id }}">{{ $data->nama_jenis }}</label>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="category-product col-lg-9 col-12 ratio_30">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <ul class="short-name"></ul>
                        </div>

                        <div class="col-12">
                            <div class="filter-options">
                                <div class="select-options">
                                    <div class="page-view-filter">
                                        <div class="dropdown select-featured">
                                            <select class="form-select" name="orderby" id="orderby">
                                                <option value="-1" selected="">Default</option>
                                                <option value="1">Date, New To Old</option>
                                                <option value="2">Date, Old To New</option>
                                                <option value="3">Price, Low To High</option>
                                                <option value="4">Price, High To Low</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="dropdown select-featured">
                                        <select class="form-select" name="size" id="pagesize">
                                            <option value="12" selected="">12 Products Per Page</option>
                                            <option value="24">24 Products Per Page</option>
                                            <option value="52">52 Products Per Page</option>
                                            <option value="100">100 Products Per Page</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid-options d-sm-inline-block d-none">
                                    <ul class="d-flex">
                                        <li class="two-grid">
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('assets/svg/grid-2.svg') }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li class="three-grid d-md-inline-block d-none">
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('assets/svg/grid-3.svg') }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li class="grid-btn active d-lg-inline-block d-none">
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('assets/svg/grid.svg') }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li class="list-btn">
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('assets/svg/list.svg') }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="row g-sm-4 g-3 row-cols-lg-4 row-cols-md-3 row-cols-2 mt-1 custom-gy-5 product-style-2 ratio_asos product-list-section">
                        @foreach ($pakets as $paket)
                            <div class="col">
                                <div class="product-box" data-category="{{ $paket->jenis_paket }}">
                                    <div class="img-wrapper">
                                        <div class="front">
                                            <a href="{{ url('product/' . $paket->slug) }}">
                                                <img src="{{ asset('storage/images/' . $paket->gambar_paket) }}"
                                                    class="bg-img" alt="">
                                            </a>
                                        </div>
                                        <div class="cart-wrap">
                                            <ul>
                                                <li>
                                                    <a href="javascript:void(0)" class="addtocart-btn">
                                                        <i data-feather="shopping-cart"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-details">
                                        <div class="rating-details">
                                            <span class="font-light grid-content">{{ $paket->deskripsi }}</span>
                                        </div>
                                        <div class="main-price">
                                            <a href="{{ url('product/' . $paket->slug) }}" class="font-default">
                                                <h5 class="ms-0">{{ $paket->nama_paket }}</h5>
                                            </a>
                                            <div class="listing-content">
                                                <span class="font-light">{{ $paket->deskripsi }}</span>
                                                <p class="font-light">{{ $paket->rincian }}</p>
                                            </div>
                                            <h3 class="theme-color">Rp{{ number_format($paket->harga, 0, ',', '.') }}</h3>
                                            <button class="btn listing-content">Add To Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <nav class="page-section">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)" aria-label="Previous"
                                    style="color:#6c757d;">
                                    <span aria-hidden="true">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="javascript:void(0)">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="shop-1.html?page=2">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="shop-1.html?page=3">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)" aria-label="Next" style="color:#6c757d;">
                                    <span aria-hidden="true">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle category accordion
            var accordionItems = document.querySelectorAll('.accordion-item');
            accordionItems.forEach(function(item) {
                item.querySelector('.accordion-button').addEventListener('click', function() {
                    var isOpen = this.getAttribute('aria-expanded') === 'true';
                    accordionItems.forEach(function(otherItem) {
                        if (otherItem !== item) {
                            otherItem.querySelector('.accordion-collapse').classList.remove(
                                'show');
                        }
                    });
                    if (!isOpen) {
                        this.setAttribute('aria-expanded', 'true');
                        item.querySelector('.accordion-collapse').classList.add('show');
                    } else {
                        this.setAttribute('aria-expanded', 'false');
                        item.querySelector('.accordion-collapse').classList.remove('show');
                    }
                });
            });

            // Handle checkbox selection
            // Handle category checkbox selection
            var checkboxes = document.querySelectorAll('.checkbox_animated');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    filterProducts();
                });
            });

            function filterProducts() {
                var selectedCategories = Array.from(checkboxes)
                    .filter(function(checkbox) {
                        return checkbox.checked;
                    })
                    .map(function(checkbox) {
                        return checkbox.value;
                    });

                var products = document.querySelectorAll('.product-box');
                products.forEach(function(product) {
                    var productCategory = product.getAttribute('data-category');
                    if (selectedCategories.length === 0 || selectedCategories.includes(productCategory)) {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                });
            }
        });
    </script>

@endsection --}}
