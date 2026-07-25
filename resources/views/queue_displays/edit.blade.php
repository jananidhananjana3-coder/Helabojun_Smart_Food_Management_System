<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Queue</title>
</head>

<body>

<h1>Edit Queue Display</h1>


<form action="{{ route('queue-displays.update',$queueDisplay->id) }}" method="POST">

@csrf
@method('PUT')


<label>Select Order</label>
<br>

<select name="order_id">


@foreach($orders as $order)

<option value="{{ $order->id }}" 
@if($queueDisplay->order_id == $order->id) selected @endif>

Order {{ $order->id }} - Token {{ $order->token_number }}

</option>

@endforeach


</select>


<br><br>


<label>Queue Number</label>
<br>

<input type="number" name="queue_number" value="{{ $queueDisplay->queue_number }}">


<br><br>


<label>Status</label>
<br>


<select name="status">


<option value="waiting" 
@if($queueDisplay->status == 'waiting') selected @endif>
Waiting
</option>


<option value="served"
@if($queueDisplay->status == 'served') selected @endif>
Served
</option>


</select>


<br><br>


<button type="submit">Update</button>


</form>


</body>
</html>