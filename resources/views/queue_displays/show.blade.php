<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Details</title>
</head>

<body>


<h1>Queue Details</h1>


<p>ID: {{ $queueDisplay->id }}</p>

<p>Order ID: {{ $queueDisplay->order_id }}</p>

<p>Queue Number: {{ $queueDisplay->queue_number }}</p>

<p>Status: {{ $queueDisplay->status }}</p>


<a href="{{ route('queue-displays.index') }}">Back</a>


</body>
</html>