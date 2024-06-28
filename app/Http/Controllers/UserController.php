<?php

namespace App\Http\Controllers;

use App\Models\Hutang;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->paginate(10);
        $hutang = Hutang::where('user_id', $user->id)->sum('total'); // Menghitung total hutang
        return view('client.profile.index', compact('user', 'orders', 'hutang'));
    }
}
