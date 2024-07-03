<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <link href="{{ asset('css/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            background-image: url('{{asset('img/login-bg-2.jpg')}}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            margin-bottom: 20px;
        }
        .signup-link {
            margin-top: 15px;
            font-size: 14px;
        }
        .form-control {
            border-radius: 0;
        }
        .btn {
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
    </style>
</head>
<body >
    <div class="login-container" data-aos="fade-up" data-aos-delay="100">
        <h2 class="text-center">Login</h2>

        <form action="/login" method="post">
            @csrf
            <div class="form-group">
                <label for="no_telpon">Nomor Telepon</label>
                <input type="number" class="form-control" id="no_telpon" name="no_telpon" value="{{ old('no_telpon') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-block">Login</button>
            <p class="signup-link text-center">Belum punya akun? <a href="/register" style="color: #01562C; font-weight:500">Daftar di sini</a></p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/aos/aos.js') }}"></script>
    <script>
        AOS.init();

        @if ($errors->has('no_telpon'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first('no_telpon') }}',
            });
        @endif

        @if ($errors->has('password'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first('password') }}',
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
