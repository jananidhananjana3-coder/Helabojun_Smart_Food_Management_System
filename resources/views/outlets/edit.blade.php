<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Outlet</title>
</head>
<body>
    <h1>Edit Outlet</h1>


<form action="{{ route('outlets.update', $outlet->id) }}" method="POST">

@csrf
@method('PUT')


<label>Outlet Name</label>
<br>

<input type="text" name="outlet_name" value="{{ $outlet->outlet_name }}">


<br><br>


<label>Location</label>
<br>

<input type="text" name="location" value="{{ $outlet->location }}">


<br><br>


<label>Contact Number</label>
<br>

<input type="text" name="contact_number" value="{{ $outlet->contact_number }}">


<br><br>


<button type="submit">Update</button>


</form>

</body>
</html>