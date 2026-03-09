@extends('layouts.student')
@php
use Illuminate\Support\Str;
@endphp

@section('title', 'Home - LoveCaring-Rr.Nursing')

@section('content')
<div x-data="{
        init() {
            this.observeScroll();
        },
        observeScroll() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        entry.target.classList.remove('opacity-0', 'translate-y-10');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
        }
    }">

    {{-- Hero Section --}}
    <section class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-24 py-20 grid lg:grid-cols-2 gap-12 items-center">

            {{-- LEFT CONTENT --}}
            <div class="space-y-6">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
                    <span class="text-slate-900">Kuesioner</span><br>
                    <span class="text-[#22C55E]">Kesehatan Mental</span>
                </h1>

                <p class="text-lg text-slate-600 leading-relaxed max-w-xl">
                    Ambil langkah pertama untuk mengenal dirimu lebih dalam.
                    Layanan skrining mandiri yang aman, privat, dan tepercaya
                    untuk mahasiswa serta seluruh sivitas akademika.
                </p>

                {{-- Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('student.screening.index') }}"
                        class="px-8 py-4 bg-[#22C55E] text-white font-semibold rounded-full hover:bg-green-600 transition-all shadow-lg">
                        Mulai Kuesioner
                    </a>

                    <a href="#about"
                        class="px-8 py-4 border-2 border-slate-800 text-slate-800 font-semibold rounded-full hover:bg-slate-800 hover:text-white transition-all">
                        Pelajari Lebih Lanjut
                    </a>
                </div>

                {{-- Participants --}}
                <div class="flex items-center gap-4 pt-6">
                    <div class="flex -space-x-4">
                        <img src="https://i.pravatar.cc/100?img=10"
                            class="w-10 h-10 rounded-full border-2 border-white">
                        <img src="https://i.pravatar.cc/100?img=12"
                            class="w-10 h-10 rounded-full border-2 border-white">
                        <img src="https://i.pravatar.cc/100?img=5"
                            class="w-10 h-10 rounded-full border-2 border-white">
                    </div>
                    <p class="text-slate-600 text-sm">
                        <span class="font-bold text-slate-900">2500+</span> partisipan telah mempercayakan
                        kesehatan mental mereka
                    </p>
                </div>
            </div>


            {{-- RIGHT IMAGE --}}
            <div class="relative flex justify-center lg:justify-end">

                {{-- Image Frame --}}
                <div class="relative">
                    <img src="{{ asset('images/home2.jpeg') }}"
                        class="w-[500px] sm:w-[560px] lg:w-[600px] rounded-[40px] shadow-2xl object-cover">

                    {{-- Bottom Floating Card --}}
                    <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 bg-white shadow-xl rounded-2xl px-6 py-4 flex items-center gap-4 w-[90%]">

                        <div class="w-12 h-12 flex items-center justify-center bg-yellow-400 rounded-full text-xl">
                            😊
                        </div>

                        <div>
                            <h4 class="font-bold text-slate-800">
                                Self Care Matters
                            </h4>
                            <p class="text-sm text-slate-500">
                                Prioritaskan kesehatan mentalmu hari ini
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="py-20 lg:py-32 bg-gradient-to-br from-slate-50 to-slate-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-24">
            <h2
                class="animate-on-scroll opacity-0 translate-y-10 transition-all duration-700 text-center text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-slate-800 mb-8 leading-tight">
                Mengapa Memilih Pendekatan Kami?
            </h2>
            <p
                class="animate-on-scroll opacity-0 translate-y-10 transition-all duration-700 delay-150 text-center text-base sm:text-lg md:text-xl lg:text-2xl text-slate-700 max-w-4xl mx-auto mb-16 leading-relaxed">
                Kami percaya bahwa kesehatan mental adalah fondasi utama bagi kebahagiaan hidup.
            </p>

            {{-- Grid Features --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                $features = [
                ['icon' => 'fa-regular fa-lock', 'title' => 'Kerahasiaan Terjamin', 'desc' => 'Seluruh data hasil skrining bersifat anonim dan hanya digunakan untuk keperluan riset kesehatan serta dukungan personal.'],
                ['icon' => 'fa-regular fa-book-medical', 'title' => 'Metode Tervalidasi', 'desc' => 'Menggunakan instrumen penilaian standar psikologi medis.'],
                ['icon' => 'fa-regular fa-user-md', 'title' => 'Dukungan Lanjutan', 'desc' => 'Dapatkan rekomendasi praktis dan akses cepat ke layanan konseling profesional Poltekkes jika Anda membutuhkannya.'],
                ];
                @endphp

                @foreach($features as $index => $item)
                <div
                    class="animate-on-scroll opacity-0 translate-y-10 transition-all duration-700 delay-{{ $index * 150 }} bg-white p-8 rounded-3xl shadow-xl hover:-translate-y-3 transition-transform duration-300 text-center group">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-[#22C55E] to-green-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-green-200 group-hover:scale-110 transition-transform">
                        <i class="fas {{ $item['icon'] }} text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4">{{ $item['title'] }}</h3>
                    <p class="text-slate-600 leading-relaxed">{{ $item['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Materi Edukasi Section --}}
    <section id="education" class="py-28 bg-[#F0FDF4] relative overflow-hidden">

        {{-- Background --}}
        <div class="absolute -top-32 -right-32 w-[500px] h-[500px] bg-green-100 rounded-full blur-3xl opacity-80"></div>
        <div class="absolute -bottom-32 -left-32 w-[500px] h-[500px] bg-green-50 rounded-full blur-3xl opacity-80"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">

            {{-- Header --}}
            <div class="text-center mb-24 animate-on-scroll opacity-0 translate-y-10">
                <span class="inline-flex items-center gap-2 px-6 py-2
                        bg-[#ECFDF5] text-[#16A34A]
                        text-xs font-semibold tracking-widest rounded-full">
                    Mulai Perubahan Hari Ini
                </span>

                <h2 class="text-4xl md:text-5xl font-sansita text-slate-800 mt-6 mb-5">
                    Berikan Perhatian Lebih Pada Kesehatan Mentalmu
                </h2>

                <p class="text-slate-500 max-w-2xl mx-auto text-lg leading-relaxed">
                    Umpan balik Anda membantu kami menciptakan lingkungan yang lebih sehat dan suportif. Mulailah kuesioner Anda sekarang.
                </p>
            </div>
            <div class="flex justify-center flex-col sm:flex-row gap-3">
                <a href="{{ route('student.screening.index') }}"
                    class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-[#22C55E] text-white font-bold rounded-full hover:bg-green-600 transition-all hover:translate-x-2">
                    Mulai Test Kuesioner<i class="fas fa-arrow-right ml-3"></i>
                </a>
            </div>
        </div>
    </section>

    <script>
        window.addEventListener('load', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        entry.target.classList.remove('opacity-0', 'translate-y-10');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
        });
    </script>

</div>
@endsection
