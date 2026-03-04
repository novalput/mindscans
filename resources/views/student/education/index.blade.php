@extends('layouts.student')

@section('content')
<div class="bg-gradient-to-br from-sky-50 to-white min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-sansita text-slate-800">Materi Edukasi Gigi</h2>
            <p class="text-slate-500 mt-2">Pelajari cara menjaga kesehatan gigi yang aman selama masa kehamilan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($materials as $item)
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-8">
                    <span class="px-4 py-1 bg-sky-100 text-sky-600 rounded-full text-xs font-bold uppercase tracking-wider">
                        {{ $item->category }}
                    </span>
                    <h3 class="text-xl font-bold text-slate-800 mt-4 mb-3">{{ $item->title }}</h3>
                    <div class="text-slate-500 text-sm line-clamp-3 mb-6">
                        {!! strip_tags($item->content) !!}
                    </div>
                    <a href="{{ route('student.education.show', $item->slug) }}"
                        class="inline-flex items-center text-sky-500 font-bold hover:gap-2 transition-all">
                        Baca Selengkapnya <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
