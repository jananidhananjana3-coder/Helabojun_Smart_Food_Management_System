@extends('layouts.admin')

@section('title', 'Counters')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="title mb-1">
                Counter Management
            </h2>

            <p class="text-muted mb-0">
                Manage counters assigned to each outlet.
            </p>
        </div>

        <a
            href="{{ route('counters.create') }}"
            class="btn btn-success"
        >
            <i class="fa fa-plus"></i>
            Add Counter
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

    <div class="card-box">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>Outlet</th>

                        <th>Counter</th>

                        <th>Name</th>

                        <th>Status</th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($counters as $c)

                        <tr>

                            <td>
                                {{ $c->outlet->outlet_name }}
                            </td>

                            <td>
                                <strong>
                                    #{{ $c->counter_number }}
                                </strong>
                            </td>

                            <td>
                                {{ $c->counter_name }}
                            </td>

                            <td>

                                <span
                                    class="badge text-bg-{{
                                        $c->status === 'active'
                                            ? 'success'
                                            : 'secondary'
                                    }}"
                                >
                                    {{ ucfirst($c->status) }}
                                </span>

                            </td>

                            <td class="text-end">

                                <a
                                    href="{{ route('counters.edit', $c) }}"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    <i class="fa fa-edit"></i>
                                    Edit
                                </a>

                                <form
                                    class="d-inline"
                                    method="POST"
                                    action="{{ route('counters.destroy', $c) }}"
                                    onsubmit="return confirm('Delete this counter?')"
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

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center p-4"
                            >
                                No counters found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection