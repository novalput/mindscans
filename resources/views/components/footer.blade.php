<footer class="relative overflow-hidden bg-white pt-16 pb-8 text-slate-600 border-t border-green-100">

    {{-- Aksen Dekorasi Medis --}}
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#22C55E] via-green-300 to-[#22C55E] opacity-60"></div>

    {{-- Background Glow --}}
    <div class="absolute -top-24 -right-24 h-64 w-64 rounded-full bg-green-50 blur-3xl opacity-80"></div>
    <div class="absolute bottom-0 -left-24 h-64 w-64 rounded-full bg-slate-50 blur-3xl opacity-80"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-24 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 text-center lg:text-left">

            {{-- Kolom 1: Branding --}}
            <div class="space-y-6">
                <div>
                    <div class="flex items-center justify-center lg:justify-start gap-3">
                        <img src="{{ asset('images/logo-poltekkes.png') }}" alt="Logo" class="h-10 w-auto">
                        <h2 class="font-sansita text-4xl tracking-tight text-[#22C55E]">LoveCaring-Rr.Nursing</h2>
                    </div>
                    <p class="mt-3 text-sm leading-relaxed text-slate-500 max-w-xs mx-auto lg:mx-0">
                        Platform pendamping kesehatan mental yang membantu mahasiswa memantau, memahami, dan menjaga kesejahteraan psikologis secara aman dan nyaman.
                    </p>
                    <div class="mt-4 text-sm text-slate-500 max-w-xs mx-auto lg:mx-0">
                        <p class="font-semibold text-slate-600">Alamat</p>
                        <p class="leading-relaxed">
                            Jl. Tirto Agung, Pedalangan, Banyumanik<br>
                            Kota Semarang, Jawa Tengah 50268
                        </p>
                    </div>
                </div>

                <div class="flex justify-center lg:justify-start gap-4">
                    @php $socials = ['instagram', 'youtube', 'x-twitter', 'tiktok']; @endphp
                    @foreach($socials as $icon)
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-[#ECFDF5] text-[#22C55E] hover:bg-[#22C55E] hover:text-white transition-all duration-300 shadow-sm">
                        <i class="fab fa-{{ $icon }} text-lg"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Kolom 2: Kontak --}}
            <div class="space-y-6 lg:pl-12 border-l-0 lg:border-l lg:border-slate-100">
                <h5 class="text-xs font-bold uppercase tracking-[0.2em] text-[#16A34A] flex items-center justify-center lg:justify-start gap-2">
                    <i class="fas fa-clinic-medical"></i> LAYANAN
                </h5>
                <ul class="space-y-4">
                    <li class="flex items-start justify-center lg:justify-start gap-4">
                        <div class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#ECFDF5] text-[#22C55E]">
                            <i class="fas fa-phone-alt text-sm"></i>
                        </div>

                        <div class="text-left">
                            <p class="text-[11px] font-bold uppercase text-slate-400 tracking-wider">
                                Telepon
                            </p>
                            <span class="text-slate-700 font-medium text-sm">
                                (+62) 812-2824-542
                                <br>Dr. Rr. Sri Endang Pusjiastuti, SKM, MNS
                            </span>
                        </div>
                    </li>
                    <li class="flex items-start justify-center lg:justify-start gap-4">
                        <div class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#ECFDF5] text-[#22C55E]">
                            <i class="fas fa-envelope text-sm"></i>
                        </div>

                        <div class="text-left">
                            <p class="text-[11px] font-bold uppercase text-slate-400 tracking-wider">
                                Email
                            </p>
                            <span class="text-slate-700 font-medium text-sm">
                                lovecaring.rr.nursing@gmail.com
                            </span>
                        </div>
                    </li>
                    <li class="flex items-start justify-center lg:justify-start gap-4">
                        <div class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#ECFDF5] text-[#22C55E]">
                            <i class="fas fa-comment-dots text-sm"></i>
                        </div>

                        <div class="text-left">
                            <p class="text-[11px] font-bold uppercase text-slate-400 tracking-wider">
                                Feedback
                            </p>
                            <a href="{{ route('student.feedback.create') }}" 
                            class="text-slate-700 font-medium text-sm hover:text-[#22C55E] transition-colors">
                            Kirim Feedback & Saran
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            {{-- Kolom 3: Status Sistem --}}
            <div class="space-y-6 lg:pl-12">
                <h5 class="text-xs font-bold uppercase tracking-[0.2em] text-[#16A34A] flex items-center justify-center lg:justify-start gap-2">
                    <i class="fas fa-shield-alt"></i> KEAMANAN DATA
                </h5>
                <p class="text-sm text-slate-600 leading-relaxed">
                    "Informasi bersifat rahasia dan digunakan untuk mendukung pelayanan kesehatan mental Anda."
                </p>

                <div class="inline-flex items-center gap-3 px-4 py-2 bg-[#F0FDF4] rounded-xl border border-green-200">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#22C55E]"></span>
                    </span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Monitoring System Aktif</span>
                </div>
            </div>

        </div>

        <div class="mt-16 pt-8 border-t border-slate-100 text-center">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.3em]">
                &copy; {{ date('Y') }} LoveCaring-Rr.Nursing Monitoring
                <span class="mx-2 text-green-200">|</span>
                Dibuat dengan <i class="fas fa-heart text-[#22C55E] mx-1"></i> untuk Kesehatan Mental Anda.
            </p>
        </div>
    </div>
</footer>