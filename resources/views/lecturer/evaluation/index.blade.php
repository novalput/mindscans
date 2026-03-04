@extends('layouts.app')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h3 class="text-xl md:text-2xl font-bold text-gray-800 tracking-tight text-center sm:text-left w-full sm:w-auto">
            Evaluasi & Hasil Medical Checkup
        </h3>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Wrapper untuk scroll horizontal di HP --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-[10px] md:text-xs border-b uppercase tracking-wider font-black">
                        <th class="p-4 md:p-6">Nama Pasien</th>
                        <th class="p-4 md:p-6 text-center">Usia Hamil</th>
                        <th class="p-4 md:p-6 text-center">Status Test</th>
                        <th class="p-4 md:p-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($students as $p)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="p-4 md:p-6">
                            <div class="flex flex-col">
                                <span class="font-extrabold text-gray-800 text-sm md:text-base">{{ $p->name }}</span>
                                <span class="text-[10px] text-gray-400 font-medium italic">ID: #{{ $p->id }}</span>
                            </div>
                        </td>

                        <td class="p-4 md:p-6 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-600">
                                {{ $p->student->pregnancy_week ?? '-' }} Minggu
                            </span>
                        </td>

                        <td class="p-4 md:p-6">
                            @php
                            $responses = $p->screeningResponses ?? collect();
                            $hasPre = $responses->where('type', 'pre_test')->first();
                            $hasPost = $responses->where('type', 'post_test')->first();
                            $hasScan = $responses->where('type', 'gingivitis_scan')->first();
                            @endphp
                            <div class="flex justify-center gap-2">
                                <span class="px-2 py-1 rounded-lg text-[9px] md:text-[10px] font-black {{ $hasPre ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                                    PRE {{ $hasPre ? '✓' : '' }}
                                </span>
                                <span class="px-2 py-1 rounded-lg text-[9px] md:text-[10px] font-black {{ $hasPost ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                                    POST {{ $hasPost ? '✓' : '' }}
                                </span>
                                {{-- Tambahkan indikator Scan AI juga biar lengkap --}}
                                <span class="px-2 py-1 rounded-lg text-[9px] md:text-[10px] font-black {{ $hasScan ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-400' }}">
                                    AI {{ $hasScan ? '✓' : '' }}
                                </span>
                            </div>
                        </td>

                        <td class="p-4 md:p-6 text-right">
                            <a href="{{ route('lecturer.evaluasi.show', $p->id) }}" class="inline-flex items-center justify-center text-blue-500 hover:text-white font-bold text-[11px] md:text-xs bg-blue-50 hover:bg-blue-500 px-4 py-2.5 rounded-xl transition-all shadow-sm hover:shadow-blue-200">
                                <i class="fa-solid fa-eye mr-2"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4 md:p-6 bg-gray-50/50 border-t border-gray-100">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
