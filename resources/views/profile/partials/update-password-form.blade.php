<section>

    <div class="mb-4">

        <h4 class="fw-bold">
            Update Password
        </h4>

        <p class="text-muted mb-0">
            Make sure your account uses a strong password.
        </p>

    </div>


    <form
        method="post"
        action="{{ route('password.update') }}"
    >

        @csrf

        @method('put')


        {{-- Current Password --}}

        <div class="mb-3">

            <label
                for="update_password_current_password"
                class="form-label fw-semibold"
            >
                Current Password
            </label>

            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="form-control"
                autocomplete="current-password"
            >

            @error('current_password', 'updatePassword')

                <div class="text-danger small mt-1">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- New Password --}}

        <div class="mb-3">

            <label
                for="update_password_password"
                class="form-label fw-semibold"
            >
                New Password
            </label>

            <input
                id="update_password_password"
                name="password"
                type="password"
                class="form-control"
                autocomplete="new-password"
            >

            @error('password', 'updatePassword')

                <div class="text-danger small mt-1">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Confirm Password --}}

        <div class="mb-3">

            <label
                for="update_password_password_confirmation"
                class="form-label fw-semibold"
            >
                Confirm Password
            </label>

            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-control"
                autocomplete="new-password"
            >

            @error('password_confirmation', 'updatePassword')

                <div class="text-danger small mt-1">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <button
            type="submit"
            class="btn btn-success"
        >

            <i class="fa fa-key me-1"></i>

            Update Password

        </button>


        @if(session('status') === 'password-updated')

            <span class="text-success ms-2">

                <i class="fa fa-check-circle"></i>

                Password Updated.

            </span>

        @endif

    </form>

</section>