<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Hela Bojun Digital System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Login CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body class="login-body">

<div class="login-container">

    <!-- Department Header -->
    <div class="login-header">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5f/Emblem_of_Sri_Lanka.svg"
             alt="Sri Lanka Emblem"
             class="login-emblem">

        <div class="login-header-text">
            <h1 class="title-si">කෘෂිකර්ම දෙපාර්තමේන්තුව</h1>
            <h2 class="title-en">DEPARTMENT OF AGRICULTURE</h2>
            <h3 class="title-ta">விவசாயத் திணைக்களம்</h3>
        </div>
    </div>


    <!-- Verification Card -->
    <div class="card login-card border-0 shadow-lg">

        <div class="card-body p-4 p-sm-5">

            <!-- Hela Bojun Logo -->
            <div class="text-center mb-4">

                <img src="{{ asset('images/hela-bojun-logo.png') }}"
                     alt="Hela Bojun Logo"
                     class="login-logo mb-3">

                <h4 class="fw-bold text-success-dark">
                    Verify Your Email Address
                </h4>

                <p class="text-muted small">
                    To ensure the security of your staff account, please verify your email address before accessing the Hela Bojun Digital System.
                </p>

            </div>


            <!-- Success Message -->
            @if (session('status') == 'verification-link-sent')

                <div class="alert alert-success alert-dismissible fade show small"
                     role="alert">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    A new verification email has been sent successfully.

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close">
                    </button>

                </div>

            @endif


            <!-- Information Message -->
            <div class="alert alert-light border small">

                <i class="bi bi-envelope-paper-fill me-2 text-success"></i>

                A verification link has been sent to your registered email address.
                Please check your inbox or spam folder and follow the instructions provided.

            </div>


            <!-- Resend Verification Email -->
            <form method="POST"
                  action="{{ route('verification.send') }}">

                @csrf

                <button type="submit"
                        class="btn btn-success-custom w-100 py-2 fw-bold shadow-sm">

                    <i class="bi bi-envelope-check-fill me-2"></i>
                    Resend Verification Email

                </button>

            </form>


            <hr class="my-4 text-muted opacity-25">


            <!-- Logout Button -->
            <form method="POST"
                  action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                        class="btn btn-outline-secondary w-100">

                    <i class="bi bi-box-arrow-left me-2"></i>
                    Log Out

                </button>

            </form>


            <!-- Footer Note -->
            <div class="text-center mt-4">

                <p class="small text-muted mb-0">

                    <i class="bi bi-shield-lock-fill text-success"></i>
                    Secure Email Verification for Hela Bojun Staff Accounts.

                </p>

            </div>

        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>