<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>
<body>
    <h1>Edit Category</h1>


<form action="{{ route('categories.update', $category->id) }}" method="POST">

    @csrf
    @method('PUT')


    <label>Category Name</label>
    <br>

    <input type="text" name="category_name" value="{{ $category->category_name }}">


    <br><br>


    <label>Description</label>
    <br>

    <textarea name="description">{{ $category->description }}</textarea>


    <br><br>


    <button type="submit">Update</button>


</form>
</body>
</html>