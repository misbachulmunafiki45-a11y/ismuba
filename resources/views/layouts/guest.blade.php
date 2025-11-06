<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>ISMUBA DIGITAL</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="icon" type="image/png" href="{{ asset('storage/stm.png') }}">
        <style>
            /* Background image full; overlay dipisah sebagai elemen fixed agar stabil di tablet */
            body.auth-bg {
                background-image: url('{{ asset('img/masjid.jpg') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
            .bg-overlay {
                position: fixed;
                inset: 0;
                background: rgba(10, 20, 40, 0.45); /* sedikit lebih terang agar lingkaran terlihat */
                pointer-events: none;
                z-index: 1; /* overlay di atas elemen dekoratif */
            }

            /* Dekorasi ripple circles di background */
            .bg-circles { position: fixed; inset: 0; pointer-events: none; z-index: 2; }
            .circle { position: absolute; border-radius: 50%; background: #1e57e9; animation: ripple 15s infinite; box-shadow: 0 0 1px 0 #508fb9; }
            .bg-circles > .circle:nth-child(odd) { background: #1e57e9; }
            .bg-circles > .circle:nth-child(even) { background: #ffffff; }
            .bg-circles .xxlarge { background: #ffffff; }
            /* Penyesuaian komposisi: gradien 45°, opacity lembut, durasi animasi, posisi */
            .bg-circles .circle.medium { background: linear-gradient(45deg, #2b6af5 0%, #1e57e9 100%) !important; animation-duration: 12s; }
            .bg-circles .circle.xlarge { background: linear-gradient(45deg, #2b6af5 0%, #1e57e9 100%) !important; animation-duration: 14s; }
            .bg-circles .circle.small { animation-duration: 16s; }
            .bg-circles .circle.large { animation-duration: 18s; }
            .bg-circles .circle.xxlarge { animation-duration: 20s; }
            .shade1 { opacity: 0.10; }
            .shade2 { opacity: 0.18; }
            .shade3 { opacity: 0.26; }
            .shade4 { opacity: 0.34; }
            .shade5 { opacity: 0.42; }
            .small { left: -80px; bottom: -120px; }
            .medium { left: -240px; bottom: -180px; }
            .large { left: -320px; bottom: -360px; }
            .xlarge { left: -420px; bottom: -420px; }
            .xxlarge { left: -520px; bottom: -560px; }
            /* Warna spesifik per ukuran sesuai permintaan */
            .bg-circles .circle.small { background: #ffffff; }
            .bg-circles .circle.medium { background: linear-gradient(180deg, #2b6af5 0%, #1e57e9 100%); }
            .bg-circles .circle.large { background: #ffffff; }
            .bg-circles .circle.xlarge { background: linear-gradient(180deg, #2b6af5 0%, #1e57e9 100%); }
            .bg-circles .circle.xxlarge { background: #ffffff; }
            .small { width: 200px; height: 200px; left: -100px; bottom: -100px; }
            .medium { width: 400px; height: 400px; left: -200px; bottom: -200px; }
            .large { width: 600px; height: 600px; left: -300px; bottom: -300px; }
            .xlarge { width: 800px; height: 800px; left: -400px; bottom: -400px; }
            .xxlarge { width: 1000px; height: 1000px; left: -500px; bottom: -500px; }
            .shade1 { opacity: 0.15; }
            .shade2 { opacity: 0.25; }
            .shade3 { opacity: 0.35; }
            .shade4 { opacity: 0.45; }
            .shade5 { opacity: 0.55; }
            @keyframes ripple { 0% { transform: scale(0.8); } 50% { transform: scale(1.2); } 100% { transform: scale(0.8); } }

            /* Teks hero di kiri */
            .login-hero {
                color: #ffffff;
            }
            .login-hero .brand {
                letter-spacing: 3px;
                font-weight: 600;
                opacity: 0.9;
                text-shadow: 0 2px 8px rgba(0,0,0,0.55);
            }
            .login-hero .brand-quote {
                opacity: 1;
                color: #ffffff; /* lebih terang */
                text-shadow: 0 2px 10px rgba(0,0,0,0.6), 0 12px 26px rgba(0,0,0,0.35);
            }
            .login-hero .headline {
                font-size: clamp(28px, 5vw, 56px);
                line-height: 1.05;
                font-weight: 800;
                text-shadow: 0 1px 0 rgba(0,0,0,0.7), 0 3px 12px rgba(0,0,0,0.6), 0 10px 28px rgba(0,0,0,0.35);
            }
            .login-hero .subcopy {
                max-width: 520px;
                opacity: 0.95;
                text-shadow: 0 2px 12px rgba(0,0,0,0.6);
            }

            /* Kartu login transparan (glassmorphism) di kanan */
            .login-card {
                background: rgba(255, 255, 255, 0.35);
                border: 1px solid rgba(255, 255, 255, 0.45);
                border-radius: 16px;
                box-shadow: 0 20px 55px rgba(0,0,0,0.35);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                /* Hindari artefak garis pada tepi saat blur + radius */
                background-clip: padding-box;
            }

            /* Input styling agar lebih mirip contoh (lebih lembut dan rounded) */
            .login-card input[type="text"],
            .login-card input[type="password"],
            .login-card input[type="email"] {
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid rgba(255, 255, 255, 0.95);
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            }

            /* Tombol utama login: biru penuh seperti di model */
            .btn-login {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: .5rem;
                background: linear-gradient(180deg, #2b6af5 0%, #1e57e9 100%);
                color: #fff;
                border: none;
                border-radius: 12px;
                padding: 12px 16px;
                font-weight: 700;
                letter-spacing: .02em;
                box-shadow: 0 12px 24px rgba(30, 87, 233, 0.35);
                transition: transform .08s ease, box-shadow .2s ease, filter .2s ease;
            }
            .btn-login:hover { filter: brightness(1.05); box-shadow: 0 16px 28px rgba(30, 87, 233, 0.45); }
            .btn-login:active { transform: translateY(1px); }

            /* Separator "or" dengan garis kiri-kanan */
            .separator { display: flex; align-items: center; gap: .75rem; opacity: .9; }
            .separator::before, .separator::after { content: ""; height: 1px; flex: 1; background: rgba(255,255,255,0.65); }
            .separator span { font-size: .75rem; color: rgba(255,255,255,0.95); text-transform: uppercase; letter-spacing: .12em; }

            /* Tombol Google (placeholder) */
            .btn-oauth-google {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: .5rem;
                background: rgba(255,255,255,0.92);
                color: #1f2937;
                border: 1px solid rgba(255,255,255,0.95);
                border-radius: 12px;
                padding: 10px 14px;
                font-weight: 600;
                box-shadow: 0 6px 18px rgba(0,0,0,0.12);
                cursor: not-allowed; /* placeholder saja */
            }
        </style>
        <style>
            :root {
                --greenSeaweed: rgba(2, 128, 144, 1);
                --blueQueen: rgba(69, 105, 144, 1);
                --redFire: rgba(244, 91, 105, 1);
            }

            /* Adaptasi gaya .login menjadi .login-card tanpa mengubah layout absolute */
            .login-card {
                overflow: hidden;
                background-color: #ffffff;
                padding: 40px 30px 30px 30px;
                border-radius: 10px;
                position: relative; /* tetap mengikuti flex container */
                transition: transform 300ms, box-shadow 300ms;
                box-shadow: 5px 10px 10px rgba(2, 128, 144, 0.2);
            }

            .login-card::before,
            .login-card::after {
                content: '';
                position: absolute;
                width: 600px;
                height: 600px;
                border-top-left-radius: 40%;
                border-top-right-radius: 45%;
                border-bottom-left-radius: 35%;
                border-bottom-right-radius: 40%;
                z-index: -1;
            }

            .login-card::before {
                left: 40%;
                bottom: -130%;
                background-color: rgba(69, 105, 144, 0.15); /* blueQueen */
                animation: wawes 6s infinite linear;
            }

            .login-card::after {
                left: 35%;
                bottom: -125%;
                background-color: rgba(2, 128, 144, 0.2); /* greenSeaweed */
                animation: wawes 7s infinite;
            }

            @keyframes wawes {
                from { transform: rotate(0); }
                to { transform: rotate(360deg); }
            }
        </style>
        <link rel="icon" type="image/png" href="{{ asset('storage/stm.png') }}">
    </head>
    <body class="font-sans text-gray-900 antialiased auth-bg">
        <div class="bg-overlay"></div>
        <div class="bg-circles">
            <div class="circle small shade1"></div>
            <div class="circle medium shade2"></div>
            <div class="circle large shade3"></div>
            <div class="circle xlarge shade4"></div>
            <div class="circle xxlarge shade5"></div>
        </div>
        <div class="min-h-screen flex items-center justify-center relative z-10">
            <div class="w-full max-w-6xl px-6">
                <div class="flex flex-col lg:flex-row items-start lg:items-start justify-start lg:justify-between gap-6 lg:gap-8 px-4 md:px-6">
                    <!-- Kiri: hero teks -->
                    <div class="login-hero w-full lg:max-w-5xl flex-1 order-1 mb-8 lg:mb-0 text-left">
                        <div class="brand text-sm mb-5">Islamic</div>
                        <div class="headline mb-4 text-left">ISMUBA<br/>SMKS Muhammadiyah 2 Genteng</div>
                        <div class="brand brand-quote text-sm mb-5">
                         Carilah ilmu di mana saja, jadilah apa saja, tapi kembalilah kepada Muhammadiyah
                        </div>
                    </div>

                    <!-- Kanan: kartu login transparan -->
                    <div class="w-full md:w-[480px] md:mx-auto lg:w-[380px] flex-none order-2">
                        <div class="login-card w-full mx-auto px-6 py-6 rounded-2xl">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
