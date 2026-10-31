<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIMHUIM - Mini Hospital UIM')</title>
    <link rel="shortcut icon" href="{{ asset('images/logouim.png') }}" type="image/png">

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Alpine.js for lightweight UI interaction -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .glass-nav {
            background: rgba(15, 118, 110, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
    @stack('styles')
</head>
<body class="h-full flex flex-col font-sans text-slate-800 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Main Navigation Bar -->
    <header class="glass-nav text-white sticky top-0 z-40 border-b border-teal-600 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand & Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-xl bg-white p-1 shadow-sm flex items-center justify-center transition-transform group-hover:scale-105">
                            <img src="{{ asset('images/logouim.png') }}" alt="Logo UIM" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <div class="font-bold text-lg leading-tight tracking-tight text-white flex items-center gap-2">
                                <span>SIMHUIM</span>
                                <span class="text-xs bg-emerald-400/20 text-emerald-200 border border-emerald-400/30 px-2 py-0.5 rounded-full font-medium">Laravel 13</span>
                            </div>
                            <div class="text-xs text-teal-100/80 font-normal">Mini Hospital UIM Yogyakarta</div>
                        </div>
                    </a>

                    <!-- Nav Links according to Role -->
                    @auth
                    <nav class="hidden md:flex items-center space-x-1 ml-6 border-l border-teal-600/60 pl-6">
                        @if(auth()->user()->isFrontOffice())
                            <a href="{{ route('front-office.pasien.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('front-office.pasien.*') ? 'bg-white/20 text-white shadow-inner font-semibold' : 'text-teal-100 hover:bg-white/10 hover:text-white' }}">
                                <i class="fa-solid fa-users mr-1.5 opacity-80"></i> Pasien
                            </a>
                            <a href="{{ route('front-office.prj.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('front-office.prj.*') ? 'bg-white/20 text-white shadow-inner font-semibold' : 'text-teal-100 hover:bg-white/10 hover:text-white' }}">
                                <i class="fa-solid fa-stethoscope mr-1.5 opacity-80"></i> Rawat Jalan
                            </a>
                            <a href="{{ route('front-office.pri.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('front-office.pri.*') ? 'bg-white/20 text-white shadow-inner font-semibold' : 'text-teal-100 hover:bg-white/10 hover:text-white' }}">
                                <i class="fa-solid fa-bed-pulse mr-1.5 opacity-80"></i> Rawat Inap
                            </a>
                            <a href="{{ route('front-office.tarif.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('front-office.tarif.*') ? 'bg-white/20 text-white shadow-inner font-semibold' : 'text-teal-100 hover:bg-white/10 hover:text-white' }}">
                                <i class="fa-solid fa-receipt mr-1.5 opacity-80"></i> Master Tarif
                            </a>
                        @elseif(auth()->user()->isDepartemen())
                            <a href="{{ route('departemen.pasien.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('departemen.pasien.*') ? 'bg-white/20 text-white shadow-inner font-semibold' : 'text-teal-100 hover:bg-white/10 hover:text-white' }}">
                                <i class="fa-solid fa-hospital-user mr-1.5 opacity-80"></i> Antrean Pasien Poli
                            </a>
                            <a href="{{ route('departemen.dokter.jadwal') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('departemen.dokter.*') ? 'bg-white/20 text-white shadow-inner font-semibold' : 'text-teal-100 hover:bg-white/10 hover:text-white' }}">
                                <i class="fa-solid fa-user-doctor mr-1.5 opacity-80"></i> Jadwal Dokter
                            </a>
                        @elseif(auth()->user()->isDokter())
                            <a href="{{ route('dokter.pasien.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('dokter.pasien.*') ? 'bg-white/20 text-white shadow-inner font-semibold' : 'text-teal-100 hover:bg-white/10 hover:text-white' }}">
                                <i class="fa-solid fa-clipboard-user mr-1.5 opacity-80"></i> Pasien Pemeriksaan
                            </a>
                            <a href="{{ route('dokter.resep.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('dokter.resep.*') ? 'bg-white/20 text-white shadow-inner font-semibold' : 'text-teal-100 hover:bg-white/10 hover:text-white' }}">
                                <i class="fa-solid fa-prescription mr-1.5 opacity-80"></i> E-Resep Obat
                            </a>
                        @endif
                    </nav>
                    @endauth
                </div>

                <!-- User Profile & Action -->
                @auth
                <div class="flex items-center space-x-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-sm font-semibold text-white leading-snug">{{ auth()->user()->name }}</span>
                        <div class="flex items-center justify-end space-x-1.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-emerald-500/20 text-emerald-200 border border-emerald-400/30">
                                {{ auth()->user()->role }}
                            </span>
                            @if(auth()->user()->grup && auth()->user()->grup !== auth()->user()->name)
                                <span class="text-[11px] text-teal-200/90 font-medium">({{ auth()->user()->grup }})</span>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin keluar?')"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-500/20 text-rose-100 hover:bg-rose-500 hover:text-white border border-rose-400/30 transition-all shadow-sm"
                                title="Keluar dari Aplikasi">
                            <i class="fa-solid fa-power-off mr-1.5"></i> Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>

        <!-- Mobile Navigation bar -->
        @auth
        <div class="md:hidden border-t border-teal-600/60 px-4 py-2 flex overflow-x-auto space-x-2 text-xs">
            @if(auth()->user()->isFrontOffice())
                <a href="{{ route('front-office.pasien.index') }}" class="whitespace-nowrap px-2.5 py-1.5 rounded {{ request()->routeIs('front-office.pasien.*') ? 'bg-white/20 font-bold' : 'text-teal-100' }}">Pasien</a>
                <a href="{{ route('front-office.prj.index') }}" class="whitespace-nowrap px-2.5 py-1.5 rounded {{ request()->routeIs('front-office.prj.*') ? 'bg-white/20 font-bold' : 'text-teal-100' }}">Rawat Jalan</a>
                <a href="{{ route('front-office.pri.index') }}" class="whitespace-nowrap px-2.5 py-1.5 rounded {{ request()->routeIs('front-office.pri.*') ? 'bg-white/20 font-bold' : 'text-teal-100' }}">Rawat Inap</a>
                <a href="{{ route('front-office.tarif.index') }}" class="whitespace-nowrap px-2.5 py-1.5 rounded {{ request()->routeIs('front-office.tarif.*') ? 'bg-white/20 font-bold' : 'text-teal-100' }}">Tarif</a>
            @elseif(auth()->user()->isDepartemen())
                <a href="{{ route('departemen.pasien.index') }}" class="whitespace-nowrap px-2.5 py-1.5 rounded {{ request()->routeIs('departemen.pasien.*') ? 'bg-white/20 font-bold' : 'text-teal-100' }}">Antrean Poli</a>
                <a href="{{ route('departemen.dokter.jadwal') }}" class="whitespace-nowrap px-2.5 py-1.5 rounded {{ request()->routeIs('departemen.dokter.*') ? 'bg-white/20 font-bold' : 'text-teal-100' }}">Jadwal Dokter</a>
            @elseif(auth()->user()->isDokter())
                <a href="{{ route('dokter.pasien.index') }}" class="whitespace-nowrap px-2.5 py-1.5 rounded {{ request()->routeIs('dokter.pasien.*') ? 'bg-white/20 font-bold' : 'text-teal-100' }}">Pemeriksaan</a>
                <a href="{{ route('dokter.resep.index') }}" class="whitespace-nowrap px-2.5 py-1.5 rounded {{ request()->routeIs('dokter.resep.*') ? 'bg-white/20 font-bold' : 'text-teal-100' }}">E-Resep</a>
            @endif
        </div>
        @endauth
    </header>

    <!-- Flash Alert Notifications -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4 shadow-sm flex items-start justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="text-sm font-medium text-emerald-900 leading-relaxed">
                        {{ session('success') }}
                    </div>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 ml-4">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 rounded-xl bg-rose-50 border border-rose-200 p-4 shadow-sm flex items-start justify-between">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center mt-0.5">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-rose-900">Perhatian:</div>
                        @if(session('error'))
                            <p class="text-sm text-rose-800">{{ session('error') }}</p>
                        @endif
                        @if($errors->any())
                            <ul class="list-disc list-inside text-sm text-rose-800 mt-1 space-y-0.5">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <button @click="show = false" class="text-rose-500 hover:text-rose-700 ml-4">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200/80 py-4 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} <strong class="font-semibold text-slate-700">Mini Hospital UIM Yogyakarta</strong>. Sistem Informasi Rumah Sakit Modern berbasis Laravel 13.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
