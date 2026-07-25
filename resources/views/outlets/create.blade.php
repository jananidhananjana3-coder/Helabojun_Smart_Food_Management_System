<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Outlet</title>
</head>
<body>
    <h1>Add New Outlet</h1>


<form action="{{ route('outlets.store') }}" method="POST">

@csrf


<label>Outlet Name</label>
<br>

<input type="text" name="outlet_name">


<br><br>


<label>Location</label>
<br>

<input type="text" name="location">


<br><br>


<label>Contact Number</label>
<br>

<input type="text" name="contact_number">


<br><br>


<button type="submit"> Save</button>


</form>
</body>
</html>