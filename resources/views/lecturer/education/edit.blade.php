@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 pb-20">
    {{-- Header & Back Button --}}
    <div class="mb-8 flex justify-between items-end">
        <div>
            <a href="{{ route('lecturer.education.index') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-blue-600 transition-colors group">
                <i class="fa-solid fa-arrow-left-long mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Kembali ke Manager
            </a>
            <h1 class="text-3xl font-black text-gray-900 mt-4 tracking-tight">Edit <span class="text-blue-600">Materi</span></h1>
            <p class="text-gray-500 text-sm">Perbarui informasi edukasi untuk menjaga kualitas literasi pasien.</p>
        </div>
        <div class="hidden md:block">
            <span class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em]">ID Materi: #{{ $materi->id }}</span>
        </div>
    </div>

    <form action="{{ route('lecturer.education.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Sisi Kiri: Form Utama --}}
            <div class="flex-1 space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 md:p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Judul Materi</label>
                            <input type="text" name="title" value="{{ old('title', $materi->title) }}"
                                class="w-full bg-gray-50 border-2 border-transparent focus:border-blue-100 focus:bg-white focus:ring-4 focus:ring-blue-50 rounded-2xl p-4 transition-all outline-none font-bold text-gray-700"
                                required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Kategori</label>
                            <div class="relative">
                                <select name="category" class="w-full bg-gray-50 border-2 border-transparent focus:border-blue-100 focus:bg-white focus:ring-4 focus:ring-blue-50 rounded-2xl p-4 transition-all outline-none font-bold text-gray-700 appearance-none">
                                    <option value="Masalah Gigi" {{ $materi->category == 'Masalah Gigi' ? 'selected' : '' }}>Masalah Gigi</option>
                                    <option value="Kesehatan Ibu Hamil" {{ $materi->category == 'Kesehatan Ibu Hamil' ? 'selected' : '' }}>Kesehatan Ibu Hamil</option>
                                    <option value="Nutrisi & Pencegahan" {{ $materi->category == 'Nutrisi & Pencegahan' ? 'selected' : '' }}>Nutrisi & Pencegahan</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 mb-2">
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Isi Konten Lengkap</label>
                        <textarea name="content" rows="15"
                            class="w-full bg-gray-50 border-2 border-transparent focus:border-blue-100 focus:bg-white focus:ring-4 focus:ring-blue-50 rounded-[2rem] p-8 transition-all outline-none leading-relaxed text-gray-600 font-medium">{{ old('content', $materi->content) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Sisi Kanan: Media & Preview --}}
            <div class="lg:w-80 space-y-6">

                {{-- Preview Thumbnail Saat Ini --}}
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-50">
                        <h3 class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Thumbnail Saat Ini</h3>
                    </div>
                    <div class="aspect-video bg-gray-100 relative">
                        @if($materi->thumbnail)
                        <img src="{{ asset('storage/' . $materi->thumbnail) }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 italic text-[10px]">Belum ada gambar</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <input type="file" name="thumbnail" id="thumbnail" class="hidden" accept="image/*">
                        <label for="thumbnail" class="flex items-center justify-center w-full py-3 bg-blue-50 text-blue-600 rounded-xl cursor-pointer hover:bg-blue-600 hover:text-white transition-all text-xs font-black uppercase tracking-tighter">
                            <i class="fa-solid fa-image mr-2"></i> Ganti Gambar
                        </label>
                    </div>
                </div>

                {{-- Video & Order Card --}}
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Link YouTube</label>
                            <div class="relative">
                                <i class="fa-brands fa-youtube absolute left-4 top-1/2 -translate-y-1/2 text-red-500"></i>
                                <input type="url" name="video_url" value="{{ old('video_url', $materi->video_url) }}"
                                    class="w-full bg-gray-50 border-none rounded-xl py-3 pl-10 pr-4 text-xs font-bold" placeholder="https://...">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Urutan Tampil</label>
                            <input type="number" name="order" value="{{ old('order', $materi->order ?? 0) }}"
                                class="w-full bg-gray-50 border-none rounded-xl p-3 text-xs font-bold">
                        </div>
                    </div>
                </div>

                {{-- Update Button --}}
                <div class="bg-gray-900 rounded-[2rem] p-6 shadow-xl shadow-gray-200">
                    <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl font-black text-sm shadow-lg hover:bg-blue-500 transition-all uppercase tracking-widest active:scale-95">
                        Simpan Perubahan
                    </button>
                    <div class="flex items-center justify-center mt-4 text-[9px] text-gray-500 font-bold uppercase tracking-[0.2em]">
                        <i class="fa-solid fa-circle-check text-green-500 mr-2"></i> Auto-Slug Enabled
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
