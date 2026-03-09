{{-- Desktop Sidebar - Hidden on mobile, visible on md and up --}}
<aside
    id="sidebar-desktop"
    class="fixed inset-y-0 left-0 z-40 w-64
           bg-gradient-to-b from-[#16A34A] to-green-900
           text-white shadow-2xl hidden md:flex flex-col">

    {{-- Logo / Title --}}
    <div class="flex items-center gap-3 px-6 py-8 border-b border-[#22C55E] border-opacity-20 flex-shrink-0">
        <div>
            <h1 class="text-xl font-sansita font-bold">LoveCaring-Rr.Nursing</h1>
            <p class="text-xs text-gray-400">Admin Panel</p>
        </div>
    </div>

    {{-- Navigation Menu --}}
    <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
            {{ request()->routeIs('admin.dashboard') ? 'bg-[#22C55E] text-white shadow-lg' : 'text-gray-300 hover:bg-[#22C55E]/20 hover:text-white' }}">
            <i class="fas fa-chart-line w-5"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        {{-- Kelola Dosen --}}
        <a href="{{ route('admin.lecturer.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
            {{ request()->routeIs('admin.lecturer.*') ? 'bg-[#22C55E] text-white shadow-lg' : 'text-gray-300 hover:bg-[#22C55E]/20 hover:text-white' }}">
            <i class="fas fa-users-between-lines w-5"></i>
            <span class="font-medium">Kelola Dosen</span>
        </a>

        {{-- Kelola Mahasiswa --}}
        <a href="{{ route('admin.student.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
            {{ request()->routeIs('admin.student.*') ? 'bg-[#22C55E] text-white shadow-lg' : 'text-gray-300 hover:bg-[#22C55E]/20 hover:text-white' }}">
            <i class="fas fa-hospital-user w-5"></i>
            <span class="font-medium">Kelola Mahasiswa</span>
        </a>

        {{-- Riwayat Kuesioner --}}
        <a href="{{ route('admin.history.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
            {{ request()->routeIs('admin.history.*') ? 'bg-[#22C55E] text-white shadow-lg' : 'text-gray-300 hover:bg-[#22C55E]/20 hover:text-white' }}">
            <i class="fas fa-history w-5"></i>
            <span class="font-medium">Riwayat Kuesioner</span>
        </a>
    </nav>

    {{-- Divider --}}
    <div class="px-4 py-4 border-t border-[#22C55E] border-opacity-20 flex-shrink-0">
        {{-- User Info --}}
        <div class="mb-4 p-3 bg-[#22C55E] bg-opacity-10 rounded-lg">
            <p class="text-xs text-gray-400 mb-1">Logged in as</p>
            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
        </div>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-red-600 hover:text-white transition-all duration-200">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside>

{{-- Mobile Sidebar Overlay --}}
<div
    x-show="sidebarOpen"
    @click="sidebarOpen = false"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
    x-cloak>
</div>

{{-- Mobile Sidebar - Fixed overlay on mobile only --}}
<aside
    id="sidebar-mobile"
    x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed inset-0 z-50 md:hidden flex flex-col w-64 bg-gradient-to-b from-[#16A34A] to-green-900 text-white shadow-2xl"
    x-cloak>

    {{-- Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-[#22C55E] border-opacity-20 flex-shrink-0">
        <div class="flex items-center gap-2">
            <h1 class="font-sansita text-lg font-bold">LoveCaring-Rr.Nursing</h1>
        </div>
        <button @click="sidebarOpen = false" class="text-gray-300 hover:text-white transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    {{-- Navigation Menu --}}
    <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            @click="sidebarOpen = false"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
            {{ request()->routeIs('dashboard') ? 'bg-[#22C55E] text-white shadow-lg' : 'text-gray-300 hover:bg-[#22C55E]/20 hover:text-white' }}">
            <i class="fas fa-chart-line w-5"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        {{-- Kelola Dosen --}}
        <a href="{{ route('admin.lecturer.index') }}"
            @click="sidebarOpen = false"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
            {{ request()->routeIs('admin.lecturer.*') ? 'bg-[#22C55E] text-white shadow-lg' : 'text-gray-300 hover:bg-[#22C55E]/20 hover:text-white' }}">
            <i class="fas fa-users-between-lines w-5"></i>
            <span class="font-medium">Kelola Dosen</span>
        </a>

        {{-- Kelola Mahasiswa --}}
        <a href="{{ route('admin.student.index') }}"
            @click="sidebarOpen = false"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
            {{ request()->requestUri === route('admin.student.index') || request()->routeIs('admin.student.*') ? 'bg-[#22C55E] text-white shadow-lg' : 'text-gray-300 hover:bg-[#22C55E]/20 hover:text-white' }}">
            <i class="fas fa-hospital-user w-5"></i>
            <span class="font-medium">Kelola Mahasiswa</span>
        </a>
        
        {{-- Riwayat Kuesioner --}}
        <a href="{{ route('admin.history.index') }}"
            @click="sidebarOpen = false"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
            {{ request()->routeIs('admin.history.*') ? 'bg-[#22C55E] text-white shadow-lg' : 'text-gray-300 hover:bg-[#22C55E]/20 hover:text-white' }}">
            <i class="fas fa-history w-5"></i>
            <span class="font-medium">Riwayat Kuesioner</span>
        </a>
    </nav>

    {{-- Divider --}}
    <div class="px-4 py-4 border-t border-[#22C55E] border-opacity-20 flex-shrink-0">
        {{-- User Info --}}
        <div class="mb-4 p-3 bg-[#22C55E] bg-opacity-10 rounded-lg">
            <p class="text-xs text-gray-400 mb-1">Logged in as</p>
            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
        </div>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-red-600 hover:text-white transition-all duration-200">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside>

{{-- Mobile Toggle Button (FAB) --}}
<button
    @click="sidebarOpen = !sidebarOpen"
    class="fixed bottom-6 right-6 z-30 md:hidden bg-[#22C55E] text-white p-3 rounded-full shadow-lg hover:bg-green-700 transition-all duration-200 hover:scale-110"
    title="Toggle Menu">
    <i class="fas fa-bars text-lg"></i>
</button>
