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
            --blue-glow:   rgba(30,107,181,0.38);
            --navy:        #0D1B2A;
            --navy-mid:    #132436;
            --card-bg:     rgba(13,27,42,0.82);
            --white:       #FFFFFF;
            --off-white:   #EEF5FF;
        }
 
        body, html { height: 100%; font-family: 'Nunito', sans-serif; overflow: hidden; }
 
        /* ── BACKGROUND ── */
        .vet-bg {
            position: fixed; inset: 0;
            background: radial-gradient(ellipse at 30% 40%, #132d4a 0%, #0D1B2A 50%, #070f18 100%);
            overflow: hidden; z-index: 0;
        }
 
        /* Green orb top-right */
        .orb-green {
            position: absolute; top: -140px; right: -100px;
            width: 480px; height: 480px; border-radius: 50%;
            background: radial-gradient(circle, rgba(93,177,53,0.18) 0%, transparent 70%);
            animation: orbPulse 7s ease-in-out infinite;
        }
        /* Blue orb bottom-left */
        .orb-blue {
            position: absolute; bottom: -100px; left: -80px;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(30,107,181,0.22) 0%, transparent 70%);
            animation: orbPulse 9s ease-in-out 2s infinite;
        }
        /* Subtle center glow */
        .orb-center {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
            width: 600px; height: 300px;
            background: radial-gradient(ellipse, rgba(30,107,181,0.07) 0%, transparent 70%);
        }
        @keyframes orbPulse {
            0%,100% { transform: scale(1); opacity:1; }
            50%      { transform: scale(1.15); opacity:0.7; }
        }
 
        /* dot grid */
        .dot-grid {
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 30px 30px;
        }
 
        /* scanlines */
        .scanlines {
            position: absolute; inset: 0;
            background: repeating-linear-gradient(0deg, transparent, transparent 3px, rgba(0,0,0,0.05) 3px, rgba(0,0,0,0.05) 4px);
            pointer-events: none;
        }
 
        /* ── FLOATING ANIMAL SILHOUETTES (SVG) ── */
        .animal-float {
            position: absolute;
            opacity: 0;
            animation: animalDrift var(--ad) ease-in-out var(--ade) infinite;
        }
        @keyframes animalDrift {
            0%   { opacity:0; transform: translateY(12px) scale(0.9) rotate(var(--ar)); }
            25%  { opacity: var(--ao); }
            75%  { opacity: var(--ao); }
            100% { opacity:0; transform: translateY(-35px) scale(1.05) rotate(var(--ar)); }
        }
 
        /* ── FLOATING CROSS MARKS ── */
        .cross-mark {
            position: absolute;
            color: rgba(30,107,181,0.15);
            font-size: var(--cms);
            opacity: 0;
            animation: crossPop var(--cmd) ease-in-out var(--cmde) infinite;
        }
        @keyframes crossPop {
            0%,100% { opacity:0; transform: scale(0.7) rotate(0deg); }
            40%,60% { opacity:1; transform: scale(1) rotate(10deg); }
        }
 
        /* ── FLOATING MED PILLS ── */
        .med-pill {
            position: absolute;
            border-radius: 50px;
            opacity: 0;
            animation: pillDrift var(--mpd) ease-in-out var(--mpde) infinite;
        }
        @keyframes pillDrift {
            0%   { opacity:0; transform: translateY(20px) rotate(var(--mpr)); }
            30%  { opacity:0.55; }
            70%  { opacity:0.3; }
            100% { opacity:0; transform: translateY(-60px) rotate(calc(var(--mpr) + 50deg)); }
        }
 
        /* ── CONTENT ── */
        .page-wrap { position: relative; z-index:1; height:100vh; display:flex; align-items:center; justify-content:center; padding: 20px; }
 
        /* ── CARD ── */
        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid rgba(30,107,181,0.25);
            border-radius: 4px 24px 4px 24px;
            box-shadow:
                0 24px 80px rgba(0,0,0,0.65),
                0 0 0 1px rgba(93,177,53,0.08) inset,
                0 1px 0 rgba(255,255,255,0.05) inset;
            width: 100%;
            max-width: 420px;
            padding: 44px 40px 36px;
            position: relative;
            overflow: hidden;
            animation: cardIn 0.85s cubic-bezier(0.16,1,0.3,1) both;
        }
 
        /* Top shimmer bar — green → blue → green */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, transparent, var(--blue), var(--green), var(--blue-light), var(--green-light), transparent);
            background-size: 200% 100%;
            animation: barMove 4s linear infinite;
        }
 
        @keyframes barMove {
            0%   { background-position: 100% 0; }
            100% { background-position: -100% 0; }
        }
 
        /* Inner card glow on left edge */
        .login-card::after {
            content: '';
            position: absolute;
            top: 3px; left: 0; bottom: 0; width: 2px;
            background: linear-gradient(to bottom, var(--green), transparent 40%, var(--blue) 80%, transparent);
            opacity: 0.4;
        }
 
        @keyframes cardIn {
            from { opacity:0; transform: translateY(36px) scale(0.96); }
            to   { opacity:1; transform: translateY(0) scale(1); }
        }
 
        /* ── LOGO ── */
        .logo-wrap {
            text-align: center;
            margin-bottom: 8px;
        }
        .logo-wrap img {
            width: 120px; height: 120px;
            object-fit: contain;
            border-radius: 50%;
            background: rgba(255,255,255,0.96);
            padding: 6px;
            box-shadow:
                0 0 0 2px rgba(93,177,53,0.4),
                0 0 0 5px rgba(30,107,181,0.2),
                0 8px 30px rgba(0,0,0,0.5);
            animation: logoSpin 0.9s cubic-bezier(0.16,1,0.3,1) both, logoGlow 4s ease-in-out 1s infinite;
        }
        @keyframes logoSpin {
            from { opacity:0; transform: scale(0.5) rotate(-15deg); }
            to   { opacity:1; transform: scale(1) rotate(0deg); }
        }
        @keyframes logoGlow {
            0%,100% { box-shadow: 0 0 0 2px rgba(93,177,53,0.4), 0 0 0 5px rgba(30,107,181,0.2), 0 8px 30px rgba(0,0,0,0.5); }
            50%     { box-shadow: 0 0 0 3px rgba(93,177,53,0.65), 0 0 0 8px rgba(30,107,181,0.3), 0 8px 40px rgba(93,177,53,0.25); }
        }
 
        /* ── HEADINGS ── */
        .card-title {
            text-align: center;
            margin-top: 14px;
            margin-bottom: 4px;
            color: var(--off-white);
            font-family: 'Montserrat', sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .card-title span { color: var(--green); }
        .card-subtitle {
            text-align: center;
            color: rgba(160,195,230,0.6);
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            margin-bottom: 0;
        }
 
        /* ── DIVIDER ── */
        .divider {
            display: flex; align-items: center; gap: 10px;
            margin: 16px 0 20px;
        }
        .divider::before, .divider::after {
            content: ''; flex:1; height:1px;
            background: linear-gradient(90deg, transparent, rgba(30,107,181,0.35), transparent);
        }
        .divider-icon { font-size: 1.1rem; opacity: 0.7; }
 
        /* ── INPUTS ── */
        .field-wrap {
            position: relative;
            margin-bottom: 14px;
        }
        .field-icon {
            position: absolute;
            left: 13px; top: 50%; transform: translateY(-50%);
            font-size: 1rem; z-index: 2;
            color: rgba(30,107,181,0.6);
            transition: color 0.3s;
            pointer-events: none;
        }
        .field-wrap:focus-within .field-icon { color: var(--green); }
 
        input.field-input {
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(30,107,181,0.28);
            color: var(--off-white);
            border-radius: 10px;
            padding: 13px 16px 13px 42px;
            font-size: 0.88rem;
            font-family: 'Nunito', sans-serif;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s, background 0.3s;
        }
        input.field-input::placeholder { color: rgba(160,195,230,0.35); }
        input.field-input:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(93,177,53,0.15), 0 0 18px rgba(93,177,53,0.07);
            background: rgba(255,255,255,0.09);
        }
 
        /* ── BUTTON ── */
        .btn-login {
            width: 100%;
            margin-top: 20px;
            background: linear-gradient(135deg, var(--green) 0%, #3d9e1a 100%);
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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 36px rgba(93,177,53,0.6); }
        .btn-login:hover::before { transform: translateX(100%); }
        .btn-login:active { transform: translateY(0); }
 
        /* ── REMEMBER ── */
        .remember-row {
            display: flex; align-items: center; justify-content: space-between;
            margin-top: 14px;
        }
        .remember-label {
            display: flex; align-items: center; gap: 8px;
            color: rgba(160,195,230,0.55);
            font-size: 0.8rem; cursor: pointer;
        }
        .remember-label input[type="checkbox"] {
            accent-color: var(--green);
            width: 14px; height: 14px;
        }
 
        /* ── FOOTER BADGE ── */
        .card-footer-badge {
            margin-top: 24px;
            text-align: center;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .badge-line {
            height: 1px; flex:1;
            background: linear-gradient(90deg, transparent, rgba(93,177,53,0.25), transparent);
        }
        .badge-text {
            color: rgba(93,177,53,0.4);
            font-size: 0.62rem;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            white-space: nowrap;
        }
 
        /* alert */
        .alert-error {
            background: rgba(200,40,40,0.14);
            border: 1px solid rgba(200,40,40,0.28);
            color: #ffb3b3;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.82rem;
            margin-bottom: 14px;
        }
    </style>
</head>
<body>
 
<!-- BACKGROUND -->
<div class="vet-bg">
    <div class="orb-green"></div>
    <div class="orb-blue"></div>
    <div class="orb-center"></div>
    <div class="dot-grid"></div>
    <div class="scanlines"></div>
    <div id="animalsLayer" style="position:absolute;inset:0;pointer-events:none;"></div>
    <div id="pillsLayer"   style="position:absolute;inset:0;pointer-events:none;"></div>
    <div id="crossLayer"   style="position:absolute;inset:0;pointer-events:none;"></div>
</div>
 
<!-- CARD -->
<div class="page-wrap">
    <div class="login-card">
 
        <div class="logo-wrap">
            <img src="{{ asset('backend/assets/images/adminlogo.webp') }}"
                 alt="SainiVet Pharma"
                 onerror="this.style.background='#132436';this.style.padding='16px';">
        </div>
 
        <h1 class="card-title">Welcome to <span>Admin</span></h1>
        <p class="card-subtitle">SainiVet Pharma &mdash; Management Portal</p>
 
        <div class="divider">
            <span class="divider-icon">🐄</span>
        </div>
 
        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif
 
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
 
            <div class="field-wrap">
                <span class="field-icon">👤</span>
                <input type="text"
                       class="field-input @error('username') is-invalid @enderror"
                       placeholder="Username" name="username"
                       value="{{ old('username') }}" required autocomplete="username">
                @error('username')<div style="color:#ff9999;font-size:0.76rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
 
            <div class="field-wrap pasword-field">
                <span class="field-icon">🔒</span>
                <input type="password"
                       class="field-password @error('password') is-invalid @enderror"
                       placeholder="Password" name="password"
                       required autocomplete="current-password">
                @error('password')<div style="color:#ff9999;font-size:0.76rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
 
            <button type="submit" class="btn-login">Sign In &nbsp;→</button>
 
            <div class="remember-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember"> Keep me signed in
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
 
<script>
(function(){
    'use strict';
 
    // ── LIVESTOCK SVG SILHOUETTES ──
    const animals = [
        // Cow
        `<svg viewBox="0 0 80 50" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="38" cy="28" rx="22" ry="13" fill="currentColor"/>
          <ellipse cx="15" cy="25" rx="10" ry="8" fill="currentColor"/>
          <ellipse cx="10" cy="21" rx="5" ry="6" fill="currentColor"/>
          <rect x="20" y="38" width="5" height="10" rx="2" fill="currentColor"/>
          <rect x="30" y="39" width="5" height="9" rx="2" fill="currentColor"/>
          <rect x="44" y="38" width="5" height="10" rx="2" fill="currentColor"/>
          <rect x="54" y="39" width="5" height="9" rx="2" fill="currentColor"/>
          <path d="M7 17 Q5 8 3 6" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round"/>
          <path d="M12 16 Q12 7 14 5" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round"/>
          <path d="M57 24 Q68 22 70 20" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round"/>
        </svg>`,
        // Buffalo/ox (bulkier)
        `<svg viewBox="0 0 90 55" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="45" cy="30" rx="28" ry="16" fill="currentColor"/>
          <ellipse cx="17" cy="26" rx="13" ry="10" fill="currentColor"/>
          <ellipse cx="10" cy="20" rx="7" ry="8" fill="currentColor"/>
          <rect x="22" y="43" width="6" height="11" rx="2" fill="currentColor"/>
          <rect x="34" y="44" width="6" height="10" rx="2" fill="currentColor"/>
          <rect x="52" y="43" width="6" height="11" rx="2" fill="currentColor"/>
          <rect x="63" y="44" width="6" height="10" rx="2" fill="currentColor"/>
          <path d="M6 16 Q2 6 0 4" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round"/>
          <path d="M13 14 Q14 4 17 2" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round"/>
          <path d="M70 28 Q82 25 85 22" stroke="currentColor" stroke-width="3.5" fill="none" stroke-linecap="round"/>
        </svg>`,
        // Goat
        `<svg viewBox="0 0 70 55" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="38" cy="27" rx="18" ry="11" fill="currentColor"/>
          <ellipse cx="20" cy="24" rx="9" ry="8" fill="currentColor"/>
          <ellipse cx="15" cy="18" rx="5" ry="6" fill="currentColor"/>
          <rect x="22" y="36" width="4" height="12" rx="2" fill="currentColor"/>
          <rect x="31" y="37" width="4" height="11" rx="2" fill="currentColor"/>
          <rect x="44" y="36" width="4" height="12" rx="2" fill="currentColor"/>
          <rect x="52" y="37" width="4" height="11" rx="2" fill="currentColor"/>
          <path d="M12 13 Q10 5 9 3" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/>
          <path d="M17 12 Q18 4 20 2" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/>
          <path d="M13 22 Q10 26 9 28" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/>
        </svg>`,
        // Chicken
        `<svg viewBox="0 0 50 55" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="25" cy="35" rx="14" ry="12" fill="currentColor"/>
          <circle cx="25" cy="16" r="10" fill="currentColor"/>
          <path d="M32 10 Q38 5 40 3 Q36 8 35 12" fill="currentColor"/>
          <path d="M18 10 Q14 7 10 8 Q13 10 15 13" fill="currentColor"/>
          <rect x="21" y="45" width="4" height="9" rx="2" fill="currentColor"/>
          <rect x="27" y="45" width="4" height="9" rx="2" fill="currentColor"/>
          <path d="M35 33 Q45 30 46 28" stroke="currentColor" stroke-width="2.5" fill="none"/>
        </svg>`,
        // Horse
        `<svg viewBox="0 0 85 55" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="45" cy="28" rx="24" ry="13" fill="currentColor"/>
          <ellipse cx="22" cy="22" rx="11" ry="9" fill="currentColor"/>
          <ellipse cx="16" cy="14" rx="6" ry="8" fill="currentColor"/>
          <rect x="26" y="38" width="5" height="13" rx="2" fill="currentColor"/>
          <rect x="36" y="39" width="5" height="12" rx="2" fill="currentColor"/>
          <rect x="52" y="38" width="5" height="13" rx="2" fill="currentColor"/>
          <rect x="62" y="39" width="5" height="12" rx="2" fill="currentColor"/>
          <path d="M13 10 Q10 3 9 0" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round"/>
          <path d="M18 8 Q20 1 23 0" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round"/>
          <path d="M67 26 Q76 18 78 14" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round"/>
        </svg>`,
    ];
 
    const positions = [
        {l:'3%',  t:'10%', color:'rgba(30,107,181,0.22)',  s:64, op:0.7, dur:9,  del:0},
        {l:'82%', t:'8%',  color:'rgba(93,177,53,0.2)',    s:70, op:0.6, dur:11, del:2},
        {l:'5%',  t:'65%', color:'rgba(30,107,181,0.18)',  s:58, op:0.55,dur:8,  del:4},
        {l:'80%', t:'65%', color:'rgba(93,177,53,0.18)',   s:66, op:0.6, dur:10, del:1},
        {l:'42%', t:'4%',  color:'rgba(30,107,181,0.15)',  s:52, op:0.45,dur:12, del:3},
        {l:'88%', t:'38%', color:'rgba(93,177,53,0.15)',   s:56, op:0.5, dur:9,  del:5},
        {l:'2%',  t:'38%', color:'rgba(30,107,181,0.15)',  s:60, op:0.5, dur:10, del:6},
        {l:'65%', t:'88%', color:'rgba(93,177,53,0.2)',    s:54, op:0.55,dur:8,  del:2.5},
        {l:'28%', t:'88%', color:'rgba(30,107,181,0.18)',  s:62, op:0.5, dur:11, del:4.5},
        {l:'58%', t:'5%',  color:'rgba(93,177,53,0.15)',   s:50, op:0.4, dur:13, del:1.5},
    ];
 
    const layer = document.getElementById('animalsLayer');
    positions.forEach((p, i) => {
        const wrap = document.createElement('div');
        wrap.className = 'animal-float';
        wrap.innerHTML = animals[i % animals.length];
        const rot = Math.random()*16 - 8;
        wrap.style.cssText = `
            left:${p.l}; top:${p.t};
            width:${p.s}px; height:auto;
            color:${p.color};
            --ad:${p.dur}s; --ade:${p.del}s; --ao:${p.op}; --ar:${rot}deg;
        `;
        layer.appendChild(wrap);
    });
 
    // ── PILLS ──
    const pillLayer = document.getElementById('pillsLayer');
    const pColors = [
        'rgba(93,177,53,0.4)','rgba(30,107,181,0.4)',
        'rgba(125,212,85,0.3)','rgba(58,143,221,0.3)',
    ];
    for(let i=0; i<22; i++){
        const el = document.createElement('div');
        el.className = 'med-pill';
        const w=22+Math.random()*26, h=8+Math.random()*5, r=Math.random()*180;
        const c=pColors[i%pColors.length];
        el.style.cssText=`
            width:${w}px;height:${h}px;
            background:${c}; box-shadow:0 0 8px ${c};
            left:${Math.random()*95}%;top:${Math.random()*95}%;
            --mpd:${5+Math.random()*8}s; --mpde:${Math.random()*10}s; --mpr:${r}deg;
        `;
        pillLayer.appendChild(el);
    }
 
    // ── CROSS MARKS ──
    const crossLayer = document.getElementById('crossLayer');
    [{l:'6%',t:'20%'},{l:'90%',t:'15%'},{l:'8%',t:'75%'},{l:'87%',t:'72%'},
     {l:'45%',t:'5%'},{l:'50%',t:'90%'},{l:'25%',t:'55%'},{l:'73%',t:'50%'}
    ].forEach((p,i)=>{
        const el = document.createElement('div');
        el.className = 'cross-mark';
        const s=18+Math.random()*22;
        el.textContent='✚';
        el.style.cssText=`left:${p.l};top:${p.t};--cms:${s}px;--cmd:${5+Math.random()*6}s;--cmde:${Math.random()*9}s;`;
        crossLayer.appendChild(el);
    });
})();
</script>
    <script src="{{ asset('backend/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('backend/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('backend/assets/js/misc.js') }}"></script>
</body>
</html>
