@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    {{-- Header & Breadcrumb --}}
    <div class="flex flex-col gap-2 px-2">
        <div class="flex items-center text-sm text-gray-500 gap-2">
            <a href="{{ route('lecturer.questions.index') }}" class="hover:text-blue-600 transition-colors">Kuesioner</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-gray-800 font-medium">Edit Soal</span>
        </div>
        <h3 class="text-xl md:text-2xl font-bold text-gray-800 tracking-tight">Edit Pertanyaan</h3>
    </div>

    {{-- Card Form --}}
    <div class="bg-white rounded-2xl md:rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('lecturer.questions.update', $question->id) }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Informasi Tipe (Read-only badge) --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Kategori Soal</label>
                <span class="inline-block bg-blue-50 text-blue-700 px-4 py-1.5 rounded-full text-xs font-bold border border-blue-100 uppercase">
                    {{ str_replace('_', ' ', $question->type) }}
                </span>
            </div>

            {{-- Textarea Pertanyaan --}}
            <div>
                <label for="question_text" class="block text-sm font-bold text-gray-700 mb-2">Teks Pertanyaan</label>
                <textarea 
                    name="question_text" 
                    id="question_text" 
                    rows="5" 
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-gray-700 leading-relaxed @error('question_text') border-red-500 @enderror"
                    placeholder="Masukkan teks pertanyaan di sini..."
                    required>{{ old('question_text', $question->question_text) }}</textarea>
                @error('question_text')
                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Kunci Jawaban --}}
            <div>
                <label for="correct_answer" class="block text-sm font-bold text-gray-700 mb-2">Kunci Jawaban</label>
                <input 
                    type="text" 
                    name="correct_answer" 
                    id="correct_answer" 
                    value="{{ old('correct_answer', $question->correct_answer) }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none text-gray-700 @error('correct_answer') border-red-500 @enderror"
                    placeholder="Contoh: Ya / Tidak atau jawaban singkat lainnya">
                <p class="mt-2 text-xs text-gray-400 italic">Kosongkan jika pertanyaan tidak memerlukan kunci jawaban spesifik.</p>
                @error('correct_answer')
                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-gray-50">

            {{-- Action Buttons --}}
            <div class="flex flex-col md:flex-row gap-3 pt-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-blue-200 flex items-center justify-center">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                </button>
                <a href="{{ route('lecturer.questions.index', ['type' => $question->type]) }}" class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold py-3 px-6 rounded-xl transition-all flex items-center justify-center border border-gray-100">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection