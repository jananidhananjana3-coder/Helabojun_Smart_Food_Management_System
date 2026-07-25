<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Tickets</title>
</head>
<body>

<h1>Kitchen Ticket Management</h1>

<a href="{{ route('kitchen-tickets.create') }}">Create Kitchen Ticket</a>

<br><br>

<table border="1">

<tr>
<th>ID</th>
<th>Order ID</th>
<th>Chef</th>
<th>Status</th>
<th>Action</th>
</tr>

@foreach($kitchenTickets as $ticket)

<tr>

<td>{{ $ticket->id }}</td>

<td>{{ $ticket->order_id }}</td>

<td>
{{ $ticket->chef ? $ticket->chef->name : 'Not Assigned' }}
</td>

<td>{{ $ticket->status }}</td>

<td>

<a href="{{ route('kitchen-tickets.show',$ticket->id) }}">View</a>

<br>

<a href="{{ route('kitchen-tickets.edit',$ticket->id) }}">Edit</a>

<form action="{{ route('kitchen-tickets.destroy',$ticket->id) }}" method="POST" style="display:inline;">

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