@extends('layouts.student')

@section('content')
<div class="py-12 px-4 max-w-3xl mx-auto">
    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 text-center">
        <div class="w-20 h-20 bg-sky-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-comment-dots text-3xl text-[#5DB8D8]"></i>
        </div>

        <h1 class="text-2xl font-sansita text-gray-800 mb-2">Umpan Balik & Saran</h1>
        <p class="text-gray-500 italic mb-6">Sampaikan kendala atau saran Bunda untuk kami.</p>

        <form action="{{ route('student.feedback.store') }}" method="POST">
            @csrf

            {{-- Input Konten --}}
            <div class="mb-6 text-left">
                <label class="block text-gray-700 font-bold mb-2 ml-2">Isi Feedback</label>
                <textarea name="content" rows="5"
                    class="w-full rounded-[2rem] border-gray-200 focus:border-[#5DB8D8] focus:ring-[#5DB8D8] p-5 text-sm"
                    placeholder="Tulis pesan Bunda di sini... Ceritakan kendala atau saran Bunda agar kami bisa melayani lebih baik." required></textarea>
            </div>

            {{-- Input Star Rating dengan Alpine.js --}}
            <div class="mb-8" x-data="{ rating: 0, hover: 0 }">
                <label class="block text-gray-700 font-bold mb-3">Seberapa puas Bunda dengan layanan kami?</label>

                <input type="hidden" name="rating" :value="rating">

                <div class="flex items-center justify-center gap-2">
                    <template x-for="star in 5">
                        <button type="button"
                            @click="rating = star"
                            @mouseenter="hover = star"
                            @mouseleave="hover = 0"
                            class="transition-transform duration-150 transform hover:scale-125 focus:outline-none">
                            <svg class="w-12 h-12 transition-colors duration-200"
                                :class="(hover || rating) >= star ? 'text-yellow-400' : 'text-gray-200'"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                    </template>
                </div>

                <p class="mt-3 text-sm font-bold text-[#5DB8D8] h-5 transition-opacity"
                    x-text="rating ? 'Bunda memberikan ' + rating + ' bintang' : 'Silakan ketuk bintang'"></p>
            </div>

            <button type="submit" class="w-full bg-[#5DB8D8] text-white font-bold py-4 rounded-2xl shadow-lg shadow-sky-100 hover:bg-sky-600 transition-all transform active:scale-95">
                Kirim Feedback
            </button>
        </form>
    </div>
</div>
@endsection
