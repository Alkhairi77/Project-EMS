<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ __('Organizer Dashboard') }}
            </h1>
            <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wide hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Event Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Metrics Ribbon -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Events -->
                <div class="bg-white border border-slate-200 rounded-lg p-5 flex flex-col shadow-sm">
                    <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Event</span>
                    <span class="text-3xl font-bold text-slate-900 tracking-tight mt-1">{{ $totalEvents }}</span>
                </div>
                <!-- Total Participants -->
                <div class="bg-white border border-slate-200 rounded-lg p-5 flex flex-col shadow-sm">
                    <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Peserta Terdaftar</span>
                    <span class="text-3xl font-bold text-slate-900 tracking-tight mt-1">{{ $totalParticipants }}</span>
                </div>
                <!-- Active Events -->
                <div class="bg-white border border-slate-200 rounded-lg p-5 flex flex-col shadow-sm">
                    <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Event Aktif (Published)</span>
                    <span class="text-3xl font-bold text-emerald-600 tracking-tight mt-1">{{ $activeEvents }}</span>
                </div>
            </div>

            <!-- Event Management Table -->
            <div class="bg-white shadow-sm border border-slate-200/80 rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900">Daftar Event Saya</h2>
                </div>

                @if($events->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kuota Terisi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($events as $event)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900">{{ $event->judul }}</div>
                                    <div class="text-xs text-slate-500">{{ $event->kategori }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }} · {{ $event->jam }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    <span class="font-semibold">{{ $event->registered_count }}</span>/{{ $event->kapasitas }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($event->status === 'Published')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">Published</span>
                                    @elseif($event->status === 'Draft')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">Draft</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">Cancelled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('organizer.events.edit', $event->_id) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors">Edit</a>
                                    <a href="{{ route('organizer.events.attendees', $event->_id) }}" class="text-emerald-600 hover:text-emerald-900 transition-colors">Lihat Peserta</a>
                                    <form method="POST" action="{{ route('organizer.events.destroy', $event->_id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-900 transition-colors">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <h3 class="mt-2 text-sm font-medium text-slate-900">Belum ada event</h3>
                    <p class="mt-1 text-sm text-slate-500">Mulai buat event pertama Anda.</p>
                    <div class="mt-4">
                        <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 rounded-lg text-sm font-semibold text-white hover:bg-indigo-700 transition">
                            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Buat Event Baru
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
