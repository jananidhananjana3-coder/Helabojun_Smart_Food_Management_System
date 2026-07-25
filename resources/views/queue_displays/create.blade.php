<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Queue</title>
</head>

<body>

<h1>Create Queue Display</h1>


<form action="{{ route('queue-displays.store') }}" method="POST">

@csrf


<label>Select Order</label>
<br>

<select name="order_id">

@foreach($orders as $order)

<option value="{{ $order->id }}">
Order {{ $order->id }} - Token {{ $order->token_number }}
</option>

@endforeach

</select>


<br><br>


<label>Queue Number</label>
<br>

<input type="number" name="queue_number">


<br><br>


<label>Status</label>
<br>

<select name="status">

<option value="waiting">Waiting</option>

<option value="served">Served</option>

</select>


<br><br>


<button type="submit">Create</button>


</form>


</body>
</html>