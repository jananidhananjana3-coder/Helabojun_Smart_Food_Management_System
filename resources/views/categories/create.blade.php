<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
</head>
<body>
    <h1>Add New Category</h1>


<form action="{{ route('categories.store') }}" method="POST">

@csrf


<label>Category Name</label>
<br>

<input type="text" name="category_name">

<br><br>


<label>Description</label>
<br>

<textarea name="description"></textarea>


<br><br>


<button type="submit">
    Save
</button>


</form>

</body>
</html>