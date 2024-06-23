<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showProfile()
{
    $user = Auth::user();
    $orders = Order::where('user_id', $user->id)->get();
    return view('client.profile.index', compact('user','orders'));
}
}
