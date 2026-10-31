<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMHUIM Mini Hospital UIM</title>
    <link rel="shortcut icon" href="{{ asset('images/logouim.png') }}" type="image/png">

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        .hero-bg {
            background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.85), rgba(15, 118, 110, 0.90)), url('{{ asset('images/uimbg.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="h-full hero-bg flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans antialiased">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <!-- Logo -->
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white shadow-xl p-2 mb-4 ring-4 ring-teal-500/30 transform hover:scale-105 transition-all">
            <img class="w-full h-full object-contain" src="{{ asset('images/logouim.png') }}" alt="Logo UIM">
        </div>
        <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
            SIMHUIM
        </h2>
        <p class="mt-2 text-sm text-teal-100 font-medium">
            Sistem Informasi Mini Hospital UIM Yogyakarta
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div class="bg-white/95 backdrop-blur-md py-8 px-6 shadow-2xl rounded-2xl sm:px-10 border border-white/20">

            @if(session('success'))
                <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 p-3 text-xs text-emerald-800 flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs text-rose-800 flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form class="space-y-5" action="{{ route('login') }}" method="POST">
                @csrf
                <div>
                    <label for="username" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Username
                    </label>
                    <div class="mt-1.5 relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user text-sm"></i>
                        </div>
                        <input id="username" name="username" type="text" required autofocus
                               value="{{ old('username') }}"
                               placeholder="Masukkan username Anda"
                               class="block w-full pl-10 pr-3.5 py-2.5 sm:text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-white text-slate-900 placeholder:text-slate-400">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Password
                    </label>
                    <div class="mt-1.5 relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input id="password" name="password" type="password" required
                               placeholder="••••••••"
                               class="block w-full pl-10 pr-3.5 py-2.5 sm:text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-white text-slate-900 placeholder:text-slate-400">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-slate-300 rounded cursor-pointer">
                        <label for="remember" class="ml-2 block text-xs font-medium text-slate-600 cursor-pointer">
                            Ingat sesi saya
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-150">
                        <i class="fa-solid fa-right-to-bracket mr-2"></i> Masuk ke Sistem
                    </button>
                </div>
            </form>

            <!-- Quick Demo Credentials Box -->
            <div class="mt-6 pt-6 border-t border-slate-200/80">
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider text-center mb-2.5">
                    Akses Cepat (Klik untuk Isi Otomatis)
                </p>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button"
                            onclick="fillCreds('admin', 'admin')"
                            class="py-1.5 px-2 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-lg text-center text-xs font-semibold text-emerald-800 transition">
                        Front Office
                        <span class="block text-[10px] text-emerald-600 font-normal">admin</span>
                    </button>
                    <button type="button"
                            onclick="fillCreds('irsyad', 'irsyad')"
                            class="py-1.5 px-2 bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-lg text-center text-xs font-semibold text-sky-800 transition">
                        Dokter
                        <span class="block text-[10px] text-sky-600 font-normal">irsyad</span>
                    </button>
                    <button type="button"
                            onclick="fillCreds('umum', 'umum')"
                            class="py-1.5 px-2 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg text-center text-xs font-semibold text-amber-800 transition">
                        Poli Umum
                        <span class="block text-[10px] text-amber-600 font-normal">umum</span>
                    </button>
                </div>
            </div>
        </div>

        <p class="mt-6 text-center text-xs text-teal-100/70">
            &copy; {{ date('Y') }} Universitas Islam Madura / UIM Yogyakarta. All rights reserved.
        </p>
    </div>

    <script>
        function fillCreds(username, password) {
            document.getElementById('username').value = username;
            document.getElementById('password').value = password;
        }
    </script>
</body>
</html>
