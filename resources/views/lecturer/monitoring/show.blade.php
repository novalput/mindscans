@extends('layouts.app')

@section('content')
<div class="p-4 md:p-8 space-y-8" x-data="{ showVisitForm: false }">
    {{-- Header & Navigasi --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('lecturer.monitoring.index') }}"
                class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm hover:bg-gray-50 text-gray-400 transition-all">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-[#262C5B]">Monitoring Pasien</h1>
                <p class="text-gray-500 font-medium italic text-sm">Bunda: {{ $student->name }}</p>
            </div>
        </div>

        <button @click="showVisitForm = !showVisitForm"
            class="flex items-center justify-center gap-2 bg-[#5DB8D8] hover:bg-[#4A9FBD] text-white px-6 py-3 rounded-xl font-bold transition-all shadow-md shadow-sky-100">
            <i class="fa-solid fa-notes-medical"></i>
            <span x-text="showVisitForm ? 'Tutup Form' : 'Catat Kunjungan'"></span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- KOLOM KIRI: KALENDER AKTIVITAS --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2.5rem] p-6 md:p-8 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-day text-[#5DB8D8]"></i>
                        Log Sikat Gigi Bulan Ini
                    </h3>
                    <span class="text-xs font-black text-gray-400 uppercase tracking-widest">
                        {{ now()->translatedFormat('F Y') }}
                    </span>
                </div>

                <div class="grid grid-cols-7 gap-2">
                    {{-- Header Hari --}}
                    @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $day)
                    <div class="text-center text-[10px] font-black text-gray-300 py-2 uppercase tracking-tighter">{{ $day }}</div>
                    @endforeach

                    @php
                    $startOfMonth = now()->startOfMonth();
                    $blankDays = $startOfMonth->dayOfWeek;
                    $daysInMonth = now()->daysInMonth;
                    @endphp

                    {{-- Offset Tanggal --}}
                    @for($i = 0; $i < $blankDays; $i++)
                        <div class="h-20 bg-gray-50/30 rounded-2xl border border-dashed border-gray-100">
                </div>
                @endfor

                {{-- Tanggal Aktif --}}
                @for($date = 1; $date <= $daysInMonth; $date++)
                    @php
                    $currentDate=now()->day($date)->format('Y-m-d');
                    $log = $logs[$currentDate] ?? null;
                    $isToday = $currentDate == now()->format('Y-m-d');
                    @endphp

                    <div class="h-24 border {{ $isToday ? 'border-[#5DB8D8] bg-sky-50/30' : 'border-gray-50' }} rounded-2xl p-2 flex flex-col justify-between hover:border-sky-200 transition-colors">
                        <span class="text-xs font-bold {{ $isToday ? 'text-[#5DB8D8]' : 'text-gray-400' }}">
                            {{ $date }}
                        </span>

                        <div class="space-y-1">
                            {{-- Dot Pagi --}}
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full {{ ($log && $log->morning) ? 'bg-yellow-400 shadow-[0_0_8px_rgba(250,204,21,0.5)]' : 'bg-gray-100' }}"></div>
                                <span class="text-[9px] font-bold {{ ($log && $log->morning) ? 'text-gray-600' : 'text-gray-200' }}">PAGI</span>
                            </div>
                            {{-- Dot Malam --}}
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full {{ ($log && $log->night) ? 'bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.5)]' : 'bg-gray-100' }}"></div>
                                <span class="text-[9px] font-bold {{ ($log && $log->night) ? 'text-gray-600' : 'text-gray-200' }}">MALAM</span>
                            </div>
                        </div>
                    </div>
                    @endfor
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: FORM & RIWAYAT KUNJUNGAN --}}
    <div class="space-y-6">

        {{-- Form Input (Muncul saat tombol diklik) --}}
        <div x-show="showVisitForm" x-transition.origin.top
            class="bg-[#262C5B] text-white rounded-[2rem] p-6 shadow-xl overflow-hidden relative">
            <div class="relative z-10">
                <h4 class="font-bold text-lg mb-4">Catat Pemeriksaan Baru</h4>
                <form action="{{ route('lecturer.visits.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $student->id }}">

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-sky-300">Tanggal Kunjungan</label>
                        <input type="date" name="visit_date" required
                            class="w-full bg-white/10 border-none rounded-xl text-white placeholder-white/50 focus:ring-2 focus:ring-[#5DB8D8]">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-sky-300">Tindakan / Perawatan</label>
                        <input type="text" name="treatment_notes" placeholder="Contoh: Scaling, Penambalan..." required
                            class="w-full bg-white/10 border-none rounded-xl text-white placeholder-white/30 focus:ring-2 focus:ring-[#5DB8D8]">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-sky-300">Catatan Konsultasi</label>
                        <textarea name="consultation_notes" rows="3" placeholder="Keluhan pasien..."
                            class="w-full bg-white/10 border-none rounded-xl text-white placeholder-white/30 focus:ring-2 focus:ring-[#5DB8D8]"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#5DB8D8] hover:bg-[#4A9FBD] text-white font-black rounded-xl transition-all uppercase text-xs tracking-widest">
                        Simpan Data
                    </button>
                </form>
            </div>
            {{-- Dekorasi --}}
            <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/5 rounded-full"></div>
        </div>

        {{-- Riwayat List --}}
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100">
            <h4 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-gray-400"></i>
                Riwayat Kunjungan
            </h4>

            <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 no-scrollbar">
                @forelse($visits as $v)
                <div class="relative pl-6 border-l-2 border-sky-100 py-1">
                    <div class="absolute -left-[5px] top-2 w-2 h-2 rounded-full bg-[#5DB8D8]"></div>
                    <p class="text-[10px] font-black text-[#5DB8D8] uppercase tracking-wider">
                        {{ \Carbon\Carbon::parse($v->visit_date)->translatedFormat('d F Y') }}
                    </p>
                    <p class="text-sm font-bold text-gray-800 mt-1">{{ $v->treatment_notes }}</p>
                    <p class="text-xs text-gray-500 italic mt-1 leading-relaxed">"{{ $v->consultation_notes }}"</p>
                </div>
                @empty
                <div class="text-center py-12">
                    <img src="https://cdn-icons-png.flaticon.com/512/6598/6598519.png" class="w-16 h-16 mx-auto opacity-20 grayscale">
                    <p class="text-gray-400 text-xs mt-4 italic">Belum ada catatan medis.</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
</div>
@endsection
