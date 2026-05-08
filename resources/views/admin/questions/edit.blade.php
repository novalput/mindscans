@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex justify-between items-center px-2">
        <h3 class="text-xl md:text-2xl font-bold text-gray-800 tracking-tight">Edit Pertanyaan</h3>
        <a href="{{ route('admin.questions.index', ['type' => $question->type]) }}" class="text-gray-500 hover:text-gray-700 font-bold text-sm flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Kategori Bagian</label>
                <select name="type" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3 outline-none" required>
                    <option value="depression" {{ $question->type == 'depression' ? 'selected' : '' }}>Indikasi Depresi</option>
                    <option value="anxiety" {{ $question->type == 'anxiety' ? 'selected' : '' }}>Indikasi Kecemasan</option>
                    <option value="impact" {{ $question->type == 'impact' ? 'selected' : '' }}>Dampak Fungsional</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Nomor Urut Tampilan</label>
                <input type="number" name="order" value="{{ old('order', $question->order) }}"
                       class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3 outline-none" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Pertanyaan / Pernyataan</label>
                <textarea name="question_text" rows="4"
                          class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3 outline-none" required>{{ old('question_text', $question->question_text) }}</textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end">
                <button type="submit" class="bg-[#16A34A] hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection