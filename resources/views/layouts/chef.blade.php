<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        <span data-i18n="chef_dashboard">Chef Dashboard</span>
    </title>

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Font Awesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    @vite([
        'resources/css/app.css'
    ])

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f7fb;
            color: #222;
            font-family: Arial, sans-serif;
        }

        /* =====================================================
           NAVBAR
        ===================================================== */

        .chef-navbar {

            min-height: 76px;

            background: #ffffff;

            border-bottom: 1px solid #e5e7eb;

            padding: 12px 25px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            position: sticky;

            top: 0;

            z-index: 1000;
        }

        .chef-brand {

            display: flex;

            align-items: center;

            gap: 13px;
        }

        .chef-logo {

            width: 52px;
            height: 52px;

            background: #fff0e6;

            border-radius: 14px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 27px;
        }

        .chef-brand-title {

            margin: 0;

            font-size: 21px;

            font-weight: 800;
        }

        .chef-brand-subtitle {

            color: #777;

            font-size: 14px;

            margin-top: 3px;
        }


        /* =====================================================
           LANGUAGE BUTTONS
        ===================================================== */

        .chef-language-box {

            display: flex;

            align-items: center;

            gap: 7px;
        }

        .chef-language-btn {

            border: 1px solid #ddd;

            background: #fff;

            border-radius: 10px;

            min-width: 45px;

            height: 42px;

            padding: 6px 9px;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 5px;

            cursor: pointer;

            font-size: 14px;

            transition: .2s;
        }

        .chef-language-btn:hover {

            background: #f5f5f5;
        }

        .chef-language-btn.active {

            background: #222;

            color: #fff;

            border-color: #222;
        }

        .chef-language-icon {

            font-size: 19px;
        }


        /* =====================================================
           MAIN
        ===================================================== */

        .chef-main {

            padding: 25px 15px;

            min-height:
                calc(100vh - 76px);
        }

        .chef-container {

            max-width: 1250px;

            margin: auto;
        }


        /* =====================================================
           WELCOME
        ===================================================== */

        .chef-welcome {

            background: #fff;

            border: 1px solid #e5e7eb;

            border-radius: 18px;

            padding: 22px;

            margin-bottom: 25px;
        }

        .chef-welcome h2 {

            margin: 0;

            font-size: 24px;

            font-weight: 800;
        }

        .chef-welcome p {

            margin: 7px 0 0;

            color: #777;

            font-size: 15px;
        }


        /* =====================================================
           SECTION
        ===================================================== */

        .chef-section-title {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin: 25px 0 15px;
        }

        .chef-section-title h2 {

            margin: 0;

            font-size: 22px;

            font-weight: 800;
        }


        /* =====================================================
           ORDER GRID
        ===================================================== */

        .chef-order-grid {

            display: grid;

            grid-template-columns:
                repeat(
                    auto-fit,
                    minmax(310px, 1fr)
                );

            gap: 18px;
        }

        .chef-order-card {

            background: #fff;

            border: 2px solid #e5e7eb;

            border-radius: 18px;

            padding: 20px;

            box-shadow:
                0 4px 15px rgba(0,0,0,.04);
        }


        /* =====================================================
           TOKEN
        ===================================================== */

        .chef-token-row {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;

            margin-bottom: 14px;
        }

        .chef-token {

            font-size: 29px;

            font-weight: 900;
        }

        .chef-counter {

            background: #f1f3f5;

            padding: 8px 12px;

            border-radius: 9px;

            font-weight: 700;

            white-space: nowrap;
        }


        /* =====================================================
           STATUS
        ===================================================== */

        .chef-status {

            display: inline-block;

            padding: 8px 12px;

            border-radius: 9px;

            font-weight: 700;

            margin-bottom: 15px;
        }

        .status-pending {

            background: #fff3cd;

            color: #856404;
        }

        .status-preparing {

            background: #cfe2ff;

            color: #084298;
        }

        .status-ready {

            background: #d1e7dd;

            color: #0f5132;
        }


        /* =====================================================
           FOOD LIST
        ===================================================== */

        .chef-food-list {

            list-style: none;

            padding: 0;

            margin: 0 0 18px;
        }

        .chef-food-list li {

            display: flex;

            justify-content: space-between;

            gap: 10px;

            padding: 10px 0;

            border-bottom: 1px solid #eee;

            font-size: 16px;
        }


        /* =====================================================
           ACTION BUTTON
        ===================================================== */

        .chef-action-btn {

            width: 100%;

            min-height: 55px;

            border: 0;

            border-radius: 12px;

            font-size: 17px;

            font-weight: 800;

            cursor: pointer;
        }

        .chef-action-btn:disabled {

            opacity: .6;

            cursor: not-allowed;
        }

        .btn-start {

            background: #f1f3f5;

            color: #222;
        }

        .btn-ready {

            background: #198754;

            color: white;
        }

        .btn-served {

            background: #222;

            color: white;
        }


        /* =====================================================
           FOOD GRID
        ===================================================== */

        .chef-food-grid {

            display: grid;

            grid-template-columns:
                repeat(
                    auto-fit,
                    minmax(240px, 1fr)
                );

            gap: 16px;
        }

        .chef-food-card {

            background: #fff;

            border: 1px solid #e5e7eb;

            border-radius: 17px;

            padding: 18px;
        }

        .chef-food-name {

            font-size: 19px;

            font-weight: 800;
        }

        .chef-food-category {

            color: #777;

            font-size: 14px;

            margin: 5px 0 17px;
        }


        /* =====================================================
           QUANTITY
        ===================================================== */

        .chef-quantity {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;
        }

        .chef-quantity button {

            width: 52px;

            height: 52px;

            border: 0;

            border-radius: 12px;

            background: #eeeeee;

            font-size: 29px;

            font-weight: 800;

            cursor: pointer;

            transition: .15s;
        }

        .chef-quantity button:active {

            transform: scale(.94);
        }

        .chef-quantity-value {

            min-width: 65px;

            text-align: center;

            font-size: 30px;

            font-weight: 900;
        }


        /* =====================================================
           FOOD STATUS
        ===================================================== */

        .chef-food-status {

            text-align: center;

            margin-top: 12px;

            font-weight: 800;

            font-size: 15px;
        }

        .available {

            color: #198754;
        }

        .not-available {

            color: #dc3545;
        }


        /* =====================================================
           EMPTY
        ===================================================== */

        .chef-empty {

            background: #fff;

            border: 1px solid #e5e7eb;

            border-radius: 17px;

            padding: 35px;

            text-align: center;

            color: #777;

            width: 100%;
        }

        .chef-empty-icon {

            font-size: 48px;

            margin-bottom: 10px;
        }

        .chef-empty h3 {

            color: #333;

            font-size: 21px;

            font-weight: 800;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .chef-footer {

            text-align: center;

            padding: 22px;

            color: #777;

            font-size: 13px;
        }


        /* =====================================================
           TOAST
        ===================================================== */

        .chef-toast {

            position: fixed;

            right: 20px;

            bottom: 20px;

            background: #222;

            color: #fff;

            padding: 14px 18px;

            border-radius: 11px;

            display: none;

            z-index: 9999;

            box-shadow:
                0 5px 20px rgba(0,0,0,.2);
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media(max-width: 700px) {

            .chef-navbar {

                flex-direction: column;

                align-items: flex-start;

                padding: 14px;
            }

            .chef-language-box {

                width: 100%;
            }

            .chef-language-btn {

                flex: 1;
            }

            .chef-main {

                padding: 15px 10px;
            }

            .chef-order-grid {

                grid-template-columns: 1fr;
            }

            .chef-food-grid {

                grid-template-columns: 1fr;
            }

            .chef-token {

                font-size: 25px;
            }

        }

    </style>

    @stack('styles')

</head>


<body>


{{-- =========================================================
   NAVBAR
========================================================= --}}

<header class="chef-navbar">


    <div class="chef-brand">

        <div class="chef-logo">

            👨‍🍳

        </div>


        <div>

            <h4 class="chef-brand-title">

                <span data-i18n="chef_dashboard">
                    Chef Dashboard
                </span>

            </h4>


            @auth

                <div class="chef-brand-subtitle">

                    {{ auth()->user()->name }}

                    @if(auth()->user()->counter)

                        <span> • </span>

                        <span data-i18n="counter">
                            Counter
                        </span>

                        {{ auth()->user()->counter->counter_number }}

                    @endif

                </div>

            @endauth

        </div>

    </div>



    {{-- =====================================================
       LANGUAGE
    ====================================================== --}}

    <div class="chef-language-box">


        <button
            type="button"
            class="chef-language-btn"
            data-language="si"
            onclick="setChefLanguage('si')"
        >

            <span class="chef-language-icon">
                🇱🇰
            </span>

            <span>
                සිං
            </span>

        </button>


        <button
            type="button"
            class="chef-language-btn"
            data-language="ta"
            onclick="setChefLanguage('ta')"
        >

            <span class="chef-language-icon">
                🇮🇳
            </span>

            <span>
                தமிழ்
            </span>

        </button>


        <button
            type="button"
            class="chef-language-btn"
            data-language="en"
            onclick="setChefLanguage('en')"
        >

            <span class="chef-language-icon">
                🇬🇧
            </span>

            <span>
                EN
            </span>

        </button>


    </div>

</header>



{{-- =========================================================
   MAIN
========================================================= --}}

<main class="chef-main">

    <div class="chef-container">

        @yield('content')

    </div>

</main>



{{-- =========================================================
   FOOTER
========================================================= --}}

<footer class="chef-footer">

    <span data-i18n="footer">
        Hela Bojun Smart Food Management System
    </span>

</footer>



{{-- TOAST --}}

<div
    id="chefToast"
    class="chef-toast"
></div>



{{-- =========================================================
   BOOTSTRAP
========================================================= --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>



{{-- =========================================================
   TRANSLATION ENGINE
========================================================= --}}

<script>

const CHEF_TRANSLATIONS = {

    en: {

        chef_dashboard:
            "Chef Dashboard",

        counter:
            "Counter",

        welcome:
            "Welcome, Chef 👨‍🍳",

        welcome_description:
            "Manage food quantities and prepare orders easily.",

        orders:
            "Orders",

        pending:
            "Pending",

        preparing:
            "Preparing",

        ready:
            "Ready",

        served:
            "Served",

        start_preparing:
            "Start Preparing",

        mark_ready:
            "Ready",

        my_foods:
            "My Foods",

        available:
            "Available",

        not_available:
            "Not Available",

        no_orders:
            "No Orders",

        no_orders_description:
            "New orders will appear here automatically.",

        no_foods:
            "No Foods Assigned",

        no_foods_description:
            "There are no foods assigned to your counter.",

        no_counter:
            "No Counter Assigned",

        no_counter_description:
            "Please contact the administrator.",

        quantity_updated:
            "Quantity updated successfully.",

        order_updated:
            "Order status updated.",

        error:
            "Something went wrong.",

        footer:
            "Hela Bojun Smart Food Management System"

    },


    si: {

        chef_dashboard:
            "චෙෆ් ඩෑෂ්බෝඩ්",

        counter:
            "කවුන්ටරය",

        welcome:
            "ආයුබෝවන්, චෙෆ් 👨‍🍳",

        welcome_description:
            "ආහාර ප්‍රමාණය වෙනස් කර ඇණවුම් පහසුවෙන් සකස් කරන්න.",

        orders:
            "ඇණවුම්",

        pending:
            "නව ඇණවුම",

        preparing:
            "සකස් කරමින්",

        ready:
            "සූදානම්",

        served:
            "භාර දුන්නා",

        start_preparing:
            "සකස් කිරීම ආරම්භ කරන්න",

        mark_ready:
            "සූදානම්",

        my_foods:
            "මගේ ආහාර",

        available:
            "තිබේ",

        not_available:
            "නොමැත",

        no_orders:
            "ඇණවුම් නොමැත",

        no_orders_description:
            "නව ඇණවුම් මෙහි ස්වයංක්‍රීයව පෙන්වනු ඇත.",

        no_foods:
            "ආහාර පවරා නොමැත",

        no_foods_description:
            "ඔබගේ කවුන්ටරයට ආහාර පවරා නොමැත.",

        no_counter:
            "කවුන්ටරයක් පවරා නොමැත",

        no_counter_description:
            "කරුණාකර පරිපාලකවරයා අමතන්න.",

        quantity_updated:
            "ප්‍රමාණය සාර්ථකව යාවත්කාලීන කරන ලදී.",

        order_updated:
            "ඇණවුමේ තත්ත්වය යාවත්කාලීන කරන ලදී.",

        error:
            "දෝෂයක් සිදුවිය.",

        footer:
            "හෙළ බොජුන් ස්මාර්ට් ආහාර කළමනාකරණ පද්ධතිය"

    },


    ta: {

        chef_dashboard:
            "சமையலாளர் டாஷ்போர்டு",

        counter:
            "கவுண்டர்",

        welcome:
            "வணக்கம், சமையலாளர் 👨‍🍳",

        welcome_description:
            "உணவின் அளவை மாற்றி ஆர்டர்களை எளிதாகத் தயாரிக்கவும்.",

        orders:
            "ஆர்டர்கள்",

        pending:
            "புதிய ஆர்டர்",

        preparing:
            "தயாராகிறது",

        ready:
            "தயார்",

        served:
            "வழங்கப்பட்டது",

        start_preparing:
            "தயாரிக்க தொடங்கு",

        mark_ready:
            "தயார்",

        my_foods:
            "எனது உணவுகள்",

        available:
            "கிடைக்கும்",

        not_available:
            "கிடைக்கவில்லை",

        no_orders:
            "ஆர்டர்கள் இல்லை",

        no_orders_description:
            "புதிய ஆர்டர்கள் இங்கே தானாக தோன்றும்.",

        no_foods:
            "உணவுகள் ஒதுக்கப்படவில்லை",

        no_foods_description:
            "உங்கள் கவுண்டருக்கு உணவுகள் ஒதுக்கப்படவில்லை.",

        no_counter:
            "கவுண்டர் ஒதுக்கப்படவில்லை",

        no_counter_description:
            "நிர்வாகியை தொடர்பு கொள்ளவும்.",

        quantity_updated:
            "அளவு வெற்றிகரமாக புதுப்பிக்கப்பட்டது.",

        order_updated:
            "ஆர்டர் நிலை வெற்றிகரமாக புதுப்பிக்கப்பட்டது.",

        error:
            "பிழை ஏற்பட்டது.",

        footer:
            "ஹெல பொஜுன் ஸ்மார்ட் உணவு மேலாண்மை அமைப்பு"

    }

};



/*
|--------------------------------------------------------------------------
| GET LANGUAGE
|--------------------------------------------------------------------------
*/

function getChefLanguage()
{
    return localStorage.getItem(
        'chef_language'
    ) || 'en';
}



/*
|--------------------------------------------------------------------------
| SET LANGUAGE
|--------------------------------------------------------------------------
*/

function setChefLanguage(language)
{

    if (!CHEF_TRANSLATIONS[language]) {

        language = 'en';

    }


    localStorage.setItem(
        'chef_language',
        language
    );


    applyChefLanguage(
        language
    );

}



/*
|--------------------------------------------------------------------------
| APPLY LANGUAGE TO ENTIRE PAGE
|--------------------------------------------------------------------------
*/

function applyChefLanguage(language)
{

    const translations =
        CHEF_TRANSLATIONS[language];


    document
        .documentElement
        .setAttribute(
            'lang',
            language
        );


    /*
    |--------------------------------------------------------------------------
    | Normal text
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '[data-i18n]'
        )
        .forEach(function(element) {

            const key =
                element.getAttribute(
                    'data-i18n'
                );


            if (
                translations[key] !== undefined
            ) {

                element.textContent =
                    translations[key];

            }

        });



    /*
    |--------------------------------------------------------------------------
    | Language button active
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.chef-language-btn'
        )
        .forEach(function(button) {

            button.classList.remove(
                'active'
            );


            if (
                button.dataset.language ===
                language
            ) {

                button.classList.add(
                    'active'
                );

            }

        });

}



/*
|--------------------------------------------------------------------------
| TOAST
|--------------------------------------------------------------------------
*/

function chefToast(message)
{

    const toast =
        document.getElementById(
            'chefToast'
        );


    toast.textContent =
        message;


    toast.style.display =
        'block';


    setTimeout(function() {

        toast.style.display =
            'none';

    }, 2500);

}



/*
|--------------------------------------------------------------------------
| DOM READY
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    function() {

        applyChefLanguage(
            getChefLanguage()
        );

    }
);

</script>



@vite([
    'resources/js/app.js',
  
])


@stack('scripts')

</body>

</html>