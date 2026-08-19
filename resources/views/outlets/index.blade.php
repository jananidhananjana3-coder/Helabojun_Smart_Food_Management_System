@extends('layouts.admin')

@section('title', 'Outlets')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="title mb-1">
                Outlet Management
            </h2>

            <p class="text-muted mb-0">
                Manage Hela Bojun outlets.
            </p>
        </div>

        <a
            class="btn btn-success"
            href="{{ route('outlets.create') }}"
        >
            <i class="fa fa-plus"></i>
            Add Outlet
        </a>

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

    <div class="row g-4">

        @forelse($outlets as $o)

            <div class="col-md-6 col-xl-4">

                <div class="card shadow-sm h-100 border-0">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start">

                            <h5 class="fw-bold mb-2">
                                {{ $o->outlet_name }}
                            </h5>

                            <span
                                class="badge text-bg-{{ $o->status === 'active' ? 'success' : 'secondary' }}"
                            >
                                {{ ucfirst($o->status) }}
                            </span>

                        </div>

                        <p class="text-muted mb-2">
                            <i class="fa fa-location-dot"></i>
                            {{ $o->location }}
                        </p>

                        @if($o->contact_number)

                            <p class="small mb-2">
                                <i class="fa fa-phone"></i>
                                {{ $o->contact_number }}
                            </p>

                        @endif

                        <div class="small text-muted mt-3">

                            <span class="me-2">
                                <i class="fa fa-cash-register"></i>
                                Counters: {{ $o->counters_count }}
                            </span>

                            <span class="me-2">
                                <i class="fa fa-utensils"></i>
                                Foods: {{ $o->foods_count }}
                            </span>

                            <span>
                                <i class="fa fa-users"></i>
                                Staff: {{ $o->users_count }}
                            </span>

                        </div>

                        @if($o->google_maps_url)

                            <div class="mt-3">

                                <a
                                    target="_blank"
                                    rel="noopener"
                                    href="{{ $o->map_open_url }}"
                                    class="text-success text-decoration-none"
                                >
                                    <i class="fa fa-map-marker-alt"></i>
                                    Open Google Maps
                                </a>

                            </div>

                        @endif

                        <div class="mt-4">

                            <a
                                href="{{ route('outlets.show', $o) }}"
                                class="btn btn-sm btn-outline-success"
                            >
                                <i class="fa fa-eye"></i>
                                View
                            </a>

                            <a
                                href="{{ route('outlets.edit', $o) }}"
                                class="btn btn-sm btn-outline-primary"
                            >
                                <i class="fa fa-edit"></i>
                                Edit
                            </a>

                            <form
                                class="d-inline"
                                method="POST"
                                action="{{ route('outlets.destroy', $o) }}"
                                onsubmit="return confirm('Delete outlet?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-danger"
                                >
                                    <i class="fa fa-trash"></i>
                                    Delete
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-info">
                    No outlets.
                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection