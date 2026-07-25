<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
</head>

<body>

<h1>Order Management</h1>


<a href="{{ route('orders.create') }}">Create Order</a>

<br><br>


<table border="1">

<tr>
    <th>ID</th>
    <th>Token Number</th>
    <th>Outlet</th>
    <th>Total Amount</th>
    <th>Status</th>
    <th>Payment Status</th>
    <th>Action</th>
</tr>


@foreach($orders as $order)

<tr>

<td>{{ $order->id }}</td>
<td>{{ $order->token_number }}</td>
<td>{{ $order->outlet->outlet_name }}</td>
<td>{{ $order->total_amount }}</td>
<td>{{ $order->status }}</td>
<td>{{ $order->payment_status }}</td>

<td>

<a href="{{ route('orders.show',$order->id) }}">View</a>

<br>

<a href="{{ route('orders.edit',$order->id) }}">Edit</a>

<form action="{{ route('orders.destroy',$order->id) }}" method="POST" style="display:inline;">

@csrf
@method('DELETE')

<button type="submit">Delete</button>

</form>

</td>

</tr>


@endforeach


</table>


</body>
</html>