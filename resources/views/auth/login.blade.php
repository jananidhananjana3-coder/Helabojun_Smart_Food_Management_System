<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hela Bojun Digital System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="login-body">

<div class="login-container">
    <!-- Top Branding Header -->
    <div class="login-header">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5f/Emblem_of_Sri_Lanka.svg" 
             alt="Sri Lanka Emblem" class="login-emblem">
        <div class="login-header-text">
            <h1 class="title-si">කෘෂිකර්ම දෙපාර්තමේන්තුව</h1>
            <h2 class="title-en">DEPARTMENT OF AGRICULTURE</h2>
            <h3 class="title-ta">விவசாயத் திணைக்களம்</h3>
        </div>
    </div>

    <!-- Login Card -->
    <div class="card login-card border-0 shadow-lg">
        <div class="card-body p-4 p-sm-5">
            
            <!-- Hela Bojun Logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('images/hela-bojun-logo.png') }}" alt="Hela Bojun Logo" class="login-logo mb-2">
                <h4 class="fw-bold text-success-dark"> Staff Login</h4>
                <p class="text-muted small">Access your Hela Bojun account</p>
            </div>

            <!-- Session Status / Email Verification Alert -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Invalid login credentials or unverified email.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold text-secondary">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                        <input type="email" id="email" name="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required autofocus placeholder="enter your e-mail">
                    </div>
                    @error('email')
                        <span class="text-danger small ms-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label fw-semibold text-secondary">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-success text-decoration-none">Forgot Password?</a>
                        @endif
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" id="password" name="password" class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" 
                               required placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                    <label class="form-check-label small text-muted" for="remember_me">
                        Remember this terminal
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success-custom w-100 py-2 fw-bold shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Log In to System
                </button>
            </form>

            <hr class="my-4 text-muted opacity-25">

            <!-- Security Footer Note -->
            <div class="text-center">
                <p class="small text-muted mb-0">
                    <i class="bi bi-shield-lock-fill text-success"></i> Secure Helabojun System Access
                </p>
                <a href="{{ url('/') }}" class="small text-decoration-none text-secondary mt-2 d-inline-block">
                    ← Back to Public Portal
                </a>
            </div>
            <div class="text-center mt-3">
    <span class="small text-muted">
        Don't have an account?
    </span>
    <a href="{{ route('register') }}" class="small text-success fw-bold text-decoration-none">
        Register
    </a>
</div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>