<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->get();
        return view('client.keranjang.index', compact('carts'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
                    ->where('menu_id', $request->menu_id)
                    ->first();

        if ($cart) {
            // Jika item sudah ada di keranjang, tambahkan quantity-nya
            $cart->quantity += 1;
            $cart->save();
        } else {
            // Jika item belum ada di keranjang, buat item baru di keranjang
            Cart::create([
                'user_id' => $user->id,
                'menu_id' => $request->menu_id,
                'quantity' => 1,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Item ditambahkan ke keranjang.']);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);

        if ($cart) {
            $cart->quantity = $request->input('quantity', 1);
            $cart->save();
        }

        return response()->json(['success' => true, 'total' => $cart->menu->harga_menu * $cart->quantity]);
    }

    public function delete($id)
    {
        $cart = Cart::find($id);

        if ($cart) {
            $cart->delete();
        }

        return redirect()->route('cart.show')->with('success', 'Item removed from cart');
    }
}

