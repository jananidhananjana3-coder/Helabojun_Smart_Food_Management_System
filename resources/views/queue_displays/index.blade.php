<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Display</title>
</head>

<body>

<h1>Queue Display</h1>

<a href="{{ route('queue-displays.create') }}">Create Queue</a>

<br><br>

<table border="1">

<tr>
<th>ID</th>
<th>Order ID</th>
<th>Queue Number</th>
<th>Status</th>
<th>Action</th>
</tr>


@foreach($queueDisplays as $queue)

<tr>

<td>{{ $queue->id }}</td>

<td>{{ $queue->order_id }}</td>

<td>{{ $queue->queue_number }}</td>

<td>{{ $queue->status }}</td>


<td>

<a href="{{ route('queue-displays.show',$queue->id) }}">View</a>

<a href="{{ route('queue-displays.edit',$queue->id) }}">Edit</a>


<form action="{{ route('queue-displays.destroy',$queue->id) }}" method="POST" style="display:inline">

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