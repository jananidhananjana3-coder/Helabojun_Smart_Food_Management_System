<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Food Management | Hela Bojun</title>


    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">


    <style>


        body{

            background:#f5f7f6;

        }


        .page-header{

            background:#075e3b;

            color:white;

            border-radius:12px;

        }


        .food-image{

            width:70px;

            height:70px;

            object-fit:cover;

            border-radius:10px;

        }


        .table-card{

            border-radius:15px;

            overflow:hidden;

        }


    </style>

</head>

<body>

<div class="container py-5">



    <div class="page-header p-4 mb-4 shadow">


        <div class="d-flex justify-content-between align-items-center">


            <h2 class="mb-0">

                Food Management

            </h2>



            <a href="{{ route('foods.create') }}"
               class="btn btn-light">


                + Add Food


            </a>



        </div>


    </div>

    @if(session('success'))


        <div class="alert alert-success">


            {{ session('success') }}


        </div>


    @endif

    <div class="card shadow table-card">


        <div class="card-body">



            <div class="table-responsive">



                <table class="table table-bordered table-hover align-middle">



                    <thead class="table-success">


                        <tr>


                            <th>

                                Image

                            </th>


                            <th>

                                Food Name

                            </th>


                            <th>

                                Category

                            </th>


                            <th>

                                Outlet

                            </th>


                            <th>

                                Price

                            </th>


                            <th>

                                Quantity

                            </th>


                            <th>

                                Action

                            </th>


                        </tr>


                    </thead>

                    <tbody>

                    @foreach($foods as $food)

                        <tr>



                            <td>



                                @if($food->image)



                                    <img src="{{ asset('storage/'.$food->image) }}"
                                         class="food-image">



                                @else



                                    <span class="text-muted">

                                        No Image

                                    </span>



                                @endif



                            </td>

                            <td>


                                {{ $food->food_name }}


                            </td>

                            <td>


                                {{ $food->category->category_name ?? 'N/A' }}


                            </td>

                            <td>


                                {{ $food->outlet->outlet_name ?? 'N/A' }}


                            </td>
                            <td>


                                Rs. {{ number_format($food->price,2) }}


                            </td>
                            <td>


                                {{ $food->available_quantity }}


                            </td>
                            <td>



                                <a href="{{ route('foods.edit',$food->id) }}"
                                   class="btn btn-warning btn-sm">


                                    Edit


                                </a>

                                <form action="{{ route('foods.destroy',$food->id) }}"
                                      method="POST"
                                      class="d-inline">


                                    @csrf

                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this food?')">


                                        Delete
                                    </button>

                                </form>

                            </td>


                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>
    </div>
</div>

</body>

</html>