<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin — SIMHUIM')</title>
    <link rel="shortcut icon" href="{{ asset('images/simhuim-logo.svg') }}" type="image/svg+xml">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        inter: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, #0f766e 0%, #0d9488 40%, #115e59 100%);
            width: 260px;
            flex-shrink: 0;
            transition: width 0.3s ease;
            overflow: hidden;
        }
        .sidebar.collapsed { width: 68px; }
        .sidebar.collapsed .nav-label,
        .sidebar.collapsed .sidebar-header-text,
        .sidebar.collapsed .nav-group-label,
        .sidebar.collapsed .user-info { display: none; }
        .sidebar.collapsed .nav-item { justify-content: center; padding-left: 0; padding-right: 0; }
        .sidebar.collapsed .nav-item i { margin-right: 0; }

        /* Nav item */
        .nav-item {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            border-radius: 10px;
            margin: 2px 10px;
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.12);
            color: white;
        }
        .nav-item.active {
            background: rgba(255,255,255,0.18);
            color: white;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 10px;
            width: 3px;
            height: 28px;
            background: #34D399;
            border-radius: 2px;
        }
        .nav-item { position: relative; }
        .nav-item i { width: 18px; text-align: center; margin-right: 11px; font-size: 14px; flex-shrink: 0; }

        .nav-group-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.12em;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            padding: 16px 22px 6px;
        }

        .nav-divider {
            height: 1px;
            background: rgba(255,255,255,0.10);
            margin: 10px 16px;
        }

        /* Topbar */
        .topbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        /* Badge */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: linear-gradient(135deg, rgba(139,92,246,0.12), rgba(109,40,217,0.08));
            border: 1px solid rgba(139,92,246,0.25);
            color: #7c3aed;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* Logo SVG in sidebar */
        .sidebar-logo {
            width: 38px;
            height: 38px;
            background: white;
            border-radius: 10px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        /* Main content area */
        .main-content {
            flex: 1;
            overflow-y: auto;
            background: #f8fafc;
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 2px; }

        /* Flash alerts */
        .flash-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }
        .flash-error {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #9f1239;
        }

        /* Sidebar mobile overlay */
        @media (max-width: 1023px) {
            .sidebar {
                position: fixed;
                left: 0; top: 0; bottom: 0;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
        }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-slate-100 font-sans antialiased" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">

<div class="flex h-screen overflow-hidden">

    {{-- ======================== SIDEBAR ======================== --}}
    <aside class="sidebar overflow-y-auto flex flex-col"
           :class="{ 'collapsed': sidebarCollapsed, 'mobile-open': sidebarOpen }"
           id="sidebar">

        {{-- Sidebar Header --}}
        <div class="flex items-center gap-3 px-4 py-5 border-b border-white/10 flex-shrink-0">
            {{-- Logo SVG --}}
            <div class="sidebar-logo">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                    <!-- Gold left flame -->
                    <path d="M30,85 C18,70 15,52 22,36 C26,27 21,17 24,8 C28,18 26,28 32,38 C38,50 37,68 30,85Z" fill="#F59E0B"/>
                    <!-- Teal center flame -->
                    <path d="M50,88 C35,70 32,48 40,28 C44,17 39,7 43,0 C48,12 46,24 50,36 C56,52 55,72 50,88Z" fill="#0D9488"/>
                    <!-- Gold right flame -->
                    <path d="M70,85 C82,70 85,52 78,36 C74,27 79,17 76,8 C72,18 74,28 68,38 C62,50 63,68 70,85Z" fill="#F59E0B"/>
                    <!-- Teal highlight -->
                    <path d="M50,82 C42,65 41,48 47,33 C49,26 47,17 50,10 C53,17 51,26 54,33 C59,48 58,65 50,82Z" fill="#14B8A6" opacity="0.5"/>
                </svg>
            </div>
            <div class="sidebar-header-text overflow-hidden">
                <div class="font-extrabold text-white text-base tracking-tight leading-tight">SIMHUIM</div>
                <div class="text-teal-200/70 text-[11px] font-medium leading-tight">Mini Hospital UIM</div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 py-4">

            {{-- ADMIN GROUP --}}
            <div class="nav-group-label">Admin Panel</div>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span class="nav-label">Dashboard</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i>
                <span class="nav-label">Manajemen Pengguna</span>
            </a>

            <a href="{{ route('admin.dokters.index') }}"
               class="nav-item {{ request()->routeIs('admin.dokters.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-doctor"></i>
                <span class="nav-label">Data Dokter</span>
            </a>

            <a href="{{ route('admin.tarifs.index') }}"
               class="nav-item {{ request()->routeIs('admin.tarifs.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <span class="nav-label">Master Tarif</span>
            </a>

            {{-- DIVIDER --}}
            <div class="nav-divider"></div>
            <div class="nav-group-label">Layanan RS</div>

            <a href="{{ route('front-office.pasien.index') }}"
               class="nav-item {{ request()->routeIs('front-office.pasien.*') ? 'active' : '' }}">
                <i class="fa-solid fa-hospital-user"></i>
                <span class="nav-label">Data Pasien</span>
            </a>

            <a href="{{ route('front-office.prj.index') }}"
               class="nav-item {{ request()->routeIs('front-office.prj.*') ? 'active' : '' }}">
                <i class="fa-solid fa-stethoscope"></i>
                <span class="nav-label">Rawat Jalan</span>
            </a>

            <a href="{{ route('front-office.pri.index') }}"
               class="nav-item {{ request()->routeIs('front-office.pri.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bed-pulse"></i>
                <span class="nav-label">Rawat Inap</span>
            </a>

            <div class="nav-divider"></div>
        </nav>

        {{-- User info bottom --}}
        <div class="border-t border-white/10 px-4 py-4 flex-shrink-0">
            <div class="flex items-center gap-3 user-info">
                <div class="w-9 h-9 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-shield-halved text-yellow-300 text-sm"></i>
                </div>
                <div class="overflow-hidden">
                    <div class="text-white text-xs font-bold truncate leading-tight">{{ auth()->user()->name }}</div>
                    <div class="text-teal-200/70 text-[10px] font-medium">{{ auth()->user()->role }}</div>
                </div>
            </div>
        </div>
    </aside>

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen"
         x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden backdrop-blur-sm">
    </div>

    {{-- ======================== MAIN AREA ======================== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- ===== TOPBAR ===== --}}
        <div class="topbar flex-shrink-0">

            {{-- Toggle Sidebar (desktop collapse / mobile open) --}}
            <button @click="sidebarCollapsed = !sidebarCollapsed"
                    class="hidden lg:flex w-8 h-8 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition flex-shrink-0">
                <i class="fa-solid fa-bars text-sm"></i>
            </button>
            <button @click="sidebarOpen = !sidebarOpen"
                    class="flex lg:hidden w-8 h-8 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 transition flex-shrink-0">
                <i class="fa-solid fa-bars text-sm"></i>
            </button>

            {{-- Breadcrumb / Page title --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 text-xs text-slate-400 font-inter">
                    <i class="fa-solid fa-house text-[10px]"></i>
                    <span>/</span>
                    <span class="text-slate-600 font-medium truncate">@yield('breadcrumb', 'Admin Panel')</span>
                </div>
            </div>

            {{-- Right: Notifications + User --}}
            <div class="flex items-center gap-3 flex-shrink-0">

                {{-- Notification Bell --}}
                <button class="relative w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="fa-regular fa-bell text-sm"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
                </button>

                {{-- Divider --}}
                <div class="h-6 w-px bg-slate-200"></div>

                {{-- User Dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-xl hover:bg-slate-100 transition">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-teal-600 to-teal-800 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-shield-halved text-yellow-300 text-sm"></i>
                        </div>
                        <div class="hidden sm:block text-left">
                            <div class="text-xs font-bold text-slate-800 leading-tight truncate max-w-[120px]">{{ auth()->user()->name }}</div>
                            <div class="text-[10px] text-slate-400 font-inter">{{ auth()->user()->role }}</div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[9px] text-slate-400 transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="open"
                         x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.outside="open = false"
                         class="absolute right-0 top-full mt-2 w-52 bg-white rounded-xl shadow-xl border border-slate-200/80 overflow-hidden z-50">

                        <div class="px-4 py-3 border-b border-slate-100">
                            <div class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->name }}</div>
                            <div class="text-[11px] text-slate-400 truncate font-inter">{{ auth()->user()->username }}</div>
                            <div class="mt-1.5">
                                <span class="role-badge">
                                    <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                    {{ auth()->user()->role }}
                                </span>
                            </div>
                        </div>

                        <div class="py-1.5">
                            <div class="px-4 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Akun</div>
                            <a href="{{ route('admin.users.index') }}"
                               class="flex items-center gap-3 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
                                <i class="fa-solid fa-users-gear text-teal-600 w-4 text-center"></i>
                                Kelola Pengguna
                            </a>
                        </div>

                        <div class="border-t border-slate-100 py-1.5">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Yakin ingin keluar dari sistem?')"
                                        class="w-full flex items-center gap-3 px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition text-left">
                                    <i class="fa-solid fa-power-off w-4 text-center"></i>
                                    Keluar dari Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="main-content flex-1">
            <div class="max-w-7xl mx-auto px-5 sm:px-7 py-7">

                {{-- Flash Notifications --}}
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                         class="flash-success mb-5 rounded-xl p-3.5 flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-circle-check text-sm"></i>
                            </div>
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>
                @endif

                @if(session('error') || $errors->any())
                    <div x-data="{ show: true }" x-show="show" x-transition
                         class="flash-error mb-5 rounded-xl p-3.5 flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold">Terjadi Kesalahan</div>
                                @if(session('error'))
                                    <p class="text-xs mt-0.5">{{ session('error') }}</p>
                                @endif
                                @if($errors->any())
                                    <ul class="list-disc list-inside text-xs mt-1 space-y-0.5">
                                        @foreach($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <button @click="show = false" class="text-rose-500 hover:text-rose-700 flex-shrink-0">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        {{-- Footer --}}
        <div class="flex-shrink-0 border-t border-slate-200 bg-white px-6 py-2.5 flex items-center justify-between">
            <div class="text-[11px] text-slate-400 font-inter">
                &copy; {{ date('Y') }} <strong class="text-slate-600">Mini Hospital UIM Yogyakarta</strong>
            </div>
            <div class="text-[11px] text-slate-400 font-inter hidden sm:block">
                Jl. Wates, Sedayu, Bantul, D.I. Yogyakarta
            </div>
        </div>

    </div>
</div>

@stack('scripts')
</body>
</html>
