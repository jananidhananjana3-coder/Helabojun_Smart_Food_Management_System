@extends('layouts.admin')

@section('title', 'Edit Counter')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm mx-auto" style="max-width: 650px;">

        <div class="card-body p-4">

            <h3 class="mb-4">
                Edit Counter
            </h3>

            @if($errors->any())

                <div class="alert alert-danger">

                    @foreach($errors->all() as $e)
                        <div>{{ $e }}</div>
                    @endforeach

                </div>

            @endif

            <form
                method="POST"
                action="{{ route('counters.update', $counter) }}"
            >

                @csrf
                @method('PUT')

                {{-- Outlet --}}
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
                                        $counter->outlet_id
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
                            $counter->counter_number
                        ) }}"
                    >

                </div>

                {{-- Counter Name --}}
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
                            $counter->counter_name
                        ) }}"
                    >

                </div>

                {{-- Status --}}
                <div class="mb-4">

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
                                    $counter->status
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
                                    $counter->status
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
                        Update Counter
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

@endsection