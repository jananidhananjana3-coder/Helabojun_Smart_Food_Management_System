@extends('layouts.admin')

@section('title', 'Admin Dashboard')


@push('styles')

<style>

    .card-box {

        background: white;

        padding: 25px;

        border-radius: 15px;

        box-shadow: 0 5px 15px #ddd;

        margin-bottom: 20px;

    }


    .icon {

        font-size: 35px;

        color: #075e3b;

    }


    .calendar-box {

        background: white;

        padding: 20px;

        border-radius: 15px;

        box-shadow: 0 5px 15px #ddd;

    }


    .calendar-box input {

        width: 100%;

        padding: 10px;

        border-radius: 8px;

        border: 1px solid #ddd;

    }

</style>

@endpush


@section('content')


<!-- WELCOME -->

<h2>

    {{ __('messages.welcome_admin') }} 👋

</h2>


<p>

    {{ __('messages.system_name') }}

</p>


<!-- =====================================================
     STAT CARDS
===================================================== -->

<div class="row mt-4">


    <!-- STAFF -->

    <div class="col-md-3">

        <div class="card-box">

            <i class="fa fa-users icon"></i>

            <h6 class="mt-3">

                {{ __('messages.total_staff') }}

            </h6>

            <h2>

                {{ $totalStaff }}

            </h2>

        </div>

    </div>


    <!-- ORDERS -->

    <div class="col-md-3">

        <div class="card-box">

            <i class="fa fa-shopping-cart icon"></i>

            <h6 class="mt-3">

                {{ __('messages.today_orders') }}

            </h6>

            <h2>

                {{ $todayOrders }}

            </h2>

        </div>

    </div>


    <!-- SALES -->

    <div class="col-md-3">

        <div class="card-box">

            <i class="fa fa-money-bill icon"></i>

            <h6 class="mt-3">

                {{ __('messages.today_sales') }}

            </h6>

            <h2>

                Rs {{ number_format($todaySales, 2) }}

            </h2>

        </div>

    </div>


    <!-- OUTLETS -->

    <div class="col-md-3">

        <div class="card-box">

            <i class="fa fa-store icon"></i>

            <h6 class="mt-3">

                {{ __('messages.outlets') }}

            </h6>

            <h2>

                {{ $totalOutlets }}

            </h2>

        </div>

    </div>


</div>


<!-- =====================================================
     CHART + STATUS
===================================================== -->

<div class="row mt-4">


    <div class="col-md-8">

        <div class="card-box">

            <h4>

                {{ __('messages.sales_analysis') }}

            </h4>

            <canvas id="salesChart"></canvas>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card-box">

            <h4>

                {{ __('messages.order_status') }}

            </h4>


            <p>

                {{ __('messages.pending') }} :

                {{ $pendingOrders }}

            </p>


            <p>

                {{ __('messages.completed') }} :

                {{ $completedOrders }}

            </p>


            <p>

                {{ __('messages.foods') }} :

                {{ $totalFoods }}

            </p>

        </div>


        <div class="calendar-box">

            <h4>

                <i class="fa fa-calendar"></i>

                {{ __('messages.calendar') }}

            </h4>


            <input type="date"
                   class="form-control"
                   value="{{ date('Y-m-d') }}">

        </div>

    </div>


</div>


<!-- =====================================================
     RECENT ORDERS
===================================================== -->

<div class="card-box mt-4">


    <h4>

        {{ __('messages.recent_orders') }}

    </h4>


    <table class="table table-hover mt-3">

        <thead>

        <tr>

            <th>
                {{ __('messages.order') }}
            </th>

            <th>
                {{ __('messages.amount') }}
            </th>

            <th>
                {{ __('messages.status') }}
            </th>

        </tr>

        </thead>


        <tbody>

        @forelse($recentOrders as $order)

            <tr>

                <td>

                    #{{ $order->id }}

                </td>


                <td>

                    Rs {{ $order->total_amount }}

                </td>


                <td>

                    {{ $order->status }}

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="3"
                    class="text-center">

                    No Recent Orders

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>


</div>


@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

new Chart(

    document.getElementById('salesChart'),

    {

        type: 'line',

        data: {

            labels: [

                'Mon',
                'Tue',
                'Wed',
                'Thu',
                'Fri',
                'Sat',
                'Sun'

            ],

            datasets: [{

                label: 'Sales',

                data: [

                    10000,
                    15000,
                    12000,
                    25000,
                    30000,
                    20000,
                    40000

                ],

                tension: 0.3

            }]

        }

    }

);

</script>

@endpush