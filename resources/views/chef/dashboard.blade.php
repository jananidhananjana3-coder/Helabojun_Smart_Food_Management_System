@extends('layouts.chef')

@section('title', 'Chef Dashboard')

@section('content')

<style>

    .chef-language {
        position: relative;
    }

    .chef-language-btn {
        width: 44px;
        height: 44px;
        border: 0;
        border-radius: 12px;
        background: #f1f3f5;
        font-size: 20px;
        cursor: pointer;
    }

    .chef-language-menu {
        position: absolute;
        right: 0;
        top: 50px;
        min-width: 180px;
        background: #fff;
        border-radius: 12px;
        padding: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,.15);
        display: none;
        z-index: 9999;
    }

    .chef-language-menu.show {
        display: block;
    }

    .chef-language-option {
        width: 100%;
        border: 0;
        background: transparent;
        text-align: left;
        padding: 10px 12px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
    }

    .chef-language-option:hover {
        background: #f1f3f5;
    }

    .chef-language-option.active {
        background: #212529;
        color: #fff;
    }

    .order-card {
        border: 1px solid #e9ecef;
        border-radius: 16px;
        padding: 18px;
        background: #fff;
        box-shadow: 0 5px 20px rgba(0,0,0,.05);
    }

    .token {
        font-size: 24px;
        font-weight: 800;
    }

    .qty-btn {
        width: 45px;
        height: 45px;
        border: 0;
        border-radius: 12px;
        font-size: 25px;
        font-weight: bold;
        background: #212529;
        color: #fff;
    }

    .qty-num {
        font-size: 28px;
        font-weight: 800;
        min-width: 60px;
        text-align: center;
    }

</style>


@if(isset($error))

    <div class="cardx text-center py-5">

        <div class="fs-1">
            ⚠️
        </div>

        <h3 data-i18n="no_counter">
            No Counter Assigned
        </h3>

        <p class="text-muted" data-i18n="contact_admin">
            Please contact the administrator.
        </p>

    </div>

@else


{{-- =========================================================
     HEADER
========================================================= --}}

<div class="cardx mb-3">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

        <div>

            <h2 class="mb-1" data-i18n="welcome">
                Welcome, Chef 👨‍🍳
            </h2>

            <div class="text-muted" data-i18n="welcome_description">
                Manage food and orders for your counter.
            </div>

        </div>


        <div class="d-flex align-items-center gap-3">

            <div class="text-end">

                <div class="fw-bold">
                    {{ $user->name }}
                </div>

                <div>

                    {{ $counter->outlet->outlet_name ?? '' }}

                    ·

                    <span data-i18n="counter">
                        Counter
                    </span>

                    {{ $counter->counter_number }}

                </div>

                <div class="small text-muted">
                    {{ $user->email }}
                </div>

            </div>


            {{-- LANGUAGE --}}

            <div class="chef-language">

                <button
                    type="button"
                    class="chef-language-btn"
                    id="chefLanguageButton"
                    aria-label="Language"
                >
                    🌐
                </button>


                <div
                    class="chef-language-menu"
                    id="chefLanguageMenu"
                >

                    <button
                        type="button"
                        class="chef-language-option"
                        data-language="si"
                    >
                        🇱🇰 සිංහල
                    </button>

                    <button
                        type="button"
                        class="chef-language-option"
                        data-language="ta"
                    >
                        🇮🇳 தமிழ்
                    </button>

                    <button
                        type="button"
                        class="chef-language-option"
                        data-language="en"
                    >
                        🇬🇧 English
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     ORDERS
========================================================= --}}

<div class="d-flex justify-content-between align-items-center mb-2">

    <h3 class="mb-0">

        🔔

        <span data-i18n="orders">
            Orders
        </span>

    </h3>

    <span
        class="badge text-bg-dark"
        id="orderCount"
    >
        {{ $orders->count() }}
    </span>

</div>


<div
    class="row g-3 mb-4"
    id="chefOrders"
>

    @forelse($orders as $order)

        <div
            class="col-md-6 col-xl-4"
            id="order-card-{{ $order->id }}"
        >

            <div class="order-card h-100">

                <div class="d-flex justify-content-between">

                    <div class="token">
                        #{{ $order->token_number }}
                    </div>

                    <span
                        class="badge text-bg-secondary status-label"
                        data-status="{{ $order->status }}"
                    >
                        {{ ucfirst($order->status) }}
                    </span>

                </div>


                <div class="small text-muted mb-3">

                    {{ $order->order_type ?? 'dine_in' }}

                </div>


                <ul class="list-group list-group-flush mb-3">

                    @foreach($order->orderItems as $item)

                        <li class="list-group-item px-0 d-flex justify-content-between">

                            <span>
                                {{ $item->food->food_name ?? 'Food' }}
                            </span>

                            <strong>
                                × {{ $item->quantity }}
                            </strong>

                        </li>

                    @endforeach

                </ul>


                {{-- PENDING --}}

                @if($order->status === 'pending')

                    <button
                        class="btn btn-dark w-100"
                        onclick="setOrder(
                            {{ $order->id }},
                            'accepted',
                            this
                        )"
                    >

                        <span data-i18n="accept">
                            Accept
                        </span>

                    </button>


                {{-- ACCEPTED --}}

                @elseif($order->status === 'accepted')

                    <button
                        class="btn btn-warning w-100"
                        onclick="setOrder(
                            {{ $order->id }},
                            'preparing',
                            this
                        )"
                    >

                        <span data-i18n="start_preparing">
                            Start Preparing
                        </span>

                    </button>


                {{-- PREPARING --}}

                @elseif($order->status === 'preparing')

                    <button
                        class="btn btn-success w-100"
                        onclick="setOrder(
                            {{ $order->id }},
                            'ready',
                            this
                        )"
                    >

                        <span data-i18n="mark_ready">
                            Ready
                        </span>

                    </button>


                {{-- READY --}}

                @elseif($order->status === 'ready')

                    <button
                        class="btn btn-outline-dark w-100"
                        onclick="setOrder(
                            {{ $order->id }},
                            'completed',
                            this
                        )"
                    >

                        <span data-i18n="completed">
                            Complete
                        </span>

                    </button>

                @endif

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="cardx text-center text-muted py-5">

                <div class="fs-1">
                    🍽️
                </div>

                <h4 data-i18n="no_orders">
                    No Orders
                </h4>

                <p data-i18n="no_orders_description">
                    New orders will appear here automatically.
                </p>

            </div>

        </div>

    @endforelse

</div>


{{-- =========================================================
     FOODS
========================================================= --}}

<div class="d-flex justify-content-between align-items-center mb-2">

    <h3 class="mb-0">

        🍛

        <span data-i18n="my_foods">
            My Foods
        </span>

    </h3>

    <span
        class="small text-muted"
        data-i18n="chef_controls_quantity"
    >
        Chef controls quantity per counter
    </span>

</div>


<div class="row g-3">

    @forelse($foods as $food)

        @php
            $q = (int) ($food->pivot->quantity ?? 0);
        @endphp


        <div class="col-sm-6 col-lg-4">

            <div class="cardx food-card">

                <h5 class="fw-bold">
                    {{ $food->food_name }}
                </h5>


                <div class="small text-muted mb-3">
                    {{ $food->category->category_name ?? '' }}
                </div>


                <div class="d-flex align-items-center justify-content-between">

                    <button
                        type="button"
                        class="qty-btn"
                        onclick="changeQty(
                            {{ $food->id }},
                            -1
                        )"
                    >
                        −
                    </button>


                    <div
                        class="qty-num"
                        id="qty-{{ $food->id }}"
                    >
                        {{ $q }}
                    </div>


                    <button
                        type="button"
                        class="qty-btn"
                        onclick="changeQty(
                            {{ $food->id }},
                            1
                        )"
                    >
                        +
                    </button>

                </div>


                <div
                    class="status text-center mt-3"
                    id="food-status-{{ $food->id }}"
                >

                    @if($q > 0)

                        🟢

                        <span data-i18n="available">
                            Available
                        </span>

                    @else

                        🔴

                        <span data-i18n="not_available">
                            Not Available
                        </span>

                    @endif

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="cardx text-center text-muted py-5">

                <div class="fs-1">
                    🍛
                </div>

                <h4 data-i18n="no_foods">
                    No Foods Assigned
                </h4>

                <p data-i18n="no_foods_description">
                    There are no foods assigned to your counter.
                </p>

            </div>

        </div>

    @endforelse

</div>


@endif

@endsection


@push('scripts')

<script>

/*
|--------------------------------------------------------------------------
| CHEF LANGUAGES
|--------------------------------------------------------------------------
*/

const CHEF_TRANSLATIONS = {

    si: {

        welcome:
            'ආයුබෝවන්, චෙෆ් 👨‍🍳',

        welcome_description:
            'ඔබගේ කවුන්ටරයේ ආහාර සහ ඇණවුම් කළමනාකරණය කරන්න.',

        counter:
            'කවුන්ටරය',

        orders:
            'ඇණවුම්',

        accept:
            'භාරගන්න',

        start_preparing:
            'පිසීම ආරම්භ කරන්න',

        mark_ready:
            'සූදානම්',

        completed:
            'සම්පූර්ණයි',

        my_foods:
            'මගේ ආහාර',

        chef_controls_quantity:
            'චෙෆ් කවුන්ටරයට අනුව ප්‍රමාණය පාලනය කරයි',

        available:
            'ඇත',

        not_available:
            'නැත',

        no_orders:
            'ඇණවුම් නැත',

        no_orders_description:
            'නව ඇණවුම් මෙහි ස්වයංක්‍රීයව දිස් වේ.',

        no_foods:
            'ආහාර පවරා නැත',

        no_foods_description:
            'ඔබගේ කවුන්ටරයට ආහාර පවරා නැත.',

        no_counter:
            'කවුන්ටරයක් පවරා නැත',

        contact_admin:
            'කරුණාකර පරිපාලක අමතන්න.',

        quantity_updated:
            'ආහාර ප්‍රමාණය යාවත්කාලීන කරන ලදී.',

        order_updated:
            'ඇණවුම යාවත්කාලීන කරන ලදී.',

        error:
            'දෝෂයක් ඇති විය.'

    },


    ta: {

        welcome:
            'வணக்கம், Chef 👨‍🍳',

        welcome_description:
            'உங்கள் கவுண்டரில் உணவு மற்றும் ஆர்டர்களை நிர்வகிக்கவும்.',

        counter:
            'கவுண்டர்',

        orders:
            'ஆர்டர்கள்',

        accept:
            'ஏற்கவும்',

        start_preparing:
            'தயாரிக்கத் தொடங்கவும்',

        mark_ready:
            'தயார்',

        completed:
            'முடிந்தது',

        my_foods:
            'எனது உணவுகள்',

        chef_controls_quantity:
            'Chef கவுண்டருக்கான அளவை நிர்வகிக்கிறார்',

        available:
            'கிடைக்கிறது',

        not_available:
            'கிடைக்கவில்லை',

        no_orders:
            'ஆர்டர்கள் இல்லை',

        no_orders_description:
            'புதிய ஆர்டர்கள் இங்கே தானாக தோன்றும்.',

        no_foods:
            'உணவுகள் ஒதுக்கப்படவில்லை',

        no_foods_description:
            'உங்கள் கவுண்டருக்கு உணவுகள் ஒதுக்கப்படவில்லை.',

        no_counter:
            'கவுண்டர் ஒதுக்கப்படவில்லை',

        contact_admin:
            'நிர்வாகியை தொடர்பு கொள்ளவும்.',

        quantity_updated:
            'உணவு அளவு புதுப்பிக்கப்பட்டது.',

        order_updated:
            'ஆர்டர் புதுப்பிக்கப்பட்டது.',

        error:
            'பிழை ஏற்பட்டது.'

    },


    en: {

        welcome:
            'Welcome, Chef 👨‍🍳',

        welcome_description:
            'Manage food and orders for your counter.',

        counter:
            'Counter',

        orders:
            'Orders',

        accept:
            'Accept',

        start_preparing:
            'Start Preparing',

        mark_ready:
            'Ready',

        completed:
            'Complete',

        my_foods:
            'My Foods',

        chef_controls_quantity:
            'Chef controls quantity per counter',

        available:
            'Available',

        not_available:
            'Not Available',

        no_orders:
            'No Orders',

        no_orders_description:
            'New orders will appear here automatically.',

        no_foods:
            'No Foods Assigned',

        no_foods_description:
            'There are no foods assigned to your counter.',

        no_counter:
            'No Counter Assigned',

        contact_admin:
            'Please contact the administrator.',

        quantity_updated:
            'Food quantity updated.',

        order_updated:
            'Order updated.',

        error:
            'An error occurred.'

    }

};


/*
|--------------------------------------------------------------------------
| Current Language
|--------------------------------------------------------------------------
*/

let chefLanguage =
    localStorage.getItem('chef_language') || 'en';


/*
|--------------------------------------------------------------------------
| Translation
|--------------------------------------------------------------------------
*/

function tr(key) {

    return (
        CHEF_TRANSLATIONS[chefLanguage]?.[key] ||
        CHEF_TRANSLATIONS.en[key] ||
        key
    );

}


/*
|--------------------------------------------------------------------------
| Apply Language
|--------------------------------------------------------------------------
*/

function applyChefLanguage() {

    document
        .querySelectorAll('[data-i18n]')
        .forEach(function (element) {

            const key =
                element.getAttribute('data-i18n');

            if (CHEF_TRANSLATIONS[chefLanguage]?.[key]) {

                element.textContent =
                    tr(key);

            }

        });


    document
        .querySelectorAll('.chef-language-option')
        .forEach(function (button) {

            button.classList.toggle(
                'active',
                button.dataset.language === chefLanguage
            );

        });

}


/*
|--------------------------------------------------------------------------
| Language Button
|--------------------------------------------------------------------------
*/

const languageButton =
    document.getElementById(
        'chefLanguageButton'
    );

const languageMenu =
    document.getElementById(
        'chefLanguageMenu'
    );


if (languageButton && languageMenu) {

    languageButton.addEventListener(
        'click',
        function (event) {

            event.stopPropagation();

            languageMenu.classList.toggle(
                'show'
            );

        }
    );


    document
        .querySelectorAll('.chef-language-option')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    chefLanguage =
                        this.dataset.language;

                    localStorage.setItem(
                        'chef_language',
                        chefLanguage
                    );

                    applyChefLanguage();

                    languageMenu.classList.remove(
                        'show'
                    );

                }
            );

        });


    document.addEventListener(
        'click',
        function () {

            languageMenu.classList.remove(
                'show'
            );

        }
    );

}


/*
|--------------------------------------------------------------------------
| CSRF
|--------------------------------------------------------------------------
*/

const csrf =
    document.querySelector(
        'meta[name="csrf-token"]'
    )?.content;


/*
|--------------------------------------------------------------------------
| CHANGE FOOD QUANTITY
|--------------------------------------------------------------------------
*/

function changeQty(
    id,
    difference
) {

    const element =
        document.getElementById(
            'qty-' + id
        );

    if (!element) {
        return;
    }

    let quantity =
        parseInt(
            element.textContent
        ) || 0;

    quantity =
        Math.max(
            0,
            quantity + difference
        );

    saveQty(
        id,
        quantity
    );

}


/*
|--------------------------------------------------------------------------
| SAVE FOOD QUANTITY
|--------------------------------------------------------------------------
*/

async function saveQty(
    id,
    quantity
) {

    try {

        const response =
            await fetch(
                '{{ url('/chef/foods') }}/' +
                id +
                '/quantity',
                {
                    method: 'PATCH',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                            csrf

                    },

                    body: JSON.stringify({
                        quantity: quantity
                    })
                }
            );


        const data =
            await response.json();


        if (!response.ok) {

            throw new Error(
                data.message ||
                tr('error')
            );

        }


        document
            .getElementById(
                'qty-' + id
            )
            .textContent =
                data.quantity;


        const status =
            document.getElementById(
                'food-status-' + id
            );


        if (data.quantity > 0) {

            status.innerHTML =
                '🟢 <span data-i18n="available">' +
                tr('available') +
                '</span>';

        } else {

            status.innerHTML =
                '🔴 <span data-i18n="not_available">' +
                tr('not_available') +
                '</span>';

        }


        toast(
            tr('quantity_updated')
        );


    } catch (error) {

        console.error(error);

        toast(
            error.message
        );

    }

}


/*
|--------------------------------------------------------------------------
| UPDATE ORDER
|--------------------------------------------------------------------------
*/

async function setOrder(
    id,
    status,
    button
) {

    button.disabled = true;


    try {

        const response =
            await fetch(
                '{{ url('/chef/orders') }}/' +
                id +
                '/status',
                {
                    method: 'PATCH',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                            csrf

                    },

                    body: JSON.stringify({
                        status: status
                    })
                }
            );


        const data =
            await response.json();


        if (!response.ok) {

            throw new Error(
                data.message ||
                tr('error')
            );

        }


        /*
        |--------------------------------------------------------------------------
        | READY
        |--------------------------------------------------------------------------
        |
        | Backend already changes:
        |
        | QueueDisplay = ready
        |
        | Therefore customer queue display can
        | immediately show this token.
        |
        */

        location.reload();


    } catch (error) {

        button.disabled = false;

        console.error(error);

        toast(
            error.message
        );

    }

}


/*
|--------------------------------------------------------------------------
| AUTO REFRESH ORDER COUNT
|--------------------------------------------------------------------------
*/

setInterval(
    async function () {

        try {

            const response =
                await fetch(
                    '{{ route('chef.data') }}',
                    {
                        headers: {
                            Accept:
                                'application/json'
                        }
                    }
                );


            if (!response.ok) {
                return;
            }


            const data =
                await response.json();


            const count =
                document.getElementById(
                    'orderCount'
                );


            if (count) {

                count.textContent =
                    data.orders.length;

            }


        } catch (error) {

            console.error(error);

        }

    },
    5000
);


/*
|--------------------------------------------------------------------------
| INITIAL LANGUAGE
|--------------------------------------------------------------------------
*/

applyChefLanguage();

</script>

@endpush