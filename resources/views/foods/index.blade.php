@extends('layouts.admin')

@section('title', 'Food Management')

@section('page-title', 'Food Management')

@section('content')

<div class="page-header p-4 mb-4 shadow">

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h2 class="mb-1">
                Food Management
            </h2>

            <div class="small opacity-75">
                Manage food details, categories and outlet assignments.
            </div>

        </div>


        <a
            href="{{ route('foods.create') }}"
            class="btn btn-light"
        >
            <i class="fa fa-plus me-1"></i>
            Add Food
        </a>

    </div>

</div>


@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="alert alert-danger">
        {{ session('error') }}
    </div>

@endif


<div class="card shadow table-card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-success">

                    <tr>

                        <th>Image</th>

                        <th>Food Name</th>

                        <th>Category</th>

                        <th>Outlet</th>

                        <th>Price</th>

                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($foods as $food)

                        <tr>

                            <td>

                                @if($food->image)

                                    <img
                                        src="{{ asset('storage/' . $food->image) }}"
                                        class="food-image"
                                    >

                                @else

                                    <span class="text-muted">
                                        No Image
                                    </span>

                                @endif

                            </td>


                            <td>

                                <strong>
                                    {{ $food->food_name }}
                                </strong>

                            </td>


                            <td>
                                {{ $food->category->category_name ?? 'N/A' }}
                            </td>


                            <td>
                                {{ $food->outlet->outlet_name ?? 'N/A' }}
                            </td>


                            <td>
                                Rs. {{ number_format($food->price, 2) }}
                            </td>


                            <td>

                                <a
                                    href="{{ route('foods.edit', $food->id) }}"
                                    class="btn btn-warning btn-sm"
                                >
                                    <i class="fa fa-pen"></i>
                                    Edit
                                </a>


                                <form
                                    action="{{ route('foods.destroy', $food->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Delete this food?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                    >
                                        <i class="fa fa-trash"></i>
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-muted py-4"
                            >
                                No foods found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

    .page-header {
        background: #075e3b;
        color: white;
        border-radius: 12px;
    }

    .food-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 10px;
    }

    .table-card {
        border-radius: 15px;
        overflow: hidden;
    }

</style>

@endpush