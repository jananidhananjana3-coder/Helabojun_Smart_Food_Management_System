<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
</head>

<body>

<h1>Create Order</h1>


@if(session('error'))
    <p style="color:red;">
        {{ session('error') }}
    </p>
@endif


<form action="{{ route('orders.store') }}" method="POST">

@csrf


<label>Select Outlet</label>

<br>

<select name="outlet_id" required>


@foreach($outlets as $outlet)

<option value="{{ $outlet->id }}">
    {{ $outlet->outlet_name }}
</option>

@endforeach


</select>


<br><br>


<label>Select Counter</label>

<br>

<select name="counter_id" required>

<option value="">
    -- Select Counter --
</option>


@foreach($counters as $counter)

<option value="{{ $counter->id }}">
    {{ $counter->counter_name }}
</option>


@endforeach


</select>


<br><br>


<label>Select Food</label>

<br>

<select name="food_id" required>

<option value="">
    -- Select Food --
</option>


@foreach($foods as $food)

<option value="{{ $food->id }}">

    {{ $food->food_name }} 
    - Rs {{ $food->price }}
    (Available: {{ $food->available_quantity }})

</option>


@endforeach


</select>


<br><br>


<label>Quantity</label>

<br>


<input 
type="number" 
name="quantity" 
value="1"
min="1"
required
>


<br><br>


<button type="submit">
    Create Order
</button>


</form>


</body>
</html>