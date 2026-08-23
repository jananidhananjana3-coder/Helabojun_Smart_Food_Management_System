<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Receipt - {{ $order->token_number }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            width: 300px;
            margin: 0 auto;
            padding: 15px;
            color: #000;
            font-size: 13px;
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
            gap: 10px;
            margin: 4px 0;
        }

        .item-name {
            max-width: 190px;
            word-wrap: break-word;
        }

        h2 {
            margin: 0 0 5px;
            font-size: 20px;
        }

        .token {
            font-size: 22px;
            font-weight: bold;
            margin: 8px 0;
        }

        .grand-total {
            font-size: 16px;
            margin-top: 7px;
        }

        .footer {
            margin-top: 15px;
        }

        button {
            margin-top: 10px;
            padding: 8px 20px;
            border: none;
            background: #000;
            color: #fff;
            cursor: pointer;
        }

        @media print {
            body {
                width: 300px;
                margin: 0;
                padding: 10px;
            }

            button {
                display: none;
            }
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <div class="center">

        <h2>HELA BOJUN</h2>

        <div>
            {{ $order->outlet?->outlet_name ?? 'Hela Bojun' }}
        </div>

        <div class="token">
            TOKEN: {{ $order->token_number }}
        </div>

    </div>

    <div class="line"></div>

    {{-- Order details --}}
    <div>

        <div>
            Date / Time:
            {{ $order->created_at?->format('Y-m-d H:i') ?? '-' }}
        </div>

        <div>
            Order ID: {{ $order->id }}
        </div>

        <div>
            Order Type:
            {{ ucfirst(str_replace('_', ' ', $order->order_type ?? 'dine_in')) }}
        </div>

        <div>
            Cashier:
            {{ $order->user?->name ?? '-' }}
        </div>

    </div>

    <div class="line"></div>

    {{-- Food items --}}
    @forelse($order->orderItems as $item)

        <div class="row">

            <span class="item-name">

                Counter
                {{
                    $item->counter?->counter_number
                    ?? $item->counter?->counter_name
                    ?? '-'
                }}

                -
                {{ $item->food?->food_name ?? 'Food' }}

                x{{ $item->quantity }}

            </span>

            <span>
                Rs.
                {{ number_format(
                    ($item->price ?? 0) * ($item->quantity ?? 0),
                    2
                ) }}
            </span>

        </div>

    @empty

        <div class="center">
            No items
        </div>

    @endforelse

    <div class="line"></div>

    {{-- Subtotal --}}
    <div class="row">

        <span>Subtotal</span>

        <span>
            Rs. {{ number_format($order->total_amount ?? 0, 2) }}
        </span>

    </div>

    {{-- Discount --}}
    <div class="row">

        <span>Discount</span>

        <span>
            Rs. {{ number_format($order->discount ?? 0, 2) }}
        </span>

    </div>

    {{-- Grand total --}}
    <div class="row grand-total">

        <strong>Grand Total</strong>

        <strong>
            Rs.
            {{ number_format(
                $order->grand_total ?? $order->total_amount ?? 0,
                2
            ) }}
        </strong>

    </div>

    <div class="line"></div>

    {{-- Payment --}}
    <div class="row">

        <span>Payment</span>

        <span>
            {{ ucfirst($order->payment_method ?? 'Cash') }}
        </span>

    </div>

    {{-- Cash details --}}
    @if(($order->payment_method ?? '') === 'cash')

        <div class="row">

            <span>Cash Received</span>

            <span>
                Rs.
                {{ number_format($order->cash_received ?? 0, 2) }}
            </span>

        </div>

        <div class="row">

            <span>Change</span>

            <span>
                Rs.
                {{ number_format($order->change_amount ?? 0, 2) }}
            </span>

        </div>

    @endif

    <div class="line"></div>

    {{-- Footer --}}
    <div class="center footer">

        <p>Thank You!</p>

        <p>Please visit us again.</p>

        <button onclick="window.print()">
            Print Receipt
        </button>

    </div>

</body>

</html>