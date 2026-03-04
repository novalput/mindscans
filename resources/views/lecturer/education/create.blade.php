@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 pb-20">
    {{-- Header & Back Button --}}
    <div class="mb-8">
        <a href="{{ route('lecturer.education.index') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-blue-600 transition-colors group">
            <i class="fa-solid fa-arrow-left-long mr-2 group-hover:-translate-x-1 transition-transform"></i>
            Kembali ke Manager
        </a>
        <h1 class="text-3xl font-black text-gray-900 mt-4 tracking-tight">Buat <span class="text-blue-600">Konten Baru</span></h1>
        <p class="text-gray-500">Susun materi edukasi yang informatif untuk meningkatkan literasi Ibu Hamil.</p>
    </div>

    <form action="{{ route('lecturer.education.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Left Side: Main Form --}}
            <div class="flex-1 space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 md:p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Judul Materi</label>
                            <input type="text" name="title"
                                class="w-full bg-gray-50 border-2 border-transparent focus:border-blue-100 focus:bg-white focus:ring-4 focus:ring-blue-50 rounded-2xl p-4 transition-all outline-none font-bold text-gray-700"
                                placeholder="Misal: Bahaya Radang Gusi..." required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Kategori</label>
                            <div class="relative">
                                <select name="category" class="w-full bg-gray-50 border-2 border-transparent focus:border-blue-100 focus:bg-white focus:ring-4 focus:ring-blue-50 rounded-2xl p-4 transition-all outline-none font-bold text-gray-700 appearance-none">
                                    <option>Masalah Gigi</option>
                                    <option>Kesehatan Ibu Hamil</option>
                                    <option>Nutrisi & Pencegahan</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 mb-8">
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Konten Materi</label>
                            <span class="text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded-md">Mendukung Multi-baris</span>
                        </div>
                        <textarea name="content" rows="15"
                            class="w-full bg-gray-50 border-2 border-transparent focus:border-blue-100 focus:bg-white focus:ring-4 focus:ring-blue-50 rounded-[2rem] p-8 transition-all outline-none leading-relaxed text-gray-600 font-medium"
                            placeholder="Tuliskan materi edukasi di sini secara detail..."></textarea>
                    </div>
                </div>
            </div>

            {{-- Right Side: Attachments & Publishing --}}
            <div class="lg:w-80 space-y-6">
                {{-- Media Card --}}
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xs font-black uppercase text-gray-900 mb-6 flex items-center">
                        <i class="fa-solid fa-paperclip mr-2 text-blue-600"></i> Media & Atribut
                    </h3>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Video YouTube</label>
                            <div class="relative">
                                <i class="fa-brands fa-youtube absolute left-4 top-1/2 -translate-y-1/2 text-red-500"></i>
                                <input type="url" name="video_url" class="w-full bg-gray-50 border-none rounded-xl py-3 pl-10 pr-4 text-xs font-bold" placeholder="https://youtube.com/...">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Thumbnail Materi</label>
                            <div class="relative group">
                                <input type="file" name="thumbnail" id="thumbnail" class="hidden" accept="image/*">
                                <label for="thumbnail" class="flex flex-col items-center justify-center w-full h-32 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition-all">
                                    <i class="fa-solid fa-cloud-arrow-up text-gray-300 text-xl group-hover:text-blue-500"></i>
                                    <span class="text-[10px] font-bold text-gray-400 mt-2 group-hover:text-blue-600">Pilih Gambar</span>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Urutan Tampil</label>
                            <input type="number" name="order" value="0" class="w-full bg-gray-50 border-none rounded-xl p-3 text-xs font-bold">
                        </div>
                    </div>
                </div>

                {{-- Action Card --}}
                <div class="bg-blue-600 rounded-[2rem] p-6 shadow-xl shadow-blue-100">
                    <p class="text-blue-100 text-[10px] font-bold uppercase mb-4 text-center tracking-widest">Siap untuk dipublikasi?</p>
                    <button type="submit" class="w-full bg-white text-blue-600 py-4 rounded-xl font-black text-sm shadow-sm hover:bg-gray-50 transition-all uppercase tracking-tighter active:scale-95">
                        Publikasikan
                    </button>
                    <p class="text-blue-200 text-[9px] mt-4 text-center leading-relaxed">
                        Materi akan langsung dapat diakses oleh pasien melalui aplikasi.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
