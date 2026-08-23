<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Hela Bojun - Locations</title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <link
        rel="stylesheet"
        href="{{ asset('css/styles.css') }}">


    <style>

        .locations-section {

            padding: 70px 0;

            background: #f8faf8;

            min-height: calc(100vh - 150px);

        }


        .location-card {

            background: white;

            border-radius: 20px;

            padding: 30px;

            box-shadow:
                0 8px 25px rgba(0,0,0,.08);

            height: 100%;

        }


        .location-icon {

            width: 60px;

            height: 60px;

            border-radius: 50%;

            background: #e8f5e9;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 28px;

            margin-bottom: 20px;

        }


        .map-container {

            width: 100%;

            height: 500px;

            border-radius: 20px;

            overflow: hidden;

            box-shadow:
                0 8px 25px rgba(0,0,0,.10);

        }


        .map-container iframe {

            width: 100%;

            height: 100%;

            border: 0;

        }


        .location-title {

            color: #198754;

        }

    </style>

</head>


<body>


<!-- HEADER -->

<header class="top-header">

    <div class="container-fluid px-4">

        <div class="d-flex align-items-center justify-content-between header-wrapper">


            <!-- LEFT -->

            <div class="d-flex align-items-center gap-3 notranslate">

                <img
                    src="https://upload.wikimedia.org/wikipedia/commons/5/5f/Emblem_of_Sri_Lanka.svg"
                    class="emblem-img"
                    alt="Sri Lanka Emblem">


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


            <!-- NAVIGATION -->

            <div class="d-none d-lg-block">

                <nav class="header-nav d-flex gap-4">

                    <a
                        href="{{ route('home') }}"
                        class="nav-link-custom"
                        data-i18n="nav_home">
                        Home
                    </a>


                    <a
                        href="{{ route('public.locations') }}"
                        class="nav-link-custom active"
                        data-i18n="nav_locations">
                        Locations
                    </a>


                    <a
                        href="{{ route('public.about') }}"
                        class="nav-link-custom"
                        data-i18n="nav_about">
                        About Us
                    </a>


                    <a
                        href="{{ route('public.contact') }}"
                        class="nav-link-custom"
                        data-i18n="nav_contact">
                        Contact
                    </a>

                </nav>

            </div>


            <!-- RIGHT -->

            <div class="header-actions">


                <div class="dropdown">

                    <button
                        class="language-btn dropdown-toggle"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        🌐

                    </button>


                    <ul class="dropdown-menu dropdown-menu-end shadow">

                        <li>

                            <button
                                class="dropdown-item"
                                onclick="changeLanguage('en')">

                                English

                            </button>

                        </li>


                        <li>

                            <button
                                class="dropdown-item"
                                onclick="changeLanguage('si')">

                                සිංහල

                            </button>

                        </li>


                        <li>

                            <button
                                class="dropdown-item"
                                onclick="changeLanguage('ta')">

                                தமிழ்

                            </button>

                        </li>

                    </ul>

                </div>


                <a
                    href="{{ route('login') }}"
                    class="login-btn"
                    data-i18n="login">

                    Login

                </a>

            </div>

        </div>

    </div>

</header>



<!-- LOCATIONS -->

<section class="locations-section">

    <div class="container">


        <!-- TITLE -->

        <div class="text-center mb-5">

            <h1
                class="fw-bold"
                data-i18n="title">

                Hela Bojun Locations

            </h1>


            <p
                class="text-muted"
                data-i18n="subtitle">

                Find Hela Bojun locations across Sri Lanka

            </p>

        </div>



        <div class="row g-4">


            <!-- LOCATION INFORMATION -->

            <div class="col-lg-4">

                <div class="location-card">


                    <div class="location-icon">

                        📍

                    </div>


                    <h3
                        class="fw-bold location-title"
                        data-i18n="location_title">

                        Hela Bojun Locations

                    </h3>


                    <p
                        class="text-muted"
                        data-i18n="location_text">

                        Hela Bojun food outlets are located
                        in different areas of Sri Lanka.
                        Use the map to find locations.

                    </p>


                    <hr>


                    <h5 class="fw-bold">

                        🇱🇰 Sri Lanka

                    </h5>


                    <p class="text-muted mb-0">

                        Hela Bojun Food Service

                        <br>

                        Department of Agriculture

                    </p>


                </div>

            </div>



            <!-- GOOGLE MAP -->

            <div class="col-lg-8">

                <div class="map-container">

                    <iframe
                        src="https://www.google.com/maps?q=Hela%20Bojun%20Sri%20Lanka&output=embed"
                        loading="lazy"
                        allowfullscreen>
                    </iframe>

                </div>

            </div>

        </div>

    </div>

</section>



<!-- FOOTER -->

<footer
    class="site-footer"
    data-i18n="footer">

    © Department of Agriculture - Hela Bojun Digital Food Management System

</footer>



<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>



<script>

const translations = {


    en: {

        nav_home: "Home",

        nav_locations: "Locations",

        nav_about: "About Us",

        nav_contact: "Contact",

        login: "Login",

        title: "Hela Bojun Locations",

        subtitle:
            "Find Hela Bojun locations across Sri Lanka",

        location_title:
            "Hela Bojun Locations",

        location_text:
            "Hela Bojun food outlets are located in different areas of Sri Lanka. Use the map to find locations.",

        footer:
            "© Department of Agriculture - Hela Bojun Digital Food Management System"

    },


    si: {

        nav_home: "මුල් පිටුව",

        nav_locations: "ස්ථාන",

        nav_about: "අප ගැන",

        nav_contact: "සම්බන්ධ කරගන්න",

        login: "ඇතුළු වන්න",

        title:
            "හෙළ බොජුන් ස්ථාන",

        subtitle:
            "ශ්‍රී ලංකාව පුරා ඇති හෙළ බොජුන් ස්ථාන සොයාගන්න",

        location_title:
            "හෙළ බොජුන් ස්ථාන",

        location_text:
            "ශ්‍රී ලංකාවේ විවිධ ප්‍රදේශවල පිහිටි හෙළ බොජුන් ස්ථාන සිතියම මගින් සොයාගන්න.",

        footer:
            "© කෘෂිකර්ම දෙපාර්තමේන්තුව - හෙළ බොජුන් ඩිජිටල් කළමනාකරණ පද්ධතිය"

    },


    ta: {

        nav_home: "முகப்பு",

        nav_locations: "இடங்கள்",

        nav_about: "எங்களைப் பற்றி",

        nav_contact: "தொடர்புகொள்ள",

        login: "உள்நுழைய",

        title:
            "ஹெல பொஜுன் இடங்கள்",

        subtitle:
            "இலங்கை முழுவதும் உள்ள ஹெல பொஜுன் இடங்களை கண்டறியவும்",

        location_title:
            "ஹெல பொஜுன் இடங்கள்",

        location_text:
            "இலங்கையின் பல்வேறு பகுதிகளில் அமைந்துள்ள ஹெல பொஜுன் இடங்களை வரைபடத்தின் மூலம் கண்டறியவும்.",

        footer:
            "© விவசாயத் திணைக்களம் - ஹெல பொஜுன் டிஜிட்டல் மேலாண்மை அமைப்பு"

    }

};



function changeLanguage(lang) {

    localStorage.setItem(
        'selectedLang',
        lang
    );


    document
        .querySelectorAll('[data-i18n]')
        .forEach(function(element) {

            const key =
                element.getAttribute('data-i18n');


            if (
                translations[lang] &&
                translations[lang][key]
            ) {

                element.innerText =
                    translations[lang][key];

            }

        });

}



document.addEventListener(
    "DOMContentLoaded",
    function() {

        const savedLang =
            localStorage.getItem('selectedLang') || 'en';

        changeLanguage(savedLang);

    }
);

</script>


</body>

</html>