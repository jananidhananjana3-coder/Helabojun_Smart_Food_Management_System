<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Counters
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2>
            Counter Management
        </h2>

        <a
            class="btn btn-success"
            href="{{ route('counters.create') }}"
        >
            + Add Counter
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


    <div class="card">

        <div class="table-responsive">

            <table class="table mb-0 align-middle">

                <thead>

                    <tr>

                        <th>
                            Outlet
                        </th>

                        <th>
                            Counter
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            Status
                        </th>

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
                                    class="btn btn-sm btn-outline-primary"
                                    href="{{ route('counters.edit', $c) }}"
                                >
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
                                No counters.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>