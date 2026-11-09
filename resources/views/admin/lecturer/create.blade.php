@extends('layouts.app')

@section('title', 'Add Healthcare Professional')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Add Healthcare Professional</h1>
    <p class="text-slate-600 mt-2 text-sm">Complete the healthcare professional profile, including a professional photo.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm shadow-slate-100 border border-slate-200 p-5 sm:p-6 w-full max-w-3xl mx-auto">
    <form action="{{ route('admin.lecturer.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Foto profesional</label>
                <div class="flex flex-col gap-3 rounded-2xl border border-dashed border-emerald-200 bg-emerald-50/40 p-4">
                    <input type="file" name="avatar" accept="image/*"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100">
                    @error('avatar')
                        <span class="text-rose-600 text-xs">{{ $message }}</span>
                    @enderror
                    <p class="text-xs text-slate-500">Unggah gambar JPG/PNG/WebP maksimal 2MB.</p>
                </div>
            </div>

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 @error('name') border-rose-300 @enderror"
                    placeholder="Nama lengkap">
                @error('name') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-rose-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 @error('email') border-rose-300 @enderror"
                    placeholder="email@example.com">
                @error('email') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-semibold text-slate-700 mb-2">No. HP <span class="text-rose-500">*</span></label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 @error('phone') border-rose-300 @enderror"
                    placeholder="081234567890">
                @error('phone') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="gender" class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin <span class="text-rose-500">*</span></label>
                <select id="gender" name="gender" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 @error('gender') border-rose-300 @enderror">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="kampus" class="block text-sm font-semibold text-slate-700 mb-2">Kampus <span class="text-rose-500">*</span></label>
                <input type="text" id="kampus" name="kampus" value="{{ old('kampus') }}" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 @error('kampus') border-rose-300 @enderror"
                    placeholder="Nama Kampus">
                @error('kampus') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="program_studi" class="block text-sm font-semibold text-slate-700 mb-2">Program Studi <span class="text-rose-500">*</span></label>
                <input type="text" id="program_studi" name="program_studi" value="{{ old('program_studi') }}" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 @error('program_studi') border-rose-300 @enderror"
                    placeholder="Studi">
                @error('program_studi') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="jabatan_fungsional" class="block text-sm font-semibold text-slate-700 mb-2">Jabatan Fungsional</label>
                <input type="text" id="jabatan_fungsional" name="jabatan_fungsional" value="{{ old('jabatan_fungsional') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100"
                    placeholder="Contoh: Lektor">
            </div>

            <div>
                <label for="pendidikan_terakhir" class="block text-sm font-semibold text-slate-700 mb-2">Pendidikan Terakhir</label>
                <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100"
                    placeholder="Contoh: S2/S3">
            </div>

            <div>
                <label for="status_ikatan_kerja" class="block text-sm font-semibold text-slate-700 mb-2">Status Ikatan Kerja</label>
                <input type="text" id="status_ikatan_kerja" name="status_ikatan_kerja" value="{{ old('status_ikatan_kerja') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100"
                    placeholder="Example: Full-time healthcare professional">
            </div>

            <div>
                <label for="status_aktivitas" class="block text-sm font-semibold text-slate-700 mb-2">Status Aktivitas</label>
                <input type="text" id="status_aktivitas" name="status_aktivitas" value="{{ old('status_aktivitas') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100"
                    placeholder="Contoh: Aktif">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-rose-500">*</span></label>
                <input type="password" id="password" name="password" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 @error('password') border-rose-300 @enderror"
                    placeholder="Min 8 karakter">
                @error('password') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password <span class="text-rose-500">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100"
                    placeholder="Ulang password">
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.lecturer.index') }}"
                class="rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Batal
            </a>
            <button type="submit"
                class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
