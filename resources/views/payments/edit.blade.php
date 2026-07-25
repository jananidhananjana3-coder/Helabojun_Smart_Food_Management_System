<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Payment</title>
</head>
<body>

<h1>Edit Payment</h1>

<form action="{{ route('payments.update',$payment->id) }}" method="POST">

@csrf
@method('PUT')

<label>Amount</label>
<br>

<input type="number" name="amount" value="{{ $payment->amount }}">

<br><br>

<label>Payment Method</label><br>

<select name="payment_method">

<option value="cash" {{ $payment->payment_method=='cash'?'selected':'' }}> Cash</option>

<option value="card" {{ $payment->payment_method=='card'?'selected':'' }}>Card</option>

</select>

<br><br>

<label>Payment Status</label><br>

<select name="payment_status">

<option value="pending" {{ $payment->payment_status=='pending'?'selected':'' }}>Pending</option>

<option value="paid" {{ $payment->payment_status=='paid'?'selected':'' }}>Paid</option>

</select>

<br><br>

<button type="submit">Update</button>

</form>

</body>
</html>