<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'My Profile') | Hela Bojun
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >

    @vite(['resources/css/app.css'])

</head>

<body class="bg-light">

<nav class="navbar navbar-light bg-white border-bottom shadow-sm">

    <div class="container-fluid">

        <a
            href="{{ route('dashboard') }}"
            class="navbar-brand fw-bold"
        >
            Hela Bojun
        </a>

        <div class="d-flex align-items-center gap-3">

            <span class="text-muted">

                {{ auth()->user()->name }}

                ·

                {{ ucfirst(auth()->user()->role) }}

            </span>

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-danger"
                >
                    <i class="fa fa-right-from-bracket"></i>
                </button>

            </form>

        </div>

    </div>

</nav>


<main class="py-4">

    @yield('content')

</main>

</body>

</html>