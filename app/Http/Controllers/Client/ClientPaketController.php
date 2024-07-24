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
    public function index(Request $request)
    {
        $jenis_id = $request->query('jenis_id');
        $query = Paket::query();

        if ($jenis_id) {
            $query->where('jenis_paket', $jenis_id);
        }

        $pakets = $query->paginate(6); // Sesuaikan dengan jumlah data per halaman       

        $jenis = Jenis_Paket::all();
        $user = Auth::user();
        $notif = 0;

        if ($user != null) {
            $cart = Cart::where('user_id', $user->id)->where('status_order', 0)->get();
            $notif = count($cart);
        }

        return view('client.paket.index', compact('pakets', 'jenis', 'notif'))
            ->with('i', (request()->input('page', 1) - 1) * 9); // Sesuaikan dengan jumlah data per halaman
    }
}
