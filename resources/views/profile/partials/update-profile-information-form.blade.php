<section>

    <div class="mb-4">

        <h4 class="fw-bold">
            Profile Information
        </h4>

        <p class="text-muted mb-0">
            Update your account name and email address.
        </p>

    </div>


    <form
        method="post"
        action="{{ route('profile.update') }}"
    >

        @csrf

        @method('patch')


        {{-- Name --}}

        <div class="mb-3">

            <label
                for="name"
                class="form-label fw-semibold"
            >
                Name
            </label>

            <input
                id="name"
                name="name"
                type="text"
                class="form-control"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
            >

            @error('name')

                <div class="text-danger small mt-1">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Email --}}

        <div class="mb-3">

            <label
                for="email"
                class="form-label fw-semibold"
            >
                Email
            </label>

            <input
                id="email"
                name="email"
                type="email"
                class="form-control"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
            >

            @error('email')

                <div class="text-danger small mt-1">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Save --}}

        <button
            type="submit"
            class="btn btn-success"
        >

            <i class="fa fa-save me-1"></i>

            Save Changes

        </button>


        @if(session('status') === 'profile-updated')

            <span class="text-success ms-2">

                <i class="fa fa-check-circle"></i>

                Saved.

            </span>

        @endif

    </form>

</section>