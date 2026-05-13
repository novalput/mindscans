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
    <div class="mb-8">
        @php $types = ['depression' => 'Kuesioner Depresi', 'anxiety' => 'Kuesioner Ansietas', 'impact' => 'Dampak Fungsional']; @endphp
        <div class="flex space-x-2 md:space-x-4">
            @foreach($types as $key => $label)
            <a href="{{ route('admin.questions.index', ['type' => $key]) }}"
               class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ request('type', 'depression') == $key ? 'bg-green-600 text-white shadow-md' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- List Soal --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Sub Tipe</th>
                        <th class="px-6 py-4">Pertanyaan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($questions as $index => $q)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $q->order }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $q->subtype ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600 leading-relaxed">{{ $q->question_text }}</td>
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
