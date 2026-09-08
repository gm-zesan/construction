<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sign In &mdash; {{ config('app.name', 'Construction Admin') }}</title>

    <!-- Favicons -->
    @include('admin.includes.favicon')

    <!-- Google Fonts: Outfit (Headings/Buttons) & Plus Jakarta Sans (Body/Inputs) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --brand-primary: #f95716;
            --brand-primary-hover: #ea4907;
            --brand-glow: rgba(249, 87, 22, 0.2);
            --brand-dark: #0b0f17;
            --text-body: #475569;
            --border-color: #E2E8F0;
            --bg-page: #F8FAFC;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-page);
            color: var(--text-body);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .login-wrapper {
            min-height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #FFFFFF;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2.25rem 2.25rem 2rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        }

        .login-logo-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 1.5rem;
        }

        .login-badge {
            width: 40px;
            height: 40px;
            background-color: var(--brand-primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-size: 1.25rem;
        }

        .login-brand-text {
            display: flex;
            flex-direction: column;
            text-align: left;
            line-height: 1.15;
        }

        .login-brand-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--brand-dark);
            letter-spacing: -0.01em;
        }

        .login-brand-sub {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--brand-primary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .login-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--brand-dark);
            text-align: center;
            margin-bottom: 1.5rem;
            letter-spacing: -0.01em;
        }

        .form-group-item {
            margin-bottom: 1.15rem;
        }

        .form-label-item {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--brand-dark);
            margin-bottom: 0.4rem;
        }

        .input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-box-icon {
            position: absolute;
            left: 0.95rem;
            color: #94A3B8;
            font-size: 0.9rem;
            pointer-events: none;
            transition: color 0.15s ease;
        }

        .form-input-clean {
            width: 100%;
            height: 44px;
            padding: 0.5rem 0.95rem 0.5rem 2.6rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.9rem;
            color: #0F172A;
            background-color: #FFFFFF;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-input-clean::placeholder {
            color: #94A3B8;
        }

        .form-input-clean:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px var(--brand-glow);
        }

        .input-box:focus-within .input-box-icon {
            color: var(--brand-primary);
        }

        .form-input-clean.has-error {
            border-color: #EF4444;
            background-color: #FFFBFB;
        }

        .password-toggle-btn {
            position: absolute;
            right: 0.75rem;
            background: none;
            border: none;
            color: #94A3B8;
            cursor: pointer;
            padding: 0.35rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle-btn:hover {
            color: var(--brand-dark);
        }

        .error-note {
            font-size: 0.76rem;
            color: #DC2626;
            margin-top: 0.35rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.4rem;
            font-size: 0.82rem;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            cursor: pointer;
            user-select: none;
            color: var(--text-body);
        }

        .remember-check {
            accent-color: var(--brand-primary);
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        .forgot-link {
            color: #64748B;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s ease;
        }

        .forgot-link:hover {
            color: var(--brand-primary);
            text-decoration: underline;
        }

        .btn-submit-login {
            width: 100%;
            height: 44px;
            background-color: var(--brand-primary);
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(249, 87, 22, 0.25);
            transition: background-color 0.15s ease, box-shadow 0.15s ease, transform 0.1s ease;
        }

        .btn-submit-login:hover {
            background-color: var(--brand-primary-hover);
            box-shadow: 0 6px 14px rgba(249, 87, 22, 0.35);
        }

        .btn-submit-login:active {
            transform: scale(0.99);
        }

        .btn-submit-login:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .back-home-link {
            margin-top: 1.25rem;
            color: #64748B;
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: color 0.15s ease;
        }

        .back-home-link:hover {
            color: var(--brand-dark);
        }

        .status-alert {
            padding: 0.65rem 0.85rem;
            background-color: #ECFDF5;
            border: 1px solid #A7F3D0;
            border-radius: 8px;
            color: #065F46;
            font-size: 0.82rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="login-logo-wrap" title="{{ config('app.name', 'Construction') }}">
            <div class="login-badge">
                <i class="fa-solid fa-building"></i>
            </div>
            <div class="login-brand-text">
                <span class="login-brand-title">BUILDING &amp; CO.</span>
                <span class="login-brand-sub">Construction Admin</span>
            </div>
        </a>

        <!-- Title -->
        <h1 class="login-title">Sign In</h1>

        <!-- Status Notification -->
        @if (session('status'))
            <div class="status-alert" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
            @csrf

            <!-- Email Address -->
            <div class="form-group-item">
                <label for="email" class="form-label-item">Email Address</label>
                <div class="input-box">
                    <input type="email" 
                           name="email" 
                           id="email" 
                           class="form-input-clean {{ $errors->has('email') ? 'has-error' : '' }}" 
                           value="{{ old('email') }}" 
                           placeholder="admin@example.com" 
                           required 
                           autofocus 
                           autocomplete="username">
                    <span class="input-box-icon">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                </div>
                @if ($errors->has('email'))
                    <div class="error-note">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first('email') }}</span>
                    </div>
                @endif
            </div>

            <!-- Password -->
            <div class="form-group-item">
                <label for="password" class="form-label-item">Password</label>
                <div class="input-box">
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="form-input-clean {{ $errors->has('password') ? 'has-error' : '' }}" 
                           placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" 
                           required 
                           autocomplete="current-password">
                    <span class="input-box-icon">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <button type="button" 
                            class="password-toggle-btn" 
                            id="togglePasswordBtn" 
                            aria-label="Toggle password visibility"
                            tabindex="-1">
                        <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
                @if ($errors->has('password'))
                    <div class="error-note">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first('password') }}</span>
                    </div>
                @endif
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="options-row">
                <label class="remember-label" for="remember">
                    <input type="checkbox" 
                           name="remember" 
                           id="remember" 
                           class="remember-check" 
                           {{ old('remember') ? 'checked' : '' }}>
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link" tabindex="-1">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit-login" id="submitBtn">
                <span id="btnText">Sign In</span>
                <i class="fa-solid fa-arrow-right-to-bracket" id="btnIcon"></i>
            </button>
        </form>
    </div>

    <!-- Back to Website Link -->
    <a href="{{ route('home') }}" class="back-home-link">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Back to Website</span>
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Password Visibility Toggle
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && toggleIcon) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                if (isPassword) {
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            });
        }

        // Form Submit Loading Feedback
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnIcon = document.getElementById('btnIcon');

        if (loginForm && submitBtn) {
            loginForm.addEventListener('submit', function () {
                if (loginForm.checkValidity()) {
                    submitBtn.disabled = true;
                    if (btnText) btnText.textContent = 'Signing in...';
                    if (btnIcon) btnIcon.className = 'fa-solid fa-circle-notch fa-spin';
                }
            });
        }
    });
</script>

</body>
</html>
