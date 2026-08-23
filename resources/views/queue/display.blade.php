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
            padding: 25px 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
            min-height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .token-label {
            font-size: 13px;
            font-weight: 800;
            color: #777;
            letter-spacing: 1.5px;
        }

        .token {
            font-size: 58px;
            font-weight: 900;
            line-height: 1;
            margin: 12px 0 18px;
        }

        .status {
            display: inline-block;
            padding: 7px 18px;
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
                font-size: 68px;
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
                font-size: 45px;
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

        @forelse($orders as $queue)

            <div
                class="col-6 col-md-4 col-lg-3 col-xl-2"
                data-queue-id="{{ $queue->id }}"
            >

                <div class="token-card">

                    <div class="token-label">
                        TOKEN
                    </div>

                    <div class="token">
                        {{ $queue->order?->token_number ?? '—' }}
                    </div>

                    <span class="status ready">
                        READY
                    </span>

                </div>

            </div>

        @empty

            <div class="col-12 empty">

                <h2>
                    No orders ready
                </h2>

            </div>

        @endforelse

    </div>

</main>

@vite(['resources/js/app.js'])

<script>

    // Clock

    function updateClock()
    {
        const clock =
            document.getElementById('clock');

        if (!clock) {
            return;
        }

        clock.textContent =
            new Date().toLocaleTimeString();
    }

    updateClock();

    setInterval(
        updateClock,
        1000
    );


    // Queue refresh

    async function refreshQueue()
    {
        try {

            const response = await fetch(
                '{{ route('queue.display.data') }}',
                {
                    method: 'GET',

                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },

                    cache: 'no-store'
                }
            );

            if (!response.ok) {

                console.error(
                    'Queue API error:',
                    response.status
                );

                return;
            }

            const data =
                await response.json();

            const queueGrid =
                document.getElementById('queueGrid');

            if (!queueGrid) {
                return;
            }

            if (
                !data.orders ||
                data.orders.length === 0
            ) {

                queueGrid.innerHTML = `
                    <div class="col-12 empty">

                        <h2>
                            No orders ready
                        </h2>

                    </div>
                `;

                return;
            }

            queueGrid.innerHTML =
                data.orders.map(function(order)
                {

                    return `

                        <div
                            class="col-6 col-md-4 col-lg-3 col-xl-2"
                            data-queue-id="${order.queue_display_id}"
                        >

                            <div class="token-card">

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

                }).join('');

        }

        catch (error)
        {

            console.error(
                'Queue refresh error:',
                error
            );

        }
    }


    // WebSocket

    function connectQueueWebSocket()
    {

        if (!window.Echo)
        {

            console.warn(
                'Laravel Echo is not available.'
            );

            return;
        }

        console.log(
            'Connecting to Queue WebSocket...'
        );

        window.Echo
            .channel('helabojun.queue')
            .listen(
                '.kitchen.ticket.updated',
                function(event)
                {

                    console.log(
                        'QUEUE UPDATE RECEIVED:',
                        event
                    );

                    refreshQueue();

                }
            );

        console.log(
            'Queue WebSocket listener attached.'
        );

    }


    // Page load

    document.addEventListener(
        'DOMContentLoaded',
        function()
        {

            refreshQueue();

            connectQueueWebSocket();

            setInterval(
                refreshQueue,
                2000
            );

        }
    );

</script>

</body>

</html>