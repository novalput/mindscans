@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex justify-between items-center px-2">
        <h3 class="text-xl md:text-2xl font-bold text-gray-800 tracking-tight">Tambah Pertanyaan</h3>
        <a href="{{ route('admin.questions.index', ['type' => $type]) }}" class="text-gray-500 hover:text-gray-700 font-bold text-sm flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
        <form action="{{ route('admin.questions.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Kategori Bagian</label>
                <select name="type" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3 outline-none" required>
                    <option value="depression" {{ $type == 'depression' ? 'selected' : '' }}>Kuesioner Depresi</option>
                    <option value="anxiety" {{ $type == 'anxiety' ? 'selected' : '' }}>Kuesioner Ansietas</option>
                    <option value="impact" {{ $type == 'impact' ? 'selected' : '' }}>Dampak Fungsional</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Sub Tipe (Opsional)</label>
                <input type="text" name="subtype" value="{{ old('subtype') }}" placeholder="Contoh: Depresi Emosional"
                       class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3 outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Nomor Urut Tampilan</label>
                <input type="number" name="order" value="{{ old('order') }}" placeholder="Contoh: 1"
                       class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3 outline-none" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Pertanyaan / Pernyataan</label>
                <textarea name="question_text" rows="4" placeholder="Ketik pertanyaan di sini..."
                          class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3 outline-none" required>{{ old('question_text') }}</textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end">
                <button type="submit" class="bg-[#16A34A] hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Pertanyaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
