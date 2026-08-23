<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Us - Hela Bojun</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <style>
        .contact-section {
            padding: 70px 0;
            background: #f8faf8;
        }

        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            height: 100%;
            box-shadow: 0 8px 25px rgba(0,0,0,.08);
        }

        .contact-icon {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: #e8f5e9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            margin-bottom: 15px;
        }

        .map-box {
            border-radius: 20px;
            overflow: hidden;
            height: 400px;
            box-shadow: 0 8px 25px rgba(0,0,0,.08);
        }

        .map-box iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
</head>

<body>

<header class="top-header">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between header-wrapper">

            <div class="d-flex align-items-center gap-3 notranslate">
                <img
                    src="https://upload.wikimedia.org/wikipedia/commons/5/5f/Emblem_of_Sri_Lanka.svg"
                    class="emblem-img"
                    alt="Sri Lanka Emblem">

                <div class="department-text">
                    <h1 class="title-si">කෘෂිකර්ම දෙපාර්තමේන්තුව</h1>
                    <h2 class="title-en">DEPARTMENT OF AGRICULTURE</h2>
                    <h3 class="title-ta">விவசாயத் திணைக்களம்</h3>
                </div>
            </div>

            <div class="d-none d-lg-block">
                <nav class="header-nav d-flex gap-4">
                    <a href="{{ route('home') }}" class="nav-link-custom">Home</a>
                    <a href="{{ route('public.locations') }}" class="nav-link-custom"> Locations</a>
                    <a href="{{ route('public.about') }}" class="nav-link-custom">About Us</a>
                    <a href="{{ route('public.contact') }}" class="nav-link-custom active">Contact</a>
                </nav>
            </div>

            <div class="header-actions">

                <div class="dropdown">
                    <button
                        class="language-btn dropdown-toggle"
                        data-bs-toggle="dropdown">
                        🌐
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <button class="dropdown-item" onclick="changeLanguage('en')">
                                English
                            </button>
                        </li>

                        <li>
                            <button class="dropdown-item" onclick="changeLanguage('si')">
                                සිංහල
                            </button>
                        </li>

                        <li>
                            <button class="dropdown-item" onclick="changeLanguage('ta')">
                                தமிழ்
                            </button>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('login') }}" class="login-btn">
                    Login
                </a>

            </div>

        </div>
    </div>
</header>


<section class="contact-section">

    <div class="container">

        <div class="text-center mb-5">

            <h1 class="fw-bold" data-i18n="contact_title">
                Contact Hela Bojun
            </h1>

            <p class="text-muted" data-i18n="contact_subtitle">
                Get in touch with the Hela Bojun and Agro Technology Park, Gannoruwa.
            </p>

        </div>


        <div class="row g-4 mb-5">

            <div class="col-md-4">

                <div class="contact-card">

                    <div class="contact-icon">
                        📍
                    </div>

                    <h5 class="fw-bold">
                        Location
                    </h5>

                    <p class="text-muted mb-0">
                        Gannoruwa,<br>
                        Peradeniya,<br>
                        Kandy, Sri Lanka
                    </p>

                </div>

            </div>


            <div class="col-md-4">

                <div class="contact-card">

                    <div class="contact-icon">
                        📞
                    </div>

                    <h5 class="fw-bold">
                        Telephone
                    </h5>

                    <p class="text-muted mb-0">
                        +94 81 238 8618
                    </p>

                </div>

            </div>


            <div class="col-md-4">

                <div class="contact-card">

                    <div class="contact-icon">
                        ✉️
                    </div>

                    <h5 class="fw-bold">
                        Email
                    </h5>

                    <p class="text-muted mb-0">
                        apark.gan@doa.gov.lk
                    </p>

                </div>

            </div>

        </div>


        <div class="row g-4 align-items-stretch">

            <div class="col-lg-7">

                <div class="map-box">

                    <iframe
                        src="https://www.google.com/maps?q=Agro%20Technology%20Park%20Gannoruwa%20Sri%20Lanka&output=embed"
                        loading="lazy">
                    </iframe>

                </div>

            </div>


            <div class="col-lg-5">

                <div class="contact-card">

                    <h3 class="fw-bold mb-3">
                        Hela Bojun Gannoruwa
                    </h3>

                    <p class="text-muted">
                        Hela Bojun is located within the Agro Technology Park,
                        Gannoruwa, which is maintained by the Department of Agriculture.
                    </p>

                    <hr>

                    <h6 class="fw-bold">
                        Agro Technology Park Unit
                    </h6>

                    <p class="text-muted">
                        Gannoruwa, Peradeniya, Sri Lanka
                    </p>

                    <p class="mb-2">
                        📞
                        <a href="tel:+94812388618">
                            +94 81 238 8618
                        </a>
                    </p>

                    <p class="mb-3">
                        ✉️
                        <a href="mailto:apark.gan@doa.gov.lk">
                            apark.gan@doa.gov.lk
                        </a>
                    </p>

                    <a
                        href="https://www.google.com/maps/search/?api=1&query=Agro+Technology+Park+Gannoruwa+Sri+Lanka"
                        target="_blank"
                        class="btn btn-success">
                        📍 Get Directions
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


<footer class="site-footer">
    © Department of Agriculture - Hela Bojun Digital Food Management System
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const translations = {

    en: {
        contact_title: "Contact Hela Bojun",
        contact_subtitle: "Get in touch with the Hela Bojun and Agro Technology Park, Gannoruwa."
    },

    si: {
        contact_title: "හෙළ බොජුන් හා සම්බන්ධ වන්න",
        contact_subtitle: "ගන්නෝරුව කෘෂි තාක්ෂණ උද්‍යානය සහ හෙළ බොජුන් සමඟ සම්බන්ධ වන්න."
    },

    ta: {
        contact_title: "ஹெல பொஜுனை தொடர்புகொள்ளுங்கள்",
        contact_subtitle: "கன்னொருவ விவசாய தொழில்நுட்ப பூங்கா மற்றும் ஹெல பொஜுனை தொடர்புகொள்ளுங்கள்."
    }
};


function changeLanguage(lang) {

    localStorage.setItem('selectedLang', lang);

    document.querySelectorAll('[data-i18n]').forEach(el => {

        const key = el.getAttribute('data-i18n');

        if (translations[lang]?.[key]) {
            el.innerText = translations[lang][key];
        }

    });
}


document.addEventListener("DOMContentLoaded", () => {

    const savedLang =
        localStorage.getItem('selectedLang') || 'en';

    changeLanguage(savedLang);

});
</script>

</body>
</html>