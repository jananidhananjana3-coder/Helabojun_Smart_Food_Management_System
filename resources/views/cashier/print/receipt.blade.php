<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>Receipt - {{ $order->token_number }}</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            width: 300px;
            margin: auto;
            padding: 15px;
        }

        .center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        h2 {
            margin-bottom: 5px;
        }

        @media print {

            body {
                width: 300px;
            }

            button {
                display: none;
            }
        }

    </style>

</head>

<body>

<div class="center">

    <h2>HELA BOJUN</h2>

    <div>
        {{ $order->outlet?->outlet_name ?? '' }}
    </div>

</div>

<div class="line"></div>

<div>
    <div>Date / Time: {{ $order->created_at?->format("Y-m-d H:i") }}</div>
    <div>Order ID: {{ $order->id }}</div>
    <div>
        Token:
        <strong>{{ $order->token_number }}</strong>
    </div>

    <div>
        Counter:
        {{ $order->counter?->counter_number ?? '-' }}
    </div>

    <div>
        Order Type:
        {{ ucfirst(str_replace('_', ' ', $order->order_type)) }}
    </div>

    <div>
        Cashier:
        {{ $order->user?->name ?? '-' }}
    </div>

</div>

<div class="line"></div>

@foreach($order->orderItems as $item)

    <div class="row">

        <span>
            {{ $item->food?->food_name }}
            x{{ $item->quantity }}
        </span>

        <span>
            Rs.
            {{ number_format(
                $item->price * $item->quantity,
                2
            ) }}
        </span>

    </div>

@endforeach

<div class="line"></div>

<div class="row"><span>Subtotal</span><span>Rs. {{ number_format($order->total_amount,2) }}</span></div>
<div class="row"><span>Discount</span><span>Rs. {{ number_format($order->discount,2) }}</span></div>
<div class="row">

    <strong>Grand Total</strong>

    <strong>
        Rs.
        {{ number_format(
            $order->grand_total,
            2
        ) }}
    </strong>

</div>

<div class="row">

    <span>Payment</span>

    <span>
        {{ ucfirst($order->payment_method) }}
    </span>

</div>

@if($order->payment_method === 'cash')

<div class="row">

    <span>Cash</span>

    <span>
        Rs.
        {{ number_format(
            $order->cash_received,
            2
        ) }}
    </span>

</div>

<div class="row">

    <span>Change</span>

    <span>
        Rs.
        {{ number_format(
            $order->change_amount,
            2
        ) }}
    </span>

</div>

@endif

<div class="line"></div>

<div class="center">

    <p>Thank You!</p>

    <button onclick="window.print()">
        Print
    </button>

</div>

</body>
</html>