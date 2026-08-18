<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hela Bojun Queue Display</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            margin: 0;
            background: #063c27;
            color: #fff;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .head {
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .brand img {
            width: 58px;
            height: 58px;
            background: #fff;
            border-radius: 50%;
            padding: 4px;
            object-fit: contain;
        }

        .brand h1 {
            font-size: 30px;
            margin: 0;
            font-weight: 800;
        }

        .subtitle {
            opacity: .75;
            font-size: 15px;
        }

        .clock {
            font-size: 28px;
            font-weight: 700;
        }

        .grid {
            padding: 10px 30px 30px;
        }

        .token-card {
            background: #fff;
            color: #064d31;
            border-radius: 22px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
            min-height: 220px;
        }

        .token {
            font-size: 68px;
            font-weight: 900;
            line-height: 1;
            margin: 10px 0 15px;
        }

        .ready {
            display: inline-block;
            background: #e7f7ed;
            color: #075e3b;
            border-radius: 999px;
            padding: 6px 14px;
            font-weight: 800;
        }

        .counter-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
            margin-top: 15px;
        }

        .counter {
            background: #075e3b;
            color: #fff;
            padding: 6px 11px;
            border-radius: 8px;
            font-weight: 700;
        }

        .empty {
            opacity: .6;
            text-align: center;
            padding: 80px;
        }

    </style>

</head>

<body>

<header class="head">

    <div class="brand">

        <img src="{{ asset('images/hela-bojun-logo.png') }}">

        <div>

            <h1>Hela Bojun</h1>

            <div class="subtitle">
                Order Ready /
                ආහාර සූදානම් /
                ஆர்டர் தயார்
            </div>

        </div>

    </div>

    <div class="clock" id="clock"></div>

</header>


<div class="grid">

    <div id="queueGrid" class="row g-4">

        @forelse($readyOrders as $order)

            <div class="col-md-4 col-xl-3">

                <div class="token-card">

                    <div class="small fw-bold">
                        TOKEN
                    </div>

                    <div class="token">
                        {{ $order->token_number }}
                    </div>

                    <span class="ready">
                        READY
                    </span>


                    {{-- Counter --}}

                    <div class="counter-list">

                        @if($order->counter)

                            <span class="counter">

                                Counter
                                {{ $order->counter->counter_number }}

                            </span>

                        @else

                            <span class="text-muted">
                                Counter —
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12 empty">

                <i class="fa fa-mug-hot fa-3x mb-3"></i>

                <h2>No orders ready</h2>

            </div>

        @endforelse

    </div>

</div>


{{-- Laravel Echo / Reverb --}}

@vite(['resources/js/app.js'])


<script>

    // Clock

    function updateClock() {

        document.getElementById('clock').textContent =
            new Date().toLocaleTimeString();

    }

    updateClock();

    setInterval(updateClock, 1000);


    // Laravel Echo

    if (window.Echo) {

        window.Echo
            .channel('helabojun.queue')
            .listen('.kitchen.ticket.updated', function (event) {

                location.reload();

            });

    }

</script>

</body>

</html>