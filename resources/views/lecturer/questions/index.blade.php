@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center px-2">
        <h3 class="text-xl md:text-2xl font-bold text-gray-800 tracking-tight">Manajemen Kuesioner</h3>
    </div>

    {{-- Tabs Kategori - Dibuat scrollable secara horizontal di mobile --}}
    <div class="flex overflow-x-auto pb-1 no-scrollbar border-b border-gray-200 hide-scrollbar">
        <div class="flex space-x-1 md:space-x-4 min-w-max px-2">
            @php $types = ['knowledge' => 'Pengetahuan', 'attitude' => 'Sikap', 'skill_check' => 'Tindakan', 'gingivitis_check' => 'Gingivitis']; @endphp
            @foreach($types as $key => $label)
            <a href="{{ route('lecturer.questions.index', ['type' => $key]) }}"
                class="px-4 py-2 text-sm md:text-base whitespace-nowrap transition-all {{ request('type', 'knowledge') == $key ? 'border-b-2 border-blue-500 text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- List Soal --}}
    <div class="bg-white rounded-2xl md:rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs md:text-sm border-b uppercase tracking-wider font-black">
                        <th class="p-4 w-16">No</th>
                        <th class="p-4">Pertanyaan</th>
                        <th class="p-4 w-40 text-center">Kunci Jawaban</th>
                        <th class="p-4 w-32 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm md:text-base">
                    @forelse($questions as $index => $q)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="p-4 text-gray-400 font-medium">
                            {{ $loop->iteration }}
                        </td>
                        <td class="p-4">
                            <p class="text-gray-700 leading-relaxed max-w-md md:max-w-xl">
                                {{ $q->question_text }}
                            </p>
                        </td>
                        <td class="p-4 text-center">
                            <span class="inline-block bg-green-50 text-green-700 px-3 py-1 rounded-full text-[10px] md:text-xs font-black border border-green-100 uppercase">
                                {{ $q->correct_answer ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('lecturer.questions.edit', $q->id) }}"
                                class="inline-flex items-center text-blue-500 hover:text-blue-700 font-bold bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-all">
                                <i class="fa-solid fa-pen-to-square mr-1.5 text-xs"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center text-gray-400 italic">
                            Belum ada pertanyaan untuk kategori ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Menghilangkan scrollbar tapi fungsi scroll tetap aktif */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection
