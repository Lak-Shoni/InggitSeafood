@extends('layout.client')

@section('title', 'Edit Profile')
@section('content')
    <style>
        .form-group label {
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #01562C;
            box-shadow: 0 0 5px rgba(1, 86, 44, 0.5);
        }

        .card-header {
            background-color: #01562C;
            color: white;
            padding: 10px;
        }

        .btn-primary {
            background-color: #01562C;
            border: none;
        }

        .btn-primary:hover {
            background-color: #013d21;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Edit Profil</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ $user->nama }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="no_telpon">No Telpon</label>
                                <input type="text" name="no_telpon"
                                    class="form-control @error('no_telpon') is-invalid @enderror"
                                    value="{{ $user->no_telpon }}" required>
                                @error('no_telpon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" required>{{ $user->alamat }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('profile') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert for Success Message -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    <!-- SweetAlert for Error Messages -->
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            });
        </script>
    @endif
@endsection
