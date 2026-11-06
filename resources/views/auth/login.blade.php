<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIMHUIM - Sistem Informasi Mini Hospital Universitas Islam Mulia Yogyakarta">
    <title>Login — SIMHUIM | Mini Hospital UIM Yogyakarta</title>
    <link rel="shortcut icon" href="{{ asset('images/logouim.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        inter: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        teal: {
                            850: '#0d7a6e',
                        }
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.6s ease-out forwards',
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                        'slide-right': 'slideRight 0.7s ease-out forwards',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideRight: {
                            '0%': { opacity: '0', transform: 'translateX(-20px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-8px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            overflow: hidden;
        }

        /* Left panel background */
        .hero-panel {
            background-image:
                linear-gradient(
                    135deg,
                    rgba(4, 78, 70, 0.93) 0%,
                    rgba(13, 118, 110, 0.87) 40%,
                    rgba(6, 95, 84, 0.92) 100%
                ),
                url('{{ asset('images/uimbg.jpg') }}');
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
        }

        /* Decorative geometric pattern */
        .hero-panel::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .hero-panel::after {
            content: '';
            position: absolute;
            bottom: -120px;
            left: -60px;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        /* Animated decorative circles */
        .deco-circle-1 {
            position: absolute;
            top: 15%;
            right: 10%;
            width: 200px;
            height: 200px;
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            animation: float 7s ease-in-out infinite;
        }
        .deco-circle-2 {
            position: absolute;
            bottom: 20%;
            right: 5%;
            width: 100px;
            height: 100px;
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 50%;
            animation: float 5s ease-in-out infinite reverse;
        }
        .deco-dots {
            position: absolute;
            top: 55%;
            left: 5%;
            display: grid;
            grid-template-columns: repeat(5, 8px);
            grid-template-rows: repeat(5, 8px);
            gap: 10px;
            opacity: 0.12;
        }
        .deco-dots span {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: white;
            display: block;
        }

        /* Islamic arch decorative line */
        .arch-line {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(to right, transparent, rgba(52, 211, 153, 0.6), rgba(16, 185, 129, 0.8), rgba(52, 211, 153, 0.6), transparent);
        }

        /* Stats card */
        .stat-card {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border-radius: 14px;
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }

        /* Right panel scrollable */
        .right-panel {
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #e2e8f0 transparent;
        }
        .right-panel::-webkit-scrollbar { width: 4px; }
        .right-panel::-webkit-scrollbar-track { background: transparent; }
        .right-panel::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 2px; }

        /* Form input focus effects */
        .form-input {
            transition: all 0.25s ease;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
        }
        .form-input:focus {
            background: #ffffff;
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.12);
            outline: none;
        }
        .form-input:hover:not(:focus) {
            border-color: #cbd5e1;
            background: #ffffff;
        }

        /* Submit button */
        .btn-login {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14b8a6 100%);
            background-size: 200% 200%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.35);
        }
        .btn-login:hover {
            background-position: right center;
            box-shadow: 0 6px 20px rgba(13, 148, 136, 0.45);
            transform: translateY(-1px);
        }
        .btn-login:active { transform: translateY(0); }

        /* Divider badge */
        .badge-layanan {
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(5, 150, 105, 0.08) 100%);
            border: 1px solid rgba(13, 148, 136, 0.2);
        }

        /* Floating keyframes */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .delay-100 { animation-delay: 0.1s; animation-fill-mode: both; }
        .delay-200 { animation-delay: 0.2s; animation-fill-mode: both; }
        .delay-300 { animation-delay: 0.3s; animation-fill-mode: both; }
        .delay-400 { animation-delay: 0.4s; animation-fill-mode: both; }
        .delay-500 { animation-delay: 0.5s; animation-fill-mode: both; }

        /* Mobile: stack layout */
        @media (max-width: 1023px) {
            body { overflow: auto; }
            .hero-panel { min-height: 280px; }
        }
    </style>
</head>
<body class="h-full bg-slate-50 antialiased">

<div class="flex h-screen lg:h-screen">

    {{-- ===================== LEFT PANEL ===================== --}}
    <div class="hero-panel hidden lg:flex lg:w-[55%] xl:w-[58%] flex-col justify-between p-10 xl:p-14 relative">

        <!-- Decorative elements -->
        <div class="deco-circle-1"></div>
        <div class="deco-circle-2"></div>
        <div class="deco-dots">
            @for ($i = 0; $i < 25; $i++)
                <span></span>
            @endfor
        </div>
        <div class="arch-line"></div>

        <!-- TOP: Logo & Institution -->
        <div class="relative z-10 animate-fade-up">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-2xl bg-white shadow-xl p-2 flex items-center justify-center ring-4 ring-white/20 flex-shrink-0">
                    <img src="{{ asset('images/logouim.png') }}" alt="Logo UIM" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="text-white font-extrabold text-xl tracking-tight leading-tight">
                        Universitas Islam Mulia
                    </div>
                    <div class="text-emerald-200 text-sm font-medium">Yogyakarta</div>
                </div>
            </div>

            <div class="mt-8 h-px bg-gradient-to-r from-white/30 via-white/10 to-transparent"></div>
        </div>

        <!-- MIDDLE: Main Content -->
        <div class="relative z-10 flex-1 flex flex-col justify-center py-8">

            <!-- System Name -->
            <div class="animate-fade-up delay-100">
                <div class="inline-flex items-center space-x-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 mb-5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse-slow"></span>
                    <span class="text-white/90 text-xs font-semibold tracking-widest uppercase">Sistem Aktif</span>
                </div>

                <h1 class="text-white font-extrabold leading-none tracking-tight">
                    <span class="block text-5xl xl:text-6xl">SIMHUIM</span>
                    <span class="block text-lg xl:text-xl font-semibold text-emerald-200/90 mt-2">
                        Sistem Informasi Mini Hospital
                    </span>
                </h1>

                <p class="mt-5 text-white/70 text-sm xl:text-base leading-relaxed max-w-md font-inter">
                    Platform manajemen layanan kesehatan terpadu Mini Hospital
                    <strong class="text-white/90">Universitas Islam Mulia Yogyakarta</strong>,
                    meliputi pendaftaran pasien, poliklinik, rawat inap, dan e-resep digital.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-3 gap-3 mt-8 animate-fade-up delay-200">
                <div class="stat-card p-4 text-center">
                    <div class="text-2xl xl:text-3xl font-extrabold text-white">4</div>
                    <div class="text-emerald-200/80 text-[11px] font-medium mt-0.5 uppercase tracking-wider">Peran Akses</div>
                </div>
                <div class="stat-card p-4 text-center">
                    <div class="text-2xl xl:text-3xl font-extrabold text-white">10+</div>
                    <div class="text-emerald-200/80 text-[11px] font-medium mt-0.5 uppercase tracking-wider">Poliklinik</div>
                </div>
                <div class="stat-card p-4 text-center">
                    <div class="text-2xl xl:text-3xl font-extrabold text-white">24/7</div>
                    <div class="text-emerald-200/80 text-[11px] font-medium mt-0.5 uppercase tracking-wider">Layanan</div>
                </div>
            </div>

            <!-- Services -->
            <div class="flex flex-wrap gap-2 mt-6 animate-fade-up delay-300">
                @foreach(['Rawat Jalan', 'Rawat Inap', 'E-Resep', 'Manajemen Pasien', 'Rekam Medis'] as $svc)
                <span class="badge-layanan inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg text-xs text-white/85 font-medium">
                    <i class="fa-solid fa-check text-emerald-300 text-[9px]"></i>
                    <span>{{ $svc }}</span>
                </span>
                @endforeach
            </div>
        </div>

        <!-- BOTTOM: Address -->
        <div class="relative z-10 animate-fade-up delay-400">
            <div class="h-px bg-gradient-to-r from-white/30 via-white/10 to-transparent mb-5"></div>
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <i class="fa-solid fa-location-dot text-emerald-300 text-xs"></i>
                </div>
                <div>
                    <div class="text-white/50 text-[10px] font-bold uppercase tracking-widest mb-1">Alamat Fasilitas</div>
                    <div class="text-white/80 text-xs leading-relaxed font-inter">
                        Jl. Wates, Plawonan, Argomulyo, Sedayu,<br>
                        Bantul, Daerah Istimewa Yogyakarta
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3 mt-4 text-white/40 text-[10px] font-inter">
                <span>Mini Hospital UIM</span>
                <span class="w-1 h-1 bg-white/30 rounded-full"></span>
                <span>© {{ date('Y') }}</span>
                <span class="w-1 h-1 bg-white/30 rounded-full"></span>
                <span>v2.0</span>
            </div>
        </div>
    </div>

    {{-- ===================== RIGHT PANEL (Form) ===================== --}}
    <div class="right-panel flex-1 lg:w-[45%] xl:w-[42%] flex flex-col bg-white">

        <!-- Mobile Header -->
        <div class="lg:hidden hero-panel flex flex-col items-center justify-center py-12 px-6 text-center relative">
            <div class="arch-line"></div>
            <div class="w-16 h-16 rounded-2xl bg-white shadow-xl p-2 mb-4 ring-4 ring-white/20">
                <img src="{{ asset('images/logouim.png') }}" alt="Logo UIM" class="w-full h-full object-contain">
            </div>
            <h1 class="text-white font-extrabold text-2xl tracking-tight">SIMHUIM</h1>
            <p class="text-emerald-100/80 text-sm mt-1">Mini Hospital UIM Yogyakarta</p>
        </div>

        <!-- Form Section -->
        <div class="flex-1 flex flex-col justify-center px-6 sm:px-10 xl:px-14 py-10">

            <!-- Form Header -->
            <div class="mb-8 animate-fade-up">
                <div class="inline-flex items-center space-x-2 bg-teal-50 border border-teal-100 rounded-full px-3.5 py-1.5 mb-4">
                    <i class="fa-solid fa-shield-halved text-teal-600 text-[10px]"></i>
                    <span class="text-teal-700 text-xs font-bold tracking-wider uppercase">Portal Login Aman</span>
                </div>
                <h2 class="text-2xl xl:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Masuk ke Sistem
                </h2>
                <p class="text-slate-500 text-sm mt-1.5 font-inter">
                    Gunakan kredensial akun yang diberikan oleh administrator.
                </p>
            </div>

            {{-- Alert: Success --}}
            @if(session('success'))
            <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 p-3.5 flex items-center space-x-3 animate-fade-up">
                <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-circle-check text-sm"></i>
                </div>
                <span class="text-sm text-emerald-800 font-medium">{{ session('success') }}</span>
            </div>
            @endif

            {{-- Alert: Error --}}
            @if($errors->any())
            <div class="mb-5 rounded-xl bg-rose-50 border border-rose-200 p-3.5 flex items-start space-x-3 animate-fade-up">
                <div class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                    <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                </div>
                <div>
                    <div class="text-sm font-semibold text-rose-800">Login Gagal</div>
                    <div class="text-xs text-rose-700 mt-0.5">{{ $errors->first() }}</div>
                </div>
            </div>
            @endif

            {{-- Login Form --}}
            <form action="{{ route('login') }}" method="POST" class="space-y-5" id="loginForm">
                @csrf

                {{-- Username --}}
                <div class="animate-fade-up delay-100">
                    <label for="username" class="block text-xs font-bold text-slate-600 uppercase tracking-widest mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-regular fa-user text-slate-400 text-sm"></i>
                        </div>
                        <input
                            id="username"
                            name="username"
                            type="text"
                            required
                            autofocus
                            autocomplete="username"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username Anda"
                            class="form-input block w-full pl-11 pr-4 py-3 text-sm rounded-xl text-slate-900 placeholder:text-slate-400 font-inter"
                        >
                    </div>
                </div>

                {{-- Password --}}
                <div class="animate-fade-up delay-200" x-data="{ show: false }">
                    <label for="password" class="block text-xs font-bold text-slate-600 uppercase tracking-widest mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-slate-400 text-sm"></i>
                        </div>
                        <input
                            id="password"
                            name="password"
                            :type="show ? 'text' : 'password'"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="form-input block w-full pl-11 pr-12 py-3 text-sm rounded-xl text-slate-900 placeholder:text-slate-400 font-inter"
                        >
                        <button type="button"
                                @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition">
                            <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between animate-fade-up delay-300">
                    <label class="flex items-center space-x-2.5 cursor-pointer group">
                        <div class="relative">
                            <input id="remember" name="remember" type="checkbox"
                                   class="sr-only peer">
                            <div class="w-5 h-5 border-2 border-slate-300 rounded-md peer-checked:bg-teal-600 peer-checked:border-teal-600 transition-all flex items-center justify-center"
                                 onclick="document.getElementById('remember').click()">
                                <i class="fa-solid fa-check text-white text-[9px] hidden peer-checked:block" id="checkIcon"></i>
                            </div>
                        </div>
                        <span class="text-xs font-medium text-slate-600 group-hover:text-slate-800 transition">Ingat sesi login saya</span>
                    </label>
                </div>

                {{-- Submit --}}
                <div class="animate-fade-up delay-400 pt-1">
                    <button type="submit"
                            id="submitBtn"
                            class="btn-login w-full flex items-center justify-center space-x-2.5 py-3.5 px-6 rounded-xl text-sm font-bold text-white tracking-wide">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Masuk ke Sistem</span>
                    </button>
                </div>
            </form>


            {{-- Bottom info --}}
            <div class="mt-8 pt-6 border-t border-slate-100 animate-fade-up delay-500">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-[11px] text-slate-400 font-inter">
                    <div class="flex items-center space-x-1.5">
                        <i class="fa-solid fa-circle-info text-teal-400 text-xs"></i>
                        <span>Butuh bantuan? Hubungi Administrator Sistem</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <i class="fa-solid fa-location-dot text-rose-400 text-xs"></i>
                        <span class="text-slate-400">Sedayu, Bantul, D.I. Yogyakarta</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Alpine.js for toggle password -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

<script>
    // Custom checkbox behavior
    document.addEventListener('DOMContentLoaded', () => {
        const checkbox = document.getElementById('remember');
        const checkIcon = document.getElementById('checkIcon');

        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                checkIcon.style.display = 'block';
            } else {
                checkIcon.style.display = 'none';
            }
        });

        // Submit button loading state
        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', () => {
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>Memverifikasi...</span>';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.85';
        });
    });
</script>
</body>
</html>
