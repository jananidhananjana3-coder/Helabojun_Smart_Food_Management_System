<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Details</title>
</head>
<body>

<h1>Payment Details</h1>

<p>ID: {{ $payment->id }}</p>

<p>Order ID: {{ $payment->order_id }}</p>

<p>Amount: {{ $payment->amount }}</p>

<p>Payment Method: {{ $payment->payment_method }}</p>

<p>Status: {{ $payment->payment_status }}</p>

<a href="{{ route('payments.index') }}">Back</a>

</body>
</html>