<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Hela Bojun Customer Display
    </title>


    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <style>

        body {
            background: #fff7d6;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }


        /* HEADER */

        .header {
            background: #075e3b;
            color: white;
            padding: 12px 15px;
        }


        .brand-area {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }


        .logo {
            width: 75px;
            height: 75px;
            object-fit: contain;
        }


        .brand-name {
            font-size: 30px;
            font-weight: 700;
            line-height: 1.1;
        }


        .header small {
            font-size: 14px;
        }


        .container {
            padding: 5px 10px;
        }


        /* CATEGORY */

        .category-title {
            background: #075e3b;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 17px;
            margin: 5px 0;
        }


        /* FOOD CARD */

        .food-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }


        .food-image {
            width: 100%;
            height: 95px;
            object-fit: cover;
        }


        .food-body {
            padding: 5px;
            text-align: center;
        }


        .food-name {
            font-size: 14px;
            font-weight: 700;
            color: #075e3b;
            line-height: 1.1;
        }


        .food-price {
            font-size: 13px;
            font-weight: bold;
            color: #d97706;
        }


        .mb-3 {
            margin-bottom: 8px !important;
        }


        /* SUB CATEGORY */

        .sub-category-title {
            color: #075e3b;
            font-weight: 700;
            font-size: 16px;
            margin: 12px 0;
        }


        /* REAL-TIME STATUS */

        .realtime-status {
            position: fixed;
            right: 15px;
            bottom: 15px;
            background: #075e3b;
            color: white;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            z-index: 9999;
        }

    </style>

</head>


<body>


    <!-- HEADER -->

    <div class="header">

        <div class="brand-area">

            <img
                src="{{ asset('images/hela-bojun-logo.png') }}"
                class="logo"
            >


            <div>

                <div class="brand-name">
                    Hela Bojun
                </div>


                <small>
                    Authentic Sri Lankan Traditional Food Experience
                </small>

            </div>

        </div>

    </div>


    <!-- FOOD CONTENT -->

    <div class="container">


        @foreach($categories as $categoryName => $foods)


            <!-- CATEGORY TITLE -->

            <div class="text-center">

                <span class="category-title">
                    {{ $categoryName }}
                </span>

            </div>


            <!-- BEVERAGES -->

            @if($categoryName == 'Beverages')


                @php

                    $beverageGroups = $foods->groupBy('sub_category');

                @endphp


                @foreach($beverageGroups as $subCategory => $items)


                    <!-- SUB CATEGORY -->

                    <div class="text-center">

                        <span class="sub-category-title">
                            {{ $subCategory }}
                        </span>

                    </div>


                    <div class="row">


                        @foreach($items as $food)


                            <div class="col-6 col-md-3 col-lg-2 mb-3">


                                <div class="card food-card">


                                    @if($food->image)

                                        <img
                                            src="{{ asset('storage/'.$food->image) }}"
                                            class="food-image"
                                        >

                                    @else

                                        <img
                                            src="https://via.placeholder.com/300"
                                            class="food-image"
                                        >

                                    @endif


                                    <div class="food-body">


                                        <div class="food-name">
                                            {{ $food->food_name }}
                                        </div>


                                        <div class="food-price">
                                            Rs.
                                            {{ number_format($food->price, 2) }}
                                        </div>


                                    </div>

                                </div>


                            </div>


                        @endforeach


                    </div>


                @endforeach


            <!-- OTHER CATEGORIES -->

            @else


                <div class="row">


                    @foreach($foods as $food)


                        <div class="col-6 col-md-3 col-lg-2 mb-3">


                            <div class="card food-card">


                                @if($food->image)

                                    <img
                                        src="{{ asset('storage/'.$food->image) }}"
                                        class="food-image"
                                    >

                                @else

                                    <img
                                        src="https://via.placeholder.com/300"
                                        class="food-image"
                                    >

                                @endif


                                <div class="food-body">


                                    <div class="food-name">
                                        {{ $food->food_name }}
                                    </div>


                                    <div class="food-price">
                                        Rs.
                                        {{ number_format($food->price, 2) }}
                                    </div>


                                </div>

                            </div>


                        </div>


                    @endforeach


                </div>


            @endif


        @endforeach


    </div>


    <!-- REAL-TIME STATUS -->

    <div
        class="realtime-status"
        id="realtimeStatus"
    >
        Connecting...
    </div>


    <!-- PUSHER JS -->

    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>


    <script>

        /*
        |--------------------------------------------------------------------------
        | Hela Bojun Customer Display - Real-Time WebSocket
        |--------------------------------------------------------------------------
        */


        @if(env('REVERB_APP_KEY'))


            const pusher = new Pusher(
                @json(env('REVERB_APP_KEY')),
                {

                    wsHost: @json(
                        env('REVERB_HOST', '127.0.0.1')
                    ),

                    wsPort: Number(
                        @json(env('REVERB_PORT', 8080))
                    ),

                    wssPort: Number(
                        @json(env('REVERB_PORT', 8080))
                    ),

                    forceTLS:
                        @json(
                            env('REVERB_SCHEME', 'http') === 'https'
                        ),

                    enabledTransports: [
                        'ws',
                        'wss'
                    ],

                    disableStats: true

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Subscribe to Inventory Channel
            |--------------------------------------------------------------------------
            */

            const inventoryChannel =
                pusher.subscribe('inventory');


            /*
            |--------------------------------------------------------------------------
            | Inventory Updated Event
            |--------------------------------------------------------------------------
            */

            inventoryChannel.bind(
                'food.inventory.updated',
                function (data) {

                    console.log(
                        'Food inventory updated:',
                        data
                    );


                    document.getElementById(
                        'realtimeStatus'
                    ).textContent = 'Updating...';


                    /*
                    |--------------------------------------------------------------------------
                    | Reload Customer Display
                    |--------------------------------------------------------------------------
                    |
                    | This keeps your existing category + beverage
                    | sub-category Blade design unchanged.
                    |
                    */

                    setTimeout(function () {

                        window.location.reload();

                    }, 300);

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Connected
            |--------------------------------------------------------------------------
            */

            pusher.connection.bind(
                'connected',
                function () {

                    document.getElementById(
                        'realtimeStatus'
                    ).textContent = '● LIVE';

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Connection Error
            |--------------------------------------------------------------------------
            */

            pusher.connection.bind(
                'error',
                function (error) {

                    console.error(
                        'WebSocket error:',
                        error
                    );


                    document.getElementById(
                        'realtimeStatus'
                    ).textContent = 'Offline';

                }
            );


        @else


            document.getElementById(
                'realtimeStatus'
            ).textContent = 'WebSocket not configured';


        @endif


    </script>


</body>

</html>