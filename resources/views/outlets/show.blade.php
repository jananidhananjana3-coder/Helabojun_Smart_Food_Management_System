@extends('layouts.admin')

@section('title', $outlet->outlet_name)

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <h2 class="title mb-1">
                {{ $outlet->outlet_name }}
            </h2>

            <p class="text-muted mb-1">
                <i class="fa fa-location-dot"></i>
                {{ $outlet->location }}
            </p>

            @if($outlet->contact_number)

                <p class="text-muted mb-0">
                    <i class="fa fa-phone"></i>
                    {{ $outlet->contact_number }}
                </p>

            @endif

        </div>

        <div>

            <a
                class="btn btn-outline-primary"
                href="{{ route('outlets.edit', $outlet) }}"
            >
                <i class="fa fa-edit"></i>
                Edit
            </a>

            <a
                class="btn btn-outline-secondary"
                href="{{ route('outlets.index') }}"
            >
                Back
            </a>

        </div>

    </div>

    <div class="row g-4">

        <div class="col-md-5">

            <div class="card-box">

                <h5 class="section-title mb-3">
                    <i class="fa fa-cash-register"></i>
                    Counters
                </h5>

                @forelse($outlet->counters as $c)

                    <div class="border rounded p-3 mb-2">

                        <strong>
                            #{{ $c->counter_number }}
                        </strong>

                        <span class="text-muted">
                            — {{ $c->counter_name }}
                        </span>

                    </div>

                @empty

                    <div class="text-muted">
                        No counters.
                    </div>

                @endforelse

            </div>

        </div>

        <div class="col-md-7">

            <div class="card-box">

                <h5 class="section-title mb-3">
                    <i class="fa fa-map-location-dot"></i>
                    Google Map
                </h5>

                @if($outlet->map_embed_url)

                    <iframe
                        src="{{ $outlet->map_embed_url }}"
                        width="100%"
                        height="350"
                        style="border:0;border-radius:12px"
                        loading="lazy"
                        allowfullscreen
                    ></iframe>

                    <a
                        class="btn btn-success mt-3"
                        target="_blank"
                        rel="noopener"
                        href="{{ $outlet->map_open_url }}"
                    >
                        <i class="fa fa-map-marker-alt"></i>
                        Open in Google Maps
                    </a>

                @else

                    <div class="text-muted">
                        No map link saved.
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection