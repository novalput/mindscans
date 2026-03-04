@extends('layouts.app')

@section('title', 'Tambah Tenaga Kesehatan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Tambah Tenaga Kesehatan</h1>
    <p class="text-slate-600 mt-2 text-sm">Lengkapi data lecturer, termasuk foto profesional.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm shadow-slate-100 border border-slate-200 p-5 sm:p-6 w-full max-w-3xl mx-auto">
    <form action="{{ route('admin.lecturer.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Foto profesional</label>
                <div class="flex flex-col gap-3 rounded-2xl border border-dashed border-sky-200 bg-sky-50/40 p-4">
                    <input type="file" name="avatar" accept="image/*"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-100">
                    @error('avatar')
                        <span class="text-rose-600 text-xs">{{ $message }}</span>
                    @enderror
                    <p class="text-xs text-slate-500">Unggah gambar JPG/PNG/WebP maksimal 2MB.</p>
                </div>
            </div>

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-100 @error('name') border-rose-300 @enderror"
                    placeholder="Nama lengkap">
                @error('name') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-rose-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-100 @error('email') border-rose-300 @enderror"
                    placeholder="email@example.com">
                @error('email') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-semibold text-slate-700 mb-2">No. HP <span class="text-rose-500">*</span></label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-100 @error('phone') border-rose-300 @enderror"
                    placeholder="081234567890">
                @error('phone') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="nip" class="block text-sm font-semibold text-slate-700 mb-2">NIP <span class="text-rose-500">*</span></label>
                <input type="text" id="nip" name="nip" value="{{ old('nip') }}" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-100 @error('nip') border-rose-300 @enderror"
                    placeholder="Nomor Induk Profesi">
                @error('nip') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="specialization" class="block text-sm font-semibold text-slate-700 mb-2">Spesialisasi</label>
                <input type="text" id="specialization" name="specialization" value="{{ old('specialization') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                    placeholder="Contoh: Gigi">
            </div>

            <div>
                <label for="education" class="block text-sm font-semibold text-slate-700 mb-2">Pendidikan</label>
                <input type="text" id="education" name="education" value="{{ old('education') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                    placeholder="Profesi Dokter / S1 Keperawatan">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-rose-500">*</span></label>
                <input type="password" id="password" name="password" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-100 @error('password') border-rose-300 @enderror"
                    placeholder="Min 8 karakter">
                @error('password') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password <span class="text-rose-500">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                    placeholder="Ulang password">
            </div>

            <div class="md:col-span-2">
                <label for="bio" class="block text-sm font-semibold text-slate-700 mb-2">Bio</label>
                <textarea id="bio" name="bio" rows="4"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
                    placeholder="Deskripsi singkat tentang Lecturer">{{ old('bio') }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.lecturer.index') }}"
                class="rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Batal
            </a>
            <button type="submit"
                class="rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-200 hover:bg-sky-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
