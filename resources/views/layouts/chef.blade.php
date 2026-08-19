<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title','Chef Dashboard') | Hela Bojun</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

@vite(['resources/css/app.css'])

<style>
body{
    margin:0;
    background:#f4f6f8;
    font-family:Arial,sans-serif;
    color:#1f2937
}

.chef-nav{
    position:sticky;
    top:0;
    z-index:1000;
    background:#fff;
    border-bottom:1px solid #e5e7eb;
    padding:12px 22px
}

.brand{
    display:flex;
    gap:12px;
    align-items:center
}

.profile-link{
    text-decoration:none;
    display:block
}

.avatar{
    width:48px;
    height:48px;
    border-radius:50%;
    object-fit:cover;
    background:#e8f5ee;
    display:grid;
    place-items:center;
    transition:.2s
}

.profile-link:hover .avatar{
    transform:scale(1.05);
    box-shadow:0 0 0 3px #d9f0e3
}

.lang-wrap{
    position:relative
}

.lang-trigger{
    width:44px;
    height:44px;
    border:1px solid #ddd;
    border-radius:50%;
    background:#fff;
    font-size:20px
}

.lang-menu{
    display:none;
    position:absolute;
    right:0;
    top:50px;
    width:180px;
    background:#fff;
    border:1px solid #ddd;
    border-radius:12px;
    box-shadow:0 10px 30px #0002;
    overflow:hidden
}

.lang-menu.show{
    display:block
}

.lang-menu button{
    display:block;
    width:100%;
    border:0;
    background:#fff;
    text-align:left;
    padding:12px 14px
}

.lang-menu button:hover{
    background:#f5f7f8
}

.main{
    max-width:1250px;
    margin:auto;
    padding:22px 14px
}

.cardx{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:18px;
    padding:20px
}

.food-card{
    height:100%
}

.qty-btn{
    width:48px;
    height:48px;
    border:0;
    border-radius:12px;
    background:#eef2f0;
    font-size:26px;
    font-weight:700
}

.qty-num{
    min-width:65px;
    text-align:center;
    font-size:28px;
    font-weight:800
}

.status{
    font-weight:700
}

.order-card{
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:16px;
    background:#fff
}

.token{
    font-size:25px;
    font-weight:900
}

.toastx{
    position:fixed;
    right:20px;
    bottom:20px;
    background:#111;
    color:#fff;
    padding:12px 16px;
    border-radius:10px;
    display:none;
    z-index:2000
}
</style>
</head>

<body>

<header class="chef-nav">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <div class="brand">

            <a href="{{ route('profile.edit') }}" class="profile-link">
                <div class="avatar">

                    @if(auth()->user()->profile_image)

                        <img
                            class="avatar"
                            src="{{ asset('storage/'.auth()->user()->profile_image) }}"
                            alt="profile"
                        >

                    @else

                        👨‍🍳

                    @endif

                </div>
            </a>

            <div>
                <div class="fw-bold fs-5">
                    Hela Bojun —
                    <span data-i18n="chef_dashboard">
                        Chef Dashboard
                    </span>
                </div>

                <div class="small text-muted">
                    {{ auth()->user()->name }}
                    ·
                    <span data-i18n="counter">
                        Counter
                    </span>

                    {{ auth()->user()->counter?->counter_number ?? '—' }}
                </div>
            </div>

        </div>


        <div class="d-flex align-items-center gap-2">

            <div class="lang-wrap">

                <button
                    class="lang-trigger"
                    id="langTrigger"
                    type="button"
                    aria-label="Language"
                >
                    🌐
                </button>

                <div class="lang-menu" id="langMenu">

                    <button
                        type="button"
                        data-lang="si"
                    >
                        🇱🇰 සිංහල
                    </button>

                    <button
                        type="button"
                        data-lang="ta"
                    >
                        🇮🇳 தமிழ்
                    </button>

                    <button
                        type="button"
                        data-lang="en"
                    >
                        🇬🇧 English
                    </button>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-danger"
                    title="Logout"
                >
                    <i class="fa fa-right-from-bracket"></i>
                </button>

            </form>

        </div>

    </div>
</header>


<main class="main">
    @yield('content')
</main>


<div id="chefToast" class="toastx"></div>


<script>

const T = {

    si: {
        chef_dashboard:'චෙෆ් ඩෑෂ්බෝඩ්',
        counter:'කවුන්ටරය',
        welcome:'ආයුබෝවන්, චෙෆ් 👨‍🍳',
        welcome_description:'ඔබගේ කවුන්ටරයේ ආහාර සහ ඇණවුම් කළමනාකරණය කරන්න.',
        orders:'ඇණවුම්',
        pending:'පොරොත්තු',
        accepted:'භාරගත්තා',
        preparing:'සූදානම් කරමින්',
        ready:'සූදානම්',
        completed:'සම්පූර්ණයි',
        accept:'භාරගන්න',
        start_preparing:'සූදානම් කිරීම අරඹන්න',
        mark_ready:'සූදානම්',
        served:'සම්පූර්ණ කරන්න',
        my_foods:'මගේ ආහාර',
        available:'ලබා ගත හැක',
        not_available:'ලබා ගත නොහැක',
        no_orders:'ඇණවුම් නැත',
        no_foods:'ආහාර නැත',
        quantity_updated:'ප්‍රමාණය යාවත්කාලීන විය',
        error:'දෝෂයක් සිදු විය'
    },

    ta: {
        chef_dashboard:'செஃப் டாஷ்போர்டு',
        counter:'கவுண்டர்',
        welcome:'வணக்கம், செஃப் 👨‍🍳',
        welcome_description:'உங்கள் கவுண்டரில் உணவு மற்றும் ஆர்டர்களை நிர்வகிக்கவும்.',
        orders:'ஆர்டர்கள்',
        pending:'நிலுவை',
        accepted:'ஏற்றுக்கொள்ளப்பட்டது',
        preparing:'தயாராகிறது',
        ready:'தயார்',
        completed:'முடிந்தது',
        accept:'ஏற்கவும்',
        start_preparing:'தயாரிப்பை தொடங்கவும்',
        mark_ready:'தயார்',
        served:'முடிக்கவும்',
        my_foods:'என் உணவுகள்',
        available:'கிடைக்கும்',
        not_available:'கிடைக்காது',
        no_orders:'ஆர்டர்கள் இல்லை',
        no_foods:'உணவுகள் இல்லை',
        quantity_updated:'அளவு புதுப்பிக்கப்பட்டது',
        error:'பிழை'
    },

    en: {
        chef_dashboard:'Chef Dashboard',
        counter:'Counter',
        welcome:'Welcome, Chef 👨‍🍳',
        welcome_description:'Manage food and orders for your counter.',
        orders:'Orders',
        pending:'Pending',
        accepted:'Accepted',
        preparing:'Preparing',
        ready:'Ready',
        completed:'Completed',
        accept:'Accept',
        start_preparing:'Start Preparing',
        mark_ready:'Ready',
        served:'Complete',
        my_foods:'My Foods',
        available:'Available',
        not_available:'Not Available',
        no_orders:'No Orders',
        no_foods:'No Foods Assigned',
        quantity_updated:'Quantity updated',
        error:'Something went wrong'
    }

};


let chefLang = localStorage.getItem('chef_language') || 'en';


function tr(key)
{
    return T[chefLang]?.[key] ?? T.en[key] ?? key;
}


function applyLang()
{
    document
        .querySelectorAll('[data-i18n]')
        .forEach(element => {

            element.textContent = tr(
                element.dataset.i18n
            );

        });


    document
        .querySelectorAll('[data-lang]')
        .forEach(button => {

            button.classList.toggle(
                'fw-bold',
                button.dataset.lang === chefLang
            );

        });
}


function toast(message)
{
    const element =
        document.getElementById('chefToast');

    element.textContent = message;
    element.style.display = 'block';

    setTimeout(() => {
        element.style.display = 'none';
    }, 2200);
}


document
    .getElementById('langTrigger')
    .onclick = () => {

        document
            .getElementById('langMenu')
            .classList.toggle('show');

    };


document
    .querySelectorAll('[data-lang]')
    .forEach(button => {

        button.onclick = () => {

            chefLang = button.dataset.lang;

            localStorage.setItem(
                'chef_language',
                chefLang
            );

            applyLang();

            document
                .getElementById('langMenu')
                .classList.remove('show');

        };

    });


document.addEventListener('click', event => {

    if (!event.target.closest('.lang-wrap')) {

        document
            .getElementById('langMenu')
            .classList.remove('show');

    }

});


applyLang();

</script>

@stack('scripts')

</body>
</html>