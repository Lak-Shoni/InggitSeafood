<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_successful()
    {
        // Simulasi pengguna login
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        // Data request
        $deliveryTime = Carbon::now()->addDays(3)->toDateTimeString();
        $requestData = [
            'address' => '123 Jalan Raya',
            'instansi_name' => 'PT Maju Sejahtera',
            'delivery_time' => $deliveryTime,
            'payment_method' => 'transfer',
            'tenggat_bulan' => 1,
            'grand_total' => 100000,
            'notes' => 'Tolong kirim pagi.',
            'cart_ids' => json_encode([1, 2, 3]),
        ];

        // Kirim POST request
        $response = $this->post(route('checkout.create'), $requestData);

        // Pastikan pengalihan ke rute pembayaran
        $response->assertRedirect(route('payment.process'));

        // Periksa data yang tersimpan di sesi
        $orderData = session('order_data');
        $this->assertNotNull($orderData);
        $this->assertEquals($user->id, $orderData['user_id']);
        $this->assertEquals('123 Jalan Raya', $orderData['address']);
        $this->assertEquals('PT Maju Sejahtera', $orderData['instansi_name']);
        $this->assertEquals(Carbon::parse($deliveryTime)->addMonths(1), $orderData['due_date']);
        $this->assertEquals('pending', $orderData['payment_status']);

        // Pastikan cart_ids juga tersimpan di sesi
        $cartIds = session('cart_ids');
        $this->assertEquals([1, 2, 3], $cartIds);
    }

    public function test_create_order_validation_error()
    {
        // Simulasi pengguna login
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        // Data request dengan data kosong
        $requestData = [
            'address' => '',
            'instansi_name' => '',
            'delivery_time' => '',
            'payment_method' => '',
            'grand_total' => '',
        ];

        // Kirim POST request
        $response = $this->post(route('checkout.create'), $requestData);

        // Pastikan validasi gagal
        $response->assertSessionHasErrors([
            'address',
            'instansi_name',
            'delivery_time',
            'payment_method',
            'grand_total',
        ]);
    }
    /** @test */
    public function it_can_create_order_with_cart_ids_as_array()
    {
        // Membuat user dan login
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        // Menyiapkan data pesanan
        $cart_ids = [1, 2, 3];  // Cart IDs dalam bentuk array, bukan string
        $data = [
            'address' => 'Jl. Test No 1',
            'instansi_name' => 'Test Instansi',
            'delivery_time' => now()->toDateString(),
            'payment_method' => 'bayar_transfer',
            'tenggat_bulan' => 2,
            'grand_total' => 1000000,
            'cart_ids' => $cart_ids, // Mengirim cart_ids sebagai array
            'notes' => 'Test notes'
        ];

        // Mengirimkan permintaan POST ke route createOrder
        $response = $this->post(route('checkout.create'), $data);

        // Memastikan data pesanan disimpan dalam session
        $response->assertSessionHas('order_data', function ($order_data) use ($cart_ids) {
            return $order_data['items'] === json_encode($cart_ids);
        });

        // Memastikan bahwa setelah memproses pesanan, rute menuju proses pembayaran
        $response->assertRedirect(route('payment.process'));
    }

    /** @test */
    public function it_can_create_order_with_cart_ids_as_json_string()
    {
        // Membuat user dan login
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        // Menyiapkan data pesanan dengan cart_ids sebagai string JSON
        $cart_ids = json_encode([1, 2, 3]);  // Cart IDs dalam format JSON string
        $data = [
            'address' => 'Jl. Test No 1',
            'instansi_name' => 'Test Instansi',
            'delivery_time' => now()->toDateString(),
            'payment_method' => 'bayar_transfer',
            'tenggat_bulan' => 2,
            'grand_total' => 1000000,
            'cart_ids' => $cart_ids, // Mengirim cart_ids sebagai string JSON
            'notes' => 'Test notes'
        ];

        // Mengirimkan permintaan POST ke route createOrder
        $response = $this->post(route('checkout.create'), $data);

        // Memastikan data pesanan disimpan dalam session
        $response->assertSessionHas('order_data', function ($order_data) use ($cart_ids) {
            return $order_data['items'] === $cart_ids;  // Cart IDs harus sama dengan string JSON yang diterima
        });

        // Memastikan bahwa setelah memproses pesanan, rute menuju proses pembayaran
        $response->assertRedirect(route('payment.process'));
    }
}
