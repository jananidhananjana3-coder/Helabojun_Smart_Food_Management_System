@extends('layouts.admin')

@section('title', $editing ? 'Edit Food' : 'Add Food')

@section('page-title', $editing ? 'Edit Food' : 'Add Food')

@section('content')

<div class="card shadow-sm mx-auto food-card">

    <div class="card-header-custom">

        <h3>
            <i class="fa fa-utensils me-2"></i>

            {{ $editing ? 'Edit Food' : 'Add Food' }}
        </h3>

        <div class="small opacity-75 mt-1">

            Admin manages food information,
            outlet and counter assignment.

            Chef controls live operational quantity.

        </div>

    </div>


    <div class="card-body p-4">

        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Please correct the following:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <div class="info-box mb-4">

            <i class="fa fa-circle-info me-1"></i>

            <strong>Stock management:</strong>

            The starting quantities entered below are assigned
            to counters. After creation, the chef manages
            live operational stock.

        </div>


        <form
            method="POST"
            action="{{ $editing
                ? route('foods.update', $food)
                : route('foods.store') }}"
            enctype="multipart/form-data"
        >

            @csrf

            @if($editing)
                @method('PUT')
            @endif


            <div class="row g-3">


                <div class="col-md-6">

                    <label class="form-label">
                        Food Name
                    </label>

                    <input
                        type="text"
                        name="food_name"
                        class="form-control"
                        value="{{ old(
                            'food_name',
                            $editing ? $food->food_name : ''
                        ) }}"
                        required
                    >

                </div>


                <div class="col-md-6">

                    <label class="form-label">
                        Category
                    </label>

                    <select
                        name="category_id"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select category
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old(
                                        'category_id',
                                        $editing
                                            ? $food->category_id
                                            : ''
                                    ) == $category->id
                                )
                            >

                                {{ $category->category_name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="col-md-6">

                    <label class="form-label">
                        Outlet
                    </label>

                    <select
                        id="outlet"
                        name="outlet_id"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select outlet
                        </option>

                        @foreach($outlets as $outlet)

                            <option
                                value="{{ $outlet->id }}"
                                @selected(
                                    old(
                                        'outlet_id',
                                        $editing
                                            ? $food->outlet_id
                                            : ''
                                    ) == $outlet->id
                                )
                            >

                                {{ $outlet->outlet_name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="col-md-6">

                    <label class="form-label">
                        Price (Rs.)
                    </label>

                    <input
                        type="number"
                        name="price"
                        class="form-control"
                        min="0"
                        step="0.01"
                        value="{{ old(
                            'price',
                            $editing ? $food->price : ''
                        ) }}"
                        required
                    >

                </div>


                <div class="col-12">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="3"
                        class="form-control"
                    >{{ old(
                        'description',
                        $editing ? $food->description : ''
                    ) }}</textarea>

                </div>


                <div class="col-12">

                    <label class="form-label">

                        Counter Assignment & Starting Quantity

                    </label>


                    <div class="text-muted small mb-3">

                        Select the counters where this food
                        will be available.

                    </div>


                    <div
                        id="counterGrid"
                        class="row g-3"
                    >

                        @foreach($counters as $counter)

                            @php

                                $pivot = $editing
                                    ? $food->counters
                                        ->firstWhere(
                                            'id',
                                            $counter->id
                                        )
                                    : null;

                                $existingQuantity = $pivot
                                    ? $pivot->pivot->quantity
                                    : 0;

                                $oldQuantity = old(
                                    'counter_quantities.' .
                                    $counter->id,
                                    $existingQuantity
                                );

                                $isSelected =
                                    ($editing && $pivot)
                                    ||
                                    old(
                                        'counter_quantities.' .
                                        $counter->id
                                    ) !== null;

                            @endphp


                            <div
                                class="col-md-6 counter-item"
                                data-outlet="{{ $counter->outlet_id }}"
                            >

                                <div
                                    class="counter-card
                                    {{ $isSelected ? 'selected' : '' }}"
                                >

                                    <div
                                        class="d-flex align-items-center gap-3"
                                    >

                                        <input
                                            type="checkbox"
                                            class="form-check-input counter-check"
                                            name="counter_quantities[{{ $counter->id }}]"
                                            value="{{ $oldQuantity }}"
                                            @checked($isSelected)
                                        >


                                        <div class="flex-grow-1">

                                            <strong>
                                                Counter
                                                {{ $counter->counter_number }}
                                            </strong>

                                            <div class="small text-muted">
                                                {{ $counter->counter_name }}
                                            </div>

                                        </div>


                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control counter-quantity"
                                            value="{{ $oldQuantity }}"
                                        >

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    <div
                        id="noCounters"
                        class="alert alert-warning mt-3 d-none"
                    >

                        No active counters are available
                        for this outlet.

                    </div>

                </div>


                <div class="col-md-6">

                    <label class="form-label">
                        {{ $editing ? 'Change Food Image' : 'Food Image' }}
                    </label>

                    <input
                        type="file"
                        name="image"
                        class="form-control"
                        accept="image/*"
                        id="image"
                    >


                    @if($editing && $food->image)

                        <div class="mt-3">

                            <div class="small text-muted mb-2">
                                Current image
                            </div>

                            <img
                                src="{{ asset('storage/' . $food->image) }}"
                                class="preview-image shadow-sm"
                            >

                        </div>

                    @endif


                    <img
                        id="imagePreview"
                        class="preview-image shadow-sm mt-3 d-none"
                    >

                </div>

            </div>


            <div class="d-flex gap-2 mt-4">

                <button
                    type="submit"
                    class="btn btn-success px-4"
                >

                    <i class="fa fa-save me-1"></i>

                    {{ $editing ? 'Update Food' : 'Create Food' }}

                </button>


                <a
                    href="{{ route('foods.index') }}"
                    class="btn btn-outline-secondary"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>


@endsection


@push('styles')

<style>

    .food-card {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
    }

    .card-header-custom {
        background: #075e3b;
        color: white;
        padding: 22px 25px;
    }

    .card-header-custom h3 {
        margin: 0;
        font-weight: 700;
    }

    .counter-card {
        border: 1px solid #dce8e1;
        border-radius: 14px;
        padding: 14px;
        background: #fbfdfc;
    }

    .counter-card.selected {
        border-color: #198754;
        box-shadow: 0 0 0 2px #d1e7dd;
        background: #f5fffa;
    }

    .counter-quantity {
        width: 110px;
    }

    .preview-image {
        width: 150px;
        height: 115px;
        object-fit: cover;
        border-radius: 12px;
    }

    .info-box {
        background: #eef8f2;
        border-left: 4px solid #075e3b;
        border-radius: 8px;
        padding: 12px 15px;
    }

    .form-label {
        font-weight: 600;
    }

</style>

@endpush


@push('scripts')

<script>

const outlet =
    document.getElementById('outlet');

const counterItems =
    document.querySelectorAll('.counter-item');

const noCounters =
    document.getElementById('noCounters');


function filterCounters()
{

    const selectedOutlet =
        outlet.value;

    let visibleCount = 0;

    counterItems.forEach(function(item)
    {

        const belongsToOutlet =
            selectedOutlet !== '' &&
            item.dataset.outlet === selectedOutlet;

        if (belongsToOutlet)
        {
            item.style.display = '';
            visibleCount++;
        }
        else
        {
            item.style.display = 'none';
        }

    });

    noCounters.classList.toggle(
        'd-none',
        selectedOutlet === '' ||
        visibleCount > 0
    );

}


outlet.addEventListener(
    'change',
    filterCounters
);

filterCounters();


document
    .querySelectorAll('.counter-card')
    .forEach(function(card)
    {

        const checkbox =
            card.querySelector('.counter-check');

        const quantity =
            card.querySelector('.counter-quantity');


        function syncCounter()
        {

            checkbox.value =
                quantity.value;

            card.classList.toggle(
                'selected',
                checkbox.checked
            );

        }


        quantity.addEventListener(
            'input',
            function()
            {

                checkbox.value =
                    quantity.value;

                if (Number(quantity.value) > 0)
                {
                    checkbox.checked = true;
                }

                syncCounter();

            }
        );


        checkbox.addEventListener(
            'change',
            syncCounter
        );


        syncCounter();

    });


const imageInput =
    document.getElementById('image');

const imagePreview =
    document.getElementById('imagePreview');


imageInput.addEventListener(
    'change',
    function(event)
    {

        const file =
            event.target.files[0];

        if (!file)
        {
            imagePreview.src = '';
            imagePreview.classList.add('d-none');
            return;
        }

        imagePreview.src =
            URL.createObjectURL(file);

        imagePreview.classList.remove('d-none');

    }
);

</script>

@endpush