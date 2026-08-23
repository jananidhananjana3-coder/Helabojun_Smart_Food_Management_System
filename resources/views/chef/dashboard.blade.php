@extends('layouts.chef')

@section('title', 'Chef Dashboard')

@section('content')

<style>

    body {
        background: linear-gradient(
            135deg,
            #fff8ed 0%,
            #f3f7f2 100%
        );
    }

    .cardx,
    .order-card {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(108, 117, 125, 0.12);
    }

    .order-card {
        border-radius: 16px;
        padding: 18px;
        box-shadow: 0 8px 25px rgba(80, 70, 40, 0.08);
    }

    .food-card {
        box-shadow: 0 8px 25px rgba(80, 70, 40, 0.08);
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
        background: #198754;
        color: #fff;
        cursor: pointer;
    }

    .qty-btn:hover {
        background: #157347;
    }

    .qty-num {
        font-size: 28px;
        font-weight: 800;
        min-width: 60px;
        text-align: center;
    }

    #chefOrders,
    .chef-foods-section {
        position: relative;
        z-index: 1;
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

        <p
            class="text-muted"
            data-i18n="contact_admin"
        >
            Please contact the administrator.
        </p>

    </div>

@else


{{-- Welcome --}}

<div class="cardx mb-3">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

        <div>

            <h2
                class="mb-1"
                data-i18n="welcome"
            >
                Welcome, Chef 👨‍🍳
            </h2>

            <div
                class="text-muted"
                data-i18n="welcome_description"
            >
                Manage food and orders for your counter.
            </div>

        </div>


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

    </div>

</div>


{{-- Foods --}}

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


<div class="row g-3 mb-4 chef-foods-section">

    @forelse($foods as $food)

        @php

            $counterPivot = $food->counters->first();

            $q = (int) (
                $counterPivot?->pivot?->quantity ?? 0
            );

        @endphp


        <div class="col-sm-6 col-lg-4">

            <div class="cardx food-card p-3">

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

            <div
                class="cardx text-center text-muted py-5"
            >

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


{{-- Orders title --}}

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


{{-- Orders --}}

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

                    ·

                    Counter
                    {{ $order->counter->counter_number ?? '-' }}

                </div>


                <ul class="list-group list-group-flush mb-3">

                    @foreach($order->orderItems as $item)

                        <li
                            class="list-group-item px-0 d-flex justify-content-between"
                        >

                            <span>
                                {{ $item->food->food_name ?? 'Food' }}
                            </span>

                            <strong>
                                × {{ $item->quantity }}
                            </strong>

                        </li>

                    @endforeach

                </ul>


                {{-- Ticket status --}}

                @if($order->myTicketStatus === 'pending')

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


                @elseif($order->myTicketStatus === 'waiting')

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


                @elseif($order->myTicketStatus === 'cooking')

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


                @elseif($order->myTicketStatus === 'ready')

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

            <div
                class="cardx text-center text-muted py-5"
            >

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


@endif

@endsection


@push('scripts')

<script>

const csrf =
    document.querySelector(
        'meta[name="csrf-token"]'
    )?.content;


// Food quantity

function changeQty(id, difference)
{
    const element =
        document.getElementById(
            'qty-' + id
        );

    if (!element) {
        return;
    }

    let quantity =
        parseInt(
            element.textContent,
            10
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


// Save quantity

async function saveQty(id, quantity)
{
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

                    body:
                        JSON.stringify({
                            quantity:
                                quantity
                        })

                }
            );


        const data =
            await response.json();


        if (!response.ok) {

            throw new Error(
                data.message ||
                'An error occurred.'
            );

        }


        const quantityElement =
            document.getElementById(
                'qty-' + id
            );


        if (quantityElement) {

            quantityElement.textContent =
                data.quantity;

        }


        const status =
            document.getElementById(
                'food-status-' + id
            );


        if (status) {

            if (data.quantity > 0) {

                status.innerHTML =
                    '🟢 ' +
                    '<span data-i18n="available">' +
                    'Available' +
                    '</span>';

            } else {

                status.innerHTML =
                    '🔴 ' +
                    '<span data-i18n="not_available">' +
                    'Not Available' +
                    '</span>';

            }

        }


    } catch (error) {

        console.error(error);

        if (typeof toast === 'function') {

            toast(
                error.message
            );

        } else {

            alert(
                error.message
            );

        }

    }
}


// Update order

async function setOrder(
    id,
    status,
    button
)
{
    if (!button) {
        return;
    }

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

                    body:
                        JSON.stringify({
                            status:
                                status
                        })

                }
            );


        const data =
            await response.json();


        if (!response.ok) {

            throw new Error(
                data.message ||
                'An error occurred.'
            );

        }


        location.reload();


    } catch (error) {

        button.disabled = false;

        console.error(error);


        if (typeof toast === 'function') {

            toast(
                error.message
            );

        } else {

            alert(
                error.message
            );

        }

    }
}


// Refresh order count

setInterval(
    async function()
    {

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

</script>

@endpush