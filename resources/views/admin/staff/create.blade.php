@extends('layouts.admin')

@section('title', 'Add Staff')

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

    .training-section {
        display: none;
    }

</style>

@endpush


@section('content')

<div class="card-box">

    <h2 class="title">

        <i class="fa fa-user-plus"></i>

        Add Staff

    </h2>

    <hr>


    {{-- VALIDATION ERRORS --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form action="{{ route('users.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf


        <div class="row">


            {{-- NAME --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Name
                </label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name') }}"
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
                       value="{{ old('email') }}"
                       required>

            </div>


            {{-- PASSWORD --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Password
                </label>

                <input type="password"
                       name="password"
                       class="form-control"
                       required>

                <small class="text-muted">
                    Password must contain at least 8 characters
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
                       value="{{ old('phone') }}">

            </div>


            {{-- NIC --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    NIC Number
                </label>

                <input type="text"
                       name="nic_number"
                       class="form-control"
                       value="{{ old('nic_number') }}">

            </div>


            {{-- BIRTHDAY --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Birthday
                </label>

                <input type="date"
                       name="birthday"
                       class="form-control"
                       value="{{ old('birthday') }}">

            </div>


            {{-- ADDRESS --}}

            <div class="col-md-12 mb-3">

                <label class="form-label">
                    Address
                </label>

                <textarea name="address"
                          class="form-control"
                          rows="3">{{ old('address') }}</textarea>

            </div>


            {{-- JOIN DATE --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Join Date
                </label>

                <input type="date"
                       name="join_date"
                       class="form-control"
                       value="{{ old('join_date') }}">

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

                    <option value="">
                        Select Role
                    </option>

                    <option value="admin"
                        {{ old('role') == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="manager"
                        {{ old('role') == 'manager' ? 'selected' : '' }}>
                        Manager
                    </option>

                    <option value="chef"
                        {{ old('role') == 'chef' ? 'selected' : '' }}>
                        Chef
                    </option>

                    <option value="cashier"
                        {{ old('role') == 'cashier' ? 'selected' : '' }}>
                        Cashier
                    </option>

                </select>

            </div>


            {{-- PROFILE IMAGE --}}

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Profile Image
                </label>

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
                            {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>

                            {{ $outlet->outlet_name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- COUNTER --}}

            <div class="col-md-6 mb-3"
                 id="counterField"
                 style="display:none;">

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


            {{-- TRAINING --}}

            <div class="col-md-6 mb-3"
                 id="trainingField"
                 style="display:none;">

                <label class="form-label">
                    Training Period
                </label>

                <div class="row">

                    <div class="col-md-6">

                        <label class="form-label">
                            Start Date
                        </label>

                        <input type="date"
                               name="training_start_date"
                               id="training_start_date"
                               class="form-control"
                               value="{{ old('training_start_date') }}">

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            End Date
                        </label>

                        <input type="date"
                               name="training_end_date"
                               id="training_end_date"
                               class="form-control"
                               value="{{ old('training_end_date') }}">

                    </div>

                </div>

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
                          placeholder="Example: Rice & Curry, Hoppers, String Hoppers">{{ old('food_specialties') }}</textarea>

            </div>


        </div>


        {{-- SAVE --}}

        <button type="submit"
                class="btn btn-save px-4">

            <i class="fa fa-save"></i>

            Save Staff

        </button>


        {{-- BACK --}}

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

    const trainingStart =
        document.getElementById('training_start_date');

    const trainingEnd =
        document.getElementById('training_end_date');


    /*
    |--------------------------------------------------------------------------
    | ALL COUNTERS FROM DATABASE
    |--------------------------------------------------------------------------
    */

    const allCounters = @json($counters);


    /*
    |--------------------------------------------------------------------------
    | LOAD COUNTERS
    |--------------------------------------------------------------------------
    */

    function loadCounters() {

        const selectedOutlet =
            String(outlet.value);


        /*
        | Reset counter
        */

        counter.innerHTML = '';

        const defaultOption =
            document.createElement('option');

        defaultOption.value = '';

        defaultOption.textContent =
            'Select Counter';

        counter.appendChild(defaultOption);


        /*
        | No outlet
        */

        if (!selectedOutlet) {

            return;
        }


        /*
        | Filter counters
        */

        const filteredCounters =
            allCounters.filter(function (item) {

                return String(item.outlet_id) ===
                       selectedOutlet;

            });


        /*
        | Add counters
        */

        filteredCounters.forEach(function (item) {

            const option =
                document.createElement('option');

            option.value =
                item.id;

            option.textContent =
                item.name +
                ' - ' +
                item.number;

            counter.appendChild(option);

        });


        /*
        | Old selected counter
        */

        const oldCounter =
            "{{ old('counter_id') }}";

        if (oldCounter) {

            counter.value =
                oldCounter;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE FIELDS
    |--------------------------------------------------------------------------
    */

    function updateFields() {

        outletField.style.display = 'none';

        counterField.style.display = 'none';

        trainingField.style.display = 'none';

        specialtiesField.style.display = 'none';


        outlet.required = false;

        counter.required = false;

        trainingStart.required = false;

        trainingEnd.required = false;


        /*
        | CASHIER
        */

        if (role.value === 'cashier') {

            outletField.style.display = 'block';

            outlet.required = true;

        }


        /*
        | CHEF
        */

        if (role.value === 'chef') {

            outletField.style.display = 'block';

            counterField.style.display = 'block';

            trainingField.style.display = 'block';

            specialtiesField.style.display = 'block';


            outlet.required = true;

            counter.required = true;

            trainingStart.required = true;

            trainingEnd.required = true;


            loadCounters();

        }


        /*
        | ADMIN / MANAGER
        */

        if (
            role.value === 'admin' ||
            role.value === 'manager'
        ) {

            outlet.value = '';

            counter.value = '';

            trainingStart.value = '';

            trainingEnd.value = '';

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

            if (role.value === 'chef') {

                loadCounters();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | TRAINING DATE VALIDATION
    |--------------------------------------------------------------------------
    */

    trainingEnd.addEventListener(
        'change',
        function () {

            if (
                trainingStart.value &&
                trainingEnd.value &&
                trainingEnd.value <
                trainingStart.value
            ) {

                alert(
                    'Training End Date cannot be before Start Date.'
                );

                trainingEnd.value = '';

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INITIAL LOAD
    |--------------------------------------------------------------------------
    */

    updateFields();

});

</script>

@endpush