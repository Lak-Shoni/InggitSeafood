<!-- resources/views/components/navbar.blade.php -->
<link href="{{ asset('css/main.css')}}" rel="stylesheet">
<style>
    /* Gaya untuk tautan dropdown */
.navbar .dropdown-menu a {
    display: block;
    padding: 10px 20px;
    color: #333;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.navbar .dropdown-menu a:hover {
    background-color: #f8f9fa;
}

.header{
    background-color: #fff; /* Ubah warna latar belakang sesuai kebutuhan */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan */
    transition: box-shadow 0.3s ease; /* Animasi perubahan bayangan */
}
/* Gaya untuk navbar saat digulir */
.header.scrolled {
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1); /* Atur bayangan yang lebih besar saat navbar digulir */
}

/* Gaya untuk tombol logout */
.navbar .dropdown-menu button {
    display: block;
    width: 100%;
    padding: 10px 20px;
    background-color: transparent;
    border: none;
    color: #333;
    text-align: left;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.navbar .dropdown-menu button:hover {
    background-color: #f8f9fa;
}

/* Gaya untuk tautan nama pengguna */
.navbar .nav-link.dropdown-toggle {
    color: #333;
    cursor: pointer;
}

/* Gaya untuk dropdown menu */
.navbar .dropdown-menu {
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

/* Gaya untuk item dropdown aktif */
.navbar .dropdown-item.active {
    background-color: #007bff;
    color: #fff;
}

</style>

<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('img/logo-inggit.png') }}" alt="" style="width: 150px; height: auto">
        
        {{-- <h1>Yummy<span>.</span></h1> --}}
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="/">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="{{ route('client.menu.index') }}">Menu</a></li>
          <li><a href="{{ route('cart.show') }}">Keranjang @auth<sup class="text-danger">{{$notif}}</sup>@endauth</a></li>
          <li><a href="#events">Events</a></li>
          <li><a href="#contact">Contact</a></li>
          @auth
            @if(auth()->user()->is_admin)
                <li><a href="{{ route('admin.dashboard') }}">Admin</a></li>
            @endif
          @endauth
        </ul>
      </nav><!-- .navbar -->

      @auth
      <li class="navbar">
        <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           Welcome, {{ auth()->user()->nama }}
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('profile') }}">Lihat Profil</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item">Logout</button>
            </form>
        </div>
      </li>   
@else
    <div class="btn-group">
        <a class="btn-book-a-table" href="{{ url('/login') }}">Login</a>
        <a class="btn-book-a-table mx-2" style="background-color: white; border: 2px solid #01562C; color: #01562C;" href="{{ url('/register') }}">Register</a>
        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
    </div>
@endauth

      
    </div>
</header><!-- End Header -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
      $('.dropdown-toggle').click(function() {
          $(this).next('.dropdown-menu').toggleClass('show');
      });

      $(document).click(function(e) {
          if (!$(e.target).closest('.dropdown-toggle').length && !$(e.target).closest('.dropdown-menu').length) {
              $('.dropdown-menu').removeClass('show');
          }
      });
  });
  $(document).ready(function() {
    // Ketika halaman dimuat
    if ($(window).scrollTop() > 0) {
        $('.header').addClass('scrolled');
    }

    // Ketika pengguna menggulir halaman
    $(window).scroll(function() {
        if ($(this).scrollTop() > 0) {
            $('.header').addClass('scrolled');
        } else {
            $('.header').removeClass('scrolled');
        }
    });
});

</script>
