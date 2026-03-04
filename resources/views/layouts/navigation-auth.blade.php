<nav class="fixed top-0 left-0 right-0 z-50 bg-[#5DB8D8] text-white shadow-md h-16 flex items-center justify-between px-3 md:px-8 transition-all duration-300">

    {{-- Left Side: Brand & Toggle --}}
    <div class="flex items-center gap-1 md:gap-4">
        {{-- Button Toggle Sidebar --}}
        <button @click="sidebarOpen = !sidebarOpen"
            class="relative w-10 h-10 flex items-center justify-center text-xl md:text-2xl focus:outline-none group hover:bg-white/10 rounded-lg transition-colors">
            <div class="transition-transform duration-500 transform" :class="sidebarOpen ? 'rotate-180' : 'rotate-0'">
                <i x-show="!sidebarOpen" class="fa-solid fa-bars transition-all duration-300"></i>
                <i x-show="sidebarOpen" x-cloak class="fa-solid fa-xmark transition-all duration-300"></i>
            </div>
        </button>

        {{-- Brand Logo --}}
        <span class="font-sansita text-lg md:text-xl tracking-wide truncate transition-opacity duration-300"
            :class="sidebarOpen ? 'max-md:hidden opacity-100' : 'opacity-100'">
            MindScans
        </span>
    </div>

    {{-- Right Side: User Info & Actions --}}
    <div class="flex items-center gap-1 md:gap-5" x-data="{ userDropdown: false, notifyDropdown: false }">

        {{-- Notification Bell --}}
        <!-- <div class="relative">
            <button @click="notifyDropdown = !notifyDropdown; userDropdown = false"
                class="relative p-2 rounded-full hover:bg-white/10 transition-colors focus:outline-none active:scale-90">
                <i class="fa-regular fa-bell text-lg md:text-xl"></i>
                {{-- Indicator Dot --}}
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 border-2 border-[#5DB8D8] rounded-full animate-pulse"></span>
            </button>

            {{-- Notification Dropdown --}}
            <div x-show="notifyDropdown"
                @click.away="notifyDropdown = false"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                {{-- Responsivitas Dropdown: Lebih lebar di desktop, full screen width di mobile jika perlu --}}
                class="absolute right-[-50px] md:right-0 mt-3 w-[280px] md:w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden text-gray-800">

                <div class="p-4 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-xs md:text-sm text-gray-700 uppercase tracking-wider">Notifikasi</h3>
                    <span class="text-[9px] md:text-[10px] bg-sky-100 text-[#5DB8D8] px-2 py-0.5 rounded-full font-bold">2 Baru</span>
                </div>

                <div class="max-h-64 overflow-y-auto">
                    {{-- Item Notif --}}
                    <a href="#" class="block p-4 hover:bg-gray-50 transition-colors border-b border-gray-50">
                        <p class="text-xs font-bold text-gray-700 line-clamp-1">Pasien Baru Terdaftar</p>
                        <p class="text-[11px] text-gray-500 mt-0.5 line-clamp-2">Bunda Fatimah baru saja mengisi data screening.</p>
                        <span class="text-[9px] text-gray-400 mt-2 block italic">2 Menit yang lalu</span>
                    </a>
                </div>

                <a href="#" class="block py-3 text-center text-xs font-bold text-[#5DB8D8] hover:bg-gray-50 transition-colors">
                    Lihat Semua
                </a>
            </div>
        </div>

        {{-- Vertical Divider (Sembunyi di mobile kecil) --}}
        <div class="h-8 w-[1px] bg-white/20 hidden sm:block"></div> -->

        {{-- User Profile Dropdown --}}
        <div class="relative">
            <button @click="userDropdown = !userDropdown; notifyDropdown = false"
                class="flex items-center gap-2 md:gap-3 p-1 md:p-1.5 rounded-xl md:rounded-2xl hover:bg-white/10 transition-all focus:outline-none group">

                {{-- Nama User: Sembunyi di HP, muncul di Tablet/Desktop --}}
                <div class="hidden md:flex flex-col text-right">
                    <span class="font-bold text-sm leading-none">{{ Auth::user()->name ?? 'Lecturer User' }}</span>
                    <span class="text-[10px] text-blue-100 mt-1 uppercase tracking-tighter font-medium">
                        {{ Auth::user()->role ?? 'Petugas' }}
                    </span>
                </div>

                {{-- Avatar --}}
                <img class="w-9 h-9 md:w-10 md:h-10 rounded-full object-cover border-2 border-white/50 shadow-sm group-hover:scale-105 transition-transform duration-300"
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=fff&color=5DB8D8"
                    alt="Avatar">

                {{-- Icon Down (Opsional untuk mobile) --}}
                <i class="fa-solid fa-chevron-down text-[10px] md:hidden"></i>
            </button>

            {{-- User Dropdown Content --}}
            <div x-show="userDropdown"
                @click.away="userDropdown = false"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="absolute right-0 mt-3 w-52 md:w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 text-gray-800 overflow-hidden">

                {{-- Header Dropdown (Muncul di Mobile sebagai pengganti nama yang hilang di navbar) --}}
                <div class="md:hidden px-4 py-3 bg-gray-50/50 border-b border-gray-50 mb-2">
                    <p class="font-bold text-xs text-gray-700 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] text-gray-400 uppercase tracking-widest">{{ Auth::user()->role }}</p>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-sky-50 hover:text-[#5DB8D8] transition-colors group">
                    <i class="fa-solid fa-circle-user text-gray-400 group-hover:text-[#5DB8D8] w-4"></i>
                    <span class="font-semibold">Profil Saya</span>
                </a>
<!-- 
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-sky-50 hover:text-[#5DB8D8] transition-colors group">
                    <i class="fa-solid fa-gear text-gray-400 group-hover:text-[#5DB8D8] w-4"></i>
                    <span class="font-semibold">Pengaturan</span>
                </a> -->

                <div class="my-2 border-t border-gray-50"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 text-sm text-red-500 hover:bg-red-50 w-full text-left font-bold transition-colors group">
                        <i class="fa-solid fa-power-off opacity-70 group-hover:scale-110 transition-transform w-4"></i>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

{{-- Tambahan spacer agar konten tidak tertutup fixed navbar --}}
<div class="h-16"></div>
