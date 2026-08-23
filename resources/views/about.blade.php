<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About Us - Hela Bojun</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

</head>

<body>

<header class="top-header">

    <div class="container-fluid px-4">

        <div class="d-flex align-items-center justify-content-between header-wrapper">

            <div class="d-flex align-items-center gap-3 notranslate">

                <img
                    src="https://upload.wikimedia.org/wikipedia/commons/5/5f/Emblem_of_Sri_Lanka.svg"
                    class="emblem-img"
                    alt="Sri Lanka Emblem"
                >

                <div class="department-text">

                    <h1 class="title-si">
                        කෘෂිකර්ම දෙපාර්තමේන්තුව
                    </h1>

                    <h2 class="title-en">
                        DEPARTMENT OF AGRICULTURE
                    </h2>

                    <h3 class="title-ta">
                        விவசாயத் திணைக்களம்
                    </h3>

                </div>

            </div>


            <nav class="header-nav d-none d-lg-flex gap-4">

                <a href="{{ route('home') }}"
                   class="nav-link-custom"
                   data-i18n="nav_home">
                    Home
                </a>

                <a href="{{ route('public.locations') }}"
   class="nav-link-custom"
   data-i18n="nav_locations">
    Locations
</a>

                <a href="{{ route('public.about') }}"
                   class="nav-link-custom active"
                   data-i18n="nav_about">
                    About Us
                </a>

                <a href="{{ route('public.contact') }}"
                   class="nav-link-custom"
                   data-i18n="nav_contact">
                    Contact
                </a>

            </nav>


            <div class="header-actions">

                <div class="dropdown">

                    <button
                        class="language-btn dropdown-toggle"
                        data-bs-toggle="dropdown">
                        🌐
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow">

                        <li>
                            <button class="dropdown-item"
                                    onclick="changeLanguage('en')">
                                English
                            </button>
                        </li>

                        <li>
                            <button class="dropdown-item"
                                    onclick="changeLanguage('si')">
                                සිංහල
                            </button>
                        </li>

                        <li>
                            <button class="dropdown-item"
                                    onclick="changeLanguage('ta')">
                                தமிழ்
                            </button>
                        </li>

                    </ul>

                </div>

                <a href="{{ route('login') }}"
                   class="login-btn"
                   data-i18n="login">
                    Login
                </a>

            </div>

        </div>

    </div>

</header>


<section class="py-5">

    <div class="container">

        <div class="text-center mb-5">

            <img
                src="{{ asset('images/hela-bojun-logo.png') }}"
                class="main-logo mb-3"
                alt="Hela Bojun"
                style="max-width:180px;"
            >

            <h1 class="fw-bold" data-i18n="title">
                About Hela Bojun
            </h1>

            <p class="text-muted" data-i18n="subtitle">
                Promoting Sri Lankan traditional food and local agriculture
            </p>

        </div>


        <div class="row g-4">

            <div class="col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100 p-4">

                    <h3 class="fw-bold mb-3">
                        🌾 Hela Bojun
                    </h3>

                    <p class="text-muted">

                        Hela Bojun is an initiative supported by the
                        Department of Agriculture to promote authentic
                        Sri Lankan traditional food while supporting
                        local producers and entrepreneurs.

                    </p>

                </div>

            </div>


            <div class="col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100 p-4">

                    <h3 class="fw-bold mb-3">
                        🍛 Our Purpose
                    </h3>

                    <p class="text-muted">

                        The initiative provides customers with access
                        to nutritious, affordable and traditional
                        Sri Lankan food while creating opportunities
                        for local communities.

                    </p>

                </div>

            </div>


            <div class="col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100 p-4">

                    <h3 class="fw-bold mb-3">
                        🌱 Supporting Agriculture
                    </h3>

                    <p class="text-muted">

                        Hela Bojun encourages the use of locally grown
                        agricultural products and helps strengthen
                        the connection between agriculture, food and
                        local communities.

                    </p>

                </div>

            </div>


            <div class="col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100 p-4">

                    <h3 class="fw-bold mb-3">
                        🇱🇰 Our Vision
                    </h3>

                    <p class="text-muted">

                        To preserve Sri Lankan food traditions and
                        provide a modern, transparent and efficient
                        food service experience.

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<footer class="site-footer">
    © Department of Agriculture - Hela Bojun Digital Food Management System
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>