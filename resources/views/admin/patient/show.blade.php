@extends('layouts.app')

@section('title', 'Detail Pasien - ' . $user->name)

@section('content')
<div class="w-full max-w-full">
    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <a href="{{ route('admin.student.index') }}" class="text-[#4da4e3] hover:text-[#367cae] text-sm mb-2 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
            <p class="text-gray-600 text-sm mt-2">Detail informasi pasien</p>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column - Main Info (2/3) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Informasi Pribadi --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-user text-[#4da4e3]"></i>
                    Informasi Pribadi
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Nama --}}
                    <div class="sm:col-span-2">
                        <p class="text-gray-600 text-sm font-medium">Nama Lengkap</p>
                        <p class="text-gray-900 font-semibold text-sm sm:text-base mt-1">{{ $user->name }}</p>
                    </div>

                    {{-- Email --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Email</p>
                        <a href="mailto:{{ $user->email }}" class="text-[#4da4e3] hover:text-[#367cae] text-sm sm:text-base mt-1 break-all">{{ $user->email }}</a>
                    </div>

                    {{-- No. HP --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">No. WhatsApp</p>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone) }}" target="_blank" class="text-[#4da4e3] hover:text-[#367cae] text-sm sm:text-base mt-1 flex items-center gap-2">
                            <i class="fas fa-phone"></i>{{ $user->phone }}
                        </a>
                    </div>

                    {{-- Verifikasi WhatsApp --}}
                    <div class="sm:col-span-2">
                        <p class="text-gray-600 text-sm font-medium">Status WhatsApp</p>
                        <div class="mt-1">
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs sm:text-sm font-semibold">
                                <i class="fas fa-clock"></i>
                                Belum Terverifikasi
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Kesehatan --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-heart text-red-500"></i>
                    Data Kesehatan
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- NIK --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">NIK</p>
                        <p class="text-gray-900 font-semibold text-sm sm:text-base mt-1">{{ $user->student?->nik ?? '-' }}</p>
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Tanggal Lahir</p>
                        <p class="text-gray-900 font-semibold text-sm sm:text-base mt-1">
                            @if($user->student?->dob)
                                {{ \Carbon\Carbon::parse($user->student->dob)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>

                    {{-- Gender --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Jenis Kelamin</p>
                        <p class="text-gray-900 font-semibold text-sm sm:text-base mt-1">{{ $user->student?->gender ? ucfirst($user->student->gender) : '-' }}</p>
                    </div>

                    {{-- Pendidikan --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pendidikan</p>
                        <p class="text-gray-900 font-semibold text-sm sm:text-base mt-1">{{ $user->student?->education ?? '-' }}</p>
                    </div>

                    {{-- Alamat --}}
                    <div class="sm:col-span-2">
                        <p class="text-gray-600 text-sm font-medium">Alamat</p>
                        <p class="text-gray-900 font-semibold text-sm sm:text-base mt-1">{{ $user->student?->address ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column - Informasi Kehamilan (1/3) --}}
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-[#4da4e3] to-[#367cae] rounded-xl shadow-md p-6 text-white">
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-baby"></i>
                    Kehamilan
                </h2>

                <div class="space-y-4">
                    {{-- Trimester --}}
                    <div class="bg-white bg-opacity-10 rounded-lg p-4">
                        <p class="text-white text-opacity-80 text-sm font-medium">Trimester</p>
                        <p class="text-2xl font-bold mt-2">{{ $user->student?->trimester ?? '-' }}</p>
                    </div>

                    {{-- Usia Kehamilan --}}
                    <div class="bg-white bg-opacity-10 rounded-lg p-4">
                        <p class="text-white text-opacity-80 text-sm font-medium">Usia Kehamilan (Minggu)</p>
                        <p class="text-2xl font-bold mt-2">{{ $user->student?->pregnancy_week ?? '-' }}</p>
                    </div>

                    {{-- HPHT --}}
                    <div class="bg-white bg-opacity-10 rounded-lg p-4">
                        <p class="text-white text-opacity-80 text-sm font-medium">Hari Pertama Haid Terakhir</p>
                        <p class="text-sm font-semibold mt-2">
                            @if($user->student?->last_period_date)
                                {{ \Carbon\Carbon::parse($user->student->last_period_date)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Catatan Tambahan --}}
                @if($user->student?->bio)
                <div class="mt-6 border-t border-white border-opacity-20 pt-4">
                    <p class="text-white text-opacity-80 text-sm font-medium mb-2">Catatan</p>
                    <p class="text-sm text-white text-opacity-90">{{ $user->student->bio }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Waktu Pendaftaran --}}
    <div class="mt-6 text-center text-gray-500 text-xs sm:text-sm">
        <p>Terdaftar sejak: <strong>{{ $user->created_at->format('d M Y H:i') }}</strong></p>
    </div>
</div>
@endsection
