<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Register</title>
    <link href="{{ asset('css/aos/aos.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('{{ asset('img/login-bg-1.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .register-container {
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 100%;
            max-width: 400px;
        }

        .register-container h2 {
            margin-bottom: 20px;
        }

        .login-link {
            margin-top: 15px;
            font-size: 14px;
        }

        .form-control {
            border-radius: 0;
        }

        .btn,
        .btn:focus {
            background-color: #01562C;
            border: none;
            font-size: 16px;
            color: #fff;
            padding: 8px 20px;
            border-radius: none;
            transition: 0.3s;
        }

        .register:active {
            background-color: #01562C;
            border: none;
            font-size: 16px;
            color: #fff;
            padding: 8px 20px;
            border-radius: none;
            transition: 0.3s;
        }

        .btn:hover {
            color: #01562C;
            background: #CCDBD1;
        }

        /* Hides the spinner for Chrome, Safari, Edge, and Opera */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hides the spinner for Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body data-aos="fade-up">
    <div class="register-container" data-aos="fade-up" data-aos-delay ="100">
        <h2 class="text-center">Register</h2>

        <form action="/register" method="post">
            @csrf


            @if (Session::has('success'))
                <div class="alert alert-success">
                    <strong>Pendaftaran berhasil!</strong> {{ Session::get('success') }}
                </div>
            @endif

            <div class="form-group">
                <label for="username">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}"
                    required>
                @error('nama')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="no_telpon">Nomor Telepon</label>
                <input type="number" class="form-control" id="no_telpon" name="no_telpon"
                    value="{{ old('no_telpon') }}" required>
                @error('no_telpon')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}"
                    required>
                @error('alamat')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-block">Register</button>
            <p class="login-link text-center">Sudah punya akun? <a href="/login"
                    style="color: #01562C; font-weight:500">Login di sini</a></p>
        </form>
    </div>
    <script src="{{ asset('js/aos/aos.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        AOS.init();
    </script>
    <script>
        @if (Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ Session::get('error') }}',
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            });
        @endif

        @if (Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ Session::get('success') }}',
            });
        @endif
    </script>
</body>

</html>
