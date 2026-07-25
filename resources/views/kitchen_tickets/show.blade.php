<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Ticket Details</title>
</head>

<body>

<h1>Kitchen Ticket Details</h1>

<p>ID: {{ $kitchenTicket->id }}</p>

<p>Order ID: {{ $kitchenTicket->order_id }}</p>


<p>Token Number: {{ $kitchenTicket->order->token_number }}</p>


<p>Chef: {{ $kitchenTicket->chef ? $kitchenTicket->chef->name : 'Not Assigned' }}</p>


<p>Status: {{ $kitchenTicket->status }}</p>


<a href="{{ route('kitchen-tickets.index') }}">Back</a>


</body>
</html>