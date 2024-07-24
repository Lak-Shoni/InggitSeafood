<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Hutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function showProfile(Request $request)
    {
        $query = Order::query();
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('order', 'asc'));
        } else {
            $query->orderBy('created_at', 'desc'); // Default sorting by latest orders
        }
        $orders = $query->paginate(10);
        $user = Auth::user();
        $hutang = Hutang::where('user_id', $user->id)->sum('total'); // Menghitung total hutang

        return view('client.profile.index', compact('user', 'orders', 'hutang'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('client.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telpon' => [
                'required',
                'string',
                'max:15',
                Rule::unique('users', 'no_telpon')->ignore($user->id),
            ],
            'alamat' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ], [
            'no_telpon.unique' => 'Nomor telepon sudah terdaftar. Silakan gunakan nomor lain',
            'password.min' => 'Password harus memiliki minimal 8 karakter',            
        ]);

        $user->nama = $request->nama;
        $user->no_telpon = $request->no_telpon;
        $user->alamat = $request->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
