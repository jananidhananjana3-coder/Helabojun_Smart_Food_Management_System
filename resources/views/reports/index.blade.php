@extends('layouts.admin')

@section('title', 'Reports | Hela Bojun')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <h2 class="title">
                Sales Reports
            </h2>

            <div class="text-muted">
                Daily, weekly, chef, counter and payment breakdown
            </div>

        </div>

        <button
            onclick="window.print()"
            class="btn btn-outline-dark"
        >
            <i class="fa fa-print"></i>
            Print
        </button>

    </div>


    {{-- Filters --}}
    <form class="card-box">

        <div class="row g-2">

            <div class="col-md-2">

                <label class="form-label">
                    From
                </label>

                <input
                    type="date"
                    name="from"
                    class="form-control"
                    value="{{ $from }}"
                >

            </div>


            <div class="col-md-2">

                <label class="form-label">
                    To
                </label>

                <input
                    type="date"
                    name="to"
                    class="form-control"
                    value="{{ $to }}"
                >

            </div>


            <div class="col-md-2">

                <label class="form-label">
                    Outlet
                </label>

                <select
                    name="outlet_id"
                    class="form-select"
                >

                    <option value="">
                        All
                    </option>

                    @foreach($outlets as $o)

                        <option
                            value="{{ $o->id }}"
                            @selected(request('outlet_id') == $o->id)
                        >
                            {{ $o->outlet_name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="col-md-2">

                <label class="form-label">
                    Counter
                </label>

                <select
                    name="counter_id"
                    class="form-select"
                >

                    <option value="">
                        All
                    </option>

                    @foreach($counters as $c)

                        <option
                            value="{{ $c->id }}"
                            @selected(request('counter_id') == $c->id)
                        >
                            #{{ $c->counter_number }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="col-md-2">

                <label class="form-label">
                    Chef
                </label>

                <select
                    name="chef_id"
                    class="form-select"
                >

                    <option value="">
                        All
                    </option>

                    @foreach($chefs as $c)

                        <option
                            value="{{ $c->id }}"
                            @selected(request('chef_id') == $c->id)
                        >
                            {{ $c->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="col-md-2">

                <label class="form-label">
                    Payment
                </label>

                <select
                    name="payment_method"
                    class="form-select"
                >

                    <option value="">
                        All
                    </option>

                    @foreach(['cash', 'card', 'qr'] as $m)

                        <option
                            value="{{ $m }}"
                            @selected(request('payment_method') === $m)
                        >
                            {{ strtoupper($m) }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="col-12 mt-3">

                <button class="btn btn-success">

                    <i class="fa fa-filter"></i>
                    Apply Filters

                </button>

            </div>

        </div>

    </form>


    {{-- Summary --}}
    <div class="row g-3 mb-3">

        <div class="col-md-3">

            <div class="card-box">

                <div class="text-muted">
                    Total Sales
                </div>

                <h3>
                    Rs. {{ number_format($sales, 2) }}
                </h3>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card-box">

                <div class="text-muted">
                    Cash
                </div>

                <h3>
                    Rs. {{ number_format($cash, 2) }}
                </h3>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card-box">

                <div class="text-muted">
                    Card
                </div>

                <h3>
                    Rs. {{ number_format($card, 2) }}
                </h3>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card-box">

                <div class="text-muted">
                    QR
                </div>

                <h3>
                    Rs. {{ number_format($qr, 2) }}
                </h3>

            </div>

        </div>

    </div>


    {{-- Reports --}}
    <div class="row g-3">

        <div class="col-lg-8">

            <div class="card-box">

                <h5 class="section-title">
                    Orders
                </h5>


                <div class="table-responsive">

                    <table class="table table-sm">

                        <thead>

                            <tr>

                                <th>Token</th>

                                <th>Date</th>

                                <th>Outlet</th>

                                <th>Counter</th>

                                <th>Chef</th>

                                <th>Payment</th>

                                <th class="text-end">
                                    Total
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($orders as $o)

                                <tr>

                                    <td>
                                        {{ $o->token_number }}
                                    </td>

                                    <td>
                                        {{ $o->created_at->format('Y-m-d H:i') }}
                                    </td>

                                    <td>
                                        {{ $o->outlet?->outlet_name }}
                                    </td>

                                    <td>
                                        {{ $o->counter?->counter_number }}
                                    </td>

                                    <td>
                                        {{ $o->kitchenTicket?->chef?->name ?? '—' }}
                                    </td>

                                    <td>
                                        {{ strtoupper($o->payment_method) }}
                                    </td>

                                    <td class="text-end">
                                        Rs. {{ number_format($o->grand_total, 2) }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center"
                                    >
                                        No sales found.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            <div class="card-box">

                <h5 class="section-title">
                    Food-wise Sales
                </h5>


                @forelse($foodSales as $name => $amount)

                    <div
                        class="d-flex justify-content-between border-bottom py-2"
                    >

                        <span>
                            {{ $name }}
                        </span>

                        <strong>
                            Rs. {{ number_format($amount, 2) }}
                        </strong>

                    </div>

                @empty

                    <div class="text-muted">
                        No data.
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection