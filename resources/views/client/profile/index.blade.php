@extends('layout.client')

@section('title', 'Profile')
@section('content') 
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Hello {{ auth()->user()->nama }}</h1>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Nama:</strong> {{ $user->nama }}
                        </li>
                        <li class="list-group-item">
                            <strong>No Telpon:</strong> {{ $user->no_telpon }}
                        </li>
                        <li class="list-group-item">
                            <strong>Alamat:</strong> {{ $user->alamat }}
                        </li>
                    </ul>
                    {{-- <div class="text-center mt-3">
                        <a href="{{ route('editProfile') }}" class="btn btn-primary">Edit Profile</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection