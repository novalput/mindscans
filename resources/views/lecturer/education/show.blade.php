@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-10 pb-32">
    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="w-12 h-12 flex items-center justify-center bg-gray-50 rounded-2xl text-gray-400 hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>

    <header class="mb-10">
        <span class="text-blue-600 font-black text-[10px] uppercase tracking-[0.2em] px-3 py-1 bg-blue-50 rounded-full">{{ $materi->category }}</span>
        <h1 class="text-3xl md:text-4xl font-black text-gray-900 mt-4 leading-tight">{{ $materi->title }}</h1>
    </header>

    @if($materi->image)
    <div class="mb-10 rounded-[2.5rem] overflow-hidden shadow-2xl">
        <img src="{{ asset('storage/'.$materi->image) }}" class="w-full object-cover">
    </div>
    @endif

    <article class="text-gray-700 leading-[1.8] text-base md:text-lg whitespace-pre-line space-y-4 font-medium">
        {{ $materi->content }}
    </article>

    @if($materi->video_url)
    <div class="mt-16 p-8 bg-red-50 rounded-[3rem] border-4 border-white shadow-xl">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center shadow-lg shadow-red-200">
                <i class="fa-solid fa-play text-white text-xs"></i>
            </div>
            <h3 class="font-black text-gray-800 uppercase text-sm tracking-widest">Video Panduan Praktis</h3>
        </div>

        <div class="aspect-video rounded-3xl overflow-hidden shadow-inner bg-black">
            @php
            // Script untuk extract YouTube ID
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $materi->video_url, $match);
            $youtubeId = $match[1] ?? null;
            @endphp
            @if($youtubeId)
            <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            @else
            <p class="text-center text-gray-400 py-20 text-xs">Video tidak dapat dimuat</p>
            @endif
        </div>
    </div>
    @endif

    <div class="mt-16 pt-10 border-t border-gray-100">
        <div class="bg-gray-900 p-8 rounded-[2.5rem] text-center">
            <h4 class="text-white font-bold mb-2">Sudah selesai membaca?</h4>
            <p class="text-gray-400 text-xs mb-6 px-4">Terus jaga kesehatan gusi Anda demi kesehatan janin.</p>
            <a href="{{ route('dashboard') }}" class="inline-block bg-white text-gray-900 px-8 py-3 rounded-2xl font-black text-sm uppercase tracking-tighter">Selesai</a>
        </div>
    </div>
</div>
@endsection
