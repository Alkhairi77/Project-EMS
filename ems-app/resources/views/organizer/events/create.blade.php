<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
            {{ __('Buat Event Baru') }}
        </h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-slate-200/80 rounded-lg p-6">
                <form method="POST" action="{{ route('organizer.events.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Judul -->
                    <div class="mb-5">
                        <label for="judul" class="block text-sm font-medium text-slate-700 mb-1">Judul Event <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required maxlength="150"
                            class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: Workshop Laravel untuk Pemula">
                        @error('judul') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-5">
                        <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi <span class="text-rose-500">*</span></label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" required
                            class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Deskripsikan acara Anda secara detail...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Banner -->
                    <div class="mb-5">
                        <label for="banner" class="block text-sm font-medium text-slate-700 mb-1">Banner Event</label>
                        <input type="file" name="banner" id="banner" accept="image/*"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('banner') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Lokasi & Kategori (2 col) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="lokasi" class="block text-sm font-medium text-slate-700 mb-1">Lokasi <span class="text-rose-500">*</span></label>
                            <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required
                                class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Alamat atau link online">
                            @error('lokasi') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                            <select name="kategori" id="kategori" required
                                class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach(['Workshop', 'Seminar', 'Competition', 'Bootcamp', 'Webinar', 'Festival'] as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                            @error('kategori') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Kapasitas & Harga (2 col) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="kapasitas" class="block text-sm font-medium text-slate-700 mb-1">Kapasitas <span class="text-rose-500">*</span></label>
                            <input type="number" name="kapasitas" id="kapasitas" value="{{ old('kapasitas') }}" required min="1"
                                class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: 100">
                            @error('kapasitas') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="harga" class="block text-sm font-medium text-slate-700 mb-1">Harga Tiket (Rp) <span class="text-rose-500">*</span></label>
                            <input type="number" name="harga" id="harga" value="{{ old('harga', 0) }}" required min="0"
                                class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="0 untuk gratis">
                            @error('harga') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Tanggal & Jam (2 col) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-slate-700 mb-1">Tanggal <span class="text-rose-500">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" required
                                class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('tanggal') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="jam" class="block text-sm font-medium text-slate-700 mb-1">Jam Mulai <span class="text-rose-500">*</span></label>
                            <input type="time" name="jam" id="jam" value="{{ old('jam') }}" required
                                class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('jam') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Status <span class="text-rose-500">*</span></label>
                        <select name="status" id="status" required
                            class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published</option>
                            <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
                        <a href="{{ route('organizer.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                            Simpan Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
