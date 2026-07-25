<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
</head>

<body>

<h1>Order Details</h1>

<p>
<b>Order ID:</b> {{ $order->id }}
</p>

<p>
<b>Token Number:</b> {{ $order->token_number }}
</p>

<p>
<b>Outlet:</b> {{ $order->outlet->outlet_name }}
</p>

<p>
<b>Status:</b> {{ $order->status }}
</p>

<p>
<b>Payment Status:</b> {{ $order->payment_status }}
</p>


<h3>Food Items</h3>

<table border="1">

<tr>
    <th>Food</th>
    <th>Quantity</th>
    <th>Price</th>
</tr>


@foreach($order->orderItems as $item)

<tr>

<td>
{{ $item->food->food_name }}
</td>

<td>
{{ $item->quantity }}
</td>

<td>
{{ $item->price }}
</td>

</tr>

@endforeach


</table>


<br>

<a href="{{ route('orders.index') }}">Back</a>


</body>
</html>