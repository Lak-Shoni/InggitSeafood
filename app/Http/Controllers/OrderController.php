<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Hutang;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
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
        $tenggatBulan = $request->input('tenggat_bulan', 0); // Jika null, default ke 0
        $dueDate = $deliveryTime->copy()->addMonths($tenggatBulan);

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
                'items' => json_encode($request->input('cart_ids')),
                'total_price' => $grandTotal,
                'order_status' => 'proses',
                'payment_status' => 'pending',
            ],
            'cart_ids' => $request->input('cart_ids')
        ]);

        $payment_method = $request->input('payment_method');
        if ($payment_method == 'bayar_langsung') {
            // Midtrans
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = config('services.midtrans.is_sanitized');
            Config::$is3ds = config('services.midtrans.is_3ds');

            // Generate unique order_id
            $unique_order_id = 'ORDER-' . uniqid();

            $params = [
                'transaction_details' => [
                    'order_id' => $unique_order_id,
                    'gross_amount' => (int) $grandTotal,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->nama,
                    'phone' => Auth::user()->no_telpon
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                return view('client.pesanan.pay', compact('snapToken', 'unique_order_id'));
            } catch (\Exception $e) {
                return redirect()->route('order.failure')->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
            }
        } elseif ($payment_method == 'bayar_ditempat') {
            // Tambahkan hutang dan buat order
            return $this->createOrder();
        } else {
            // Tambahkan hutang dan buat order
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

            if ($order_data['payment_method'] == 'bayar_ditempat' || $order_data['payment_method'] == 'lainnya') {
                $hutang = new Hutang();
                $hutang->order_id = $order->id;
                $hutang->user_id = Auth::id();
                $hutang->total = $order_data['total_price'];
                $hutang->status = 'unpaid';
                $hutang->save();
            }

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

    public function get_detail(Request $request, $id)
    {
        $order = Order::find($id);

        echo json_encode($order);
    }

    public function generatePDF($id)
    {
        $order = Order::findOrFail($id);
        $user = $order->user;  // Assuming you have a relationship defined in your Order model
        $carts = Cart::whereIn('id', json_decode($order->items))->get();

        $pdf = FacadePdf::loadView('client.pesanan.invoice', compact('order', 'user', 'carts'));
        return $pdf->download('invoice_' . $order->id . '.pdf');
    }
}
