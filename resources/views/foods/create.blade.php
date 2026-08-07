<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Add Food | Hela Bojun</title>


    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">


    <style>

        body{

            background:#f5f7f6;

        }


        .food-card{

            border-radius:15px;

        }


        .card-header{

            background:#075e3b;

            color:white;

        }


        .preview-image{

            width:180px;

            height:150px;

            object-fit:cover;

            border-radius:10px;

            display:none;

        }


    </style>


</head>



<body>


<div class="container py-5">


    <div class="row justify-content-center">


        <div class="col-md-8">


            <div class="card shadow food-card">


                <div class="card-header">


                    <h3 class="mb-0">

                        Add Food

                    </h3>


                </div>



                <div class="card-body">



                    @if($errors->any())


                        <div class="alert alert-danger">


                            <ul class="mb-0">


                                @foreach($errors->all() as $error)


                                    <li>

                                        {{ $error }}

                                    </li>


                                @endforeach


                            </ul>


                        </div>


                    @endif






                    <form action="{{ route('foods.store') }}"
                          method="POST"
                          enctype="multipart/form-data">


                        @csrf





                        <!-- Category -->


                        <div class="mb-3">


                            <label class="form-label fw-bold">

                                Category

                            </label>



                            <select name="category_id"
                                    class="form-select"
                                    required>


                                <option value="">

                                    Select Category

                                </option>



                                @foreach($categories as $category)


                                    <option value="{{ $category->id }}">


                                        {{ $category->category_name }}


                                    </option>


                                @endforeach



                            </select>


                        </div>






                        <!-- Outlet -->


                        <div class="mb-3">


                            <label class="form-label fw-bold">

                                Outlet

                            </label>



                            <select name="outlet_id"
                                    class="form-select"
                                    required>


                                <option value="">

                                    Select Outlet

                                </option>



                                @foreach($outlets as $outlet)


                                    <option value="{{ $outlet->id }}">


                                        {{ $outlet->outlet_name }}


                                    </option>


                                @endforeach



                            </select>


                        </div>






                        <!-- Food Name -->


                        <div class="mb-3">


                            <label class="form-label fw-bold">

                                Food Name

                            </label>



                            <input type="text"
                                   name="food_name"
                                   class="form-control"
                                   placeholder="Enter food name"
                                   required>


                        </div>






                        <!-- Description -->


                        <div class="mb-3">


                            <label class="form-label fw-bold">

                                Description

                            </label>



                            <textarea name="description"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Enter description"></textarea>


                        </div>






                        <!-- Price -->


                        <div class="mb-3">


                            <label class="form-label fw-bold">

                                Price (Rs.)

                            </label>



                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   class="form-control"
                                   placeholder="350.00"
                                   required>


                        </div>






                        <!-- Quantity -->


                        <div class="mb-3">


                            <label class="form-label fw-bold">

                                Available Quantity

                            </label>



                            <input type="number"
                                   name="available_quantity"
                                   class="form-control"
                                   value="0"
                                   required>


                        </div>







                        <!-- Image Upload -->


                        <div class="mb-3">


                            <label class="form-label fw-bold">

                                Food Image

                            </label>



                            <input type="file"
                                   name="image"
                                   class="form-control"
                                   accept="image/*"
                                   onchange="previewImage(event)">



                        </div>







                        <!-- Image Preview -->


                        <div class="text-center mb-3">


                            <img id="imagePreview"
                                 class="preview-image shadow">


                        </div>








                        <!-- Submit Button -->


                        <button type="submit"
                                class="btn btn-success w-100">


                            Save Food


                        </button>





                    </form>



                </div>


            </div>


        </div>


    </div>


</div>







<!-- Image Preview Script -->


<script>


function previewImage(event){


    let image = document.getElementById('imagePreview');


    image.src = URL.createObjectURL(event.target.files[0]);


    image.style.display = 'block';


}



</script>





</body>

</html>