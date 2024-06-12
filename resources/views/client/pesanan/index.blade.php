@extends('layout.client')

@section('title', 'Buat Pesanan')
@section('content')
<div class="container" style="margin-top: 40px">
    <h2>Checkout</h2>
    @if(session()->has('error'))
<script>
    alert("{{ session('error') }}");
</script>
@endif
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->nama }}" readonly>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">No Telepon</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ auth()->user()->no_telpon }}" readonly>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ auth()->user()->alamat }}" readonly>
            <div class="form-check mt-2">
                <input type="checkbox" class="form-check-input" id="use_different_address">
                <label class="form-check-label" for="use_different_address">Apakah ingin menggunakan alamat lain?</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="partner_name" class="form-label">Nama Mitra</label>
            <input type="text" class="form-control" id="partner_name" name="partner_name" required>
        </div>
        <div class="mb-3">
            <label for="delivery_time" class="form-label">Waktu Pengiriman</label>
            <input type="datetime-local" class="form-control" id="delivery_time" name="delivery_time" required>
        </div>
        <div class="mb-3">
            <label for="payment_method" class="form-label">Metode Pembayaran</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="bayar_langsung">Bayar Langsung</option>
                <option value="bayar_ditempat">Bayar di Tempat</option>
                <option value="bayar_dengan_tenggat_waktu">Bayar dengan Tenggat Waktu</option>
            </select>
        </div>
        <div class="mb-3" id="due_date_container" style="display: none;">
            <label for="due_date" class="form-label">Tanggal Jatuh Tempo (Opsional)</label>
            <input type="datetime-local" class="form-control" id="due_date" name="due_date">
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Catatan (Opsional)</label>
            <textarea class="form-control" id="notes" name="notes"></textarea>
        </div>
        <input type="hidden" name="grand_total" value="{{ $grandTotal }}">
        <button type="submit" class="btn btn-primary">Proses Checkout</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#use_different_address').change(function() {
            if ($(this).is(':checked')) {
                $('#address').attr('readonly', false).val('');
            } else {
                $('#address').attr('readonly', true).val('{{ auth()->user()->address }}');
            }
        });

        $('#payment_method').change(function() {
            if ($(this).val() === 'bayar_dengan_tenggat_waktu') {
                $('#due_date_container').show();
                $('#due_date').attr('required', true);
            } else {
                $('#due_date_container').hide();
                $('#due_date').attr('required', false);
            }
        });
    });
</script>
@endsection
