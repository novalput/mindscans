@extends('layouts.student')

@section('title', 'Daily Activity')

@section('content')
@php
    // Logika Realtime Date yang Presisi
    $now = \Carbon\Carbon::now();
    $daysInMonth = $now->daysInMonth;
    $currentMonth = $now->month;
    $currentYear = $now->year;
    $today = $now->format('Y-m-d');

    // Cari tahu tanggal 1 itu hari apa (0 untuk Minggu, 1 untuk Senin, dst)
    $startOfMonth = \Carbon\Carbon::create($currentYear, $currentMonth, 1);
    $blankCells = $startOfMonth->dayOfWeek;
@endphp

<div class="py-10 px-4 md:px-8 max-w-5xl mx-auto" x-data="{ tab: 'brushing' }">

    {{-- Header Tetap --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-sansita text-gray-800">Daily Activity</h1>
            <p class="text-gray-500 font-medium italic">Pantau kebersihan & riwayat kesehatan gigi Bunda</p>
        </div>

        <div class="flex bg-gray-100 p-1.5 rounded-2xl w-fit">
            <button @click="tab = 'brushing'"
                :class="tab === 'brushing' ? 'bg-white text-[#5DB8D8] shadow-sm' : 'text-gray-500'"
                class="px-6 py-2 rounded-xl font-bold text-sm transition-all duration-100">
                <i class="fa-solid fa-tooth mr-2"></i> Sikat Gigi
            </button>
            <button @click="tab = 'visits'"
                :class="tab === 'visits' ? 'bg-white text-[#5DB8D8] shadow-sm' : 'text-gray-500'"
                class="px-6 py-2 rounded-xl font-bold text-sm transition-all duration-100">
                <i class="fa-solid fa-notes-medical mr-2"></i> Kunjungan
            </button>
        </div>
    </div>

    {{-- TAB 1: BRUSHING LOG --}}
    <div x-show="tab === 'brushing'" x-transition.duration.100ms class="space-y-6">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 bg-[#5DB8D8] text-white flex justify-between items-center">
                <h2 class="font-bold text-lg"><i class="fa-solid fa-calendar-check mr-2"></i> Kalender Sikat Gigi</h2>
                <span class="bg-white/20 px-4 py-1 rounded-full text-sm font-bold">{{ $now->translatedFormat('F Y') }}</span>
            </div>

            <div class="grid grid-cols-7 bg-gray-50/50 border-b border-gray-100 text-center">
                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                    <div class="py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $day }}</div>
                @endforeach
            </div>

            <div class="grid grid-cols-7">
                {{-- 1. KOTAK KOSONG (Padding agar tanggal 1 sesuai harinya) --}}
                @for($x = 0; $x < $blankCells; $x++)
                    <div class="border-b border-r border-gray-50 bg-gray-50/20 min-h-[110px]"></div>
                @endfor

                {{-- 2. LOOPING TANGGAL REALTIME --}}
                @for($i = 1; $i <= $daysInMonth; $i++)
                    @php
                        $dateKey = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $i);
                        $log = $logs[$dateKey] ?? null;
                        $isToday = $dateKey === $today;
                    @endphp
                    <div class="border-b border-r border-gray-50 p-2 min-h-[110px] flex flex-col items-center justify-between hover:bg-sky-50 transition-none {{ $isToday ? 'bg-sky-50/30' : '' }}">
                        <span class="text-xs font-bold {{ $isToday ? 'text-[#5DB8D8] bg-white w-6 h-6 rounded-full flex items-center justify-center shadow-md border border-sky-100' : 'text-gray-400' }}">
                            {{ $i }}
                        </span>

                        <div class="flex flex-col gap-1.5 mb-1">
                            <button onclick="toggleBrushing('{{ $dateKey }}', 'morning')"
                                id="btn-morning-{{ $dateKey }}"
                                class="w-10 h-10 rounded-2xl flex items-center justify-center transition-none shadow-sm border-2 {{ $log?->morning ? 'bg-yellow-400 border-yellow-200 text-white' : 'bg-white border-gray-100 text-gray-200' }}">
                                <i class="fa-solid fa-sun text-sm"></i>
                            </button>
                            <button onclick="toggleBrushing('{{ $dateKey }}', 'night')"
                                id="btn-night-{{ $dateKey }}"
                                class="w-10 h-10 rounded-2xl flex items-center justify-center transition-none shadow-sm border-2 {{ $log?->night ? 'bg-indigo-600 border-indigo-400 text-white' : 'bg-white border-gray-100 text-gray-200' }}">
                                <i class="fa-solid fa-moon text-sm"></i>
                            </button>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- TAB 2: HEALTH VISITS --}}
    <div x-show="tab === 'visits'" x-transition class="space-y-6">
        <div class="bg-white rounded-[2rem] p-6 md:p-10 shadow-sm border border-gray-100">
            @if($visits->isEmpty())
                <div class="text-center py-10">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <i class="fa-solid fa-calendar-xmark text-4xl"></i>
                    </div>
                    <p class="text-gray-400 font-medium">Belum ada catatan kunjungan pemeriksaan.</p>
                </div>
            @else
                <div class="relative border-l-2 border-sky-100 ml-4 md:ml-6 space-y-10">
                    @foreach($visits as $visit)
                        <div class="relative pl-8">
                            {{-- Dot --}}
                            <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-[#5DB8D8] border-4 border-white shadow-sm"></div>

                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-black text-[#5DB8D8] uppercase tracking-wider">
                                    {{ $visit->visit_date->translatedFormat('d F Y') }}
                                </span>

                                <div class="bg-gray-50 rounded-2xl p-5 mt-2 border border-gray-100">
                                    @if($visit->lecturer)
                                        <div class="flex items-center gap-2 mb-4">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($visit->lecturer->name) }}&background=5DB8D8&color=fff" class="w-6 h-6 rounded-full" alt="Avatar">
                                            <span class="text-xs font-bold text-gray-600">Pemeriksa: {{ $visit->lecturer->name }}</span>
                                        </div>
                                    @endif

                                    <div class="grid md:grid-cols-2 gap-6">
                                        {{-- Catatan Konsultasi --}}
                                        <div>
                                            <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Keluhan / Konsultasi</p>
                                            <p class="text-sm text-gray-700 leading-relaxed italic">
                                                "{{ $visit->consultation_notes ?? 'Tidak ada catatan keluhan.' }}"
                                            </p>
                                        </div>

                                        {{-- Tindakan Perawatan --}}
                                        <div>
                                            <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Tindakan / Perawatan</p>
                                            <div class="flex flex-wrap gap-2">
                                                @if($visit->treatment_notes)
                                                    <span class="px-3 py-1 bg-sky-100 text-[#5DB8D8] rounded-lg text-xs font-bold">
                                                        {{ $visit->treatment_notes }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-gray-400 italic">Hanya konsultasi rutin.</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function toggleBrushing(date, time) {
        const btn = document.getElementById(`btn-${time}-${date}`);
        
        fetch("{{ route('student.monitoring.toggle') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ date, time })
        })
        .then(res => res.json())
        .then(data => {
            if (data.state) {
                btn.classList.remove('bg-white', 'text-gray-200', 'border-gray-100');
                btn.classList.add(time === 'morning' ? 'bg-yellow-400' : 'bg-indigo-600', 'text-white', time === 'morning' ? 'border-yellow-200' : 'border-indigo-400');
            } else {
                btn.classList.add('bg-white', 'text-gray-200', 'border-gray-100');
                btn.classList.remove('bg-yellow-400', 'bg-indigo-600', 'text-white', 'border-yellow-200', 'border-indigo-400');
            }
        });
    }
</script>
@endsection