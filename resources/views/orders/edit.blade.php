<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
</head>

<body>

<h1>Edit Order</h1>

<form action="{{ route('orders.update',$order->id) }}" method="POST">

@csrf
@method('PUT')


<label>Status</label>
<br>

<select name="status">

<option value="pending">Pending</option>
<option value="preparing">Preparing</option>
<option value="ready">Ready</option>
<option value="completed">Completed</option>
<option value="cancelled">Cancelled</option>

</select>


<br><br>


<label>Payment Status</label>
<br>

<select name="payment_status">

<option value="unpaid">Unpaid</option>
<option value="paid">Paid</option>

</select>


<br><br>

<button type="submit">Update</button>

</form>


</body>
</html>