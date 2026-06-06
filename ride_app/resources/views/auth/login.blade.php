<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
</head>
<body data-bs-theme="light">
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('login') }}">
            <i class="fas fa-car-side me-2"></i>RideShare
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                <li class="nav-item ms-2">
                    <div class="theme-toggle" onclick="toggleTheme()">
                        <i class="fas fa-moon text-white" id="themeIcon"></i>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    </nav>

<div class="container" style="padding-top: 100px;">
    <div class="row justify-content-center align-items-center" style="min-height: 75vh;">
        <div class="col-md-5">
            <div class="glass-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <span class="badge-verified mb-2"><i class="fas fa-shield-alt me-1"></i>Secure Login</span>
                    <h4 class="mb-1">Welcome Back</h4>
                    <p class="text-muted mb-0">Sign in to continue</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-500">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control search-input" value="{{ old('email') }}" placeholder="you@example.com" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" class="form-control search-input" placeholder="Your password" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="text-primary">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn-glow w-100"><i class="fas fa-sign-in-alt me-2"></i>Login</button>
                </form>

                <p class="mt-3 text-center">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/script.js') }}" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof initializeTheme === 'function') { initializeTheme(); }
});
</script>
</body>
</html>
