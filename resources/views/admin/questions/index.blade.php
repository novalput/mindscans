@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center px-2 gap-4">
        <h3 class="text-xl md:text-2xl font-bold text-gray-800 tracking-tight">Manajemen Pertanyaan Kuesioner</h3>
        <a href="{{ route('admin.questions.create', ['type' => request('type', 'depression')]) }}" class="bg-[#16A34A] hover:bg-green-700 text-white font-bold py-2 px-4 rounded-xl shadow-md transition-all flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Pertanyaan
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Tabs Kategori - Dibuat scrollable secara horizontal di mobile --}}
    <div class="flex overflow-x-auto pb-1 no-scrollbar border-b border-gray-200 hide-scrollbar">
        <div class="flex space-x-1 md:space-x-4 min-w-max px-2">
            @php $types = ['depression' => 'Indikasi Depresi', 'anxiety' => 'Indikasi Kecemasan', 'impact' => 'Dampak Fungsional']; @endphp
            @foreach($types as $key => $label)
            <a href="{{ route('admin.questions.index', ['type' => $key]) }}"
                class="px-4 py-2 text-sm md:text-base whitespace-nowrap transition-all {{ request('type', 'depression') == $key ? 'border-b-2 border-green-500 text-green-600 font-bold' : 'text-gray-500 hover:text-gray-700' }}">
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
                        <th class="p-4 w-16">Urutan</th>
                        <th class="p-4">Pertanyaan</th>
                        <th class="p-4 w-40 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm md:text-base">
                    @forelse($questions as $index => $q)
                    <tr class="hover:bg-green-50/30 transition-colors group">
                        <td class="p-4 text-gray-800 font-bold text-center">
                            {{ $q->order }}
                        </td>
                        <td class="p-4">
                            <p class="text-gray-700 leading-relaxed max-w-md md:max-w-xl">
                                {{ $q->question_text }}
                            </p>
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.questions.edit', $q->id) }}"
                                    class="inline-flex items-center text-blue-500 hover:text-blue-700 font-bold bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-all">
                                    <i class="fa-solid fa-pen-to-square mr-1.5 text-xs"></i> Edit
                                </a>
                                <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center text-red-500 hover:text-red-700 font-bold bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-all">
                                        <i class="fa-solid fa-trash mr-1.5 text-xs"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-10 text-center text-gray-400 italic">
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
