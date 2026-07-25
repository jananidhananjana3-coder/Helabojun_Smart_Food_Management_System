<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Kitchen Ticket</title>
</head>
<body>

<h1>Create Kitchen Ticket</h1>

<form action="{{ route('kitchen-tickets.store') }}" method="POST">

@csrf

<label>Select Order</label>
<br>

<select name="order_id">

@foreach($orders as $order)

<option value="{{ $order->id }}"> Order #{{ $order->id }} - Token {{ $order->token_number }}</option>

@endforeach

</select>

<br><br>

<label>Select Chef</label>
<br>

<select name="chef_id">

<option value="">Not Assigned</option>

@foreach($chefs as $chef)

<option value="{{ $chef->id }}">{{ $chef->name }}</option>

@endforeach

</select>

<br><br>

<label>Status</label>
<br>

<select name="status">

<option value="waiting">Waiting</option>
<option value="cooking">Cooking</option>
<option value="completed">Completed</option>

</select>

<br><br>

<button type="submit">Create</button>

</form>

</body>
</html>