<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outlets</title>
</head>
<body>
    <h1>Helabojun Outlets</h1>

<a href="{{ route('outlets.create') }}"> Add Outlet</a>

<br><br>


<table border="1">

<tr>
    <th>ID</th>
    <th>Outlet Name</th>
    <th>Location</th>
    <th>Contact Number</th>
    <th>Action</th>
</tr>


@foreach($outlets as $outlet)

<tr>

    <td>{{ $outlet->id }}</td>

    <td>{{ $outlet->outlet_name }}</td>

    <td>{{ $outlet->location }}</td>

    <td>{{ $outlet->contact_number }}</td>

    <td>

<a href="{{ route('outlets.edit', $outlet->id) }}">Edit</a>


<form action="{{ route('outlets.destroy', $outlet->id) }}"method="POST" syle="display:inline;">

@csrf
@method('DELETE')

<button type="submit"> Delete</button>

</form>

</td>

</tr>

@endforeach


</table>
</body>
</html>