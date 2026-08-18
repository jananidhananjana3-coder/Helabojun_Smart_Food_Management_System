<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{ $editing ? 'Edit' : 'Add' }} Counter
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container py-5">

    <div
        class="card shadow-sm mx-auto"
        style="max-width: 650px"
    >

        <div class="card-body p-4">

            <h3 class="mb-4">
                {{ $editing ? 'Edit' : 'Add' }} Counter
            </h3>


            @if($errors->any())

                <div class="alert alert-danger">

                    @foreach($errors->all() as $e)

                        <div>
                            {{ $e }}
                        </div>

                    @endforeach

                </div>

            @endif


            <form
                method="POST"
                action="{{ $editing
                    ? route('counters.update', $counter)
                    : route('counters.store')
                }}"
            >

                @csrf

                @if($editing)

                    @method('PUT')

                @endif


                <div class="mb-3">

                    <label class="form-label">
                        Outlet
                    </label>

                    <select
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


                <div class="mb-3">

                    <label class="form-label">
                        Counter Number
                    </label>

                    <input
                        type="text"
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


                <div class="mb-3">

                    <label class="form-label">
                        Counter Name
                    </label>

                    <input
                        type="text"
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


                <div class="mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select
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


                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        Save
                    </button>

                    <a
                        href="{{ route('counters.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>