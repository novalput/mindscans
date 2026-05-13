@extends('layouts.app')

@section('title', 'Riwayat Kuesioner Mahasiswa')

@section('content')
<div class="p-4 md:p-8">
    <div class="mb-6">
        <a href="{{ route('lecturer.datamahasiswa') }}" class="inline-flex items-center text-gray-500 hover:text-green-600 transition-colors font-medium text-sm">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Mahasiswa
        </a>
    </div>

    <!-- Student Info Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8 mb-8 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-green-50 to-transparent opacity-50 pointer-events-none"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
            <div class="flex items-center gap-5 md:col-span-1">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-400 to-green-600 text-white flex items-center justify-center text-2xl font-bold shadow-lg shadow-green-200 shrink-0">
                    {{ strtoupper(substr($student->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-[#262C5B] leading-tight">{{ $student->name }}</h2>
                    <p class="text-gray-500 text-sm mt-1 flex items-center gap-2">
                        <i class="fa-regular fa-envelope text-gray-400"></i> {{ $student->email }}
                    </p>
                </div>
            </div>

            <div class="md:col-span-2 grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                    <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Gender</p>
                    <p class="font-bold text-gray-800">{{ ucfirst($student->biodata?->jenis_kelamin ?? '-') }}</p>
                </div>
                <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                    <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Status</p>
                    <p class="font-bold text-gray-800">{{ $student->biodata?->status ?? '-' }}</p>
                </div>
                <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100 lg:col-span-2">
                    <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Program Studi</p>
                    <p class="font-bold text-gray-800 truncate" title="{{ $student->biodata?->prodi }}">{{ $student->biodata?->prodi ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- History Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-[#262C5B]">Riwayat Tes Mental</h2>
            <p class="text-sm text-gray-500 mt-1">Total tes yang telah diselesaikan: <span class="font-bold text-green-600">{{ $history->count() }}</span></p>
        </div>
        <a href="{{ route('lecturer.datamahasiswa.history.export', $student->id) }}" class="bg-red-600 text-white px-4 py-2 rounded-xl font-semibold hover:bg-red-700 transition-colors text-sm flex items-center gap-2">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>

    @if($history->isEmpty())
        <div class="bg-white rounded-3xl border border-dashed border-gray-200 p-12 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-clipboard text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Riwayat</h3>
            <p class="text-gray-500">Mahasiswa ini belum pernah mengisi kuesioner profil mental.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($history as $item)
                @php
                    $isWarning = $item->score >= $warningThreshold;
                    $statusColor = $isWarning ? 'bg-yellow-50 border-yellow-200' : 'bg-green-50 border-green-200';
                    $textColor = $isWarning ? 'text-yellow-700' : 'text-green-700';
                    $badgeBg = $isWarning ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800';
                    $icon = $isWarning ? 'fa-triangle-exclamation' : 'fa-check';
                @endphp
                
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden group flex flex-col h-full">
                    <!-- Card Header -->
                    <div class="p-6 border-b border-gray-50 flex items-center justify-between {{ $statusColor }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-clipboard-check {{ $textColor }} text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 leading-tight">Tes Mental</h3>
                                <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wider mt-1">{{ $item->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-black {{ $textColor }}">{{ $item->created_at->format('H:i') }}</span>
                            <p class="text-[10px] font-bold text-gray-400 uppercase mt-1">WIB</p>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex-grow flex flex-col justify-center">
                        <div class="text-center mb-4">
                            <h4 class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2">Total Skor</h4>
                            <div class="flex items-baseline justify-center gap-1">
                                <span class="text-5xl font-black text-gray-800">{{ $item->score }}</span>
                            </div>
                        </div>

                        <div class="flex justify-center mt-auto">
                            <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase flex items-center gap-2 {{ $badgeBg }}">
                                <i class="fa-solid {{ $icon }}"></i>
                                {{ $isWarning ? 'Perlu Perhatian' : 'Aman' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
