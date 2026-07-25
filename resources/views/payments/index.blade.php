<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
</head>

<body>

<h1>Payment Management</h1>


<a href="{{ route('payments.create') }}">Add Payment</a>

<br><br>


<table border="1">

<tr>
    <th>ID</th>
    <th>Order ID</th>
    <th>Amount</th>
    <th>Payment Method</th>
    <th>Status</th>
    <th>Action</th>
</tr>


@foreach($payments as $payment)

<tr>

<td>{{ $payment->id }}</td>

<td>{{ $payment->order_id }}</td>

<td>{{ $payment->amount }}</td>

<td>{{ $payment->payment_method }}</td>

<td>{{ $payment->payment_status }}</td>


<td>

<a href="{{ route('payments.show',$payment->id) }}">View</a>

<a href="{{ route('payments.edit',$payment->id) }}">Edit</a>

<form action="{{ route('payments.destroy',$payment->id) }}" method="POST" style="display:inline;">

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