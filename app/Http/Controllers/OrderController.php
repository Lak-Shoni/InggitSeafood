<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
    public function showCheckoutForm(Request $request)
    {
        $user = Auth::user();
        $cartIds = explode(',', $request->input('cart_ids', ''));
        $carts = Cart::whereIn('id', $cartIds)->get();
        $grandTotal = $request->input('grand_total');
        $grandTotal = str_replace("Rp. ", "", $grandTotal);
        $grandTotal = floatval(str_replace(".", "", $grandTotal));

        $array_id_cart = [];
        foreach ($carts as $c) {
            array_push($array_id_cart, $c['id']);
        }
        if ($carts->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Keranjang belanja kosong.');
        }
        return view('client.pesanan.index', compact('user', 'carts', 'grandTotal', 'array_id_cart'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'partner_name' => 'required|string',
            'delivery_time' => 'required|date',
            'payment_method' => 'required|string',
            'due_date' => 'nullable|date',
            'grand_total' => 'required|numeric',
        ]);

        $grandTotal = $request->input('grand_total');
        
        if ($grandTotal === null) {
            return redirect()->back()->with('error', 'Total harga tidak valid.');
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->address = $request->input('address');
        $order->partner_name = $request->input('partner_name');
        $order->delivery_time = $request->input('delivery_time');
        $order->payment_method = $request->input('payment_method');
        $order->due_date = $request->input('due_date');
        $order->notes = $request->input('notes');
        $order->items = json_encode($request->input('cart_ids'));
        $order->total_price = $grandTotal;
        $order->save();

        // Change Status Order Cart ID
        Cart::whereIn('id', $request->input('cart_ids'))->update(['status_order' => 1]);

        $payment_method = $order->payment_method;
        if ($payment_method == 'bayar_langsung') {
            // Midtrans
            // Midtrans configuration
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = config('services.midtrans.is_sanitized');
            Config::$is3ds = config('services.midtrans.is_3ds');

            // Logging for debugging
            Log::info('Midtrans Config:', [
                'server_key' => Config::$serverKey,
                'is_production' => Config::$isProduction,
                'is_sanitized' => Config::$isSanitized,
                'is_3ds' => Config::$is3ds,
            ]);

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => (int) $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->nama,
                    'phone' => Auth::user()->no_telpon
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                // return view('client.pesanan.pay', compact('snapToken', 'order'));
                return view('client.checkout.payment', compact('snapToken', 'order'));
            } catch (\Exception $e) {
                return redirect()->route('order.failure')->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
            }
        } else {
            // No Midtrans
            echo json_encode("NO MIDTRANS");
            die;
        }
    }

    public function failure()
    {
        return view('client.pesanan.failure')->with('error', 'Pembayaran gagal diproses. Silakan coba lagi.');
    }


    public function paymentNotification(Request $request)
    {
        $data = $request->input('result_data');
        $data = json_decode($data);

        $order = Order::findOrFail($data->order_id);

        switch ($data->transaction_status) {
            case 'capture':
                $order->status = 'paid';
                break;

            case 'settlement':
                $order->status = 'paid';
                break;

            case 'pending':
                $order->status = 'pending';
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                $order->status = 'failed';
                break;
        }

        $order->save();
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->status = $request->input('status');
            $order->save();
        }

        return response()->json(['success' => true]);
    }
}
