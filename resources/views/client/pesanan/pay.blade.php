<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f7f7f7;
        }
        .container {
            text-align: center;
        }
        h1 {
            color: #333;
        }
        .loader {
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #3498db;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .message {
            display: none;
            font-size: 1.2em;
            margin-top: 20px;
        }
        .success {
            color: green;
        }
        .pending {
            color: orange;
        }
        .error {
            color: red;
        }
        .details {
            margin-top: 20px;
            display: none;
        }
        .details.success {
            color: green;
        }
        .details.pending {
            color: orange;
        }
        .details.error {
            color: red;
        }
    </style>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        function showMessage(message, className, json_data, details) {
            // Process Update Panggil Payment Notification Method
            $.ajax({
                url: '{{ url('/payment/notification') }}/',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    result_data: json_data
                },
                success: function(response) {
                    console.log(response)
                    // if (response.success) {

                    // }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
            var messageContainer = document.getElementById('message');
            var detailsContainer = document.getElementById('details');
            messageContainer.innerHTML = message;
            messageContainer.className = 'message ' + className;
            messageContainer.style.display = 'block';
            if (details) {
                detailsContainer.innerHTML = details;
                detailsContainer.className = 'details ' + className;
                detailsContainer.style.display = 'block';
            }
            setTimeout(function() {
                if (className === 'success') {
                    window.location.href = '{{ route('profile') }}';
                } else if (className === 'pending') {
                    window.location.href = '/payment/pending';
                } else if (className === 'error') {
                    window.location.href = '/payment/error';
                }
            }, 5000); // Delay for 5 seconds before redirecting
        }

        function pay() {
            snap.pay('{{ $snapToken }}', {
                // Optional, add callbacks for success, pending, and error handling
                onSuccess: function(result) {
                    // Handle success
                    // var details = `Transaction ID: ${result.transaction_id}<br>
                    //                Amount Paid: ${result.gross_amount}<br>
                    //                Payment Method: ${result.payment_type}`;
                    showMessage('Payment successful! Redirecting...', 'success', result, details);
                },
                onPending: function(result) {
                    // Handle pending
                    showMessage('Payment is pending. Redirecting...', 'pending', result);
                },
                onError: function(result) {
                    // Handle error
                    showMessage('Payment failed. Redirecting...', 'error', result);
                }
            });
        }
    </script>
</head>
<body onload="pay()">
    <div class="container">
        <h1>Processing your payment...</h1>
        <div class="loader"></div>
        <div id="message" class="message"></div>
        <div id="details" class="details"></div>
    </div>
</body>
</html>
