<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foods</title>
</head>
<body>

<h1>Food Management</h1>

<a href="{{ route('foods.create') }}">
    Add Food
</a>

<br><br>

<table border="1">

<tr>
    <th>ID</th>
    <th>Food Name</th>
    <th>Category</th>
    <th>Outlet</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Actions</th>
</tr>

@foreach($foods as $food)

<tr>

    <td>{{ $food->id }}</td>

    <td>{{ $food->food_name }}</td>

    <td>{{ $food->category->category_name }}</td>

    <td>{{ $food->outlet->outlet_name }}</td>

    <td>{{ $food->price }}</td>

    <td>{{ $food->available_quantity }}</td>

    <td>

        <a href="{{ route('foods.edit', $food->id) }}">Edit</a>

        <form action="{{ route('foods.destroy', $food->id) }}" method="POST"style="display:inline;">

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