@forelse($orders as $order)

    <div class="col-6 col-md-4 col-lg-3 col-xl-2">

        <div class="token-card">

            <div class="counter-label">
                COUNTER
            </div>

            <div class="counter-number">
                {{ $order->counter?->counter_number ?? '—' }}
            </div>

            <div class="token-label">
                TOKEN
            </div>

            <div class="token">
                {{ $order->token_number }}
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