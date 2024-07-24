<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Paket;

class HomeController extends Controller
{
    public function index()
    {
        $fav_pakets = Paket::orderBy('purchase_count', 'desc')->take(8)->get(); // Mengambil 8 paket terfavorit
        $user = Auth::user();

        if ($user != null) {
            $cart = Cart::where('user_id', $user->id)->where('status_order', 0)->get();
            $notif = count($cart);
            return view('home', compact('fav_pakets', 'notif')); // Mengirim data paket terfavorit ke view home
        } else {
            return view('home', compact('fav_pakets')); // Mengirim data paket terfavorit ke view home
        }
    }
}
