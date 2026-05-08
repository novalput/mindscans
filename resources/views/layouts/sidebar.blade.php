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
    class="fixed top-0 left-0 bottom-0 z-40 w-64 bg-green-600 text-green-50 pt-20 pb-6 px-4 flex flex-col shadow-2xl border-r border-green-800 overflow-y-auto no-scrollbar">
    
    {{-- Sidebar Logo (Desktop) --}}
    <!-- <div class="text-center mb-10 hidden md:block">
        <h2 class="font-sansita text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-green-300 to-emerald-200 tracking-wide">LoveCaring-Rr.Nursing</h2>
    </div> -->

    {{-- Menu Links --}}
    <ul class="flex-1 space-y-3">

        {{-- Item: Dashboard --}}
        <li>
            <a href="{{ route('lecturer.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-300
               {{ request()->routeIs('lecturer.dashboard') ? 'bg-green-500 text-white shadow-lg shadow-green-500/30' : 'hover:bg-green-800 hover:text-white hover:translate-x-1' }}">
                <i class="fa-solid fa-chart-line w-5 text-center {{ request()->routeIs('lecturer.dashboard') ? 'text-green-100' : 'text-green-300/70' }}"></i> 
                <span>Dashboard</span>
            </a>
        </li>

        {{-- Item: Daftar Mahasiswa (Hanya Lecturer) --}}
        @if(auth()->user()->sub_role === 'lecturer')
        <li>
            <a href="{{ route('lecturer.datamahasiswa') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-300
               {{ request()->routeIs('lecturer.datamahasiswa*') ? 'bg-green-500 text-white shadow-lg shadow-green-500/30' : 'hover:bg-green-800 hover:text-white hover:translate-x-1' }}">
                <i class="fa-solid fa-users w-5 text-center {{ request()->routeIs('lecturer.datamahasiswa*') ? 'text-green-100' : 'text-green-300/70' }}"></i> 
                <span>Daftar Mahasiswa</span>
            </a>
        </li>

        {{-- Item: Tes Mental Health (Kuesioner untuk Lecturer sendiri) --}}
        <li>
            <a href="{{ route('lecturer.screening.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-300
               {{ request()->routeIs('lecturer.screening*') ? 'bg-green-500 text-white shadow-lg shadow-green-500/30' : 'hover:bg-green-800 hover:text-white hover:translate-x-1' }}">
                <i class="fa-solid fa-clipboard-question w-5 text-center {{ request()->routeIs('lecturer.screening*') ? 'text-green-100' : 'text-green-300/70' }}"></i> 
                <span>Tes Mental Health</span>
            </a>
        </li>
        @endif

    </ul>

    {{-- Logout Button --}}
    <div class="mt-8 pt-6 border-t border-green-800">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-green-800 text-green-100 hover:bg-red-500 hover:text-white hover:shadow-lg hover:shadow-red-500/30 font-semibold transition-all duration-300">
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
