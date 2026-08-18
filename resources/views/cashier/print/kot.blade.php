<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>
        KOT - {{ $order->token_number }}
    </title>

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
            border-top: 2px dashed #000;
            margin: 10px 0;
        }

        .item {
            margin-bottom: 10px;
        }

        .qty {
            font-size: 20px;
            font-weight: bold;
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

    <h2>KITCHEN ORDER</h2>

    <strong>
        KOT
    </strong>

</div>

<div class="line"></div>

<div>

    <strong>
        TOKEN:
        {{ $order->token_number }}
    </strong>

    <br>

    Counter:
    {{ $order->counter?->counter_number ?? '-' }}

    <br>

    Order:
    {{ ucfirst(
        str_replace(
            '_',
            ' ',
            $order->order_type
        )
    ) }}

</div>

<div class="line"></div>

@foreach($order->orderItems as $item)

    <div class="item">

        <div>

            <strong>
                {{ $item->food?->food_name }}
            </strong>

        </div>

        <div class="qty">

            QTY:
            {{ $item->quantity }}

        </div>

    </div>

@endforeach

<div class="line"></div>

<div class="center">

    <button onclick="window.print()">
        Print KOT
    </button>

</div>

</body>
</html>