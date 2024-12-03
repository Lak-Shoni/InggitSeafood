<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Keuangan;

class KeuanganStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_keuangan_data_successfully()
    {
        // Membuat user dan login
        $user = User::factory()->create(); // Pastikan ada factory untuk User
        $this->actingAs($user); // Login sebagai user

        // Data valid untuk pengujian
        $data = [
            'transaction_date' => now()->toDateString(),
            'omset' => 1000000,
            'purchasing' => 200000,
            'tenaga_kerja' => 300000,
            'pln' => 50000,
            'akomodasi' => 70000,
            'sewa_alat' => 100000,
            'profit' => 500000,
        ];

        // Kirim permintaan POST ke rute `admin.keuangan.store`
        $response = $this->post(route('admin.keuangan.store'), $data);

        // Pastikan respon sukses dan diarahkan ke index
        $response->assertRedirect(route('admin.keuangan.index'));
        $response->assertSessionHas('success', 'Data keuangan berhasil ditambahkan.');

        // Pastikan data telah tersimpan di database
        $this->assertDatabaseHas('keuangans', $data);
    }

    /** @test */
    public function it_fails_to_store_keuangan_data_with_invalid_input()
    {
        // Membuat user dan login
        $user = User::factory()->create(); // Pastikan ada factory untuk User
        $this->actingAs($user); // Login sebagai user

        // Data tidak valid
        $data = [
            'transaction_date' => 'invalid-date',
            'omset' => 'not-a-number',
            'purchasing' => null, // Required field missing
            'tenaga_kerja' => 300000,
            'pln' => 50000,
            'akomodasi' => 70000,
            'sewa_alat' => 100000,
            'profit' => 500000,
        ];

        // Kirim permintaan POST ke rute `admin.keuangan.store`
        $response = $this->post(route('admin.keuangan.store'), $data);

        // Pastikan respon memiliki error
        $response->assertSessionHasErrors(['transaction_date', 'omset', 'purchasing']);

        // Pastikan tidak ada data yang disimpan di database
        $this->assertDatabaseMissing('keuangans', ['transaction_date' => 'invalid-date']);
    }
}
