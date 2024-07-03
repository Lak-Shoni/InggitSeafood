<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Paket;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->where('status_order', 0)->get();
        $notif = $user ? $carts->count() : 0;
        return view('client.keranjang.index', compact('carts', 'notif'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:pakets,id',
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
            ->where('paket_id', $request->paket_id)
            ->where('status_order', 0)
            ->first();
        $paket = Paket::find($request->paket_id);
        if ($cart) {
            // Jika item sudah ada di keranjang, tambahkan quantity-nya
            $cart->quantity += 1;
            $total_per_item = $cart->quantity * $paket->harga_paket;
            $cart->total_per_item = $total_per_item;
            $cart->status_order = 0;
            $cart->save();
        } else {
            // Jika item belum ada di keranjang, buat item baru di keranjang
            Cart::create([
                'user_id' => $user->id,
                'paket_id' => $request->paket_id,
                'quantity' => 1,
                'total_per_item' => 1 * $paket->harga_paket,
                'status_order' => 0,
            ]);
        }
        $notif = Cart::where('user_id', $user->id)->where('status_order', 0)->count();

        return response()->json(['notif' => $notif,'message' => 'Item ditambahkan ke keranjang.']);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);
        $paket = Paket::find($cart->paket_id);
        $total_per_item = $request->input('quantity', 1) * $paket->harga_paket;
        if ($cart) {
            $cart->quantity = $request->input('quantity', 1);
            $cart->total_per_item = $total_per_item;
            $cart->save();
        }

        return response()->json(['success' => true, 'total' => 'Rp. ' . number_format($cart->paket->harga_paket * $cart->quantity, 0, ",", ".")]);
    }

    public function delete($id)
    {
        $cart = Cart::find($id);

        if ($cart) {
            $cart->delete();
        }

        return redirect()->route('cart.show')->with('success', 'Paket Berhasil Dihapus');
    }
}
