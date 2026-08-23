<section>

    <div class="mb-4">

        <h4 class="fw-bold text-danger">
            Delete Account
        </h4>

        <p class="text-muted">
            Once your account is deleted, all of its data will be
            permanently deleted.
        </p>

    </div>


    <button
        type="button"
        class="btn btn-danger"
        data-bs-toggle="modal"
        data-bs-target="#deleteAccountModal"
    >

        <i class="fa fa-trash me-1"></i>

        Delete Account

    </button>


    {{-- Delete Modal --}}

    <div
        class="modal fade"
        id="deleteAccountModal"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title text-danger">

                        Delete Account

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <form
                    method="post"
                    action="{{ route('profile.destroy') }}"
                >

                    @csrf

                    @method('delete')


                    <div class="modal-body">

                        <p>
                            Are you sure you want to delete your account?
                        </p>

                        <p class="text-muted small">
                            This action cannot be undone.
                        </p>


                        <label
                            for="delete_password"
                            class="form-label fw-semibold"
                        >
                            Enter your password
                        </label>


                        <input
                            id="delete_password"
                            name="password"
                            type="password"
                            class="form-control"
                            required
                        >


                        @error('password', 'userDeletion')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>


                        <button
                            type="submit"
                            class="btn btn-danger"
                        >

                            <i class="fa fa-trash me-1"></i>

                            Delete Account

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>