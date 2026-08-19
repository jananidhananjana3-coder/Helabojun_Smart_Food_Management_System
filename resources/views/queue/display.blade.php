<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Queue | Hela Bojun</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #063c27;
            color: #fff;
            font-family: Arial, sans-serif;
            min-height: 100vh;
        }

        .head {
            padding: 22px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
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
            margin: 0;
            font-size: 30px;
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
            color: #075e3b;
            border-radius: 20px;
            padding: 20px 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
            min-height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .counter-label {
            font-size: 13px;
            font-weight: 800;
            color: #777;
            letter-spacing: 1.5px;
        }

        .counter-number {
            font-size: 30px;
            font-weight: 900;
            line-height: 1;
            margin-top: 4px;
        }

        .token-label {
            font-size: 12px;
            font-weight: 800;
            color: #777;
            letter-spacing: 1.5px;
            margin-top: 18px;
        }

        .token {
            font-size: 52px;
            font-weight: 900;
            line-height: 1;
            margin: 7px 0 15px;
        }

        .status {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 13px;
        }

        .ready {
            background: #e7f7ed;
            color: #075e3b;
        }

        .empty {
            opacity: .7;
            text-align: center;
            padding: 80px 20px;
        }

        @media (min-width: 1400px) {

            .token-card {
                min-height: 240px;
            }

            .token {
                font-size: 60px;
            }

            .counter-number {
                font-size: 34px;
            }

        }

        @media (max-width: 992px) {

            .head {
                padding: 18px 20px;
            }

            .brand h1 {
                font-size: 25px;
            }

            .clock {
                font-size: 23px;
            }

            .grid {
                padding: 10px 20px 25px;
            }

        }

        @media (max-width: 576px) {

            .head {
                padding: 15px;
            }

            .brand img {
                width: 48px;
                height: 48px;
            }

            .brand h1 {
                font-size: 21px;
            }

            .subtitle {
                font-size: 11px;
            }

            .clock {
                font-size: 17px;
            }

            .grid {
                padding: 10px 12px 20px;
            }

            .token-card {
                min-height: 190px;
            }

            .token {
                font-size: 42px;
            }

            .counter-number {
                font-size: 25px;
            }

        }

    </style>

</head>

<body>

<header class="head">

    <div class="brand">

        <img
            src="{{ asset('images/hela-bojun-logo.png') }}"
            alt="Hela Bojun"
        >

        <div>

            <h1>
                Hela Bojun
            </h1>

            <div class="subtitle">
                Order Ready /
                ආහාර සූදානම් /
                ஆர்டர் தயார்
            </div>

        </div>

    </div>

    <div
        id="clock"
        class="clock"
    ></div>

</header>

<main class="grid">

    <div
        id="queueGrid"
        class="row g-4"
    >

        @include(
            'queue.partials.cards',
            ['orders' => $orders]
        )

    </div>

</main>

@vite(['resources/js/app.js'])

<script>

    function updateClock()
    {
        document.getElementById('clock').textContent =
            new Date().toLocaleTimeString();
    }

    updateClock();

    setInterval(updateClock, 1000);

    if (window.Echo)
    {
        window.Echo
            .channel('helabojun.queue')
            .listen(
                '.kitchen.ticket.updated',
                function ()
                {
                    refreshQueue();
                }
            );
    }

    async function refreshQueue()
    {
        try
        {
            const response =
                await fetch(
                    '{{ route('queue.display.data') }}',
                    {
                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                );

            if (!response.ok)
            {
                return;
            }

            const data =
                await response.json();

            const queueGrid =
                document.getElementById('queueGrid');

            if (
                !data.orders ||
                data.orders.length === 0
            )
            {
                queueGrid.innerHTML = `
                    <div class="col-12 empty">
                        <h2>No orders ready</h2>
                    </div>
                `;

                return;
            }

            queueGrid.innerHTML =
                data.orders.map(
                    function(order)
                    {
                        return `
                            <div class="col-6 col-md-4 col-lg-3 col-xl-2">

                                <div class="token-card">

                                    <div class="counter-label">
                                        COUNTER
                                    </div>

                                    <div class="counter-number">
                                        ${order.counter ?? '—'}
                                    </div>

                                    <div class="token-label">
                                        TOKEN
                                    </div>

                                    <div class="token">
                                        ${order.token ?? '—'}
                                    </div>

                                    <span class="status ready">
                                        READY
                                    </span>

                                </div>

                            </div>
                        `;
                    }
                ).join('');
        }
        catch (error)
        {
            console.error(
                'Queue refresh error:',
                error
            );
        }
    }

</script>

</body>

</html>