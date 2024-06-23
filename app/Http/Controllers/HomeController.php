<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class HomeController extends Controller
{
    public function index(){
        $menus = Menu::all(); // Mengambil semua data menu dari database
        $user = Auth::user();
        if($user != null){
            $cart = Cart::where('user_id', $user->id)->where('status_order', 0)->get();
            $notif = count($cart);
            return view('home', compact('menus', 'notif')); // Mengirim data menu ke view home
        }else{
            return view('home', compact('menus')); // Mengirim data menu ke view home
        }
    }
}
