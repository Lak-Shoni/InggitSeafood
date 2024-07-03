@extends('layout.client')

@section('title', 'Daftar Menu')
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
                            @foreach ($categories as $category)
                                <div class="accordion-item category-rating">
                                    <h2 class="accordion-header" id="heading{{ $category->id }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $category->id }}">
                                            {{ $category->name }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $category->id }}" class="accordion-collapse collapse show"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body category-scroll">
                                            <ul class="category-list">
                                                @foreach ($category->menus as $menu)
                                                    <li>
                                                        <div class="form-check ps-0 custome-form-check">
                                                            <input class="checkbox_animated check-it"
                                                                id="menu{{ $menu->id }}" name="menu"
                                                                value="{{ $menu->id }}" type="checkbox">
                                                            <label class="form-check-label"
                                                                for="menu{{ $menu->id }}">{{ $menu->name }}</label>
                                                            <p class="font-light">({{ $menu->count }})</p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
                        @foreach ($categories as $category)
                            @foreach ($category->menus as $menu)
                                <div class="col">
                                    <div class="product-box" data-category="{{ $category->id }}">
                                        <div class="img-wrapper">
                                            <div class="front">
                                                <a href="{{ url('product/' . $menu->slug) }}">
                                                    <img src="{{ asset('img/menu/' . $menu->image) }}" class="bg-img"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="back">
                                                <a href="{{ url('product/' . $menu->slug) }}">
                                                    <img src="{{ asset('img/menu/' . $menu->image) }}" class="bg-img"
                                                        alt="">
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
                                                <span class="font-light grid-content">{{ $menu->description }}</span>
                                            </div>
                                            <div class="main-price">
                                                <a href="{{ url('product/' . $menu->slug) }}" class="font-default">
                                                    <h5 class="ms-0">{{ $menu->name }}</h5>
                                                </a>
                                                <div class="listing-content">
                                                    <span class="font-light">{{ $menu->description }}</span>
                                                    <p class="font-light">{{ $menu->details }}</p>
                                                </div>
                                                <h3 class="theme-color">${{ $menu->price }}</h3>
                                                <button class="btn listing-content">Add To Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
            var checkboxes = document.querySelectorAll('.checkbox_animated');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    // Filter products based on selected categories
                    // You need to implement this part to filter products
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                    if (selectedCategories.includes(productCategory)) {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                });
            }
        });
    </script>

@endsection
