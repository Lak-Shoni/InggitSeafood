@extends('layout.client')

@section('title', 'Pembayaran')
@section('content')
<div class="container" style="margin-top: 40px">
    <h2>Pembayaran</h2>
    <form id="payment-form" method="post" action="{{ route('payment.notification') }}">
        <input type="hidden" name="result_data" id="result-data" value="">
        @csrf
        <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
    </form>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function(e) {
        e.preventDefault();
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                sendResponseToForm(result);
            },
            onPending: function(result) {
                sendResponseToForm(result);
            },
            onError: function(result) {
                sendResponseToForm(result);
            },
            onClose: function() {
                alert('You closed the popup without finishing the payment');
            }
        });
    });

    function sendResponseToForm(result) {
        document.getElementById('result-data').value = JSON.stringify(result);
        document.getElementById('payment-form').submit();
    }
</script>
@endsection
