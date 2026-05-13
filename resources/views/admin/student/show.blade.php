@extends('layouts.app')

@section('title', 'Detail Mahasiswa - ' . $user->name)

@section('content')
<div class="w-full max-w-full">
    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <a href="{{ route('admin.student.index') }}" class="text-green-600 hover:text-green-800 text-sm mb-2 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
            <p class="text-gray-600 text-sm mt-2">Detail informasi mahasiswa</p>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-4xl space-y-6">
        <div class="space-y-6">
            {{-- Informasi Pribadi --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-user text-green-500"></i>
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
                        <a href="mailto:{{ $user->email }}" class="text-green-600 hover:text-green-800 text-sm sm:text-base mt-1 break-all">{{ $user->email }}</a>
                    </div>

                    {{-- No. HP --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">No. WhatsApp</p>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone) }}" target="_blank" class="text-green-600 hover:text-green-800 text-sm sm:text-base mt-1 flex items-center gap-2">
                            <i class="fas fa-phone"></i>{{ $user->phone }}
                        </a>
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Tanggal Lahir</p>
                        <p class="text-gray-900 font-semibold text-sm sm:text-base mt-1">
                            {{ $user->biodata?->ttl ? \Carbon\Carbon::parse($user->biodata->ttl)->format('d F Y') : '-' }}
                        </p>
                    </div>

                    {{-- Alamat Asal --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Alamat Asal</p>
                        <p class="text-gray-900 font-semibold text-sm sm:text-base mt-1">{{ $user->biodata?->alamat_asal ?? '-' }}</p>
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

            {{-- Data Akademik --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-university text-green-500"></i>
                    Data Akademik
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Kampus --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Kampus / Universitas</p>
                        <p class="text-gray-900 font-semibold text-sm sm:text-base mt-1">{{ $user->biodata?->nama_kampus ?? '-' }}</p>
                    </div>

                    {{-- Program Studi --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Program Studi</p>
                        <p class="text-gray-900 font-semibold text-sm sm:text-base mt-1">{{ $user->biodata?->prodi ?? '-' }}</p>
                    </div>

                    {{-- Gender --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Jenis Kelamin</p>
                        <p class="text-gray-900 font-semibold text-sm sm:text-base mt-1">{{ $user->biodata?->jenis_kelamin ? ucfirst($user->biodata->jenis_kelamin) : '-' }}</p>
                    </div>

                    {{-- Status --}}
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Status Akademik</p>
                        <p class="text-gray-900 font-semibold text-sm sm:text-base mt-1">{{ $user->biodata?->status ? ucfirst($user->biodata->status) : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Waktu Pendaftaran --}}
    <div class="mt-6 text-center text-gray-500 text-xs sm:text-sm">
        <p>Terdaftar sejak: <strong>{{ $user->created_at->format('d M Y H:i') }}</strong></p>
    </div>
</div>
@endsection
