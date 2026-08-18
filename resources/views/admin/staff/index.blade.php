@extends('layouts.admin')

@section('title', 'Staff Management')


@push('styles')

<style>

    .card-box {

        background: white;

        padding: 25px;

        border-radius: 15px;

        box-shadow: 0 5px 15px #ddd;

        margin-bottom: 30px;

    }


    .title {

        color: #075e3b;

        font-weight: bold;

    }


    .section-title {

        color: #075e3b;

        font-weight: bold;

    }


    .table th {

        background: #075e3b;

        color: white;

    }


    .btn-add {

        background: #075e3b;

        color: white;

    }


    .btn-add:hover {

        background: #0b8050;

        color: white;

    }


    .profile-img {

        width: 50px;

        height: 50px;

        border-radius: 50%;

        object-fit: cover;

    }

</style>

@endpush


@section('content')


<div class="card-box">


    <!-- TITLE -->

    <div class="d-flex justify-content-between align-items-center">

        <h2 class="title">

            <i class="fa fa-users"></i>

            Staff Management

        </h2>

    </div>


    <hr>


    <!-- =================================================
         ADMIN SECTION
    ================================================= -->

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="section-title">

            <i class="fa fa-user-tie"></i>

            Admins / Managers

        </h4>


        <a href="{{ route('users.create', ['role'=>'admin']) }}"
           class="btn btn-add">

            <i class="fa fa-plus"></i>

            Add Admin

        </a>

    </div>


    <table class="table table-bordered table-hover">

        <thead>

        <tr>

            <th>Image</th>

            <th>Name</th>

            <th>Email</th>

            <th>Phone</th>

            <th>Role</th>

            <th>Action</th>

        </tr>

        </thead>


        <tbody>

        @forelse($admins as $user)

            <tr>

                <td>

                    @if($user->profile_image)

                        <img src="{{ asset('storage/'.$user->profile_image) }}"
                             class="profile-img">

                    @else

                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                             class="profile-img">

                    @endif

                </td>


                <td>
                    {{ $user->name }}
                </td>


                <td>
                    {{ $user->email }}
                </td>


                <td>
                    {{ $user->phone ?? 'N/A' }}
                </td>


                <td>

                    <span class="badge bg-dark">

                        {{ ucfirst($user->role) }}

                    </span>

                </td>


                <td>

                    <a href="{{ route('users.show', $user->id) }}"
                       class="btn btn-success btn-sm">

                        <i class="fa fa-eye"></i>

                    </a>


                    <a href="{{ route('users.edit', $user->id) }}"
                       class="btn btn-warning btn-sm">

                        <i class="fa fa-edit"></i>

                    </a>


                    <form action="{{ route('users.destroy', $user->id) }}"
                          method="POST"
                          style="display:inline">

                        @csrf

                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete Staff?')">

                            <i class="fa fa-trash"></i>

                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="6"
                    class="text-center">

                    No Admin Found

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>


    <!-- =================================================
         CHEF SECTION
    ================================================= -->

    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">

        <h4 class="section-title">

            <i class="fa fa-utensils"></i>

            Chefs

        </h4>


        <a href="{{ route('users.create', ['role'=>'chef']) }}"
           class="btn btn-add">

            <i class="fa fa-plus"></i>

            Add Chef

        </a>

    </div>


    <table class="table table-bordered table-hover">

        <thead>

        <tr>

            <th>Image</th>

            <th>Name</th>

            <th>Email</th>

            <th>Phone</th>

            <th>Role</th>

            <th>Action</th>

        </tr>

        </thead>


        <tbody>

        @forelse($chefs as $user)

            <tr>

                <td>

                    @if($user->profile_image)

                        <img src="{{ asset('storage/'.$user->profile_image) }}"
                             class="profile-img">

                    @else

                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                             class="profile-img">

                    @endif

                </td>


                <td>
                    {{ $user->name }}
                </td>


                <td>
                    {{ $user->email }}
                </td>


                <td>
                    {{ $user->phone ?? 'N/A' }}
                </td>


                <td>

                    <span class="badge bg-success">

                        Chef

                    </span>

                </td>


                <td>

                    <a href="{{ route('users.show', $user->id) }}"
                       class="btn btn-success btn-sm">

                        <i class="fa fa-eye"></i>

                    </a>


                    <a href="{{ route('users.edit', $user->id) }}"
                       class="btn btn-warning btn-sm">

                        <i class="fa fa-edit"></i>

                    </a>


                    <form action="{{ route('users.destroy', $user->id) }}"
                          method="POST"
                          style="display:inline">

                        @csrf

                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete Chef?')">

                            <i class="fa fa-trash"></i>

                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="6"
                    class="text-center">

                    No Chefs Found

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>


    <!-- =================================================
         CASHIER SECTION
    ================================================= -->

    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">

        <h4 class="section-title">

            <i class="fa fa-cash-register"></i>

            Cashiers

        </h4>


        <a href="{{ route('users.create', ['role'=>'cashier']) }}"
           class="btn btn-add">

            <i class="fa fa-plus"></i>

            Add Cashier

        </a>

    </div>


    <table class="table table-bordered table-hover">

        <thead>

        <tr>

            <th>Image</th>

            <th>Name</th>

            <th>Email</th>

            <th>Phone</th>

            <th>Role</th>

            <th>Action</th>

        </tr>

        </thead>


        <tbody>

        @forelse($cashiers as $user)

            <tr>

                <td>

                    @if($user->profile_image)

                        <img src="{{ asset('storage/'.$user->profile_image) }}"
                             class="profile-img">

                    @else

                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                             class="profile-img">

                    @endif

                </td>


                <td>
                    {{ $user->name }}
                </td>


                <td>
                    {{ $user->email }}
                </td>


                <td>
                    {{ $user->phone ?? 'N/A' }}
                </td>


                <td>

                    <span class="badge bg-primary">

                        Cashier

                    </span>

                </td>


                <td>

                    <a href="{{ route('users.show', $user->id) }}"
                       class="btn btn-success btn-sm">

                        <i class="fa fa-eye"></i>

                    </a>


                    <a href="{{ route('users.edit', $user->id) }}"
                       class="btn btn-warning btn-sm">

                        <i class="fa fa-edit"></i>

                    </a>


                    <form action="{{ route('users.destroy', $user->id) }}"
                          method="POST"
                          style="display:inline">

                        @csrf

                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete Cashier?')">

                            <i class="fa fa-trash"></i>

                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="6"
                    class="text-center">

                    No Cashiers Found

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>


</div>


@endsection