<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Hutang;
use App\Models\Order;
use App\Models\Paket;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Carbon\Carbon;



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
            'tenggat_bulan' => 'nullable|numeric',
            'grand_total' => 'required|numeric',
        ]);

        $grandTotal = $request->input('grand_total');
        if ($grandTotal === null) {
            return redirect()->back()->with('error', 'Total harga tidak valid.');
        }

        $deliveryTime = Carbon::parse($request->input('delivery_time'));
        $tenggatBulan = $request->input('tenggat_bulan', 0);
        $dueDate = $deliveryTime->copy()->addMonths($tenggatBulan);

        $cart_ids = $request->input('cart_ids');

        // Convert cart_ids to array 
        if (is_string($cart_ids)) {
            $cart_ids = json_decode($cart_ids, true);
        }

        // Simpan data pesanan sementara di sesi
        session([
            'order_data' => [
                'user_id' => Auth::id(),
                'address' => $request->input('address'),
                'partner_name' => $request->input('partner_name'),
                'delivery_time' => $deliveryTime,
                'payment_method' => $request->input('payment_method'),
                'due_date' => $dueDate,
                'notes' => $request->input('notes'),
                'items' => json_encode($cart_ids),
                'total_price' => $grandTotal,
                'order_status' => 'proses',
                'payment_status' => 'pending',
            ],
            'cart_ids' => $cart_ids,
        ]);

        $payment_method = $request->input('payment_method');
        if ($payment_method == 'bayar_langsung') {
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = config('services.midtrans.is_sanitized');
            Config::$is3ds = config('services.midtrans.is_3ds');

            $unique_order_id = 'ORDER-' . uniqid();

            $params = [
                'transaction_details' => [
                    'order_id' => $unique_order_id,
                    'gross_amount' => (int) $grandTotal,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->nama,
                    'phone' => Auth::user()->no_telpon,
                ],            

            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                return view('client.pesanan.pay', compact('snapToken', 'unique_order_id'));
            } catch (\Exception $e) {
                return redirect()->route('order.failure')->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
            }
        } elseif ($payment_method == 'bayar_ditempat') {
            return $this->createOrder();
        } else {
            return $this->createOrder();
        }
    }

    private function createOrder()
    {
        $order_data = session('order_data');
        $cart_ids = session('cart_ids');

        if ($order_data && $cart_ids) {
            $order = Order::create($order_data);
            Cart::whereIn('id', $cart_ids)->update(['status_order' => 1]);

            // Ambil paket_id dan quantity dari Cart
            $cart_items = Cart::whereIn('id', $cart_ids)->get();

            foreach ($cart_items as $cart_item) {
                $paket = Paket::find($cart_item->paket_id);
                if ($paket) {
                    $paket->increment('purchase_count', $cart_item->quantity);
                }
            }

            if ($order_data['payment_method'] == 'bayar_ditempat' || $order_data['payment_method'] == 'lainnya') {
                $hutang = new Hutang();
                $hutang->order_id = $order->id;
                $hutang->user_id = Auth::id();
                $hutang->total = $order_data['total_price'];
                $hutang->status = 'unpaid';
                $hutang->save();
            }

            event(new OrderCreated($order));
            // Clear session data
            session()->forget(['order_data', 'cart_ids']);

            return redirect()->route('profile')->with('success', 'Pesanan berhasil dibuat. Silakan bayar saat barang diterima.');
        }

        return redirect()->route('cart.show')->with('error', 'Gagal membuat pesanan.');
    }


    public function paymentNotification(Request $request)
    {
        $data = $request->input('result_data');
        $order_data = session('order_data');
        $cart_ids = session('cart_ids');

        if (!$order_data || !$cart_ids) {
            return response()->json(['success' => false, 'message' => 'Order data not found.']);
        }

        $order = new Order($order_data);
        $order->save();

        Cart::whereIn('id', $cart_ids)->update(['status_order' => 1]);

        switch ($data['transaction_status']) {
            case 'capture':
            case 'settlement':
                $order->payment_status = 'paid';
                break;
            case 'pending':
                $order->payment_status = 'pending';
                break;
            case 'deny':
            case 'expire':
            case 'cancel':
                $order->payment_status = 'failed';
                break;
        }

        $order->save();

        // Clear session data
        session()->forget(['order_data', 'cart_ids']);

        echo json_encode(['success' => true]);
    }



    public function failure()
    {
        return view('client.pesanan.failure')->with('error', 'Pembayaran gagal diproses. Silakan coba lagi.');
    }


    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->payment_status = $request->input('status');
            $order->save();
        }

        return response()->json(['success' => true]);
    }
    public function lunas(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->payment_status = 'paid';
            $order->save();

            // Cari hutang yang sesuai dengan order ID
            $hutang = Hutang::where('order_id', $id)->first();
            if ($hutang) {
                $hutang->status = 'paid';
                $hutang->total -= $order->total_price;
                $hutang->save();
            }
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order sudah lunas');
    }
    public function kirim(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->order_status = 'kirim';
            $order->save();
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order sedang dikirim');
    }

    public function selesai(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->order_status = 'selesai';
            $order->save();
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order selesai');
    }
    public function terima(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->order_status = 'terima';
            $order->save();
        }

        return redirect()->route('profile')->with('success', 'Order diterima');
    }

    public function get_detail($id)
    {
        $order = Order::with(['user'])->find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Ambil carts_id dari order
        $cart_ids = json_decode($order->items, true);

        // Ambil data Cart berdasarkan carts_id
        $carts = Cart::with('paket')->whereIn('id', $cart_ids)->get();

        // Log carts data for debugging
        // \Log::info('Carts Data:', ['carts' => $carts->toArray()]);

        // Format data items sesuai kebutuhan
        $items = $carts->map(function ($cart) {
            // Log each cart and paket for debugging
            // \Log::info('Cart Data:', ['cart' => $cart->toArray()]);
            // \Log::info('Paket Data:', ['paket' => $cart->paket->toArray()]);

            return [
                'nama_paket' => $cart->paket->nama_paket,
                'quantity' => $cart->quantity,
                'total_per_item' => $cart->total_per_item,
            ];
        });

        // Log items data for debugging
        // \Log::info('Items Data:', ['items' => $items->toArray()]);

        // Format data pesanan sesuai kebutuhan
        $orderData = [
            'order_code' => $order->order_code,
            'user' => [
                'nama' => $order->user->nama,
                'no_telpon' => $order->user->no_telpon,
            ],
            'items' => $items,
            'total_price' => $order->total_price,
            'address' => $order->address,
            'partner_name' => $order->partner_name,
            'delivery_time' => $order->delivery_time,
            'payment_method' => $order->payment_method,
            'due_date' => $order->due_date,
            'notes' => $order->notes,
            'order_status' => $order->order_status,
            'payment_status' => $order->payment_status,
        ];

        return response()->json($orderData);
    }



    public function generatePDF($id)
    {
        $order = Order::findOrFail($id);
        $user = $order->user; // Assuming you have a relationship defined in your Order model
        $carts = Cart::whereIn('id', json_decode($order->items))->get();

        // Load the view file 'client.pesanan.invoice' and pass the data
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('client.pesanan.invoice', compact('order', 'user', 'carts'));

        // Download the generated PDF file
        return $pdf->download('invoice_' . $order->id . '.pdf');
    }
}
