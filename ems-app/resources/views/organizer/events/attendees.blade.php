<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Daftar Peserta</h1>
                <p class="text-sm text-slate-500 mt-1">{{ $event->judul }}</p>
            </div>
            <a href="{{ route('organizer.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Event Quick Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm">
                    <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Terdaftar</span>
                    <span class="block text-2xl font-bold text-slate-900 mt-1">{{ $registrations->count() }} / {{ $event->kapasitas }}</span>
                </div>
                <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm">
                    <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Sudah Check-In</span>
                    <span class="block text-2xl font-bold text-emerald-600 mt-1">{{ $registrations->where('status', 'Checked In')->count() }}</span>
                </div>
                <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm">
                    <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Belum Check-In</span>
                    <span class="block text-2xl font-bold text-amber-600 mt-1">{{ $registrations->where('status', 'Registered')->count() }}</span>
                </div>
            </div>

            <!-- Search Form -->
            <div class="mb-6 flex justify-end">
                <form action="{{ route('organizer.events.attendees', $event->_id) }}" method="GET" class="flex gap-2 w-full md:w-1/3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode tiket..." 
                           class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('organizer.events.attendees', $event->_id) }}" class="inline-flex items-center px-4 py-2 bg-slate-200 border border-transparent rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest hover:bg-slate-300">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Attendee Table -->
            <div class="bg-white shadow-sm border border-slate-200/80 rounded-lg overflow-hidden">
                @if($registrations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama Peserta</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kode Tiket</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($registrations as $index => $reg)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                    {{ $reg->participant ? $reg->participant->name : 'Unknown' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $reg->participant ? $reg->participant->email : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-mono font-bold tracking-wider text-sm text-indigo-600 bg-slate-50 px-2 py-1 rounded border border-slate-200">
                                        {{ $reg->registration_code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($reg->status === 'Checked In')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            ✓ Checked In
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            Registered
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    @if($reg->status === 'Registered')
                                        <form method="POST" action="{{ route('organizer.registrations.checkin', $reg->_id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 border border-transparent rounded-md text-xs font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition">
                                                Set Hadir (Check In)
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400">Sudah hadir</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <h3 class="mt-2 text-sm font-medium text-slate-900">Belum ada peserta terdaftar</h3>
                    <p class="mt-1 text-sm text-slate-500">Peserta akan muncul di sini setelah mereka mendaftar.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
