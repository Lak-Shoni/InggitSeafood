<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Jenis_Paket;
use App\Models\Paket;

class ClientPaketController extends Controller
{
    // public function index()
    // {
    //     $paket = Menu::all();
    //     $user = Auth::user();
    //     if($user != null){
    //         $cart = Cart::where('user_id', $user->id)->where('status_order', 0)->get();
    //         $notif = count($cart);
    //         return view('client.menu.index', compact('paket', 'notif'));
    //     }else{
    //         return view('client.menu.index', compact('paket'));
    //     }

    // }
    public function index(Request $request)
    {
        $jenis_id = $request->query('jenis_id');
        
        if ($jenis_id) {
            $pakets = Paket::where('jenis_paket', $jenis_id)->get();
        } else {
            $pakets = Paket::all();
        }

        $jenis = Jenis_Paket::all();
        $user = Auth::user();
        $notif = 0;

        if ($user != null) {
            $cart = Cart::where('user_id', $user->id)->where('status_order', 0)->get();
            $notif = count($cart);
        }

        return view('client.paket.index', compact('pakets', 'jenis', 'notif'));
    }
}
