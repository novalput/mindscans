<aside
    {{-- Gunakan x-show untuk trigger animasi Alpine --}}
    x-show="sidebarOpen"
    {{-- Animasi Slide In/Out --}}
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed top-0 left-0 bottom-0 z-40 w-64 bg-[#5DB8D8] text-white pt-20 pb-6 px-4 flex flex-col shadow-2xl overflow-y-auto no-scrollbar">
    {{-- Sidebar Logo (Desktop) --}}
    <div class="text-center mb-8 hidden md:block">
        <h1 class="font-sansita text-3xl tracking-wide">Lia's Dent</h1>
    </div>

    {{-- Menu Links --}}
    <ul class="flex-1 space-y-2">

        {{-- Item: Dashboard --}}
        <li>
            <a href="{{ route('lecturer.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200
               {{ request()->routeIs('lecturer.dashboard') ? 'bg-white text-[#5DB8D8] shadow-md' : 'hover:bg-white/20 hover:pl-6' }}">
                <i class="fa-solid fa-chart-line w-5 text-center"></i> Dashboard
            </a>
        </li>

        {{-- Item: Data Pasien --}}
        @if(Auth::user()->role === 'lecturer')
        <li>
            <a href="{{ route('lecturer.datapasien') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200
       {{ request()->routeIs('lecturer.datapasien') ? 'bg-white text-[#5DB8D8] shadow-md' : 'hover:bg-white/20 hover:pl-6' }}">
                <i class="fa-solid fa-hospital-user w-5 text-center"></i> Data Pasien
            </a>
        </li>
        @endif

        {{-- Item: Daily Activity --}}
        <li>
            <a href="{{ route('lecturer.monitoring.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200
       {{ request()->routeIs('lecturer.monitoring*') ? 'bg-white text-[#5DB8D8] shadow-md' : 'hover:bg-white/20 hover:pl-6' }}">
                <i class="fa-solid fa-calendar-days w-5 text-center"></i> Daily Activity
            </a>
        </li>

        {{-- Item: Edukasi --}}
        <li>
            <a href="{{ route('lecturer.education.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200
       {{ request()->routeIs('lecturer.education*') ? 'bg-white text-[#5DB8D8] shadow-md' : 'hover:bg-white/20 hover:pl-6' }}">
                <i class="fa-solid fa-book w-5 text-center"></i> Edukasi
            </a>
        </li>

        {{-- Item: Evaluasi --}}
        <li>
            <a href="{{ route('lecturer.evaluasi.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200
       {{ request()->routeIs('lecturer.evaluasi*') ? 'bg-white text-[#5DB8D8] shadow-md' : 'hover:bg-white/20 hover:pl-6' }}">
                <i class="fa-solid fa-clipboard-check w-5 text-center"></i> Evaluasi
            </a>
        </li>

        {{-- Manajemen Kuesioner (Dropdown) --}}
        <li>
            <a href="{{ route('lecturer.questions.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200
       {{ request()->routeIs('lecturer.questions*') ? 'bg-white text-[#5DB8D8] shadow-md' : 'hover:bg-white/20 hover:pl-6' }}">
                <i class="fa-solid fa-file-pen w-5 text-center"></i> Manajemen Kuesioner
            </a>
        </li>

        {{-- Item: Feedback --}}
        <li>
            <a href="{{ route('lecturer.feedback') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-200
       {{ request()->routeIs('lecturer.feedback') ? 'bg-white text-[#5DB8D8] shadow-md' : 'hover:bg-white/20 hover:pl-6' }}">
                <i class="fa-solid fa-comment-dots w-5 text-center"></i> Feedback
            </a>
        </li>
    </ul>

    {{-- Logout Button --}}
    <div class="mt-6 pt-6 border-t border-white/30">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-white/10 hover:bg-red-500/80 hover:text-white font-bold transition-colors">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</aside>

{{-- Mobile Overlay (Bagian dari Sidebar UX) --}}
<div x-show="sidebarOpen"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="sidebarOpen = false"
    class="fixed inset-0 bg-black/50 z-30 md:hidden"
    x-cloak>
</div>
