<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Event Management System - Platform manajemen acara terbaik untuk Organizer dan Participant">
    <title>EMS - Event Management System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50">
    <!-- Header -->
    <nav class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <span class="text-lg font-bold text-indigo-600 tracking-tight">EMS</span>
                <div class="space-x-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-indigo-700 transition">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200 mb-6">
                    ✨ Platform Manajemen Acara MVP
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Kelola Event Anda<br>
                    <span class="text-indigo-600">dengan Mudah</span>
                </h1>
                <p class="mt-6 text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed">
                    Platform berbasis web yang mempertemukan Penyelenggara Acara dan Peserta. Buat event, kelola pendaftaran, dan validasi kehadiran dalam satu sistem yang terintegrasi.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-lg text-base font-bold text-white hover:bg-indigo-700 shadow-sm hover:shadow-md transition-all">
                        Mulai Sekarang →
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3 bg-white border border-slate-300 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50 shadow-sm transition-all">
                        Sudah Punya Akun
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white border-t border-slate-200 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Fitur Utama</h2>
                <p class="mt-2 text-sm text-slate-500">Semua yang Anda butuhkan untuk mengelola acara</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-slate-50 rounded-xl p-6 border border-slate-100">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Buat & Kelola Event</h3>
                    <p class="mt-2 text-sm text-slate-500">CRUD lengkap untuk data event dengan upload banner, pengaturan kapasitas, dan manajemen status.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-slate-50 rounded-xl p-6 border border-slate-100">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Tiket Digital Instan</h3>
                    <p class="mt-2 text-sm text-slate-500">Pendaftaran satu klik dengan kode tiket unik. Lihat semua tiket di dashboard personal Anda.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-slate-50 rounded-xl p-6 border border-slate-100">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Check-In Manual</h3>
                    <p class="mt-2 text-sm text-slate-500">Validasi kehadiran peserta di lokasi dengan satu klik tombol Check In di daftar peserta.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-50 border-t border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm text-slate-400">© {{ date('Y') }} Event Management System. Built with Laravel 11 & MongoDB.</p>
        </div>
    </footer>
</body>
</html>
