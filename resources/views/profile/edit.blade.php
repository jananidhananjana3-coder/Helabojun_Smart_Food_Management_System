@extends('layouts.profile')

@section('title', 'My Profile')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2 class="fw-bold">
            My Profile
        </h2>

        <p class="text-muted">
            Update your profile information.
        </p>

    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            @include('profile.partials.update-profile-information-form')

        </div>

    </div>

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            @include('profile.partials.update-password-form')

        </div>

    </div>

</div>

@endsection