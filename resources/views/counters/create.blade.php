<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Add Counter</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

    <div class="container py-5">

        <div
            class="card shadow-sm mx-auto"
            style="max-width: 650px;"
        >

            <div class="card-body p-4">

                <h3 class="mb-4">
                    {{ $editing ? 'Edit Counter' : 'Add Counter' }}
                </h3>


                {{-- Validation Errors --}}

                @if($errors->any())

                    <div class="alert alert-danger">

                        @foreach($errors->all() as $e)

                            <div>
                                {{ $e }}
                            </div>

                        @endforeach

                    </div>

                @endif


                {{-- Counter Form --}}

                <form
                    method="POST"
                    action="{{ $editing
                        ? route('counters.update', $counter)
                        : route('counters.store') }}"
                >

                    @csrf

                    @if($editing)

                        @method('PUT')

                    @endif


                    {{-- Outlet --}}

                    <div class="mb-3">

                        <label
                            for="outlet_id"
                            class="form-label"
                        >
                            Outlet
                        </label>

                        <select
                            id="outlet_id"
                            name="outlet_id"
                            class="form-select"
                            required
                        >

                            @foreach($outlets as $o)

                                <option
                                    value="{{ $o->id }}"
                                    @selected(
                                        old(
                                            'outlet_id',
                                            $editing
                                                ? $counter->outlet_id
                                                : ''
                                        ) == $o->id
                                    )
                                >
                                    {{ $o->outlet_name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Counter Number --}}

                    <div class="mb-3">

                        <label
                            for="counter_number"
                            class="form-label"
                        >
                            Counter Number
                        </label>

                        <input
                            type="number"
                            id="counter_number"
                            name="counter_number"
                            class="form-control"
                            required
                            value="{{ old(
                                'counter_number',
                                $editing
                                    ? $counter->counter_number
                                    : ''
                            ) }}"
                        >

                    </div>


                    {{-- Counter Name --}}

                    <div class="mb-3">

                        <label
                            for="counter_name"
                            class="form-label"
                        >
                            Counter Name
                        </label>

                        <input
                            type="text"
                            id="counter_name"
                            name="counter_name"
                            class="form-control"
                            required
                            value="{{ old(
                                'counter_name',
                                $editing
                                    ? $counter->counter_name
                                    : ''
                            ) }}"
                        >

                    </div>


                    {{-- Status --}}

                    <div class="mb-4">

                        <label
                            for="status"
                            class="form-label"
                        >
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-select"
                        >

                            <option
                                value="active"
                                @selected(
                                    old(
                                        'status',
                                        $editing
                                            ? $counter->status
                                            : 'active'
                                    ) === 'active'
                                )
                            >
                                Active
                            </option>

                            <option
                                value="inactive"
                                @selected(
                                    old(
                                        'status',
                                        $editing
                                            ? $counter->status
                                            : 'active'
                                    ) === 'inactive'
                                )
                            >
                                Inactive
                            </option>

                        </select>

                    </div>


                    {{-- Buttons --}}

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        {{ $editing ? 'Update' : 'Save' }}
                    </button>

                    <a
                        href="{{ route('counters.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        Cancel
                    </a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>