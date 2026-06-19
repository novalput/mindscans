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
                    <option value="depression" {{ $question->type == 'depression' ? 'selected' : '' }}>Kuesioner Depresi</option>
                    <option value="anxiety" {{ $question->type == 'anxiety' ? 'selected' : '' }}>Kuesioner Ansietas</option>
                    <option value="impact" {{ $question->type == 'impact' ? 'selected' : '' }}>Dampak Fungsional</option>
                </select>
            </div>

            <div x-data="{
                open: false,
                search: '{{ old('subtype', $question->subtype ?? '') }}',
                subtypes: {{ json_encode($subtypes) }},
                get filteredSubtypes() {
                    if (this.search === '') return this.subtypes;
                    return this.subtypes.filter(item => item.toLowerCase().includes(this.search.toLowerCase()));
                }
            }" class="relative">
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Sub Tipe (Opsional)</label>
                
                <div class="relative">
                    <input 
                        type="text" 
                        name="subtype" 
                        x-model="search"
                        @focus="open = true"
                        @click.away="open = false"
                        @keydown.escape="open = false"
                        placeholder="Pilih atau ketik sub tipe..."
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3 pr-10 outline-none"
                        autocomplete="off"
                    >

                    <i 
                        class="fa-solid fa-chevron-down text-xs text-gray-400 transition-transform duration-200 absolute"
                        :class="open ? 'rotate-180' : ''"
                        style="right: 16px; top: 50%; transform: translateY(-50%);">
                    </i>
                </div>

                <!-- Dropdown List -->
                <div 
                    x-show="open && filteredSubtypes.length > 0"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 transform -translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 transform -translate-y-2 scale-95"
                    class="absolute left-0 z-50 w-full mt-2 bg-white/95 backdrop-blur-md border border-gray-100 rounded-2xl shadow-xl max-h-60 overflow-y-auto no-scrollbar"
                    style="display: none;"
                >
                    <div class="py-2">
                        <template x-for="item in filteredSubtypes" :key="item">
                            <button 
                                type="button"
                                @click="search = item; open = false;"
                                class="w-full text-left px-5 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors flex items-center justify-between group"
                            >
                                <span x-text="item" class="font-semibold"></span>
                                <i class="fa-solid fa-check text-green-600 opacity-0 group-hover:opacity-100 transition-opacity text-xs"></i>
                            </button>
                        </template>
                    </div>
                </div>
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
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection