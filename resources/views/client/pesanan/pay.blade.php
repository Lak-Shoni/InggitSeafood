<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
        function pay() {
            snap.pay('{{ $snapToken }}', {
                // Optional, add callbacks for success, pending, and error handling
                onSuccess: function(result) {
                    // Handle success
                    window.location.href = '/payment/success';
                },
                onPending: function(result) {
                    // Handle pending
                    window.location.href = '/payment/pending';
                },
                onError: function(result) {
                    // Handle error
                    window.location.href = '/payment/error';
                }
            });
        }
    </script>
</head>
<body onload="pay()">
    <h1>Processing your payment...</h1>
</body>
</html>
