<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login - SainiVet Pharma</title>
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
        :root {
            --green:       #5DB135;
            --green-light: #7DD455;
            --green-glow:  rgba(93,177,53,0.35);
            --blue:        #1E6BB5;
            --blue-light:  #3A8FDD;
            --navy:        #0D1B2A;
            --card-bg:     rgba(13,27,42,0.90);
            --off-white:   #EEF5FF;
        }
 
        body, html {
            height: 100%;
            font-family: 'Nunito', sans-serif;
            overflow: hidden;
        }
 
        /* ── GRADIENT BACKGROUND ONLY ── */
        .vet-bg {
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse at 15% 20%, rgba(30,107,181,0.28) 0%, transparent 55%),
                radial-gradient(ellipse at 85% 80%, rgba(93,177,53,0.18) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 10%, rgba(30,107,181,0.15) 0%, transparent 45%),
                radial-gradient(ellipse at 20% 85%, rgba(93,177,53,0.12) 0%, transparent 45%),
                linear-gradient(160deg, #0f2035 0%, #0D1B2A 45%, #091420 100%);
            z-index: 0;
        }
 
        /* Subtle dot grid */
        .vet-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 30px 30px;
        }
 
        /* ── CONTENT ── */
        .page-wrap {
            position: relative;
            z-index: 1;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
 
        /* ── CARD ── */
        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(30,107,181,0.28);
            border-radius: 4px 22px 4px 22px;
            box-shadow:
                0 24px 80px rgba(0,0,0,0.65),
                0 0 0 1px rgba(93,177,53,0.07) inset,
                0 1px 0 rgba(255,255,255,0.05) inset;
            width: 100%;
            max-width: 420px;
            padding: 44px 40px 36px;
            position: relative;
            overflow: hidden;
            animation: cardIn 0.85s cubic-bezier(0.16,1,0.3,1) both;
        }
 
        /* Top shimmer bar green → blue */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg,
                transparent 0%,
                var(--blue) 20%,
                var(--green) 50%,
                var(--blue-light) 80%,
                transparent 100%
            );
            background-size: 200% 100%;
            animation: barMove 5s linear infinite;
        }
 
        /* Left edge accent */
        .login-card::after {
            content: '';
            position: absolute;
            top: 3px; left: 0; bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, var(--green), transparent 40%, var(--blue) 80%, transparent);
            opacity: 0.35;
        }
 
        @keyframes barMove {
            0%   { background-position: 100% 0; }
            100% { background-position: -100% 0; }
        }
 
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(36px) scale(0.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
 
        /* ── LOGO ── */
        .logo-wrap {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo-wrap img {
            width: 110px;
            height: 110px;
            object-fit: contain;
            border-radius: 50%;
            background: rgba(255,255,255,0.97);
            padding: 6px;
            box-shadow:
                0 0 0 2px rgba(93,177,53,0.5),
                0 0 0 6px rgba(30,107,181,0.18),
                0 8px 32px rgba(0,0,0,0.55);
            animation: logoIn 0.9s cubic-bezier(0.16,1,0.3,1) both 0.1s, logoGlow 4s ease-in-out 1s infinite;
        }
        @keyframes logoIn {
            from { opacity: 0; transform: scale(0.5) rotate(-12deg); }
            to   { opacity: 1; transform: scale(1) rotate(0deg); }
        }
        @keyframes logoGlow {
            0%,100% { box-shadow: 0 0 0 2px rgba(93,177,53,0.5), 0 0 0 6px rgba(30,107,181,0.18), 0 8px 32px rgba(0,0,0,0.55); }
            50%     { box-shadow: 0 0 0 3px rgba(93,177,53,0.75), 0 0 0 9px rgba(30,107,181,0.28), 0 8px 42px rgba(93,177,53,0.2); }
        }
 
        /* ── HEADINGS ── */
        .card-title {
            text-align: center;
            margin-top: 16px;
            margin-bottom: 5px;
            color: var(--off-white);
            font-family: 'Montserrat', sans-serif;
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: 0.3px;
        }
        .card-title span { color: var(--green); }
 
        .card-subtitle {
            text-align: center;
            color: rgba(160,195,230,0.55);
            font-size: 0.78rem;
            letter-spacing: 0.4px;
            margin-bottom: 0;
        }
 
        /* ── DIVIDER ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 16px 0 20px;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(30,107,181,0.3), transparent);
        }
        .divider span { font-size: 1.1rem; }
 
        /* ── INPUTS ── */
        .field-wrap {
            position: relative;
            margin-bottom: 14px;
        }
 
        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.95rem;
            z-index: 2;
            color: rgba(30,107,181,0.65);
            transition: color 0.3s;
            pointer-events: none;
            line-height: 1;
        }
 
        .field-wrap:focus-within .field-icon {
            color: var(--green);
        }
 
        /* ← THIS is the one class used on BOTH username AND password inputs */
        .field-input {
            display: block;
            width: 100%;
            background: rgba(255,255,255,0.06) !important;
            border: 1px solid rgba(30,107,181,0.3) !important;
            color: var(--off-white) !important;
            border-radius: 10px !important;
            padding: 13px 16px 13px 42px !important;
            font-size: 0.88rem !important;
            font-family: 'Nunito', sans-serif !important;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s, background 0.3s;
            -webkit-appearance: none;
            appearance: none;
        }
 
        .field-input::placeholder {
            color: rgba(160,195,230,0.35) !important;
        }
 
        .field-input:focus {
            border-color: var(--green) !important;
            box-shadow: 0 0 0 3px rgba(93,177,53,0.15), 0 0 18px rgba(93,177,53,0.06) !important;
            background: rgba(255,255,255,0.09) !important;
        }
 
        /* Override browser autofill background */
        .field-input:-webkit-autofill,
        .field-input:-webkit-autofill:hover,
        .field-input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #0f2035 inset !important;
            -webkit-text-fill-color: var(--off-white) !important;
            border-color: rgba(30,107,181,0.3) !important;
        }
 
        /* ── BUTTON ── */
        .btn-login {
            width: 100%;
            margin-top: 20px;
            background: linear-gradient(135deg, var(--green) 0%, #3e9c1a 100%);
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.82rem;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            border: none;
            border-radius: 10px;
            padding: 15px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.3s;
            box-shadow: 0 6px 24px rgba(93,177,53,0.45), 0 2px 0 rgba(255,255,255,0.12) inset;
        }
 
        .btn-login::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 36px rgba(93,177,53,0.6); }
        .btn-login:hover::before { transform: translateX(100%); }
        .btn-login:active { transform: translateY(0); }
 
        /* ── REMEMBER ── */
        .remember-row {
            display: flex;
            align-items: center;
            margin-top: 16px;
        }
        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(160,195,230,0.55);
            font-size: 0.8rem;
            cursor: pointer;
        }
        .remember-label input[type="checkbox"] {
            accent-color: var(--green);
            width: 14px; height: 14px;
            cursor: pointer;
        }
 
        /* ── FOOTER BADGE ── */
        .card-footer-badge {
            margin-top: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .badge-line {
            height: 1px; flex: 1;
            background: linear-gradient(90deg, transparent, rgba(93,177,53,0.2), transparent);
        }
        .badge-text {
            color: rgba(93,177,53,0.4);
            font-size: 0.62rem;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            white-space: nowrap;
        }
 
        /* ── ALERT ── */
        .alert-error {
            background: rgba(200,40,40,0.13);
            border: 1px solid rgba(200,40,40,0.28);
            color: #ffb3b3;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.82rem;
            margin-bottom: 14px;
        }
 
        /* ── VALIDATION ── */
        .invalid-msg {
            color: #ff9999;
            font-size: 0.76rem;
            margin-top: 5px;
            padding-left: 4px;
        }
    </style>
</head>
<body>
 
<!-- GRADIENT BACKGROUND ONLY — NO SVG ANIMATIONS -->
<div class="vet-bg"></div>
 
<!-- CARD -->
<div class="page-wrap">
    <div class="login-card">
 
        <!-- Logo -->
        <div class="logo-wrap">
            <img src="{{ asset('backend/assets/images/adminlogo.webp') }}"
                 alt="SainiVet Pharma">
        </div>
 
        <h1 class="card-title">Welcome to <span>Admin</span></h1>
        <p class="card-subtitle">SainiVet Pharma &mdash; Management Portal</p>
 
        <div class="divider"><span>🐄</span></div>
 
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
 
            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif
 
            <!-- Username -->
            <div class="field-wrap">
                <span class="field-icon">👤</span>
                <input type="text"
                       class="field-input @error('username') is-invalid @enderror"
                       placeholder="Username"
                       name="username"
                       value="{{ old('username') }}"
                       required
                       autocomplete="username">
                @error('username')
                    <div class="invalid-msg">{{ $message }}</div>
                @enderror
            </div>
 
            <!-- Password -->
            <div class="field-wrap">
                <span class="field-icon">🔒</span>
                <input type="password"
                       class="field-input @error('password') is-invalid @enderror"
                       placeholder="Password"
                       name="password"
                       required
                       autocomplete="current-password">
                @error('password')
                    <div class="invalid-msg">{{ $message }}</div>
                @enderror
            </div>
 
            <button type="submit" class="btn-login">Sign In &nbsp;→</button>
 
            <div class="remember-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember">
                    Keep me signed in
                </label>
            </div>
        </form>
 
        <div class="card-footer-badge">
            <div class="badge-line"></div>
            <span class="badge-text">🐄 Saini Vet Pharma &nbsp;✦&nbsp; Livestock &amp; Animal Health</span>
            <div class="badge-line"></div>
        </div>
    </div>
</div>
 
    <script src="{{ asset('backend/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('backend/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('backend/assets/js/misc.js') }}"></script>
</body>
</html>
