<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Email Verification - Hela Bojun Digital System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body class="login-body">

<div class="login-container">

    <!-- Header -->
    <div class="login-header">

        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5f/Emblem_of_Sri_Lanka.svg"
             class="login-emblem"
             alt="Sri Lanka Emblem">

        <div class="login-header-text">
            <h1 class="title-si">කෘෂිකර්ම දෙපාර්තමේන්තුව</h1>
            <h2 class="title-en">DEPARTMENT OF AGRICULTURE</h2>
            <h3 class="title-ta">விவசாயத் திணைக்களம்</h3>
        </div>

    </div>


    <div class="card login-card border-0 shadow-lg">

        <div class="card-body p-4 p-sm-5">


            <div class="text-center mb-4">

                <img src="{{ asset('images/hela-bojun-logo.png') }}"
                     class="login-logo mb-3"
                     alt="Hela Bojun Logo">

                <h4 class="fw-bold text-success-dark">
                    Email Verification
                </h4>

                <p class="text-muted small">
                    Enter the 6 digit verification code
                </p>

            </div>


            @if ($errors->any())

                <div class="alert alert-danger small">
                    {{ $errors->first() }}
                </div>

            @endif


            @if(session('success'))

                <div class="alert alert-success small">
                    {{ session('success') }}
                </div>

            @endif


            <!-- Demo OTP Display -->
            <div class="alert alert-info text-center">
                Your Verification Code:
                <strong>
                    {{ auth()->user()->verification_code }}
                </strong>
            </div>


            <form method="POST" action="{{ route('otp.verify') }}">

                @csrf

                <div class="mb-4">

                    <label class="form-label fw-semibold text-secondary">
                        Verification Code
                    </label>


                    <input type="text"
                           name="verification_code"
                           maxlength="6"
                           class="form-control text-center fs-4 letter-spacing"
                           placeholder="000000"
                           required>

                </div>


                <button type="submit"
                        class="btn btn-success-custom w-100 py-2 fw-bold">

                    Verify Account

                </button>

            </form>


        </div>

    </div>

</div>


</body>
</html>