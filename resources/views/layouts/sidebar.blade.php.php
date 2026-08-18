<div class="sidebar">

    <div class="sidebar-logo">

        <img src="{{ asset('images/hela-bojun-logo.png') }}"
             alt="Hela Bojun Logo">

        <div>
            <h4>Hela Bojun</h4>
            <small>Smart Food Management</small>
        </div>

    </div>

    <hr>

    <a href="/admin-dashboard">
        <i class="fa fa-home"></i>
        <span>{{ __('messages.dashboard') }}</span>
    </a>

    <a href="{{ route('users.index') }}">
        <i class="fa fa-users"></i>
        <span>{{ __('messages.staff_management') }}</span>
    </a>

    <a href="{{ route('outlets.index') }}">
        <i class="fa fa-store"></i>
        <span>{{ __('messages.outlets') }}</span>
    </a>

    <a href="{{ route('foods.index') }}">
        <i class="fa fa-utensils"></i>
        <span>{{ __('messages.foods') }}</span>
    </a>

    <a href="#">
        <i class="fa fa-box"></i>
        <span>{{ __('messages.inventory') }}</span>
    </a>

    <a href="#">
        <i class="fa fa-chart-line"></i>
        <span>{{ __('messages.reports') }}</span>
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit" class="logout-btn">
            <i class="fa fa-sign-out-alt"></i>
            <span>{{ __('messages.logout') }}</span>
        </button>

    </form>

</div>