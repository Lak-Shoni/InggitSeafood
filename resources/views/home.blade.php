<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Inggit Seafood Katering</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    {{-- <link href="{{ asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon"> --}}

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Amatic+SC&family=Inter:wght@400;700&family=Poppins:wght@400;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('css/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/swiper/swiper-bundle.min.css') }}" rel="stylesheet">


    <!-- Template Main CSS File -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>

<body>

    @include('components.navbar') <!-- Include the navbar component -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center justify-content-center section-bg"
        style="background-image: url('{{ asset('img/hero-bg.png') }}');height: 100vh;" data-aos="fade-up"
        data-aos-delay="200">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center">
                    <h2 data-aos="fade-up">Selamat Datang<br>Di Inggit Seafood</h2>
                    <p data-aos="fade-up" data-aos-delay="100">Melayani pemesanan katering untuk acara hajatan, nikahan,
                        khitanan dan acara lainnya </p>
                    <div class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('client.paket.index') }}" class="btn-book-a-table">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>About Us</h2>
                    <p>Learn More <span>About Us</span></p>
                </div>

                <div class="row gy-4">
                    <div class="col-lg-7 position-relative about-img"
                        style="background-image: url('{{ asset('img/about.jpg') }}');" data-aos="fade-up"
                        data-aos-delay="150">
                        <div class="call-us position-absolute">
                            <h4>Pesan Sekarang</h4>
                            <p>082257168691</p>
                        </div>
                    </div>
                    <div class="col-lg-5 d-flex align-items-end" data-aos="fade-up" data-aos-delay="300">
                        <div class="content ps-0 ps-lg-5">
                            <p>
                                PT Inggit Seafood Katering merupakan salah satu bisnis yang bergerak pada bidang kuliner
                                berupa penyedia jasa layanan katering. Usaha ini didirikan sejak 2014 oleh Inggit Rizka
                                Prastiwi. PT Inggit Seafood Katering terletak di Perum De Salvia Residence, Blk. E
                                No.13, Desa Tanjungrejo, Kecamatan Sukun, Kota Malang, Jawa Timur. Jasa layanan katering
                                ini memiliki beberapa pegawai dengan tugas kerja yang berbeda-beda di antaranya,
                                manager, admin, tim memasak, tim pengemasan, dan tim pembelian.
                            </p>

                            <div class="position-relative mt-4">
                                <img src="{{ asset('img/about-2.jpg') }}"class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

        <!-- ======= Why Us Section ======= -->
        <section id="why-us" class="why-us section-bg">
            <div class="container" data-aos="fade-up">
                <div class="row gy-4">

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="why-box" style="height: 280px">
                            <h3>Layanan Kami</h3>
                            <p>Kami menyediakan layanan katering dan prasmanan untuk berbagai acara yang Anda pesan</p>
                        </div>
                    </div><!-- End Why Box -->


                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="row gy-4">

                            <div class="col-xl-6" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <img src="{{ asset('img/katering.png') }}" alt="" class=""
                                        style="width: 60px; height: 60px;">
                                    <h4>Layanan Katering</h4>
                                    <p>Nikmati pengalaman katering profesional dengan beragam menu berkualitas tinggi
                                        untuk segala jenis acara.</p>
                                </div>
                            </div><!-- End Icon Box -->

                            <div class="col-xl-6" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <img src="{{ asset('img/prasmanan.png') }}" alt="" class=""
                                        style="width: 60px; height: 60px;">
                                    <h4>Layanan Prasmanan</h4>
                                    <p>Sajikan hidangan lezat dan berkualitas dengan layanan prasmanan kami yang praktis
                                        dan istimewa.</p>
                                </div>
                            </div><!-- End Icon Box -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Why Us Section -->

        {{-- favorit menu section --}}
        <section class="fav-menu" data-aos="fade-up" data-aos-delay="300">
            <div class="container">
                <div class="section-header">
                    <p>Paket <span>Populer</span></p>
                </div>
                <div class="wrapper">
                    <i id="left" class="fa-solid fa-angle-left"></i>
                    <ul class="carousel">
                        @foreach ($fav_pakets as $paket)
                            <li class="card">
                                <div class="img">
                                    <img src="{{ asset('storage/images/' . $paket->gambar_paket) }}"
                                        alt="{{ $paket->nama_paket }}" draggable="false">
                                </div>
                                <h2>Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</h2>
                                <h1>{{ $paket->nama_paket }}</h1>
                                <p>{{ $paket->isi_paket }}</p>
                                <form class="add-to-cart-form" data-paket-id="{{ $paket->id }}">
                                    @csrf
                                    <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                                    <button type="submit" class="btn btn-primary"> Tambah ke Keranjang</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                    <i id="right" class="fa-solid fa-angle-right"></i>
                </div>
            </div>
            <a href="{{ route('client.paket.index') }}" class="btn btn-primary align-items-center">Lihat paket
                Lainnya</a>
        </section>


        {{-- end --}}

        <!-- ======= Testimonials Section ======= -->
        <section id="testimonials" class="testimonials section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>Testimonials</h2>
                    <p>What Are They <span>Saying About Us</span></p>
                </div>

                <div class="slides-1 swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="row gy-4 justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="testimonial-content">
                                            <p>
                                                <i class="bi bi-quote quote-icon-left"></i>
                                                Proin iaculis purus consequat sem cure digni ssim donec porttitora entum
                                                suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh
                                                et. Maecen aliquam, risus at semper.
                                                <i class="bi bi-quote quote-icon-right"></i>
                                            </p>
                                            <h3>Saul Goodman</h3>
                                            <h4>Ceo &amp; Founder</h4>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                                    class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <img src="{{ asset('img/testimonials/testimonials-1.jpg') }}"
                                            class="img-fluid testimonial-img" alt="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- End testimonial item -->

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section>
        <!-- End Testimonials Section -->


        <!-- ======= Gallery Section ======= -->
        <section id="gallery" class="gallery section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>gallery</h2>
                    <p>Check <span>Our Gallery</span></p>
                </div>

                <div class="gallery-slider swiper">
                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="{{ asset('img/gallery/gallery-1.jpg') }}"><img
                                    src="{{ asset('img/gallery/gallery-1.jpg') }}" class="img-fluid"
                                    alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="{{ asset('img/gallery/gallery-1.jpg') }}"><img
                                    src="{{ asset('img/gallery/gallery-2.jpg') }}" class="img-fluid"
                                    alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="{{ asset('img/gallery/gallery-1.jpg') }}"><img
                                    src="{{ asset('img/gallery/gallery-3.jpg') }}" class="img-fluid"
                                    alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="{{ asset('img/gallery/gallery-1.jpg') }}"><img
                                    src="{{ asset('img/gallery/gallery-4.jpg') }}" class="img-fluid"
                                    alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="{{ asset('img/gallery/gallery-1.jpg') }}"><img
                                    src="{{ asset('img/gallery/gallery-5.jpg') }}" class="img-fluid"
                                    alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="{{ asset('img/gallery/gallery-1.jpg') }}"><img
                                    src="{{ asset('img/gallery/gallery-6.jpg') }}" class="img-fluid"
                                    alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="{{ asset('img/gallery/gallery-1.jpg') }}"><img
                                    src="{{ asset('img/gallery/gallery-7.jpg') }}" class="img-fluid"
                                    alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="{{ asset('img/gallery/gallery-1.jpg') }}"><img
                                    src="{{ asset('img/gallery/gallery-8.jpg') }}" class="img-fluid"
                                    alt=""></a></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section>
        <!-- End Gallery Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>Contact</h2>
                    <p>Need Help? <span>Contact Us</span></p>
                </div>

                <div class="mb-3">

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.083498046567!2d112.60888457476835!3d-7.990313892035276!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7883b1d055c6eb%3A0x5b503c77eafe02f9!2sDe%20salvia%20E-13!5e0!3m2!1sid!2sid!4v1720593336797!5m2!1sid!2sid"
                        width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div><!-- End Google Maps -->

                <div class="row gy-4">

                    <div class="col-md-6">
                        <div class="info-item  d-flex align-items-center">
                            <i class="icon bi bi-map flex-shrink-0"></i>
                            <div>
                                <h3>Our Address</h3>
                                <p>Perum De Salvia Residence, Blk. E No.13, Desa Tanjungrejo, Kecamatan Sukun, Kota
                                    Malang, Jawa Timur</p>
                            </div>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center">
                            <i class="icon bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email Us</h3>
                                <p>inggitSeafood@gmail.com</p>
                            </div>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item  d-flex align-items-center">
                            <i class="icon bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Call Us</h3>
                                <p>082257168691</p>
                            </div>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item  d-flex align-items-center">
                            <i class="icon bi bi-share flex-shrink-0"></i>
                            <div>
                                <h3>Opening Hours</h3>
                                <div><strong>Mon-Sat:</strong> 11AM - 23PM;
                                    <strong>Sunday:</strong> Closed
                                </div>
                            </div>
                        </div>
                    </div><!-- End Info Item -->

                </div>
                <form action="{{ url('/contact') }}" method="post" role="form"
                    class="php-email-form p-3 p-md-4">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 form-group">
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Your Name" required>
                        </div>
                        <div class="col-xl-6 form-group">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Your Email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject" id="subject"
                            placeholder="Subject" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                    </div>
                    <div class="my-3">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>
                    </div>
                    <div class="text-center"><button type="submit">Send Message</button></div>
                </form>
            </div>
            <script src="{{ asset('js/validate.js') }}"></script>
            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    @include('components.footer')

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    {{-- <div id="preloader"></div> --}}

    <!-- Vendor JS Files -->
    <script src="{{ asset('js/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/aos/aos.js') }}"></script>
    <script src="{{ asset('js/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('js/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('js/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/php-email-form/validate.js') }}"></script>


    <!-- Template Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            var $carousel = $('.carousel');
            var $leftButton = $('#left');
            var $rightButton = $('#right');

            $leftButton.click(function() {
                $carousel.animate({
                    scrollLeft: '-=300'
                }, 300);
            });

            $rightButton.click(function() {
                $carousel.animate({
                    scrollLeft: '+=300'
                }, 300);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.add-to-cart-form').submit(function(event) {
                event.preventDefault();

                var form = $(this);
                var paketId = form.data('paket-id');

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
                        var alertHtml =
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.php-email-form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const loading = document.querySelector('.loading');
                    const errorMessage = document.querySelector('.error-message');
                    const sentMessage = document.querySelector('.sent-message');

                    if (loading) loading.classList.add('d-block');

                    const formData = new FormData(form);
                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (loading) loading.classList.remove('d-block');
                            if (data.success) {
                                if (sentMessage) sentMessage.classList.add('d-block');
                                form.reset(); // Clear form after successful submission
                            } else {
                                if (errorMessage) errorMessage.classList.add('d-block');
                                if (errorMessage) errorMessage.innerHTML = data.message ||
                                    'Form submission failed and no error message returned from: ' + form
                                    .action;
                            }
                        })
                        .catch((error) => {
                            if (loading) loading.classList.remove('d-block');
                            if (errorMessage) errorMessage.classList.add('d-block');
                            if (errorMessage) errorMessage.innerHTML =
                                'Form submission failed! Please try again later.';
                        });
                });
            }
        });
    </script>

</body>

</html>
