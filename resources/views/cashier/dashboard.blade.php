@extends('layouts.cashier')

@section('page-title')
    <span>POS / Cashier</span>
@endsection

@section('page-subtitle')
    {{ $outlet?->outlet_name ?? 'Hela Bojun' }}
    <span class="mx-1">•</span>
    Today Orders: {{ $recentOrders->count() }}
@endsection


@push('styles')

<style>

    .cashier-counter-btn {
        min-height: 75px;
        border-radius: 12px;
        transition: .15s ease;
    }

    .cashier-counter-btn.active {
        background: #198754 !important;
        color: #fff !important;
        border-color: #198754 !important;
    }

    .cashier-food-card {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        height: 100%;
        background: #fff;
        transition: .15s ease;
    }

    .cashier-food-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,.08);
    }

    .cashier-food-image {
        width: 100%;
        height: 145px;
        object-fit: cover;
    }

    .cashier-food-placeholder {
        height: 145px;
        background: #edf6f0;
        display: grid;
        place-items: center;
        color: #198754;
        font-size: 42px;
    }

    .cashier-cart-row {
        border-bottom: 1px solid #eee;
        padding: 12px 0;
    }

    .cashier-cart-row:last-child {
        border-bottom: 0;
    }

    .counter-stock-badge {
        font-size: .75rem;
    }

    #cashierCartItems {
        max-height: 42vh;
        overflow-y: auto;
    }

    .cashier-sticky-cart {
        position: sticky;
        top: 18px;
        z-index: 10;
    }

    .cashier-food-search {
        max-width: 280px;
    }

    @media (max-width: 1199px) {
        .cashier-sticky-cart {
            position: static;
        }
    }

</style>

@endpush


@section('content')

<div class="container-fluid">

    <div class="row g-3">

        {{-- ============================================================
             LEFT SIDE
        ============================================================= --}}

        <div class="col-xl-8">

            {{-- COUNTERS --}}

            <div class="hb-card p-3 mb-3">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Select Counter
                        </h5>

                        <div class="small text-muted">
                            Select the counter for this customer's bill.
                        </div>

                    </div>

                </div>


                @if($counters->count())

                    <div class="row g-2">

                        @foreach($counters as $counter)

                            <div class="col-sm-6 col-md-4">

                                <button
                                    type="button"
                                    class="btn btn-outline-success w-100 cashier-counter-btn counter-btn"
                                    data-counter-id="{{ $counter->id }}"
                                    data-counter-number="{{ $counter->counter_number }}"
                                    data-counter-name="{{ $counter->counter_name }}"
                                >

                                    <strong>
                                        Counter {{ $counter->counter_number }}
                                    </strong>

                                    <br>

                                    <small>
                                        {{ $counter->counter_name }}
                                    </small>

                                </button>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="alert alert-warning mb-0">
                        No active counter is available for this cashier.
                    </div>

                @endif

            </div>


            {{-- FOOD AREA --}}

            <div class="hb-card p-3">

                <div class="d-flex justify-content-between align-items-center mb-3 gap-2">

                    <div>

                        <h5 class="fw-bold mb-0">
                            Foods
                        </h5>

                        <small class="text-muted">
                            Food availability is controlled by Chef.
                        </small>

                    </div>


                    <input
                        type="search"
                        id="foodSearch"
                        class="form-control cashier-food-search"
                        placeholder="Search food..."
                        autocomplete="off"
                    >

                </div>


                <div
                    id="selectCounterMessage"
                    class="text-center text-muted py-5"
                >

                    <i class="fa fa-store fa-2x mb-2"></i>

                    <div class="fw-semibold">
                        Please select a counter first.
                    </div>

                    <small>
                        Foods assigned to that counter will appear here.
                    </small>

                </div>


                <div id="foodArea"></div>

            </div>

        </div>


        {{-- ============================================================
             RIGHT SIDE
        ============================================================= --}}

        <div class="col-xl-4">

            <div class="hb-card p-3 cashier-sticky-cart">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="fw-bold mb-0">
                            Current Bill
                        </h5>

                        <small class="text-muted">
                            One customer = one bill
                        </small>

                    </div>


                    <button
                        type="button"
                        id="clearCart"
                        class="btn btn-sm btn-outline-danger"
                    >
                        Clear
                    </button>

                </div>


                {{-- SELECTED COUNTER --}}

                <div
                    id="selectedCounterBox"
                    class="alert alert-success mt-3 mb-3"
                    style="display:none"
                ></div>


                {{-- CART --}}

                <div
                    id="cashierCartItems"
                    class="my-3"
                >

                    <div class="text-center text-muted py-4">
                        No items added.
                    </div>

                </div>


                {{-- TOTALS --}}

                <div class="border-top pt-3">

                    <div class="d-flex justify-content-between">

                        <span>
                            Subtotal
                        </span>

                        <strong id="subtotal">
                            Rs. 0.00
                        </strong>

                    </div>


                    <div class="mt-2">

                        <label
                            for="discount"
                            class="form-label small fw-semibold"
                        >
                            Discount
                        </label>

                        <input
                            type="number"
                            id="discount"
                            class="form-control"
                            min="0"
                            step="0.01"
                            value="0"
                        >

                    </div>


                    <div class="d-flex justify-content-between mt-3 fs-5">

                        <strong>
                            Grand Total
                        </strong>

                        <strong id="grandTotal">
                            Rs. 0.00
                        </strong>

                    </div>

                </div>


                {{-- ORDER TYPE --}}

                <div class="mt-3">

                    <label
                        for="orderType"
                        class="form-label fw-semibold"
                    >
                        Order Type
                    </label>

                    <select
                        id="orderType"
                        class="form-select"
                    >

                        <option value="dine_in">
                            Dine In
                        </option>

                        <option value="take_away">
                            Take Away
                        </option>

                    </select>

                </div>


                {{-- PAYMENT METHOD --}}

                <div class="mt-3">

                    <label
                        for="paymentMethod"
                        class="form-label fw-semibold"
                    >
                        Payment Method
                    </label>

                    <select
                        id="paymentMethod"
                        class="form-select"
                    >

                        <option value="cash">
                            Cash
                        </option>

                        <option value="card">
                            Card
                        </option>

                        <option value="qr">
                            QR / Barcode
                        </option>

                    </select>

                </div>


                {{-- CASH --}}

                <div
                    id="cashBox"
                    class="mt-3"
                >

                    <label
                        for="cashReceived"
                        class="form-label fw-semibold"
                    >
                        Cash Received
                    </label>

                    <input
                        type="number"
                        id="cashReceived"
                        class="form-control"
                        min="0"
                        step="0.01"
                        placeholder="Enter received cash"
                    >


                    <div class="d-flex justify-content-between mt-2">

                        <span class="small">
                            Change
                        </span>

                        <strong
                            id="change"
                            class="small"
                        >
                            Rs. 0.00
                        </strong>

                    </div>

                </div>


                {{-- CHECKOUT --}}

                <button
                    type="button"
                    id="checkoutBtn"
                    class="btn btn-success btn-lg w-100 mt-3"
                    disabled
                >

                    <i class="fa fa-check-circle me-2"></i>

                    PAY & CREATE ONE BILL

                </button>


                {{-- MESSAGE --}}

                <div
                    id="checkoutMessage"
                    class="mt-3"
                ></div>

            </div>

        </div>

    </div>

</div>


{{-- ================================================================
     SUCCESS MODAL
================================================================ --}}

<div
    class="modal fade"
    id="orderSuccessModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-body p-4">

                <div class="text-center">

                    <div class="display-5 text-success">
                        <i class="fa fa-circle-check"></i>
                    </div>

                    <h4 class="fw-bold mt-2">
                        Bill Created Successfully
                    </h4>

                    <div
                        id="successSummary"
                        class="text-muted"
                    ></div>

                </div>


                <div
                    id="receiptPreview"
                    class="bg-light rounded p-3 mt-3"
                ></div>


                <div class="d-grid gap-2 mt-3">

                    <button
                        type="button"
                        class="btn btn-success"
                        id="printReceiptBtn"
                    >

                        <i class="fa fa-print me-2"></i>

                        Print Receipt

                    </button>


                    <button
                        type="button"
                        class="btn btn-outline-success"
                        id="printKotBtn"
                    >

                        <i class="fa fa-utensils me-2"></i>

                        Print KOT

                    </button>


                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>


@endsection


@push('scripts')

<script>

(function () {

    'use strict';


    /* ================================================================
       SERVER DATA
    ================================================================= */

    const counters = @json(
        $counters->map(function ($counter) {

            return [
                'id' => $counter->id,

                'number' => $counter->counter_number,

                'name' => $counter->counter_name,

                'foods' => $counter->foods
                    ->map(function ($food) {

                        return [
                            'id' => $food->id,

                            'name' => $food->food_name,

                            'price' => (float) $food->price,

                            'quantity' =>
                                (int) ($food->pivot->quantity ?? 0),

                            'category' =>
                                $food->category?->category_name
                                ?? 'Other',

                            'image' =>
                                $food->image
                                    ? asset('storage/' . $food->image)
                                    : null,
                        ];

                    })
                    ->values(),
            ];

        })->values()
    );


    /* ================================================================
       STATE
    ================================================================= */

    let selectedCounterId = null;

    let cart = {};

    let lastReceiptUrl = null;

    let lastKotUrl = null;

    let checkoutInProgress = false;


    /* ================================================================
       ELEMENTS
    ================================================================= */

    const foodArea =
        document.getElementById('foodArea');

    const selectCounterMessage =
        document.getElementById(
            'selectCounterMessage'
        );

    const selectedCounterBox =
        document.getElementById(
            'selectedCounterBox'
        );

    const cartItems =
        document.getElementById(
            'cashierCartItems'
        );

    const subtotalElement =
        document.getElementById(
            'subtotal'
        );

    const grandTotalElement =
        document.getElementById(
            'grandTotal'
        );

    const discountInput =
        document.getElementById(
            'discount'
        );

    const paymentMethod =
        document.getElementById(
            'paymentMethod'
        );

    const cashBox =
        document.getElementById(
            'cashBox'
        );

    const cashReceived =
        document.getElementById(
            'cashReceived'
        );

    const changeElement =
        document.getElementById(
            'change'
        );

    const checkoutBtn =
        document.getElementById(
            'checkoutBtn'
        );

    const checkoutMessage =
        document.getElementById(
            'checkoutMessage'
        );

    const foodSearch =
        document.getElementById(
            'foodSearch'
        );


    /* ================================================================
       HELPERS
    ================================================================= */

    function money(value) {

        return 'Rs. ' +
            Number(value || 0)
                .toLocaleString(
                    'en-LK',
                    {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }
                );
    }


    function escapeHtml(value) {

        const div =
            document.createElement('div');

        div.textContent =
            String(value ?? '');

        return div.innerHTML;
    }


    function getSelectedCounter() {

        return counters.find(
            counter =>
                Number(counter.id) ===
                Number(selectedCounterId)
        );
    }


    function getSubtotal() {

        return Object.values(cart)
            .reduce(
                (total, item) =>
                    total +
                    (
                        item.food.price *
                        item.qty
                    ),
                0
            );
    }


    function getDiscount() {

        const subtotal =
            getSubtotal();

        const entered =
            Number(
                discountInput.value || 0
            );

        return Math.min(
            Math.max(0, entered),
            subtotal
        );
    }


    function getGrandTotal() {

        return Math.max(
            0,
            getSubtotal() -
            getDiscount()
        );
    }


    function setMessage(
        message,
        type = 'danger'
    ) {

        if (!message) {

            checkoutMessage.innerHTML = '';

            return;
        }

        checkoutMessage.innerHTML = `
            <div class="alert alert-${type} mb-0">
                ${escapeHtml(message)}
            </div>
        `;
    }


    /* ================================================================
       COUNTER SELECTION
    ================================================================= */

    document
        .querySelectorAll('.counter-btn')
        .forEach(button => {

            button.addEventListener(
                'click',
                function () {

                    if (checkoutInProgress) {
                        return;
                    }


                    selectedCounterId =
                        Number(
                            this.dataset.counterId
                        );


                    /*
                    ----------------------------------------------------
                    New counter = new customer's bill.
                    ----------------------------------------------------
                    */

                    cart = {};


                    document
                        .querySelectorAll(
                            '.counter-btn'
                        )
                        .forEach(btn => {

                            btn.classList.remove(
                                'active'
                            );

                        });


                    this.classList.add(
                        'active'
                    );


                    const counterNumber =
                        this.dataset.counterNumber;

                    const counterName =
                        this.dataset.counterName;


                    selectedCounterBox
                        .style.display = 'block';


                    selectedCounterBox.innerHTML = `
                        <strong>
                            Selected Counter:
                        </strong>
                        ${escapeHtml(counterNumber)}
                        <span class="mx-1">•</span>
                        ${escapeHtml(counterName)}
                    `;


                    selectCounterMessage
                        .style.display = 'none';


                    foodSearch.value = '';


                    setMessage('');


                    renderFoods();

                    renderCart();

                }
            );

        });


    /* ================================================================
       FOOD RENDER
    ================================================================= */

    function renderFoods() {

        foodArea.innerHTML = '';


        if (!selectedCounterId) {

            selectCounterMessage
                .style.display = 'block';

            return;
        }


        selectCounterMessage
            .style.display = 'none';


        const counter =
            getSelectedCounter();


        if (!counter) {
            return;
        }


        const search =
            foodSearch.value
                .trim()
                .toLowerCase();


        const grouped = {};


        counter.foods
            .filter(food => {

                if (
                    Number(food.quantity) <= 0
                ) {
                    return false;
                }


                if (!search) {
                    return true;
                }


                return food.name
                    .toLowerCase()
                    .includes(search);

            })
            .forEach(food => {

                const category =
                    food.category || 'Other';


                if (!grouped[category]) {
                    grouped[category] = [];
                }


                grouped[category].push(food);

            });


        const categories =
            Object.keys(grouped);


        if (!categories.length) {

            foodArea.innerHTML = `
                <div class="alert alert-warning">
                    No food is currently available
                    at Counter
                    ${escapeHtml(counter.number)}.
                </div>
            `;

            return;
        }


        categories.forEach(category => {

            const section =
                document.createElement('div');

            section.className =
                'mb-4';


            const heading =
                document.createElement('h6');

            heading.className =
                'fw-bold text-success mb-3';

            heading.textContent =
                category;


            const row =
                document.createElement('div');

            row.className =
                'row g-3';


            grouped[category]
                .forEach(food => {

                    const col =
                        document.createElement('div');

                    col.className =
                        'col-sm-6 col-lg-4';


                    const card =
                        document.createElement('div');

                    card.className =
                        'cashier-food-card';


                    const image =
                        document.createElement('div');


                    if (food.image) {

                        image.innerHTML = `
                            <img
                                src="${escapeHtml(food.image)}"
                                class="cashier-food-image"
                                alt=""
                            >
                        `;

                    } else {

                        image.innerHTML = `
                            <div class="cashier-food-placeholder">
                                <i class="fa fa-utensils"></i>
                            </div>
                        `;

                    }


                    const body =
                        document.createElement('div');

                    body.className =
                        'p-3';


                    body.innerHTML = `
                        <div class="d-flex justify-content-between align-items-start gap-2">

                            <div class="fw-bold">
                                ${escapeHtml(food.name)}
                            </div>

                            <span class="badge text-bg-success counter-stock-badge">
                                ${Number(food.quantity)}
                            </span>

                        </div>

                        <div class="text-muted small mt-1">
                            ${money(food.price)}
                        </div>

                        <div class="small text-muted mt-2 mb-3">
                            Available: ${Number(food.quantity)}
                        </div>
                    `;


                    const addButton =
                        document.createElement('button');

                    addButton.type =
                        'button';

                    addButton.className =
                        'btn btn-success w-100';

                    addButton.innerHTML =
                        '<i class="fa fa-plus me-1"></i> Add';


                    addButton.addEventListener(
                        'click',
                        function () {

                            addFood(
                                food.id
                            );

                        }
                    );


                    body.appendChild(
                        addButton
                    );


                    card.appendChild(
                        image
                    );

                    card.appendChild(
                        body
                    );

                    col.appendChild(
                        card
                    );

                    row.appendChild(
                        col
                    );

                });


            section.appendChild(
                heading
            );

            section.appendChild(
                row
            );

            foodArea.appendChild(
                section
            );

        });

    }


    /* ================================================================
       ADD FOOD
    ================================================================= */

    function addFood(foodId) {

        if (!selectedCounterId) {

            alert(
                'Please select a counter first.'
            );

            return;
        }


        const counter =
            getSelectedCounter();


        if (!counter) {
            return;
        }


        const food =
            counter.foods.find(
                item =>
                    Number(item.id) ===
                    Number(foodId)
            );


        if (!food) {
            return;
        }


        const available =
            Number(food.quantity);


        if (available <= 0) {

            alert(
                'This food is currently out of stock.'
            );

            return;
        }


        if (!cart[foodId]) {

            cart[foodId] = {
                food: food,
                qty: 0
            };

        }


        if (
            cart[foodId].qty >=
            available
        ) {

            alert(
                `${food.name} has only ${available} available.`
            );

            return;
        }


        cart[foodId].qty++;


        renderCart();

    }


    /* ================================================================
       CART
    ================================================================= */

    function renderCart() {

        const items =
            Object.values(cart)
                .filter(item =>
                    item.qty > 0
                );


        if (!items.length) {

            cartItems.innerHTML = `
                <div class="text-center text-muted py-4">
                    No items added.
                </div>
            `;

        } else {

            cartItems.innerHTML = '';


            items.forEach(item => {

                const row =
                    document.createElement('div');

                row.className =
                    'cashier-cart-row';


                const top =
                    document.createElement('div');

                top.className =
                    'd-flex justify-content-between gap-2';


                const name =
                    document.createElement('strong');

                name.textContent =
                    item.food.name;


                const remove =
                    document.createElement('button');

                remove.type =
                    'button';

                remove.className =
                    'btn btn-sm btn-link text-danger p-0';

                remove.innerHTML =
                    '<i class="fa fa-trash"></i>';


                remove.addEventListener(
                    'click',
                    function () {

                        delete cart[
                            item.food.id
                        ];

                        renderCart();

                    }
                );


                top.appendChild(
                    name
                );

                top.appendChild(
                    remove
                );


                const price =
                    document.createElement('div');

                price.className =
                    'small text-muted';

                price.textContent =
                    `${money(item.food.price)} × ${item.qty}`;


                const controls =
                    document.createElement('div');

                controls.className =
                    'd-flex justify-content-between align-items-center mt-2';


                const group =
                    document.createElement('div');

                group.className =
                    'btn-group btn-group-sm';


                const minus =
                    document.createElement('button');

                minus.type =
                    'button';

                minus.className =
                    'btn btn-outline-secondary';

                minus.textContent =
                    '−';


                minus.addEventListener(
                    'click',
                    function () {

                        changeQuantity(
                            item.food.id,
                            -1
                        );

                    }
                );


                const quantity =
                    document.createElement('span');

                quantity.className =
                    'btn btn-light';

                quantity.textContent =
                    item.qty;


                const plus =
                    document.createElement('button');

                plus.type =
                    'button';

                plus.className =
                    'btn btn-outline-secondary';

                plus.textContent =
                    '+';


                plus.addEventListener(
                    'click',
                    function () {

                        changeQuantity(
                            item.food.id,
                            1
                        );

                    }
                );


                group.appendChild(
                    minus
                );

                group.appendChild(
                    quantity
                );

                group.appendChild(
                    plus
                );


                const lineTotal =
                    document.createElement('strong');

                lineTotal.textContent =
                    money(
                        item.food.price *
                        item.qty
                    );


                controls.appendChild(
                    group
                );

                controls.appendChild(
                    lineTotal
                );


                row.appendChild(
                    top
                );

                row.appendChild(
                    price
                );

                row.appendChild(
                    controls
                );


                cartItems.appendChild(
                    row
                );

            });

        }


        const subtotal =
            getSubtotal();

        const discount =
            getDiscount();

        const grandTotal =
            Math.max(
                0,
                subtotal - discount
            );


        subtotalElement.textContent =
            money(subtotal);


        grandTotalElement.textContent =
            money(grandTotal);


        updateChange();


        checkoutBtn.disabled =
            checkoutInProgress ||
            !selectedCounterId ||
            items.length === 0;

    }


    /* ================================================================
       CHANGE QUANTITY
    ================================================================= */

    function changeQuantity(
        foodId,
        amount
    ) {

        const item =
            cart[foodId];


        if (!item) {
            return;
        }


        const max =
            Number(
                item.food.quantity
            );


        item.qty =
            Math.max(
                0,
                Math.min(
                    max,
                    item.qty + amount
                )
            );


        if (item.qty <= 0) {

            delete cart[foodId];

        }


        renderCart();

    }


    /* ================================================================
       CLEAR CART
    ================================================================= */

    document
        .getElementById('clearCart')
        .addEventListener(
            'click',
            function () {

                if (
                    checkoutInProgress
                ) {
                    return;
                }


                cart = {};


                renderCart();


                setMessage('');

            }
        );


    /* ================================================================
       SEARCH
    ================================================================= */

    foodSearch.addEventListener(
        'input',
        function () {

            renderFoods();

        }
    );


    /* ================================================================
       DISCOUNT
    ================================================================= */

    discountInput.addEventListener(
        'input',
        function () {

            renderCart();

        }
    );


    /* ================================================================
       PAYMENT
    ================================================================= */

    paymentMethod.addEventListener(
        'change',
        function () {

            const isCash =
                this.value === 'cash';


            cashBox.style.display =
                isCash
                    ? 'block'
                    : 'none';


            if (!isCash) {

                cashReceived.value =
                    '';

            }


            updateChange();

        }
    );


    cashReceived.addEventListener(
        'input',
        updateChange
    );


    function updateChange() {

        const grandTotal =
            getGrandTotal();


        const cash =
            Number(
                cashReceived.value || 0
            );


        if (
            paymentMethod.value !==
            'cash'
        ) {

            changeElement.textContent =
                money(0);

            changeElement.className =
                'small text-muted';

            return;

        }


        if (cash < grandTotal) {

            const needed =
                grandTotal - cash;


            changeElement.textContent =
                'Need ' + money(needed);

            changeElement.className =
                'small text-danger';

        } else {

            const change =
                cash - grandTotal;


            changeElement.textContent =
                money(change);

            changeElement.className =
                'small text-success';

        }

    }


    /* ================================================================
       CHECKOUT
    ================================================================= */

    checkoutBtn.addEventListener(
        'click',
        async function () {

            if (checkoutInProgress) {
                return;
            }


            if (!selectedCounterId) {

                alert(
                    'Please select a counter first.'
                );

                return;
            }


            const items =
                Object.values(cart)
                    .filter(item =>
                        item.qty > 0
                    );


            if (!items.length) {

                alert(
                    'Please add at least one food.'
                );

                return;
            }


            const method =
                paymentMethod.value;


            const grandTotal =
                getGrandTotal();


            const cash =
                Number(
                    cashReceived.value || 0
                );


            /*
            ------------------------------------------------------------
            Client-side convenience check.
            Server still performs the real validation.
            ------------------------------------------------------------
            */

            if (
                method === 'cash' &&
                cash < grandTotal
            ) {

                setMessage(
                    'Cash received is less than the grand total.'
                );

                return;
            }


            const body = {

                counter_id:
                    Number(
                        selectedCounterId
                    ),

                items:
                    items.map(item => ({
                        food_id:
                            Number(
                                item.food.id
                            ),

                        quantity:
                            Number(
                                item.qty
                            )
                    })),

                order_type:
                    document.getElementById(
                        'orderType'
                    ).value,

                payment_method:
                    method,

                discount:
                    Number(
                        discountInput.value || 0
                    ),

                cash_received:
                    method === 'cash'
                        ? cash
                        : 0
            };


            checkoutInProgress =
                true;


            checkoutBtn.disabled =
                true;


            checkoutBtn.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm me-2"
                ></span>
                Processing...
            `;


            setMessage('');


            try {

                const response =
                    await fetch(
                        @json(route('cashier.orders.store')),
                        {
                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        ?.getAttribute(
                                            'content'
                                        )
                                        ||
                                    @json(csrf_token())
                            },

                            body:
                                JSON.stringify(body)
                        }
                    );


                const data =
                    await response.json();


                if (
                    !response.ok ||
                    !data.success
                ) {

                    throw new Error(
                        data.message ||
                        'Unable to create the bill.'
                    );

                }


                /*
                --------------------------------------------------------
                SUCCESS
                --------------------------------------------------------
                */

                lastReceiptUrl =
                    data.receipt_url;

                lastKotUrl =
                    data.kot_url;


                /*
                --------------------------------------------------------
                Update local stock
                --------------------------------------------------------
                */

                const counter =
                    getSelectedCounter();


                if (counter) {

                    data.items.forEach(
                        soldItem => {

                            const food =
                                counter.foods.find(
                                    food =>
                                        Number(food.id) ===
                                        Number(
                                            soldItem.food_id
                                        )
                                );


                            if (food) {

                                food.quantity =
                                    Math.max(
                                        0,
                                        Number(
                                            food.quantity
                                        ) -
                                        Number(
                                            soldItem.quantity
                                        )
                                    );

                            }

                        }
                    );

                }


                /*
                --------------------------------------------------------
                Clear current bill
                --------------------------------------------------------
                */

                cart = {};

                discountInput.value =
                    '0';

                cashReceived.value =
                    '';


                renderCart();

                renderFoods();


                /*
                --------------------------------------------------------
                Success text
                --------------------------------------------------------
                */

                document.getElementById(
                    'successSummary'
                ).textContent =
                    `Token ${data.token} • ` +
                    `Counter ${data.counter} • ` +
                    `Queue ${data.queue_number}`;


                /*
                --------------------------------------------------------
                Receipt preview
                --------------------------------------------------------
                */

                const preview =
                    document.getElementById(
                        'receiptPreview'
                    );


                preview.innerHTML = '';


                const title =
                    document.createElement(
                        'div'
                    );

                title.className =
                    'fw-bold mb-2';

                title.textContent =
                    'Hela Bojun';


                preview.appendChild(
                    title
                );


                const counterLine =
                    document.createElement(
                        'div'
                    );

                counterLine.textContent =
                    `Counter: ${data.counter}`;

                preview.appendChild(
                    counterLine
                );


                const tokenLine =
                    document.createElement(
                        'div'
                    );

                tokenLine.textContent =
                    `Token: ${data.token}`;

                preview.appendChild(
                    tokenLine
                );


                const hr1 =
                    document.createElement(
                        'hr'
                    );

                preview.appendChild(
                    hr1
                );


                data.items.forEach(
                    item => {

                        const line =
                            document.createElement(
                                'div'
                            );

                        line.className =
                            'd-flex justify-content-between';


                        const left =
                            document.createElement(
                                'span'
                            );

                        left.textContent =
                            `${item.name} ×${item.quantity}`;


                        const right =
                            document.createElement(
                                'span'
                            );

                        right.textContent =
                            money(
                                item.subtotal
                            );


                        line.appendChild(
                            left
                        );

                        line.appendChild(
                            right
                        );


                        preview.appendChild(
                            line
                        );

                    }
                );


                const hr2 =
                    document.createElement(
                        'hr'
                    );

                preview.appendChild(
                    hr2
                );


                const subtotalLine =
                    document.createElement(
                        'div'
                    );

                subtotalLine.className =
                    'd-flex justify-content-between';

                subtotalLine.innerHTML =
                    '<span>Subtotal</span>';


                const subtotalValue =
                    document.createElement(
                        'strong'
                    );

                subtotalValue.textContent =
                    money(
                        data.subtotal
                    );

                subtotalLine.appendChild(
                    subtotalValue
                );

                preview.appendChild(
                    subtotalLine
                );


                const discountLine =
                    document.createElement(
                        'div'
                    );

                discountLine.className =
                    'd-flex justify-content-between';

                discountLine.innerHTML =
                    '<span>Discount</span>';


                const discountValue =
                    document.createElement(
                        'span'
                    );

                discountValue.textContent =
                    money(
                        data.discount
                    );

                discountLine.appendChild(
                    discountValue
                );

                preview.appendChild(
                    discountLine
                );


                const grandLine =
                    document.createElement(
                        'div'
                    );

                grandLine.className =
                    'd-flex justify-content-between mt-1';

                grandLine.innerHTML =
                    '<strong>Grand Total</strong>';


                const grandValue =
                    document.createElement(
                        'strong'
                    );

                grandValue.textContent =
                    money(
                        data.grand_total
                    );

                grandLine.appendChild(
                    grandValue
                );

                preview.appendChild(
                    grandLine
                );


                if (
                    data.payment_method ===
                    'cash'
                ) {

                    const cashLine =
                        document.createElement(
                            'div'
                        );

                    cashLine.className =
                        'd-flex justify-content-between mt-2';


                    cashLine.innerHTML =
                        '<span>Cash</span>';


                    const cashValue =
                        document.createElement(
                            'span'
                        );

                    cashValue.textContent =
                        money(
                            data.cash_received
                        );

                    cashLine.appendChild(
                        cashValue
                    );

                    preview.appendChild(
                        cashLine
                    );


                    const changeLine =
                        document.createElement(
                            'div'
                        );

                    changeLine.className =
                        'd-flex justify-content-between';


                    changeLine.innerHTML =
                        '<span>Change</span>';


                    const changeValue =
                        document.createElement(
                            'strong'
                        );

                    changeValue.textContent =
                        money(
                            data.change
                        );

                    changeLine.appendChild(
                        changeValue
                    );

                    preview.appendChild(
                        changeLine
                    );

                }


                /*
                --------------------------------------------------------
                Show success modal
                --------------------------------------------------------
                */

                const modalElement =
                    document.getElementById(
                        'orderSuccessModal'
                    );


                const modal =
                    bootstrap.Modal.getOrCreateInstance(
                        modalElement
                    );


                modal.show();


                setMessage('');


            } catch (error) {

                setMessage(
                    error.message ||
                    'Checkout failed.'
                );

            } finally {

                checkoutInProgress =
                    false;


                checkoutBtn.disabled =
                    !selectedCounterId ||
                    Object.keys(cart).length === 0;


                checkoutBtn.innerHTML = `
                    <i class="fa fa-check-circle me-2"></i>
                    PAY & CREATE ONE BILL
                `;

            }

        }
    );


    /* ================================================================
       PRINT RECEIPT
    ================================================================= */

    document
        .getElementById('printReceiptBtn')
        .addEventListener(
            'click',
            function () {

                if (!lastReceiptUrl) {
                    return;
                }


                window.open(
                    lastReceiptUrl,
                    '_blank'
                );

            }
        );


    /* ================================================================
       PRINT KOT
    ================================================================= */

    document
        .getElementById('printKotBtn')
        .addEventListener(
            'click',
            function () {

                if (!lastKotUrl) {
                    return;
                }


                window.open(
                    lastKotUrl,
                    '_blank'
                );

            }
        );


    /* ================================================================
       INITIAL STATE
    ================================================================= */

    cashBox.style.display =
        paymentMethod.value === 'cash'
            ? 'block'
            : 'none';


    renderCart();

})();

</script>

@endpush