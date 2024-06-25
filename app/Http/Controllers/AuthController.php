<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'no_telpon' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:8',
            'alamat' => 'required|string',
            'is_admin' => 'boolean',
        ]);
    
        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Pendaftaran gagal. Mohon isi semua kolom dengan benar.');
        }
        $user = User::create([
            'nama' => $request->nama,
            'no_telpon' => $request->input('no_telpon'),
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'is_admin' => $request->input('is_admin', false)
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->is_admin) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil!');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('no_telpon', 'password');

    // Cek apakah nomor telepon terdaftar
    $user = User::where('no_telpon', $credentials['no_telpon'])->first();
    if (!$user) {
        return back()->withErrors([
            'no_telpon' => 'Nomor telepon tidak terdaftar.',
        ])->withInput();
    }

    // Cek apakah password benar
    if (!Hash::check($credentials['password'], $user->password)) {
        return back()->withErrors([
            'password' => 'Password yang dimasukkan salah.',
        ])->withInput();
    }

    // Jika nomor telepon dan password benar
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    return back()->withErrors([
        'no_telpon' => 'The provided credentials do not match our records.',
    ])->withInput();
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
