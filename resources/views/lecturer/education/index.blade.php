@extends('layouts.app')

@section('content')
{{-- Inisialisasi Alpine.js untuk Modal Global --}}
<div x-data="{ openDelete: false, postUrl: '' }" class="max-w-7xl mx-auto p-4 md:p-6 pb-20">

    {{-- Header Section --}}
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-10">
        <div class="w-full lg:w-auto">
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 text-[10px] font-semibold text-gray-400 uppercase tracking-[0.2em]">
                    <li>DASHBOARD</li>
                    <li><i class="fa-solid fa-chevron-right text-[7px]"></i></li>
                    <li class="text-blue-600">EDUKASI</li>
                </ol>
            </nav>
            <h1 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">EduContent <span class="text-blue-600">Manager</span></h1>
            <p class="text-gray-500 mt-1 text-sm md:text-base">Kelola literasi kesehatan gigi dan mulut Ibu Hamil.</p>
        </div>

        <a href="{{ route('lecturer.education.create') }}" class="w-full lg:w-auto text-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-blue-100 transition-all active:scale-95 flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>TAMBAH MATERI</span>
        </a>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Konten</p>
                <p class="text-xl font-black text-gray-800">{{ $contents->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Content Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @forelse($contents as $item)
        <div class="group bg-white rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">

            {{-- Thumbnail Area --}}
            <div class="relative h-48 md:h-56 bg-gray-100 overflow-hidden">
                @if($item->thumbnail)
                <img src="{{ asset('storage/' . $item->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @else
                <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 bg-gray-50">
                    <i class="fa-solid fa-image text-3xl mb-2"></i>
                    <span class="text-[9px] font-black uppercase tracking-tighter">No Preview Available</span>
                </div>
                @endif
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1.5 bg-white/90 backdrop-blur text-blue-600 text-[10px] font-black rounded-xl shadow-sm uppercase tracking-tight">
                        {{ $item->category }}
                    </span>
                </div>
            </div>

            {{-- Content Area --}}
            <div class="p-6 md:p-8 flex flex-col flex-grow">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">Post #{{ $loop->iteration }}</span>
                    @if($item->video_url)
                    <span class="flex items-center gap-1.5 text-red-500 text-[10px] font-black uppercase tracking-tighter bg-red-50 px-2 py-1 rounded-lg">
                        <i class="fa-solid fa-play"></i> Video
                    </span>
                    @endif
                </div>

                <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-6 leading-tight uppercase line-clamp-2 min-h-[3rem]">
                    {{ $item->title }}
                </h3>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3 mt-auto">
                    <a href="{{ route('lecturer.education.edit', $item->id) }}" class="flex-1 inline-flex items-center justify-center px-4 py-3.5 bg-blue-50 text-blue-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all active:scale-95">
                        <i class="fa-solid fa-pen-to-square mr-2"></i> Edit
                    </a>

                    {{-- Tombol Hapus (Hanya Trigger Alpine) --}}
                    <button type="button"
                        @click="openDelete = true; postUrl = '{{ route('lecturer.education.destroy', $item->id) }}'"
                        class="w-12 h-12 inline-flex items-center justify-center bg-red-50 text-red-400 rounded-2xl hover:bg-red-500 hover:text-white transition-all active:scale-90">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 px-6 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-gray-300 text-2xl">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 uppercase tracking-tight">Kosong</h3>
            <p class="text-gray-400 text-sm mt-1">Belum ada materi edukasi yang dibuat.</p>
        </div>
        @endforelse
    </div>

    {{-- MODAL HAPUS GLOBAL (Teleported to Body) --}}
    <template x-teleport="body">
        <div x-show="openDelete" class="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-hidden" x-cloak>
            {{-- Backdrop --}}
            <div x-show="openDelete"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                @click="openDelete = false" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

            {{-- Card Modal --}}
            <div x-show="openDelete"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                class="relative w-full max-w-sm bg-white p-8 md:p-10 rounded-[3rem] shadow-2xl border border-gray-100 text-center">

                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl animate-bounce">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>

                <h3 class="text-2xl font-black text-gray-800 uppercase tracking-tighter leading-tight">Hapus Konten?</h3>
                <p class="text-gray-500 mt-2 text-sm leading-relaxed">Tindakan ini permanen. Materi yang dihapus tidak dapat dipulihkan kembali.</p>

                <div class="flex flex-col sm:flex-row gap-3 mt-10">
                    <button @click="openDelete = false" class="order-2 sm:order-1 flex-1 py-4 bg-gray-100 text-gray-400 rounded-2xl font-black text-xs tracking-widest hover:bg-gray-200 transition-all">
                        BATAL
                    </button>
                    <form :action="postUrl" method="POST" class="order-1 sm:order-2 flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-4 bg-red-500 text-white rounded-2xl font-black text-xs tracking-widest shadow-lg shadow-red-100 hover:bg-red-600 transition-all active:scale-95">
                            HAPUS
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection
