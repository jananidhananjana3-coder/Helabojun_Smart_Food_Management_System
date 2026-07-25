<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kitchen Ticket</title>
</head>

<body>

<h1>Edit Kitchen Ticket</h1>

<form action="{{ route('kitchen-tickets.update',$kitchenTicket->id) }}" method="POST">

@csrf
@method('PUT')


<label>Select Chef</label>
<br>

<select name="chef_id">

<option value="">Not Assigned</option>

@foreach($chefs as $chef)

<option value="{{ $chef->id }}">
{{ $chef->name }}
</option>

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

<button type="submit">Update</button>

</form>

</body>
</html>