<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;


class ClientMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        $user = Auth::user();
        if($user != null){
            $cart = Cart::where('user_id', $user->id)->where('status_order', 0)->get();
            $notif = count($cart);
            return view('client.menu.index', compact('menus', 'notif'));
        }else{
            return view('client.menu.index', compact('menus'));
        }

    }
}
