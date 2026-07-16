<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
            {{ __('Tiket Saya') }}
        </h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Tab Navigation -->
            <div x-data="{ activeTab: 'upcoming' }" class="space-y-6">
                <div class="border-b border-slate-200">
                    <nav class="-mb-px flex space-x-8">
                        <button @click="activeTab = 'upcoming'"
                            :class="activeTab === 'upcoming' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                            class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm transition-colors">
                            Upcoming Events
                            <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-600">
                                {{ $upcoming->count() }}
                            </span>
                        </button>
                        <button @click="activeTab = 'past'"
                            :class="activeTab === 'past' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                            class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm transition-colors">
                            Past Events
                            <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                {{ $past->count() }}
                            </span>
                        </button>
                    </nav>
                </div>

                <!-- Upcoming Tab -->
                <div x-show="activeTab === 'upcoming'" x-transition>
                    @if($upcoming->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($upcoming as $reg)
                        <div class="bg-white border-2 border-dashed border-slate-200 rounded-xl p-6 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-slate-900">{{ $reg->event->judul }}</h3>
                                <div class="mt-1 space-y-1">
                                    <p class="text-xs text-slate-500">
                                        📅 {{ \Carbon\Carbon::parse($reg->event->tanggal)->format('d M Y') }} · {{ $reg->event->jam }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        📍 {{ Str::limit($reg->event->lokasi, 50) }}
                                    </p>
                                </div>
                                <div class="mt-3">
                                    @if($reg->status === 'Checked In')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            ✓ Checked In
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            Registered
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-500 mb-1">Kode Tiket</p>
                                <span class="font-mono font-bold tracking-wider text-base text-indigo-600 bg-slate-50 px-3 py-1 rounded border border-slate-200 inline-block">
                                    {{ $reg->registration_code }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="bg-white rounded-lg border border-slate-200 px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        <h3 class="mt-2 text-sm font-medium text-slate-900">Belum ada tiket upcoming</h3>
                        <p class="mt-1 text-sm text-slate-500">Cari dan daftar event yang menarik!</p>
                        <div class="mt-4">
                            <a href="{{ route('participant.events.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 rounded-lg text-sm font-semibold text-white hover:bg-indigo-700 transition">
                                Cari Event
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Past Tab -->
                <div x-show="activeTab === 'past'" x-transition style="display: none;">
                    @if($past->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($past as $reg)
                        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm opacity-75 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-slate-700">{{ $reg->event->judul }}</h3>
                                <div class="mt-1 space-y-1">
                                    <p class="text-xs text-slate-400">
                                        📅 {{ \Carbon\Carbon::parse($reg->event->tanggal)->format('d M Y') }} · {{ $reg->event->jam }}
                                    </p>
                                </div>
                                <div class="mt-3">
                                    @if($reg->status === 'Checked In')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            ✓ Hadir
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                            Tidak Hadir
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-mono text-sm text-slate-400 bg-slate-50 px-2 py-1 rounded border border-slate-100 inline-block">
                                    {{ $reg->registration_code }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="bg-white rounded-lg border border-slate-200 px-6 py-12 text-center">
                        <p class="text-sm text-slate-500">Belum ada riwayat event.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
