@extends('layouts.admin')

@section('title', 'Edit Staff')

@push('styles')

<style>

    .card-box {
        background: white;
        padding: 35px;
        border-radius: 15px;
        box-shadow: 0 5px 15px #ddd;
    }

    .title {
        color: #075e3b;
        font-weight: bold;
    }

    .btn-save {
        background: #075e3b;
        color: white;
    }

    .btn-save:hover {
        background: #0b8050;
        color: white;
    }

    .current-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #075e3b;
    }

</style>

@endpush


@section('content')

<div class="card-box">

    <h2 class="title">
        <i class="fa fa-user-edit"></i>
        Edit Staff
    </h2>

    <hr>


    {{-- ERRORS --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form action="{{ route('users.update', $user->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        @method('PUT')


        <div class="row">


            {{-- NAME --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Name
                </label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $user->name) }}"
                       required>

            </div>


            {{-- EMAIL --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email', $user->email) }}"
                       required>

            </div>


            {{-- PASSWORD --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    New Password
                </label>

                <input type="password"
                       name="password"
                       class="form-control">

                <small class="text-muted">
                    Leave empty to keep current password.
                </small>

            </div>


            {{-- PHONE --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Phone
                </label>

                <input type="text"
                       name="phone"
                       class="form-control"
                       value="{{ old('phone', $user->phone) }}">

            </div>


            {{-- NIC --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    NIC Number
                </label>

                <input type="text"
                       name="nic_number"
                       class="form-control"
                       value="{{ old('nic_number', $user->nic_number) }}">

            </div>


            {{-- BIRTHDAY --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Birthday
                </label>

                <input type="date"
                       name="birthday"
                       class="form-control"
                       value="{{ old('birthday', $user->birthday) }}">

            </div>


            {{-- ADDRESS --}}

            <div class="col-md-12 mb-3">

                <label class="form-label">
                    Address
                </label>

                <textarea name="address"
                          class="form-control"
                          rows="3">{{ old('address', $user->address) }}</textarea>

            </div>


            {{-- JOIN DATE --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Join Date
                </label>

                <input type="date"
                       name="join_date"
                       class="form-control"
                       value="{{ old('join_date', $user->join_date) }}">

            </div>


            {{-- ROLE --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Role
                </label>

                <select name="role"
                        id="role"
                        class="form-control"
                        required>

                    <option value="admin"
                        {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="manager"
                        {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>
                        Manager
                    </option>

                    <option value="chef"
                        {{ old('role', $user->role) == 'chef' ? 'selected' : '' }}>
                        Chef
                    </option>

                    <option value="cashier"
                        {{ old('role', $user->role) == 'cashier' ? 'selected' : '' }}>
                        Cashier
                    </option>

                </select>

            </div>


            {{-- PROFILE IMAGE --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Profile Image
                </label>


                @if($user->profile_image)

                    <div class="mb-2">

                        <img
                            src="{{ asset('storage/' . $user->profile_image) }}"
                            class="current-image"
                            alt="Current Profile Image">

                    </div>

                @endif


                <input type="file"
                       name="profile_image"
                       class="form-control">

            </div>


            {{-- OUTLET --}}

            <div class="col-md-6 mb-3"
                 id="outletField">

                <label class="form-label">
                    Outlet
                </label>

                <select name="outlet_id"
                        id="outlet_id"
                        class="form-control">

                    <option value="">
                        Select Outlet
                    </option>

                    @foreach($outlets as $outlet)

                        <option value="{{ $outlet->id }}"
                            {{ old('outlet_id', $user->outlet_id) == $outlet->id ? 'selected' : '' }}>

                            {{ $outlet->outlet_name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- COUNTER --}}

            <div class="col-md-6 mb-3"
                 id="counterField">

                <label class="form-label">
                    Counter
                </label>

                <select name="counter_id"
                        id="counter_id"
                        class="form-control">

                    <option value="">
                        Select Counter
                    </option>

                </select>

            </div>


            {{-- TRAINING PERIOD --}}

            <div class="col-md-6 mb-3"
                 id="trainingField"
                 style="display:none;">

                <label class="form-label">
                    Training Period
                </label>

                <input type="text"
                       name="training_period"
                       id="training_period"
                       class="form-control"
                       value="{{ old('training_period', $user->training_period) }}"
                       placeholder="Example: 2026-08-01 to 2026-08-31">

                <small class="text-muted">
                    Enter Chef training period.
                </small>

            </div>


            {{-- FOOD SPECIALTIES --}}

            <div class="col-md-6 mb-3"
                 id="specialtiesField"
                 style="display:none;">

                <label class="form-label">
                    Food Specialties
                </label>

                <textarea name="food_specialties"
                          id="food_specialties"
                          class="form-control"
                          rows="3"
                          placeholder="Example: Rice & Curry, Hoppers, String Hoppers">{{ old('food_specialties', $user->food_specialties) }}</textarea>

            </div>


        </div>


        {{-- UPDATE BUTTON --}}

        <button type="submit"
                class="btn btn-save px-4">

            <i class="fa fa-save"></i>

            Update Staff

        </button>


        {{-- BACK BUTTON --}}

        <a href="{{ route('users.index') }}"
           class="btn btn-secondary">

            <i class="fa fa-arrow-left"></i>

            Back

        </a>

    </form>

</div>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | GET ELEMENTS
    |--------------------------------------------------------------------------
    */

    const role = document.getElementById('role');

    const outlet = document.getElementById('outlet_id');

    const counter = document.getElementById('counter_id');

    const outletField =
        document.getElementById('outletField');

    const counterField =
        document.getElementById('counterField');

    const trainingField =
        document.getElementById('trainingField');

    const specialtiesField =
        document.getElementById('specialtiesField');

    const training =
        document.getElementById('training_period');

    const specialties =
        document.getElementById('food_specialties');


    /*
    |--------------------------------------------------------------------------
    | COUNTERS FROM CONTROLLER
    |--------------------------------------------------------------------------
    |
    | Laravel 10 safe JavaScript conversion.
    |
    */

    const allCounters =
        {{ Illuminate\Support\Js::from($counterData) }};


    /*
    |--------------------------------------------------------------------------
    | CURRENT COUNTER
    |--------------------------------------------------------------------------
    */

    const existingCounter =
        "{{ old('counter_id', $user->counter_id ?? '') }}";


    /*
    |--------------------------------------------------------------------------
    | FILTER COUNTERS
    |--------------------------------------------------------------------------
    */

    function filterCounters() {

        const selectedOutlet =
            String(outlet.value || '');

        /*
        | If user changes outlet, keep current selected counter
        | only if it belongs to that outlet.
        */

        let currentCounter =
            String(counter.value || '');

        if (!currentCounter) {

            currentCounter =
                String(existingCounter || '');

        }


        /*
        |--------------------------------------------------------------------------
        | Reset Counter Dropdown
        |--------------------------------------------------------------------------
        */

        counter.innerHTML = '';


        const defaultOption =
            document.createElement('option');

        defaultOption.value = '';

        defaultOption.textContent =
            'Select Counter';

        counter.appendChild(defaultOption);


        /*
        |--------------------------------------------------------------------------
        | No Outlet
        |--------------------------------------------------------------------------
        */

        if (!selectedOutlet) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        allCounters.forEach(function (item) {

            const itemOutlet =
                String(item.outlet_id || '');

            const itemStatus =
                String(item.status || '')
                    .toLowerCase();


            /*
            |--------------------------------------------------------------------------
            | Selected Outlet + Active Counter
            |--------------------------------------------------------------------------
            */

            if (
                itemOutlet === selectedOutlet &&
                itemStatus === 'active'
            ) {

                const option =
                    document.createElement('option');


                option.value =
                    item.id;


                /*
                |--------------------------------------------------------------------------
                | Counter Name
                |--------------------------------------------------------------------------
                */

                let counterText =
                    item.name || 'Counter';


                /*
                |--------------------------------------------------------------------------
                | Counter Number
                |--------------------------------------------------------------------------
                */

                if (item.number) {

                    counterText +=
                        ' - ' + item.number;

                }


                option.textContent =
                    counterText;


                /*
                |--------------------------------------------------------------------------
                | Existing Counter
                |--------------------------------------------------------------------------
                */

                if (
                    String(item.id) ===
                    currentCounter
                ) {

                    option.selected =
                        true;

                }


                counter.appendChild(option);

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE FIELDS BASED ON ROLE
    |--------------------------------------------------------------------------
    */

    function updateFields() {

        /*
        |--------------------------------------------------------------------------
        | Hide all conditional fields
        |--------------------------------------------------------------------------
        */

        outletField.style.display =
            'none';

        counterField.style.display =
            'none';

        trainingField.style.display =
            'none';

        specialtiesField.style.display =
            'none';


        /*
        |--------------------------------------------------------------------------
        | Remove required
        |--------------------------------------------------------------------------
        */

        outlet.required =
            false;

        counter.required =
            false;

        training.required =
            false;

        specialties.required =
            false;


        /*
        |--------------------------------------------------------------------------
        | CASHIER
        |--------------------------------------------------------------------------
        */

        if (
            role.value === 'cashier'
        ) {

            outletField.style.display =
                'block';

            outlet.required =
                true;

            /*
            | Counter is not required for cashier.
            */

            counter.required =
                false;

        }


        /*
        |--------------------------------------------------------------------------
        | CHEF
        |--------------------------------------------------------------------------
        */

        if (
            role.value === 'chef'
        ) {

            outletField.style.display =
                'block';

            counterField.style.display =
                'block';

            trainingField.style.display =
                'block';

            specialtiesField.style.display =
                'block';


            /*
            | Required fields.
            */

            outlet.required =
                true;

            counter.required =
                true;

            training.required =
                true;

            specialties.required =
                true;


            /*
            | Load counters.
            */

            filterCounters();

        }


        /*
        |--------------------------------------------------------------------------
        | ADMIN / MANAGER
        |--------------------------------------------------------------------------
        */

        if (
            role.value === 'admin' ||
            role.value === 'manager'
        ) {

            outlet.value =
                '';

            counter.value =
                '';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | ROLE CHANGE
    |--------------------------------------------------------------------------
    */

    role.addEventListener(
        'change',
        function () {

            updateFields();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | OUTLET CHANGE
    |--------------------------------------------------------------------------
    */

    outlet.addEventListener(
        'change',
        function () {

            /*
            | Clear counter when outlet changes.
            */

            counter.value = '';


            if (
                role.value === 'chef'
            ) {

                filterCounters();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INITIAL LOAD
    |--------------------------------------------------------------------------
    */

    updateFields();


    /*
    |--------------------------------------------------------------------------
    | CHEF INITIAL LOAD
    |--------------------------------------------------------------------------
    */

    if (
        role.value === 'chef'
    ) {

        filterCounters();

    }

});

</script>

@endpush