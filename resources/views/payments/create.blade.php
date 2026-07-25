<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Payment</title>
</head>
<body>

<h1>Create Payment</h1>

<form action="{{ route('payments.store') }}" method="POST">

@csrf

<label>Order</label><br>

<select name="order_id">

@foreach($orders as $order)

<option value="{{ $order->id }}">Order #{{ $order->id }} - Rs {{ $order->total_amount }}</option>

@endforeach

</select>

<br><br>

<label>Amount</label><br>
<input type="number" name="amount">

<br><br>

<label>Payment Method</label><br>

<select name="payment_method">
<option value="cash">Cash</option>
<option value="card">Card</option>
</select>

<br><br>

<label>Payment Status</label><br>

<select name="payment_status">
<option value="pending">Pending</option>
<option value="paid">Paid</option>
</select>

<br><br>

<button type="submit">Save Payment</button>

</form>

</body>
</html>