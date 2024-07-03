<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Paket;

class HomeController extends Controller
{
    public function index(){
        $pakets = Paket::all(); // Mengambil semua data menu dari database
        $user = Auth::user();
        if($user != null){
            $cart = Cart::where('user_id', $user->id)->where('status_order', 0)->get();
            $notif = count($cart);
            return view('home', compact('pakets', 'notif')); // Mengirim data menu ke view home
        }else{
            return view('home', compact('pakets')); // Mengirim data menu ke view home
        }
    }
}
