<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Hela Bojun Admin')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
          rel="stylesheet">

    @stack('styles')

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f7fb;
            font-family: Arial, sans-serif;
        }


        /* ========================================
           SIDEBAR
        ======================================== */

        .sidebar {

            width: 260px;

            height: 100vh;

            position: fixed;

            top: 0;

            left: 0;

            background: #075e3b;

            color: white;

            padding: 20px 15px;

            overflow-y: auto;

            z-index: 1000;

        }


        /* ========================================
           LOGO
        ======================================== */

        .sidebar-logo {

            text-align: center;

            margin-bottom: 15px;

        }


        .sidebar-logo img {

            width: 150px;

            max-height: 90px;

            object-fit: contain;

        }


        .sidebar hr {

            border-color: rgba(255,255,255,0.3);

        }


        /* ========================================
           SIDEBAR LINKS
        ======================================== */

        .sidebar a {

            display: flex;

            align-items: center;

            gap: 12px;

            color: white;

            padding: 12px 15px;

            text-decoration: none;

            border-radius: 8px;

            margin-bottom: 5px;

            transition: 0.2s;

        }


        .sidebar a:hover {

            background: #0b8050;

        }


        .sidebar a.active {

            background: #0b8050;

        }


        .sidebar a i {

            width: 22px;

            text-align: center;

        }


        /* ========================================
           LOGOUT
        ======================================== */

        .logout-btn {

            border: none;

            width: 100%;

            margin-top: 20px;

            padding: 11px;

        }


        /* ========================================
           CONTENT
        ======================================== */

        .content {

            margin-left: 260px;

            min-height: 100vh;

            padding: 30px;

        }


        /* ========================================
           TOP BAR
        ======================================== */

        .topbar {

            background: white;

            padding: 12px 20px;

            border-radius: 12px;

            margin-bottom: 25px;

            box-shadow: 0 3px 12px #ddd;

            display: flex;

            justify-content: flex-end;

            align-items: center;

        }


        /* ========================================
           LANGUAGE
        ======================================== */

        .language-box {

            position: relative;

        }


        .language-btn {

            background: #075e3b;

            color: white;

            border: none;

            width: 42px;

            height: 42px;

            border-radius: 50%;

            font-size: 18px;

            cursor: pointer;

        }


        .language-menu {

            display: none;

            position: absolute;

            right: 0;

            top: 50px;

            background: white;

            width: 160px;

            border-radius: 10px;

            box-shadow: 0 5px 15px #ccc;

            overflow: hidden;

            z-index: 2000;

        }


        .language-menu.show {

            display: block;

        }


        .language-menu button {

            width: 100%;

            border: none;

            background: white;

            text-align: left;

            padding: 12px;

            cursor: pointer;

        }


        .language-menu button:hover {

            background: #f1f1f1;

        }


        /* ========================================
           GENERAL CARD
        ======================================== */

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


        /* ========================================
           MOBILE
        ======================================== */

        @media(max-width: 768px) {

            .sidebar {

                width: 220px;

            }


            .content {

                margin-left: 220px;

                padding: 20px;

            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     SIDEBAR
===================================================== -->

<div class="sidebar">


    <!-- LOGO -->

    <div class="sidebar-logo">

        <img src="{{ asset('images/hela-bojun-logo.png') }}"
             alt="Hela Bojun Logo">

    </div>


    <hr>


    <!-- DASHBOARD -->

    <a href="/admin-dashboard"
       class="{{ request()->is('admin-dashboard') ? 'active' : '' }}">

        <i class="fa fa-home"></i>

        <span>
            {{ __('messages.dashboard') }}
        </span>

    </a>


    <!-- STAFF -->

    <a href="{{ route('users.index') }}"
       class="{{ request()->routeIs('users.*') ? 'active' : '' }}">

        <i class="fa fa-users"></i>

        <span>
            {{ __('messages.staff_management') }}
        </span>

    </a>


    <!-- OUTLETS -->

    <a href="{{ route('outlets.index') }}"
       class="{{ request()->routeIs('outlets.*') ? 'active' : '' }}">

        <i class="fa fa-store"></i>

        <span>
            {{ __('messages.outlets') }}
        </span>

    </a>


    <!-- FOODS -->

    <a href="{{ route('foods.index') }}"
       class="{{ request()->routeIs('foods.*') ? 'active' : '' }}">

        <i class="fa fa-utensils"></i>

        <span>
            {{ __('messages.foods') }}
        </span>

    </a>


    <!-- INVENTORY -->

    <a href="#">

        <i class="fa fa-box"></i>

        <span>
            {{ __('messages.inventory') }}
        </span>

    </a>


    <!-- REPORTS -->

    <a href="#">

        <i class="fa fa-chart-line"></i>

        <span>
            {{ __('messages.reports') }}
        </span>

    </a>


    <!-- LOGOUT -->

    <form method="POST"
          action="{{ route('logout') }}">

        @csrf

        <button type="submit"
                class="btn btn-danger logout-btn">

            <i class="fa fa-sign-out"></i>

            {{ __('messages.logout') }}

        </button>

    </form>


</div>


<!-- =====================================================
     MAIN CONTENT
===================================================== -->

<div class="content">


    <!-- TOP BAR -->

    <div class="topbar">


        <!-- LANGUAGE -->

        <div class="language-box">


            <button type="button"
                    class="language-btn"
                    id="languageButton">

                <i class="fa fa-globe"></i>

            </button>


            <div class="language-menu"
                 id="languageMenu">


                <button type="button"
                        onclick="changeLanguage('en')">

                    🇬🇧 English

                </button>


                <button type="button"
                        onclick="changeLanguage('si')">

                    🇱🇰 සිංහල

                </button>


                <button type="button"
                        onclick="changeLanguage('ta')">

                    🇮🇳 தமிழ்

                </button>


            </div>


        </div>


    </div>


    <!-- PAGE CONTENT -->

    @yield('content')


</div>


<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>


/* ========================================
   LANGUAGE BUTTON
======================================== */

document
    .getElementById('languageButton')
    .addEventListener('click', function () {

        document
            .getElementById('languageMenu')
            .classList.toggle('show');

    });


/* ========================================
   CLOSE LANGUAGE MENU
======================================== */

document.addEventListener('click', function(event) {

    const box =
        document.querySelector('.language-box');

    if (!box.contains(event.target)) {

        document
            .getElementById('languageMenu')
            .classList.remove('show');

    }

});


/* ========================================
   CHANGE LANGUAGE
======================================== */

function changeLanguage(language) {

    window.location.href =
        '/language/' + language;

}

</script>


@stack('scripts')


</body>

</html>