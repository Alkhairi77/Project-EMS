<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ __('Cari Event') }}
            </h1>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search & Filter Bar -->
            <div class="bg-white shadow-sm border border-slate-200/80 rounded-lg p-4 mb-8">
                <form method="GET" action="{{ route('participant.events.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ $search }}" placeholder="🔍 Cari event berdasarkan judul..."
                            class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="sm:w-48">
                        <select name="kategori" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ $kategori == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                        Cari
                    </button>
                    @if($search || $kategori)
                        <a href="{{ route('participant.events.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Event Grid -->
            @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                <a href="{{ route('participant.events.show', $event->_id) }}" class="group flex flex-col overflow-hidden bg-white rounded-lg border border-slate-200 transition hover:shadow-md">
                    <!-- Banner Image -->
                    <div class="relative aspect-video bg-slate-100">
                        @if($event->banner)
                            <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->judul }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-50 to-slate-100">
                                <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <!-- Category Badge -->
                        <span class="absolute top-3 left-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200/50 backdrop-blur-sm">
                            {{ $event->kategori }}
                        </span>
                    </div>

                    <!-- Card Content -->
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="text-lg font-semibold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-2">
                            {{ $event->judul }}
                        </h3>
                        <div class="mt-2 space-y-1.5 flex-1">
                            <p class="text-xs text-slate-500 flex items-center">
                                <svg class="w-3.5 h-3.5 me-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }} · {{ $event->jam }}
                            </p>
                            <p class="text-xs text-slate-500 flex items-center">
                                <svg class="w-3.5 h-3.5 me-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ Str::limit($event->lokasi, 40) }}
                            </p>
                        </div>
                        <div class="mt-3 pt-3 border-t border-slate-100 flex justify-between items-center">
                            <span class="text-sm font-bold {{ $event->harga > 0 ? 'text-slate-900' : 'text-emerald-600' }}">
                                {{ $event->harga > 0 ? 'Rp ' . number_format($event->harga, 0, ',', '.') : 'Gratis' }}
                            </span>
                            <span class="text-xs text-slate-500">
                                Sisa {{ $event->sisa_kuota }} kursi
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-lg border border-slate-200 px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <h3 class="mt-2 text-sm font-medium text-slate-900">Tidak ada event ditemukan</h3>
                <p class="mt-1 text-sm text-slate-500">Coba ubah kata kunci atau filter kategori Anda.</p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
