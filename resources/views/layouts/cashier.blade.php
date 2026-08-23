<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Cashier POS - Hela Bojun')
    </title>

    <!-- Vite -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            background: #f5f7fb;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Sidebar */

        .cashier-sidebar {

            width: 250px;
            min-height: 100vh;

            position: fixed;
            left: 0;
            top: 0;

            background: #075e3b;
            color: white;

            z-index: 1000;

            padding: 20px 15px;

            overflow-y: auto;
        }

        /* Logo */

        .cashier-logo {

            width: 100%;
            text-align: center;

            margin-bottom: 15px;
        }

        .cashier-logo img {

            display: block;

            width: 150px;
            max-width: 100%;

            height: auto;
            max-height: 90px;

            object-fit: contain;

            margin: 0 auto;
        }

        .cashier-logo .logo-title {

            margin-top: 10px;

            font-size: 18px;
            font-weight: 700;
        }

        .cashier-logo .logo-subtitle {

            font-size: 13px;
            opacity: 0.85;
        }

        /* Divider */

        .cashier-sidebar hr {

            border-color: rgba(255,255,255,0.3);

            margin: 0 0 15px 0;
        }

        /* Navigation */

        .cashier-nav {

            padding: 0;
        }

        .cashier-nav a {

            display: flex;
            align-items: center;

            gap: 12px;

            color: white;

            text-decoration: none;

            padding: 12px 15px;

            border-radius: 8px;

            margin-bottom: 5px;

            transition: 0.2s;
        }

        .cashier-nav a:hover {

            background: #0b8050;
        }

        .cashier-nav a.active {

            background: #0b8050;
        }

        .cashier-nav a i {

            width: 22px;

            text-align: center;
        }

        /* Logout */

        .cashier-logout {

            border: none;

            width: 100%;

            margin-top: 20px;

            padding: 11px;

            text-align: left;
        }

        /* Main */

        .cashier-main {

            margin-left: 250px;

            min-height: 100vh;
        }

        /* Header */

        .cashier-header {

            height: 70px;

            background: white;

            border-bottom: 1px solid #e5e7eb;

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 0 25px;
        }

        /* User */

        .cashier-user {

            display: flex;

            align-items: center;

            gap: 10px;

            cursor: pointer;
        }

        .cashier-user img {

            width: 42px;
            height: 42px;

            border-radius: 50%;

            object-fit: cover;

            border: 2px solid #075e3b;
        }

        .cashier-user-placeholder {

            width: 42px;
            height: 42px;

            border-radius: 50%;

            background: #075e3b;

            color: white;

            display: flex;

            align-items: center;
            justify-content: center;
        }

        /* Content */

        .cashier-content {

            padding: 25px;
        }

        /* Mobile */

        @media (max-width: 768px) {

            .cashier-sidebar {

                width: 220px;
            }

            .cashier-main {

                margin-left: 220px;
            }

            .cashier-logo img {

                width: 130px;
            }
        }

    </style>

    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    @stack('styles')

</head>


<body>


<!-- Sidebar -->

<aside class="cashier-sidebar">


    <!-- Logo -->

    <div class="cashier-logo">

        <img
            src="{{ asset('images/hela-bojun-logo.png') }}"
            alt="Hela Bojun Logo"
        >

        <div class="logo-title">
            Hela Bojun
        </div>

        <div class="logo-subtitle">
            Cashier POS
        </div>

    </div>


    <hr>


    <!-- Navigation -->

    <div class="cashier-nav">


        <!-- POS -->

        <a
            href="{{ route('cashier.dashboard') }}"
            class="{{ request()->routeIs('cashier.dashboard') ? 'active' : '' }}"
        >

            <i class="fa fa-cash-register"></i>

            <span class="nav-text">
                POS / Cashier
            </span>

        </a>


        

        <!-- Queue -->

        <!-- Queue -->

<a
    href="{{ route('queue.display') }}"
    class="{{ request()->routeIs('queue.display') ? 'active' : '' }}"
>
    <i class="fa fa-list-ol"></i>

    <span class="nav-text">
        Queue
    </span>
</a>


        <!-- Profile -->

        <a
    href="{{ route('profile.edit') }}"
    class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}"
>
    <i class="fa fa-user"></i>

    <span class="nav-text">
        My Profile
    </span>
</a>


        <!-- Logout -->

        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="btn btn-danger cashier-logout"
            >

                <i class="fa fa-right-from-bracket me-2"></i>

                <span class="nav-text">
                    Logout
                </span>

            </button>

        </form>

    </div>

</aside>


<!-- Main -->

<main class="cashier-main">


    <!-- Header -->

    <header class="cashier-header">


        <!-- Page title -->

        <div>

            <h5 class="mb-0 fw-bold">

                @yield('page-title', 'POS / Cashier')

            </h5>

            <small class="text-muted">

                @yield('page-subtitle')

            </small>

        </div>


        <!-- User profile -->

        @auth

            <div class="cashier-user">

                @if(auth()->user()->profile_image)

                    <img
                        src="{{ asset('storage/' . auth()->user()->profile_image) }}"
                        alt="{{ auth()->user()->name }}"
                    >

                @else

                    <div class="cashier-user-placeholder">

                        <i class="fa fa-user"></i>

                    </div>

                @endif


                <div>

                    <div class="fw-semibold">

                        {{ auth()->user()->name }}

                    </div>

                    <small class="text-muted">

                        Cashier

                    </small>

                </div>

            </div>

        @endauth

    </header>


    <!-- Page content -->

    <div class="cashier-content">

        @yield('content')

    </div>


</main>


<!-- Scripts -->

@stack('scripts')


</body>

</html>