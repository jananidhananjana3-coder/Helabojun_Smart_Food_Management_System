@extends('layouts.admin')

@section('title', 'Edit Outlet')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm mx-auto" style="max-width:760px">

        <div class="card-body p-4">

            <h3 class="mb-2">Edit Outlet</h3>

            <p class="text-muted">
                Update the outlet details and Google Maps location.
            </p>

            @if($errors->any())

                <div class="alert alert-danger">

                    @foreach($errors->all() as $e)
                        <div>{{ $e }}</div>
                    @endforeach

                </div>

            @endif

            <form
                method="POST"
                action="{{ route('outlets.update', $outlet) }}"
            >

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Outlet Name
                    </label>

                    <input
                        type="text"
                        name="outlet_name"
                        class="form-control"
                        required
                        value="{{ old('outlet_name', $outlet->outlet_name) }}"
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Address / Location
                    </label>

                    <textarea
                        name="location"
                        class="form-control"
                        rows="3"
                        required
                    >{{ old('location', $outlet->location) }}</textarea>

                </div>

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label">
                            Contact Number
                        </label>

                        <input
                            type="text"
                            name="contact_number"
                            class="form-control"
                            value="{{ old('contact_number', $outlet->contact_number) }}"
                        >

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status" class="form-select">

                            <option
                                value="active"
                                @selected(old('status', $outlet->status) === 'active')
                            >
                                Active
                            </option>

                            <option
                                value="inactive"
                                @selected(old('status', $outlet->status) === 'inactive')
                            >
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

                <div class="mt-3">

                    <label class="form-label">
                        Google Maps Link or Search Text
                    </label>

                    <input
                        type="text"
                        name="google_maps_url"
                        class="form-control"
                        placeholder="https://maps.google.com/... or Hela Bojun Battaramulla"
                        value="{{ old('google_maps_url', $outlet->google_maps_url) }}"
                    >

                    <div class="form-text">
                        Paste a Google Maps share link or enter a location.
                    </div>

                </div>

                <div class="mt-4">

                    <button type="submit" class="btn btn-success">
                        Update Outlet
                    </button>

                    <a
                        href="{{ route('outlets.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection