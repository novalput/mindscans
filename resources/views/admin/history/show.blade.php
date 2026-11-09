@extends('layouts.app')

@section('title', 'Patient Screening History Detail')

@section('content')
<div class="w-full max-w-full">
    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Detail Evaluasi</h1>
            <p class="text-gray-600 text-sm mt-2">Detail hasil skrining mental dan rekomendasi penanganan.</p>
        </div>
        <a href="{{ route('admin.history.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-4 border border-gray-300 rounded shadow-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Kolom Kiri: Info Mahasiswa & Skor --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Biodata Card --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 text-white flex items-center justify-center text-xl font-bold shadow-md shrink-0">
                        {{ strtoupper(substr($history->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">{{ $history->user->name ?? 'User Terhapus' }}</h2>
                        <p class="text-gray-500 text-sm">{{ $history->user->email ?? '-' }}</p>
                    </div>
                </div>
                <div class="space-y-3 mt-4 pt-4 border-t border-gray-100">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Peran / Sub-Role</span>
                        <span class="font-medium text-gray-800">
                            @if(($history->user->sub_role ?? '') === 'student')
                                Patient
                            @elseif(($history->user->sub_role ?? '') === 'lecturer')
                                Healthcare Professional
                            @elseif(($history->user->sub_role ?? '') === 'others')
                                Lainnya (Umum)
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Kampus</span>
                        <span class="font-medium text-gray-800">{{ $history->user->biodata?->nama_kampus ?? '-' }}</span>
                    </div>
                    @if(($history->user->sub_role ?? '') === 'student' || ($history->user->sub_role ?? '') === 'lecturer')
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Program Studi</span>
                        <span class="font-medium text-gray-800">{{ $history->user->biodata?->prodi ?? '-' }}</span>
                    </div>
                    @endif
                    @if(($history->user->sub_role ?? '') === 'others' || !empty($history->user->biodata?->job_description))
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Pekerjaan / Jabatan</span>
                        <span class="font-medium text-gray-800">{{ $history->user->biodata?->job_description ?? '-' }}</span>
                    </div>
                    @endif
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase">Jenis Kelamin</span>
                        <span class="font-medium text-gray-800">
                            @if(($history->user->biodata?->jenis_kelamin ?? '') === 'male')
                                Laki-laki
                            @elseif(($history->user->biodata?->jenis_kelamin ?? '') === 'female')
                                Perempuan
                            @else
                                -
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Hasil --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200 text-center relative overflow-hidden">
                @php
                    $isWarning = $history->score >= $metrics->warning_threshold;
                    $bgClass = $isWarning ? 'bg-rose-50 border-rose-200' : 'bg-emerald-50 border-emerald-200';
                    $textClass = $isWarning ? 'text-rose-700' : 'text-emerald-700';
                @endphp
                <div class="absolute right-0 top-0 w-32 h-32 bg-gradient-to-bl from-white to-transparent opacity-20 pointer-events-none"></div>
                <h3 class="text-sm font-bold text-gray-500 uppercase mb-2">Total Skor Kuesioner</h3>
                <div class="text-6xl font-black {{ $textClass }} mb-2">{{ $history->score }}</div>
                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $bgClass }} {{ $textClass }}">
                    {{ $history->category }}
                </div>
                <div class="mt-4 text-xs text-gray-400">
                    <i class="far fa-clock mr-1"></i> Disubmit pada {{ $history->created_at->format('d M Y, H:i') }} WIB
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Rincian & Intervensi --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Detail Kuesioner --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Rincian Diagnosis</h3>
                
                @if($detail)
                <div class="space-y-4">
                    {{-- Depresi --}}
                    @if(isset($detail['depression']))
                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-100 flex items-start justify-between">
                        <div>
                            <h4 class="font-bold text-gray-700">Kuesioner Depresi</h4>
                            <p class="text-sm text-gray-500 mt-1">{{ $detail['depression']['recommendation'] ?? '-' }}</p>
                        </div>
                        <div class="text-right ml-4 shrink-0">
                            <span class="block text-2xl font-bold text-gray-800">{{ $detail['depression']['score'] ?? 0 }}</span>
                            <span class="text-xs font-semibold px-2 py-1 bg-white border border-gray-200 rounded text-gray-600 mt-1 inline-block">{{ $detail['depression']['category'] ?? '-' }}</span>
                        </div>
                    </div>
                    @endif

                    {{-- Kecemasan --}}
                    @if(isset($detail['anxiety']))
                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-100 flex items-start justify-between">
                        <div>
                            <h4 class="font-bold text-gray-700">Kuesioner Ansietas</h4>
                            <p class="text-sm text-gray-500 mt-1">{{ $detail['anxiety']['recommendation'] ?? '-' }}</p>
                        </div>
                        <div class="text-right ml-4 shrink-0">
                            <span class="block text-2xl font-bold text-gray-800">{{ $detail['anxiety']['score'] ?? 0 }}</span>
                            <span class="text-xs font-semibold px-2 py-1 bg-white border border-gray-200 rounded text-gray-600 mt-1 inline-block">{{ $detail['anxiety']['category'] ?? '-' }}</span>
                        </div>
                    </div>
                    @endif

                    {{-- Dampak --}}
                    @if(isset($detail['impact']))
                    <div class="p-4 rounded-lg bg-indigo-50 border border-indigo-100">
                        <h4 class="font-bold text-indigo-900 text-sm">Dampak Kegiatan Sehari-hari</h4>
                        <p class="text-indigo-700 font-medium mt-1">{{ $detail['impact']['text_answer'] ?? '-' }}</p>
                    </div>
                    @endif
                </div>
                @else
                <p class="text-gray-500 italic">Format detail tidak tersedia pada data kuesioner ini.</p>
                @endif
            </div>

            {{-- Form Intervensi Admin --}}
            <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-t-green-500 border-l border-r border-b border-gray-200">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 rounded bg-green-100 text-green-600 flex items-center justify-center">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Rekomendasi Penanganan (Admin)</h3>
                </div>
                
                <form action="{{ route('admin.history.update-intervention', $history->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="admin_intervention" class="block text-sm font-medium text-gray-700 mb-2">Tambahkan catatan, saran kegiatan, atau tindak lanjut:</label>
                        <textarea id="admin_intervention" name="admin_intervention" rows="4" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition" 
                            placeholder="Contoh: Disarankan untuk mengikuti konseling kampus pada hari Jumat..."
                        >{{ old('admin_intervention', $history->admin_intervention) }}</textarea>
                        @error('admin_intervention')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="text-right">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                            <i class="fas fa-save mr-2"></i> Simpan Rekomendasi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
