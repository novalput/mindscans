@extends('layouts.student')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-6">
        {{-- Back Button --}}
        <a href="{{ route('student.education.index') }}"
            class="inline-flex items-center text-slate-500 hover:text-sky-600 mb-6 transition-colors">
            <i class="fas fa-chevron-left mr-2"></i>
            Kembali ke Edukasi
        </a>

        <article class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            {{-- Header Materi --}}
            <div class="bg-gradient-to-r from-[#5DB8D8] to-sky-400 p-10 text-white">
                <span class="text-sky-100 text-sm font-bold uppercase">{{ $education->category }}</span>
                <h1 class="text-3xl md:text-4xl font-bold mt-2">{{ $education->title }}</h1>
                <div class="flex items-center gap-4 mt-4 text-sky-100 text-sm">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $education->created_at->format('d M Y') }}
                    </span>
                    <span class="flex items-center gap-2">
                        <i class="fas fa-clock"></i>
                        {{ ceil(str_word_count(strip_tags($education->content)) / 200) }} menit baca
                    </span>
                </div>
            </div>

            <div class="p-8 md:p-12">
                {{-- Thumbnail (jika ada) --}}
                @if($education->thumbnail)
                <div class="mb-10 rounded-2xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/' . $education->thumbnail) }}"
                        alt="{{ $education->title }}"
                        class="w-full object-cover">
                </div>
                @endif

                {{-- Konten Video --}}
                @if($education->video_url)
                <div class="mb-10 p-6 bg-gradient-to-br from-red-50 to-pink-50 rounded-3xl border-2 border-red-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-play text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">Video Panduan Praktis</h3>
                            <p class="text-xs text-slate-500">Tonton untuk pemahaman lebih mendalam</p>
                        </div>
                    </div>
                    <div class="rounded-2xl overflow-hidden shadow-lg aspect-video">
                        <iframe class="w-full h-full"
                            src="{{ $education->video_url }}"
                            frameborder="0"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
                @endif

                {{-- Isi Teks dengan Styling --}}
                <div class="prose prose-sky max-w-none text-slate-700 leading-relaxed content-article">
                    {!! $education->content !!}
                </div>

                {{-- Ilustrasi Tambahan berdasarkan Kategori --}}
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if(stripos($education->content, 'gingivitis') !== false || stripos($education->content, 'gusi') !== false)
                    <div class="bg-blue-50 p-6 rounded-3xl border-2 border-blue-100">
                        <div class="aspect-square bg-white rounded-2xl mb-4 flex items-center justify-center">
                            <div class="text-center p-4">
                                <i class="fas fa-teeth text-6xl text-blue-300 mb-3"></i>
                                <p class="text-xs font-bold text-slate-600">Ilustrasi: Gusi Sehat vs Gingivitis</p>
                            </div>
                        </div>
                        <h4 class="font-bold text-sm text-slate-800 mb-2">Tanda-tanda Radang Gusi</h4>
                        <ul class="text-xs text-slate-600 space-y-1">
                            <li>• Gusi berwarna merah tua</li>
                            <li>• Bengkak dan mudah berdarah</li>
                            <li>• Nyeri saat menyikat gigi</li>
                        </ul>
                    </div>
                    @endif

                    @if(stripos($education->content, 'menyikat') !== false || stripos($education->content, 'sikat gigi') !== false)
                    <div class="bg-green-50 p-6 rounded-3xl border-2 border-green-100">
                        <div class="aspect-square bg-white rounded-2xl mb-4 flex items-center justify-center">
                            <div class="text-center p-4">
                                <i class="fas fa-tooth text-6xl text-green-300 mb-3"></i>
                                <p class="text-xs font-bold text-slate-600">Teknik Menyikat Gigi 45°</p>
                            </div>
                        </div>
                        <h4 class="font-bold text-sm text-slate-800 mb-2">Tips Menyikat Gigi</h4>
                        <ul class="text-xs text-slate-600 space-y-1">
                            <li>• 2x sehari (pagi & malam)</li>
                            <li>• Sudut 45° dari gusi ke gigi</li>
                            <li>• Durasi minimal 2 menit</li>
                        </ul>
                    </div>
                    @endif

                    @if(stripos($education->content, 'nutrisi') !== false || stripos($education->content, 'makanan') !== false)
                    <div class="bg-orange-50 p-6 rounded-3xl border-2 border-orange-100">
                        <div class="aspect-square bg-white rounded-2xl mb-4 flex items-center justify-center">
                            <div class="text-center p-4">
                                <i class="fas fa-apple-alt text-6xl text-orange-300 mb-3"></i>
                                <p class="text-xs font-bold text-slate-600">Makanan Sehat untuk Gigi</p>
                            </div>
                        </div>
                        <h4 class="font-bold text-sm text-slate-800 mb-2">Nutrisi Penting</h4>
                        <ul class="text-xs text-slate-600 space-y-1">
                            <li>• Sayuran hijau (bayam, brokoli)</li>
                            <li>• Buah-buahan segar</li>
                            <li>• Susu & produk olahan</li>
                        </ul>
                    </div>
                    @endif

                    @if(stripos($education->content, 'kehamilan') !== false || stripos($education->content, 'trimester') !== false)
                    <div class="bg-purple-50 p-6 rounded-3xl border-2 border-purple-100">
                        <div class="aspect-square bg-white rounded-2xl mb-4 flex items-center justify-center">
                            <div class="text-center p-4">
                                <i class="fas fa-baby text-6xl text-purple-300 mb-3"></i>
                                <p class="text-xs font-bold text-slate-600">Perawatan Gigi Saat Hamil</p>
                            </div>
                        </div>
                        <h4 class="font-bold text-sm text-slate-800 mb-2">Waktu Aman Perawatan</h4>
                        <ul class="text-xs text-slate-600 space-y-1">
                            <li>• Trimester 1: Hindari perawatan</li>
                            <li>• Trimester 2: Waktu ideal</li>
                            <li>• Trimester 3: Hanya darurat</li>
                        </ul>
                    </div>
                    @endif
                </div>

                {{-- Action CTA --}}
                <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row gap-4 items-center justify-between">
                    <div class="flex-1">
                        <p class="text-slate-700 font-bold text-base">Selesai Membaca?</p>
                        <p class="text-slate-500 text-sm mt-1">
                            {{ $hasPreTest ? 'Bunda bisa melanjutkan ke tahap Evaluasi/Post-test.' : 'Silakan isi kuesioner awal (Pre-test) terlebih dahulu untuk bisa melakukan evaluasi.' }}
                        </p>
                    </div>

                    @if($hasPreTest)
                    {{-- Jika sudah Pre-test, tombol mengarah ke Post-test/Evaluasi --}}
                    <a href="{{ route('student.screening.show', 'post_test') }}"
                        class="px-8 py-4 bg-[#5DB8D8] text-white font-bold rounded-2xl hover:bg-sky-600 transition-all shadow-lg shadow-sky-100">
                        Mulai Post-test (Evaluasi)
                    </a>
                    @else
                    {{-- Jika belum, arahkan ke dashboard agar popup pre-test muncul --}}
                    <a href="{{ route('student.dashboard', ['must_pretest' => 1]) }}"
                        class="px-8 py-4 bg-amber-400 text-white font-bold rounded-2xl hover:bg-amber-500 transition-all shadow-lg shadow-amber-100 flex items-center">
                        <i class="fas fa-lock mr-2"></i>
                        Isi Pre-test Dulu
                    </a>
                    @endif
                </div>
            </div>
        </article>
    </div>
</div>

{{-- Custom Styling untuk Article Content --}}
<style>
    .content-article {
        font-size: 1.0625rem;
        line-height: 1.8;
    }

    .content-article h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        margin-top: 2rem;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: -0.025em;
    }

    .content-article h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #334155;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .content-article p {
        margin-bottom: 1.25rem;
        color: #475569;
    }

    .content-article ul,
    .content-article ol {
        margin-left: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .content-article li {
        margin-bottom: 0.5rem;
        color: #475569;
    }

    .content-article strong {
        color: #1e293b;
        font-weight: 700;
    }

    .content-article em {
        color: #64748b;
    }

    /* Styling untuk konten dari seeder yang menggunakan HTML */
    .content-article .content-section {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 1.5rem;
        margin: 1.5rem 0;
        border-left: 4px solid #5DB8D8;
    }

    .content-article .warning-box {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border-radius: 0 1.5rem 1.5rem 0;
    }

    .content-article .disease-card {
        margin-bottom: 1rem;
    }

    .content-article .timeline-item {
        margin-bottom: 1.5rem;
    }

    .content-article .food-card {
        transition: all 0.3s ease;
    }

    .content-article .food-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .content-article .step-box {
        background: white;
        padding: 0.75rem 1.5rem;
        border-radius: 1rem;
        border: 2px solid #e2e8f0;
        font-size: 0.875rem;
        font-weight: 700;
        color: #334155;
        white-space: nowrap;
        display: inline-block;
    }

    .content-article .diagram-box,
    .content-article .flowchart,
    .content-article .process-diagram,
    .content-article .danger-section,
    .content-article .important-notes,
    .content-article .timeline-section,
    .content-article .steps-section,
    .content-article .brushing-guide,
    .content-article .food-recommendations,
    .content-article .avoid-foods,
    .content-article .tips-box {
        margin: 2rem 0;
    }

    /* Grid layouts dalam konten */
    .content-article .grid {
        display: grid;
        gap: 1rem;
    }

    @media (min-width: 768px) {
        .content-article .grid-cols-1.md\:grid-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .content-article .grid-cols-1.md\:grid-cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Flex layouts */
    .content-article .flex {
        display: flex;
    }

    .content-article .items-center {
        align-items: center;
    }

    .content-article .items-start {
        align-items: flex-start;
    }

    .content-article .justify-center {
        justify-content: center;
    }

    .content-article .gap-2 {
        gap: 0.5rem;
    }

    .content-article .gap-3 {
        gap: 0.75rem;
    }

    .content-article .gap-4 {
        gap: 1rem;
    }

    .content-article .gap-6 {
        gap: 1.5rem;
    }

    /* Spacing */
    .content-article .space-y-1>*+* {
        margin-top: 0.25rem;
    }

    .content-article .space-y-2>*+* {
        margin-top: 0.5rem;
    }

    .content-article .space-y-3>*+* {
        margin-top: 0.75rem;
    }

    .content-article .space-y-4>*+* {
        margin-top: 1rem;
    }

    .content-article .space-y-6>*+* {
        margin-top: 1.5rem;
    }

    /* Borders & Radius */
    .content-article .rounded-xl {
        border-radius: 0.75rem;
    }

    .content-article .rounded-2xl {
        border-radius: 1rem;
    }

    .content-article .rounded-3xl {
        border-radius: 1.5rem;
    }

    .content-article .rounded-full {
        border-radius: 9999px;
    }

    /* Shadows */
    .content-article .shadow-sm {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .content-article .shadow-lg {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    /* Text sizes */
    .content-article .text-xs {
        font-size: 0.75rem;
    }

    .content-article .text-sm {
        font-size: 0.875rem;
    }

    .content-article .text-base {
        font-size: 1rem;
    }

    .content-article .text-lg {
        font-size: 1.125rem;
    }

    .content-article .text-xl {
        font-size: 1.25rem;
    }

    .content-article .text-2xl {
        font-size: 1.5rem;
    }

    .content-article .text-3xl {
        font-size: 1.875rem;
    }

    .content-article .text-4xl {
        font-size: 2.25rem;
    }

    .content-article .text-6xl {
        font-size: 3.75rem;
    }

    /* Font weights */
    .content-article .font-bold {
        font-weight: 700;
    }

    .content-article .font-black {
        font-weight: 900;
    }

    /* Colors - dapat disesuaikan dengan tema Anda */
    .content-article .text-gray-500 {
        color: #64748b;
    }

    .content-article .text-gray-600 {
        color: #475569;
    }

    .content-article .text-gray-700 {
        color: #334155;
    }

    .content-article .text-gray-800 {
        color: #1e293b;
    }

    .content-article .bg-white {
        background-color: #ffffff;
    }

    .content-article .bg-gray-50 {
        background-color: #f8fafc;
    }

    .content-article .bg-gray-100 {
        background-color: #f1f5f9;
    }

    .content-article .bg-blue-50 {
        background-color: #eff6ff;
    }

    .content-article .bg-blue-100 {
        background-color: #dbeafe;
    }

    .content-article .bg-blue-600 {
        background-color: #2563eb;
    }

    .content-article .bg-green-50 {
        background-color: #f0fdf4;
    }

    .content-article .bg-green-100 {
        background-color: #dcfce7;
    }

    .content-article .bg-green-600 {
        background-color: #16a34a;
    }

    .content-article .bg-red-50 {
        background-color: #fef2f2;
    }

    .content-article .bg-red-100 {
        background-color: #fee2e2;
    }

    .content-article .bg-red-500 {
        background-color: #ef4444;
    }

    .content-article .bg-orange-50 {
        background-color: #fff7ed;
    }

    .content-article .bg-orange-100 {
        background-color: #ffedd5;
    }

    .content-article .bg-orange-600 {
        background-color: #ea580c;
    }

    .content-article .bg-yellow-50 {
        background-color: #fefce8;
    }

    .content-article .bg-yellow-100 {
        background-color: #fef9c3;
    }

    .content-article .bg-purple-50 {
        background-color: #faf5ff;
    }

    .content-article .bg-purple-100 {
        background-color: #f3e8ff;
    }

    .content-article .bg-purple-600 {
        background-color: #9333ea;
    }

    .content-article .bg-pink-50 {
        background-color: #fdf2f8;
    }

    .content-article .bg-pink-100 {
        background-color: #fce7f3;
    }

    .content-article .bg-pink-600 {
        background-color: #db2777;
    }

    .content-article .bg-teal-50 {
        background-color: #f0fdfa;
    }

    .content-article .bg-teal-600 {
        background-color: #0d9488;
    }

    .content-article .bg-cyan-50 {
        background-color: #ecfeff;
    }

    .content-article .border-blue-100 {
        border-color: #dbeafe;
    }

    .content-article .border-blue-200 {
        border-color: #bfdbfe;
    }

    .content-article .border-blue-300 {
        border-color: #93c5fd;
    }

    .content-article .border-green-100 {
        border-color: #dcfce7;
    }

    .content-article .border-green-200 {
        border-color: #bbf7d0;
    }

    .content-article .border-green-500 {
        border-color: #22c55e;
    }

    .content-article .border-red-100 {
        border-color: #fee2e2;
    }

    .content-article .border-red-200 {
        border-color: #fecaca;
    }

    .content-article .border-red-300 {
        border-color: #fca5a5;
    }

    .content-article .border-orange-100 {
        border-color: #ffedd5;
    }

    .content-article .border-purple-100 {
        border-color: #f3e8ff;
    }

    .content-article .border-yellow-400 {
        border-color: #facc15;
    }

    /* Utilities */
    .content-article .flex-1 {
        flex: 1 1 0%;
    }

    .content-article .flex-shrink-0 {
        flex-shrink: 0;
    }

    .content-article .text-center {
        text-align: center;
    }

    .content-article .uppercase {
        text-transform: uppercase;
    }

    .content-article .mb-2 {
        margin-bottom: 0.5rem;
    }

    .content-article .mb-3 {
        margin-bottom: 0.75rem;
    }

    .content-article .mb-4 {
        margin-bottom: 1rem;
    }

    .content-article .mb-6 {
        margin-bottom: 1.5rem;
    }

    .content-article .mb-8 {
        margin-bottom: 2rem;
    }

    .content-article .mt-2 {
        margin-top: 0.5rem;
    }

    .content-article .mt-3 {
        margin-top: 0.75rem;
    }

    .content-article .mt-4 {
        margin-top: 1rem;
    }

    .content-article .mt-6 {
        margin-top: 1.5rem;
    }

    .content-article .my-4 {
        margin-top: 1rem;
        margin-bottom: 1rem;
    }

    .content-article .my-6 {
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .content-article .my-8 {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

    .content-article .p-3 {
        padding: 0.75rem;
    }

    .content-article .p-4 {
        padding: 1rem;
    }

    .content-article .p-5 {
        padding: 1.25rem;
    }

    .content-article .p-6 {
        padding: 1.5rem;
    }

    .content-article .p-8 {
        padding: 2rem;
    }

    .content-article .px-2 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .content-article .px-3 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    .content-article .px-4 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .content-article .py-1 {
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
    }

    /* Width & Height utilities */
    .content-article .w-8 {
        width: 2rem;
    }

    .content-article .w-10 {
        width: 2.5rem;
    }

    .content-article .w-12 {
        width: 3rem;
    }

    .content-article .w-14 {
        width: 3.5rem;
    }

    .content-article .w-16 {
        width: 4rem;
    }

    .content-article .w-20 {
        width: 5rem;
    }

    .content-article .w-full {
        width: 100%;
    }

    .content-article .h-8 {
        height: 2rem;
    }

    .content-article .h-10 {
        height: 2.5rem;
    }

    .content-article .h-12 {
        height: 3rem;
    }

    .content-article .h-14 {
        height: 3.5rem;
    }

    .content-article .h-16 {
        height: 4rem;
    }

    .content-article .h-20 {
        height: 5rem;
    }

    .content-article .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }

    /* Border utilities */
    .content-article .border-2 {
        border-width: 2px;
    }

    .content-article .border-4 {
        border-width: 4px;
    }

    .content-article .border-l-4 {
        border-left-width: 4px;
    }

    /* Aspect ratio */
    .content-article .aspect-square {
        aspect-ratio: 1 / 1;
    }
</style>
@endsection
