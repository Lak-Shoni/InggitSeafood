<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Paket;
use App\Models\Hutang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentProcessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_process_payment_using_bayar_transfer()
    {
        // Membuat user dan login
        $user = User::factory()->create();
        $this->actingAs($user);

        // Menyiapkan data pesanan dan cart
        $order_data = [
            'payment_method' => 'bayar_transfer',
            'total_price' => 1000000,
            'address' => 'Jl. Test No 1',
            'instansi_name' => 'Test Instansi',
            'delivery_time' => now(),
            'due_date' => now()->addMonth(),
            'notes' => 'No notes',
            'order_status' => 'proses',
            'payment_status' => 'pending',
        ];
        $cart_ids = [1, 2];

        Session::put('order_data', $order_data);
        Session::put('cart_ids', $cart_ids);

        // Mocking Midtrans Snap::getSnapToken
        $mockSnapToken = 'mock-snap-token';
        \Mockery::mock(Snap::class)
            ->shouldReceive('getSnapToken')
            ->once()
            ->withAnyArgs()
            ->andReturn($mockSnapToken);

        // Mengirimkan permintaan POST ke proses pembayaran
        $response = $this->post(route('payment.process'));

        // Memastikan response mengarah ke halaman pembayaran dengan SnapToken
        $response->assertViewIs('client.pesanan.pay');
        $response->assertViewHas('snapToken', $mockSnapToken);
        $response->assertViewHas('unique_order_id');
    }

    /** @test */
    public function it_can_process_payment_using_bayar_ditempat_or_bayar_termin()
    {
        // Membuat user dan login
        $user = User::factory()->create();
        $this->actingAs($user);

        // Menyiapkan data pesanan dan cart
        $order_data = [
            'payment_method' => 'bayar_ditempat',
            'total_price' => 500000,
            'address' => 'Jl. Test No 1',
            'instansi_name' => 'Test Instansi',
            'delivery_time' => now(),
            'due_date' => now()->addMonth(),
            'notes' => 'No notes',
            'order_status' => 'proses',
            'payment_status' => 'pending',
        ];
        $cart_ids = [1, 2];

        // Simulasi sesi
        Session::put('order_data', $order_data);
        Session::put('cart_ids', $cart_ids);

        // Menyiapkan Cart dan Paket
        Cart::factory()->create(['id' => 1, 'paket_id' => 1, 'quantity' => 1]);
        Cart::factory()->create(['id' => 2, 'paket_id' => 2, 'quantity' => 2]);
        Paket::factory()->create(['id' => 1, 'purchase_count' => 0]);
        Paket::factory()->create(['id' => 2, 'purchase_count' => 0]);

        // Mengirimkan permintaan POST ke proses pembayaran
        $response = $this->post(route('payment.process'));

        // Memastikan response diarahkan ke profil setelah berhasil
        $response->assertRedirect(route('profile'));
        $response->assertSessionHas('success', 'Pesanan berhasil dibuat.');

        // Memastikan order dan hutang tercatat di database
        $this->assertDatabaseHas('orders', $order_data);
        $this->assertDatabaseHas('hutangs', [
            'order_id' => 1,  // Pastikan ID order yang sesuai
            'status' => 'unpaid',
        ]);
    }

    /** @test */
    public function it_redirects_to_failure_page_when_payment_process_fails()
    {
        // Membuat user dan login
        $user = User::factory()->create();
        $this->actingAs($user);

        // Menyiapkan data pesanan dan cart
        $order_data = [
            'payment_method' => 'bayar_transfer',
            'total_price' => 1000000,
            'address' => 'Jl. Test No 1',
            'instansi_name' => 'Test Instansi',
            'delivery_time' => now(),
            'due_date' => now()->addMonth(),
            'notes' => 'No notes',
            'order_status' => 'proses',
            'payment_status' => 'pending',
        ];
        $cart_ids = [1, 2];

        Session::put('order_data', $order_data);
        Session::put('cart_ids', $cart_ids);

        // Mocking Midtrans Snap::getSnapToken untuk gagal
        \Mockery::mock(Snap::class)
            ->shouldReceive('getSnapToken')
            ->once()
            ->withAnyArgs()
            ->andThrow(new \Exception('Midtrans error'));

        // Mengirimkan permintaan POST ke proses pembayaran
        $response = $this->post(route('payment.process'));

        // Memastikan respon mengarah ke halaman kegagalan
        $response->assertRedirect(route('order.failure'));
        $response->assertSessionHas('error', 'Gagal memproses pembayaran: Midtrans error');
    }

    /** @test */
    public function it_redirects_to_cart_show_when_no_order_data_in_session()
    {
        // Menghapus data dari sesi
        Session::forget(['order_data', 'cart_ids']);

        // Mengirimkan permintaan POST ke proses pembayaran
        $response = $this->post(route('payment.process'));

        // Memastikan pengguna diarahkan ke halaman keranjang dengan error
        $response->assertRedirect(route('cart.show'));
        $response->assertSessionHas('error', 'Data pesanan tidak ditemukan.');
    }
}
