<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login - Red Labs</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Lato:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body, html {
            height: 100%;
            font-family: 'Lato', sans-serif;
            overflow: hidden;
        }

        /* ── ANIMATED BACKGROUND ── */
        .agri-bg {
            position: fixed;
            inset: 0;
            background: linear-gradient(160deg, #0d2b1a 0%, #1a4a2e 40%, #0f3320 70%, #0a1f12 100%);
            overflow: hidden;
            z-index: 0;
        }

        /* Subtle grid lines like farm rows */
        .agri-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(90deg, rgba(255,255,255,0.03) 0px, transparent 1px, transparent 80px),
                repeating-linear-gradient(0deg, rgba(255,255,255,0.03) 0px, transparent 1px, transparent 80px);
            animation: gridDrift 20s linear infinite;
        }

        @keyframes gridDrift {
            from { transform: translateY(0); }
            to   { transform: translateY(80px); }
        }

        /* ── FLOATING MOLECULES / DROPLETS ── */
        .molecules { position: absolute; inset: 0; pointer-events: none; }

        .mol {
            position: absolute;
            border-radius: 50%;
            opacity: 0;
            animation: floatUp var(--dur) ease-in var(--delay) infinite;
        }
        .mol.blue  { background: radial-gradient(circle at 35% 35%, #7fd7ff, #0088cc88); box-shadow: 0 0 12px #00aaff55; }
        .mol.green { background: radial-gradient(circle at 35% 35%, #a8ff78, #22863688); box-shadow: 0 0 12px #44cc6655; }
        .mol.amber { background: radial-gradient(circle at 35% 35%, #ffe066, #cc880088); box-shadow: 0 0 12px #ffaa0055; }

        @keyframes floatUp {
            0%   { opacity: 0; transform: translateY(0) scale(0.6); }
            15%  { opacity: 0.85; }
            80%  { opacity: 0.5; }
            100% { opacity: 0; transform: translateY(-420px) scale(1.1); }
        }

        /* ── SVG ICONS FLOATING ── */
        .icons-layer { position: absolute; inset: 0; pointer-events: none; }

        .float-icon {
            position: absolute;
            opacity: 0;
            animation: iconFloat var(--idur) ease-in-out var(--idelay) infinite;
            filter: drop-shadow(0 0 8px var(--iglow));
        }

        @keyframes iconFloat {
            0%   { opacity: 0; transform: translateY(20px) rotate(0deg) scale(0.8); }
            20%  { opacity: var(--iop); }
            80%  { opacity: var(--iop); }
            100% { opacity: 0; transform: translateY(-60px) rotate(var(--irot)) scale(1); }
        }

        /* ── SPRAY LINES ── */
        .spray-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .spray-line {
            position: absolute;
            bottom: -10px;
            width: 2px;
            border-radius: 1px;
            background: linear-gradient(to top, rgba(100,220,160,0.7), transparent);
            transform-origin: bottom center;
            animation: sprayShoot var(--sdur) ease-out var(--sdelay) infinite;
            opacity: 0;
        }

        @keyframes sprayShoot {
            0%   { opacity: 0; height: 0; transform: rotate(var(--sang)) scaleX(1); }
            10%  { opacity: 0.9; }
            60%  { opacity: 0.4; height: var(--slen); }
            100% { opacity: 0; height: var(--slen); }
        }

        /* ── LEAF PARTICLES ── */
        .leaf {
            position: absolute;
            font-size: var(--lsize);
            opacity: 0;
            animation: leafDrift var(--ldur) ease-in-out var(--ldelay) infinite;
        }

        @keyframes leafDrift {
            0%   { opacity: 0; transform: translateY(-20px) translateX(0) rotate(0deg); }
            20%  { opacity: 0.7; }
            80%  { opacity: 0.4; }
            100% { opacity: 0; transform: translateY(100vh) translateX(var(--ldx)) rotate(360deg); }
        }

        /* ── SCAN LINE OVERLAY ── */
        .scanlines {
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 3px,
                rgba(0,0,0,0.08) 3px,
                rgba(0,0,0,0.08) 4px
            );
            pointer-events: none;
        }

        /* ── CONTENT WRAPPER ── */
        .container-scroller { position: relative; z-index: 1; height: 100vh; }
        .container-fluid.page-body-wrapper { height: 100%; }

        .content-wrapper {
            background: transparent !important;
            height: 100vh;
            display: flex;
            align-items: center;
        }

        /* ── LOGIN CARD ── */
        .auth-form-light {
            background: rgba(255, 255, 255, 0.07) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.15) !important;
            border-radius: 4px 24px 4px 24px !important;
            box-shadow:
                0 8px 60px rgba(0,0,0,0.5),
                0 0 0 1px rgba(100,220,140,0.1) inset !important;
            animation: cardAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes cardAppear {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Top glowing bar */
        .auth-form-light::before {
            content: '';
            display: block;
            height: 3px;
            width: 60%;
            margin: 0 auto 24px;
            background: linear-gradient(90deg, transparent, #4cde8a, #7fd7ff, #4cde8a, transparent);
            border-radius: 2px;
            animation: barGlow 3s ease-in-out infinite;
        }

        @keyframes barGlow {
            0%, 100% { opacity: 0.6; width: 60%; }
            50%       { opacity: 1;   width: 75%; }
        }

        /* ── LOGO ── */
        .brand-logo img {
            width: 140px;
            margin-bottom: 16px;
            filter: drop-shadow(0 0 12px rgba(100,220,140,0.4));
        }

        /* ── HEADINGS ── */
        .auth-form-light h4 {
            color: #e8f5ee !important;
            font-family: 'Merriweather', serif;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
        }
        .auth-form-light h6 {
            color: rgba(200,230,210,0.7) !important;
            font-size: 0.82rem;
            letter-spacing: 0.3px;
        }

        /* ── INPUTS ── */
        .form-control {
            background: rgba(255,255,255,0.08) !important;
            border: 1px solid rgba(100,200,140,0.3) !important;
            color: #e8f5ee !important;
            border-radius: 6px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-control::placeholder { color: rgba(180,210,190,0.5) !important; }
        .form-control:focus {
            border-color: #4cde8a !important;
            box-shadow: 0 0 0 3px rgba(76,222,138,0.15) !important;
            background: rgba(255,255,255,0.12) !important;
            outline: none;
        }

        /* ── BUTTON ── */
        .btn-brand {
            background: linear-gradient(135deg, #30674D, #1d8a4e) !important;
            color: #fff !important;
            font-weight: 600;
            letter-spacing: 1.5px;
            font-size: 0.85rem;
            border: none;
            border-radius: 6px;
            padding: 14px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.3s;
            box-shadow: 0 4px 20px rgba(48,103,77,0.5);
        }
        .btn-brand::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s;
        }
        .btn-brand:hover { transform: translateY(-1px); box-shadow: 0 6px 28px rgba(48,103,77,0.7); }
        .btn-brand:hover::after { transform: translateX(100%); }

        /* ── LINKS & LABELS ── */
        .form-check-label, .text-muted { color: rgba(200,230,210,0.65) !important; }
        .auth-link { color: #6ddea0 !important; font-size: 0.82rem; }
        .auth-link:hover { color: #a8f5c6 !important; }

        /* ── ALERT ── */
        .alert-danger {
            background: rgba(220,50,50,0.15) !important;
            border-color: rgba(220,50,50,0.3) !important;
            color: #ffb3b3 !important;
            border-radius: 6px;
        }

        /* ── BADGE / WATERMARK ── */
        .agri-badge {
            position: absolute;
            bottom: 18px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(150,200,170,0.4);
            font-size: 0.7rem;
            letter-spacing: 1px;
            white-space: nowrap;
        }
        .agri-badge span { font-size: 1rem; }
    </style>
</head>
<body>

<!-- ══════════════ ANIMATED BACKGROUND ══════════════ -->
<div class="agri-bg">
    <div class="scanlines"></div>

    <!-- Floating droplet molecules -->
    <div class="molecules" id="molecules"></div>

    <!-- Spray lines from bottom -->
    <div class="spray-container" id="sprays"></div>

    <!-- Floating leaves / plant icons -->
    <div class="icons-layer" id="icons"></div>

    <!-- Floating SVG elements -->
    <svg style="position:absolute;inset:0;width:100%;height:100%;pointer-events:none;" id="svgLayer"></svg>
</div>

<!-- ══════════════ PAGE CONTENT ══════════════ -->
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow w-100">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo text-center">
                            <img src="{{ asset('backend/assets/images/adminlogo.webp') }}" alt="logo">
                        </div>
                        <h4 class="text-center">Welcome Back!</h4>
                        <h6 class="font-weight-light text-center mb-4">Sign in to continue to DLLPL Admin.</h6>

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form class="pt-3" method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="form-group">
                                <input type="text"
                                       class="form-control form-control-lg @error('username') is-invalid @enderror"
                                       id="username" name="username"
                                       placeholder="Username"
                                       value="{{ old('username') }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password"
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       id="password" name="password"
                                       placeholder="Password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-3 d-grid gap-2">
                                <button type="submit" class="btn btn-block btn-brand btn-lg font-weight-medium auth-form-btn">
                                    SIGN IN
                                </button>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input" name="remember"> Keep me signed in
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                                
                            </div>
                        </form>
                    </div>

                    <!-- Watermark -->
                    <div class="agri-badge">
                        <span>🌿</span> PESTICIDES &amp; FERTILIZERS MANAGEMENT &nbsp;|&nbsp; <span>🌱</span> DLLPL
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="{{ asset('backend/assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('backend/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('backend/assets/js/misc.js') }}"></script>

<script>
(function () {
    'use strict';

    /* ── 1. FLOATING MOLECULES ── */
    const molContainer = document.getElementById('molecules');
    const molColors = ['blue', 'green', 'amber'];
    const molCount = 40;
    for (let i = 0; i < molCount; i++) {
        const el = document.createElement('div');
        el.className = 'mol ' + molColors[i % 3];
        const size = 6 + Math.random() * 18;
        el.style.cssText = `
            width:${size}px; height:${size}px;
            left:${Math.random()*100}%;
            bottom:${Math.random()*20}%;
            --dur:${4 + Math.random()*6}s;
            --delay:${Math.random()*8}s;
        `;
        molContainer.appendChild(el);
    }

    /* ── 2. SPRAY LINES ── */
    const sprayContainer = document.getElementById('sprays');
    const sprayCount = 18;
    for (let i = 0; i < sprayCount; i++) {
        const el = document.createElement('div');
        el.className = 'spray-line';
        const angle = -20 + Math.random() * 40;
        const len   = 80 + Math.random() * 200;
        el.style.cssText = `
            left:${5 + Math.random()*90}%;
            --sdur:${2 + Math.random()*4}s;
            --sdelay:${Math.random()*6}s;
            --sang:${angle}deg;
            --slen:${len}px;
        `;
        sprayContainer.appendChild(el);
    }

    /* ── 3. FALLING LEAVES / ICONS ── */
    const iconContainer = document.getElementById('icons');
    const leafEmojis = ['🌿','🍃','🌱','🌾','🍀','☘️'];
    const leafCount = 20;
    for (let i = 0; i < leafCount; i++) {
        const el = document.createElement('div');
        el.className = 'leaf';
        const dx = (Math.random() - 0.5) * 200;
        el.style.cssText = `
            left:${Math.random()*100}%;
            top:${-5 + Math.random()*-10}%;
            --lsize:${14 + Math.random()*18}px;
            --ldur:${6 + Math.random()*8}s;
            --ldelay:${Math.random()*10}s;
            --ldx:${dx}px;
        `;
        el.textContent = leafEmojis[Math.floor(Math.random()*leafEmojis.length)];
        iconContainer.appendChild(el);
    }

    /* ── 4. SVG FLOATING ICONS (pesticide bottle, plant, molecule) ── */
    const svgLayer = document.getElementById('svgLayer');
    const svgIcons = [
        // Fertilizer bag
        `<g>
          <rect x="-16" y="-20" width="32" height="36" rx="4" fill="rgba(255,200,80,0.18)" stroke="rgba(255,200,80,0.5)" stroke-width="1.5"/>
          <text x="0" y="6" text-anchor="middle" font-size="14" fill="rgba(255,220,100,0.7)">🌿</text>
          <rect x="-10" y="-20" width="20" height="7" rx="2" fill="rgba(255,200,80,0.3)" stroke="rgba(255,200,80,0.5)" stroke-width="1"/>
        </g>`,
        // Spray bottle
        `<g>
          <rect x="-10" y="-22" width="20" height="34" rx="5" fill="rgba(100,220,160,0.18)" stroke="rgba(100,220,160,0.5)" stroke-width="1.5"/>
          <rect x="2" y="-28" width="8" height="10" rx="2" fill="rgba(100,220,160,0.3)" stroke="rgba(100,220,160,0.5)" stroke-width="1"/>
          <line x1="10" y1="-23" x2="22" y2="-30" stroke="rgba(100,220,160,0.5)" stroke-width="1.5"/>
          <circle cx="23" cy="-31" r="3" fill="rgba(100,220,160,0.5)"/>
        </g>`,
        // Molecule hex
        `<g>
          <circle cx="0" cy="0" r="10" fill="none" stroke="rgba(127,215,255,0.4)" stroke-width="1.5"/>
          <circle cx="0" cy="0" r="4" fill="rgba(127,215,255,0.35)"/>
          <circle cx="14" cy="0"  r="3" fill="rgba(127,215,255,0.3)"/>
          <circle cx="-14" cy="0" r="3" fill="rgba(127,215,255,0.3)"/>
          <circle cx="7" cy="-12" r="3" fill="rgba(127,215,255,0.3)"/>
          <circle cx="-7" cy="12" r="3" fill="rgba(127,215,255,0.3)"/>
          <line x1="10" y1="0"  x2="14" y2="0"  stroke="rgba(127,215,255,0.4)" stroke-width="1"/>
          <line x1="-10" y1="0" x2="-14" y2="0" stroke="rgba(127,215,255,0.4)" stroke-width="1"/>
          <line x1="5" y1="-8"  x2="7" y2="-12"  stroke="rgba(127,215,255,0.4)" stroke-width="1"/>
          <line x1="-5" y1="8"  x2="-7" y2="12"  stroke="rgba(127,215,255,0.4)" stroke-width="1"/>
        </g>`,
        // Leaf shape
        `<g>
          <path d="M0,-25 C15,-15 20,5 0,20 C-20,5 -15,-15 0,-25Z"
                fill="rgba(80,200,120,0.2)" stroke="rgba(80,200,120,0.5)" stroke-width="1.5"/>
          <line x1="0" y1="-20" x2="0" y2="18" stroke="rgba(80,200,120,0.5)" stroke-width="1"/>
        </g>`,
        // Droplet
        `<g>
          <path d="M0,-20 C10,0 14,12 0,20 C-14,12 -10,0 0,-20Z"
                fill="rgba(100,180,255,0.25)" stroke="rgba(100,180,255,0.5)" stroke-width="1.5"/>
        </g>`
    ];

    const iconPositions = [
        {x:'8%',  y:'15%', op:0.55, dur:8,  delay:0},
        {x:'85%', y:'20%', op:0.45, dur:10, delay:2},
        {x:'15%', y:'65%', op:0.5,  dur:9,  delay:4},
        {x:'80%', y:'70%', op:0.4,  dur:7,  delay:1},
        {x:'50%', y:'10%', op:0.35, dur:11, delay:3},
        {x:'92%', y:'45%', op:0.45, dur:8,  delay:5},
        {x:'5%',  y:'40%', op:0.5,  dur:9,  delay:6},
        {x:'70%', y:'88%', op:0.4,  dur:10, delay:2.5},
        {x:'30%', y:'85%', op:0.45, dur:7,  delay:4.5},
        {x:'60%', y:'5%',  op:0.35, dur:12, delay:1.5},
    ];

    iconPositions.forEach((pos, idx) => {
        const icon = svgIcons[idx % svgIcons.length];
        const scale = 0.8 + Math.random() * 0.7;
        const rot   = Math.random() * 30 - 15;

        const foreignObj = document.createElementNS('http://www.w3.org/2000/svg','foreignObject');
        foreignObj.setAttribute('width', '80');
        foreignObj.setAttribute('height', '80');
        foreignObj.setAttribute('x', pos.x);
        foreignObj.setAttribute('y', pos.y);

        const g = document.createElementNS('http://www.w3.org/2000/svg','g');
        g.innerHTML = icon;
        g.setAttribute('transform', `translate(40,40) scale(${scale})`);
        g.style.cssText = `
            opacity:0;
            animation: iconFloat ${pos.dur}s ease-in-out ${pos.delay}s infinite;
            --iop:${pos.op};
            --irot:${rot}deg;
            --idur:${pos.dur}s;
            --idelay:${pos.delay}s;
        `;

        // We'll use a regular SVG group instead of foreignObject
        const wrapper = document.createElementNS('http://www.w3.org/2000/svg','g');
        wrapper.innerHTML = icon;

        // Convert % to approximate pixel values for SVG
        const svgEl = svgLayer;
        const W = window.innerWidth;
        const H = window.innerHeight;
        const px = parseFloat(pos.x) / 100 * W;
        const py = parseFloat(pos.y) / 100 * H;
        wrapper.setAttribute('transform', `translate(${px},${py}) scale(${scale})`);
        wrapper.style.opacity = '0';
        wrapper.style.animation = `iconFloat ${pos.dur}s ease-in-out ${pos.delay}s infinite`;
        wrapper.style.setProperty('--iop', pos.op);
        wrapper.style.setProperty('--irot', rot + 'deg');

        svgLayer.appendChild(wrapper);
    });
})();
</script>

<!-- Add keyframes for iconFloat inside the SVG layer context -->
<style>
@keyframes iconFloat {
    0%   { opacity: 0; transform: translateY(15px) rotate(0deg); }
    20%  { opacity: var(--iop, 0.45); }
    80%  { opacity: var(--iop, 0.45); }
    100% { opacity: 0; transform: translateY(-50px) rotate(var(--irot, 10deg)); }
}
</style>

</body>
</html>