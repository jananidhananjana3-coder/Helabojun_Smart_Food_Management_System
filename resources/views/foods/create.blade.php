<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Add Food | Hela Bojun</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        body {
            background: #f5f7f6;
        }

        .food-card {
            border-radius: 15px;
        }

        .card-header {
            background: #075e3b;
            color: white;
        }

        .preview-image {
            width: 180px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            display: none;
        }

        .counter-card {
            border: 1px solid #dfe7e3;
            border-radius: 12px;
            background: #f8fbf9;
        }

        .counter-card:hover {
            border-color: #075e3b;
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


                    <form
                        action="{{ route('foods.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        {{-- CATEGORY --}}

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Category
                            </label>

                            <select
                                name="category_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Select Category
                                </option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->category_name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- OUTLET --}}

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Outlet
                            </label>

                            <select
                                name="outlet_id"
                                id="outletSelect"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Select Outlet
                                </option>

                                @foreach($outlets as $outlet)

                                    <option
                                        value="{{ $outlet->id }}"
                                        {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}
                                    >
                                        {{ $outlet->outlet_name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- COUNTERS --}}

                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Counter Quantities
                            </label>

                            <small class="text-muted d-block mb-3">
                                Set how many portions are available at each counter.
                            </small>


                            <div
                                id="counterContainer"
                                class="row g-3"
                            >

                                @foreach($counters as $counter)

                                    <div
                                        class="col-md-6 counter-item"
                                        data-outlet="{{ $counter->outlet_id }}"
                                        style="display:none"
                                    >

                                        <div class="counter-card p-3">

                                            <div class="d-flex justify-content-between align-items-center mb-2">

                                                <strong>
                                                    Counter {{ $counter->counter_number }}
                                                </strong>

                                                <span class="badge bg-success">
                                                    Active
                                                </span>

                                            </div>

                                            <input
                                                type="number"
                                                min="0"
                                                name="counter_quantities[{{ $counter->id }}]"
                                                class="form-control"
                                                value="{{ old('counter_quantities.' . $counter->id, 0) }}"
                                            >

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                            <div
                                id="noCounterMessage"
                                class="alert alert-warning mt-3"
                                style="display:none"
                            >
                                No active counters found for this outlet.
                            </div>

                        </div>


                        {{-- FOOD NAME --}}

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Food Name
                            </label>

                            <input
                                type="text"
                                name="food_name"
                                class="form-control"
                                value="{{ old('food_name') }}"
                                placeholder="Enter food name"
                                required
                            >

                        </div>


                        {{-- DESCRIPTION --}}

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Description
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="3"
                                placeholder="Enter description"
                            >{{ old('description') }}</textarea>

                        </div>


                        {{-- PRICE --}}

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Price (Rs.)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="price"
                                class="form-control"
                                value="{{ old('price') }}"
                                placeholder="350.00"
                                required
                            >

                        </div>


                        {{-- GLOBAL QUANTITY --}}

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Total Available Quantity
                            </label>

                            <input
                                type="number"
                                min="0"
                                name="available_quantity"
                                class="form-control"
                                value="{{ old('available_quantity', 0) }}"
                                required
                            >

                            <small class="text-muted">
                                Overall food quantity for the outlet.
                            </small>

                        </div>


                        {{-- IMAGE --}}

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Food Image
                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control"
                                accept="image/*"
                                onchange="previewImage(event)"
                            >

                        </div>


                        {{-- PREVIEW --}}

                        <div class="text-center mb-3">

                            <img
                                id="imagePreview"
                                class="preview-image shadow"
                                alt="Preview"
                            >

                        </div>


                        <button
                            type="submit"
                            class="btn btn-success w-100"
                        >
                            Save Food
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

function previewImage(event)
{
    const image =
        document.getElementById('imagePreview');

    if (
        event.target.files &&
        event.target.files[0]
    ) {

        image.src =
            URL.createObjectURL(
                event.target.files[0]
            );

        image.style.display = 'block';
    }
}


/*
|--------------------------------------------------------------------------
| Outlet → Counters
|--------------------------------------------------------------------------
*/

const outletSelect =
    document.getElementById('outletSelect');

const counterItems =
    document.querySelectorAll('.counter-item');

const noCounterMessage =
    document.getElementById('noCounterMessage');


function filterCounters()
{
    const outletId =
        outletSelect.value;

    let visibleCount = 0;


    counterItems.forEach(function(item) {

        if (
            outletId &&
            item.dataset.outlet === outletId
        ) {

            item.style.display = '';

            visibleCount++;

        } else {

            item.style.display = 'none';

        }

    });


    noCounterMessage.style.display =
        outletId && visibleCount === 0
            ? 'block'
            : 'none';
}


outletSelect.addEventListener(
    'change',
    filterCounters
);


filterCounters();

</script>


</body>
</html>