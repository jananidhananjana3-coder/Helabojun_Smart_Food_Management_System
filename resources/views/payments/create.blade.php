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



<label>Select Order</label>
<br>


<select name="order_id" required>


@foreach($orders as $order)

<option value="{{ $order->id }}">

Order #{{ $order->id }} 
- Rs {{ $order->total_amount }}

</option>


@endforeach


</select>


<br><br>



<label>Total Amount</label>
<br>


<input 
type="number"
name="amount"
required
>


<br><br>




<label>Payment Method</label>
<br>


<select name="payment_method" id="payment_method">


<option value="cash">
Cash
</option>


<option value="card">
Card
</option>


<option value="qr">
QR
</option>


</select>


<br><br>





<div id="cash_box">


<label>Cash Received</label>
<br>


<input 
type="number"
name="cash_received"
>


<br><br>


</div>





<label>Payment Status</label>
<br>


<select name="payment_status">


<option value="paid">
Paid
</option>


<option value="pending">
Pending
</option>


</select>



<br><br>



<button type="submit">

Complete Payment

</button>


</form>



</body>

</html>