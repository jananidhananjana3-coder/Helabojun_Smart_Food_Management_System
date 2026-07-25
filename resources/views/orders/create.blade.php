<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
</head>

<body>

<h1>Create Order</h1>

<form action="{{ route('orders.store') }}" method="POST">

@csrf

<label>Select Outlet</label>

<br>

<select name="outlet_id">


@foreach($outlets as $outlet)

<option value="{{ $outlet->id }}">{{ $outlet->outlet_name }}</option>


@endforeach


</select>

<br><br>

<label>Select Food</label>

<br>

<select name="food_id">

<option value="">-- Select Food --</option>

@foreach($foods as $food)

<option value="{{ $food->id }}">{{ $food->food_name }} - Rs {{ $food->price }}</option>

@endforeach

</select>

<br><br>

<label>Quantity</label>

<br>


<input type="number" name="quantity" value="1">

<br><br>

<button type="submit">Create Order</button>

</form>

</body>
</html>