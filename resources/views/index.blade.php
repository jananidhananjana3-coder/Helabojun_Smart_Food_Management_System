<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department of Agriculture - Hela Bojun</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>

<header class="top-header">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between header-wrapper">

            <!-- Left: Emblem + Titles (NO TRANSLATE SECTION) -->
            <div class="d-flex align-items-center gap-3 notranslate">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5f/Emblem_of_Sri_Lanka.svg"
                     class="emblem-img"
                     alt="Sri Lanka Emblem">

                <div class="department-text">
                    <h1 class="title-si">කෘෂිකර්ම දෙපාර්තමේන්තුව</h1>
                    <h2 class="title-en">DEPARTMENT OF AGRICULTURE</h2>
                    <h3 class="title-ta">விவசாயத் திணைக்களம்</h3>
                </div>
            </div>

            <!-- Center Navigation (Translating) -->
            <div class="d-none d-lg-block">
                <nav class="header-nav d-flex gap-4">
                    <a href="#" class="nav-link-custom active" data-i18n="nav_home">Home</a>
                    <a href="#" class="nav-link-custom" data-i18n="nav_outlets">Outlets</a>
                    <a href="#" class="nav-link-custom" data-i18n="nav_about">About Us</a>
                    <a href="#" class="nav-link-custom" data-i18n="nav_contact">Contact</a>
                </nav>
            </div>

            <!-- Right: Actions -->
            <div class="header-actions">
                <div class="dropdown">
                    <button class="language-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        🌐
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><button class="dropdown-item" onclick="changeLanguage('en')">English</button></li>
                        <li><button class="dropdown-item" onclick="changeLanguage('si')">සිංහල</button></li>
                        <li><button class="dropdown-item" onclick="changeLanguage('ta')">தமிழ்</button></li>
                    </ul>
                </div>

                <a href="{{ route('login') }}" class="login-btn" data-i18n="login">
                    Login
                </a>
            </div>

        </div>
    </div>
</header>


<section class="hero-section">
    <div class="container text-center">

        <h2 class="welcome-text" data-i18n="welcome">
            Welcome to Hela Bojun
        </h2>

        <p class="sub-text" data-i18n="sub_title">
            Authentic Sri Lankan Traditional Food Experience
        </p>

        <img src="{{ asset('images/hela-bojun-logo.png') }}"
             class="main-logo"
             alt="Hela Bojun Logo">

    </div>
</section>


<footer class="site-footer" data-i18n="footer">
    © Department of Agriculture - Hela Bojun Digital Food Management System
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS Translation Script -->
<script>
    const translations = {
        en: {
            nav_home: "Home",
            nav_outlets: "Outlets",
            nav_about: "About Us",
            nav_contact: "Contact",
            login: "Login",
            welcome: "Welcome to Hela Bojun",
            sub_title: "Authentic Sri Lankan Traditional Food Experience",
            footer: "© Department of Agriculture - Hela Bojun Digital Food Management System"
        },
        si: {
            nav_home: "මුල් පිටුව",
            nav_outlets: "අලෙවිසැල්",
            nav_about: "අප ගැන",
            nav_contact: "සම්බන්ධ කරගන්න",
            login: "ඇතුළු වන්න",
            welcome: "හෙළ බොජුන් හල වෙත සාදරයෙන් පිළිගනිමු",
            sub_title: "දේශීය පාරම්පරික රසවත් ආහාර අත්දැකීම",
            footer: "© කෘෂිකර්ම දෙපාර්තමේන්තුව - හෙළ බොජුන් ඩිජිටල් කළමනාකරණ පද්ධතිය"
        },
        ta: {
            nav_home: "முகப்பு",
            nav_outlets: "விற்பனை நிலையங்கள்",
            nav_about: "எங்களைப் பற்றி",
            nav_contact: "தொடர்புகொள்ள",
            login: "உள்நுழைய",
            welcome: "ஹெல பொஜுன் பகுதிக்கு நல்வரவு",
            sub_title: "உண்மையான இலங்கை பாரம்பரிய உணவு அனுபவம்",
            footer: "© விவசாயத் திணைக்களம் - ஹெல பொஜுன் டிஜிட்டல் மேலாண்மை அமைப்பு"
        }
    };

    function changeLanguage(lang) {
        // Save preference in LocalStorage so it stays on page refresh
        localStorage.setItem('selectedLang', lang);

        const elements = document.querySelectorAll('[data-i18n]');
        elements.forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (translations[lang] && translations[lang][key]) {
                el.innerText = translations[lang][key];
            }
        });
    }

    // Auto load selected language on refresh
    document.addEventListener("DOMContentLoaded", () => {
        const savedLang = localStorage.getItem('selectedLang') || 'en';
        changeLanguage(savedLang);
    });
</script>

</body>
</html>