<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('participant.events.index') }}" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ __('Detail Event') }}
            </h1>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-slate-200/80 rounded-lg overflow-hidden">
                <!-- Banner -->
                @if($event->banner)
                    <div class="aspect-video bg-slate-100">
                        <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->judul }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="aspect-video bg-gradient-to-br from-indigo-50 to-slate-100 flex items-center justify-center">
                        <svg class="w-20 h-20 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif

                <div class="p-6 lg:p-8">
                    <!-- Category & Price -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                            {{ $event->kategori }}
                        </span>
                        <span class="text-lg font-bold {{ $event->harga > 0 ? 'text-slate-900' : 'text-emerald-600' }}">
                            {{ $event->harga > 0 ? 'Rp ' . number_format($event->harga, 0, ',', '.') : 'GRATIS' }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight mb-4">{{ $event->judul }}</h2>

                    <!-- Meta Info Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <div>
                                <p class="text-xs font-medium text-slate-500 uppercase">Tanggal & Waktu</p>
                                <p class="text-sm text-slate-900">{{ \Carbon\Carbon::parse($event->tanggal)->format('l, d F Y') }} · {{ $event->jam }} WIB</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <div>
                                <p class="text-xs font-medium text-slate-500 uppercase">Lokasi</p>
                                <p class="text-sm text-slate-900">{{ $event->lokasi }}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <div>
                                <p class="text-xs font-medium text-slate-500 uppercase">Sisa Kuota</p>
                                <p class="text-sm font-semibold {{ $sisaKuota > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $sisaKuota > 0 ? $sisaKuota . ' dari ' . $event->kapasitas . ' kursi tersedia' : 'KUOTA PENUH' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <div>
                                <p class="text-xs font-medium text-slate-500 uppercase">Penyelenggara</p>
                                <p class="text-sm text-slate-900">{{ $event->user ? $event->user->name : 'Unknown' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="border-t border-slate-200 pt-6 mb-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">Tentang Event</h3>
                        <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $event->deskripsi }}</div>
                    </div>

                    <!-- Register Button -->
                    <div class="border-t border-slate-200 pt-6">
                        @if($alreadyRegistered)
                            <div class="bg-emerald-50 border border-emerald-200 rounded-lg px-4 py-3 text-center">
                                <p class="text-sm font-medium text-emerald-700">✓ Anda sudah terdaftar di event ini</p>
                                <a href="{{ route('participant.dashboard') }}" class="text-xs text-emerald-600 hover:underline mt-1 inline-block">Lihat tiket saya →</a>
                            </div>
                        @elseif($sisaKuota > 0)
                            <form method="POST" action="{{ route('participant.events.register', $event->_id) }}">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg text-base font-bold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                                    🎫 Daftar Sekarang
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full inline-flex items-center justify-center px-6 py-3 bg-slate-300 border border-transparent rounded-lg text-base font-bold text-slate-500 cursor-not-allowed">
                                Kuota Sudah Penuh
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
