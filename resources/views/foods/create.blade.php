<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1>Add Food</h1>

<form action="{{ route('foods.store') }}" method="POST">

    @csrf

    <label>Category</label>
    <br>

    <select name="category_id">

        @foreach($categories as $category)

        <option value="{{ $category->id }}"> {{ $category->category_name }} </option>

        @endforeach

    </select>

    <br><br>

    <label>Outlet</label>
    <br>

    <select name="outlet_id">

        @foreach($outlets as $outlet)

        <option value="{{ $outlet->id }}"> {{ $outlet->outlet_name }} </option>

        @endforeach

    </select>

    <br><br>

    <label>Food Name</label>
    <br>

    <input type="text" name="food_name">

    <br><br>

    <label>Description</label>
    <br>

    <textarea name="description"></textarea>

    <br><br>

    <label>Price</label>
    <br>

    <input type="number" step="0.01" name="price">

    <br><br>

    <label>Available Quantity</label>
    <br>

    <input type="number" name="available_quantity">

    <br><br>

    <button type="submit">
        Save
    </button>

</form>

</body>
</html>