<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KOT - {{ $order->token_number }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            background: #fff;
            color: #000;
            font-family: Arial, Helvetica, sans-serif;
        }

        .kot {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        .title {
            text-align: center;
            font-size: 26px;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .subtitle {
            text-align: center;
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .line {
            border-top: 2px dashed #000;
            margin: 12px 0;
        }

        .order-info {
            font-size: 17px;
            font-weight: 700;
            line-height: 1.7;
        }

        .item {
            padding: 14px 0;
            border-bottom: 1px dashed #000;
        }

        .counter {
            font-size: 17px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .food-name {
            font-size: 21px;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .quantity {
            font-size: 18px;
            font-weight: 800;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            font-weight: 700;
        }

        .print-btn {
            display: block;
            margin: 20px auto 0;
            padding: 10px 22px;
            border: 0;
            border-radius: 6px;
            background: #000;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        @media print {

            body {
                padding: 0;
            }

            .kot {
                max-width: 100%;
            }

            .print-btn {
                display: none;
            }
        }
    </style>

</head>

<body>

<div class="kot">

    <div class="title">
        KITCHEN ORDER
    </div>

    <div class="subtitle">
        KOT
    </div>

    <div class="line"></div>

    <div class="order-info">

        <div>
            TOKEN:
            {{ $order->token_number }}
        </div>

        <div>
            Order:
            {{ $order->order_type === 'take_away' ? 'Take Away' : 'Dine in' }}
        </div>

    </div>

    <div class="line"></div>

    @foreach($order->orderItems as $item)

        <div class="item">

            <div class="counter">
                Counter
                {{ $item->counter?->counter_number ?? '-' }}
            </div>

            <div class="food-name">
                {{ $item->food?->food_name ?? 'Food' }}
            </div>

            <div class="quantity">
                QTY:
                {{ $item->quantity }}
            </div>

        </div>

    @endforeach

    <div class="footer">
        {{ now()->format('Y-m-d H:i') }}
    </div>

    <button
        type="button"
        class="print-btn"
        onclick="window.print()"
    >
        Print KOT
    </button>

</div>

<script>
    window.onload = function () {
        window.print();
    };
</script>

</body>

</html>