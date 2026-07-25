<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
</head>
<body>
    <h1>Food Categories</h1>

<a href="{{ route('categories.create') }}">
    Add Category
</a>

<br><br>

<table border="1">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Description</th>
    <th>Actions</th>
</tr>


@foreach($categories as $category)

<tr>
    <td>{{ $category->id }}</td>
    <td>{{ $category->category_name }}</td>
    <td>{{ $category->description }}</td>
<td>

<a href="{{ route('categories.edit', $category->id) }}">Edit</a>


<form action="{{ route('categories.destroy', $category->id) }}" 
      method="POST"
      style="display:inline;">

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