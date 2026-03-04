<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-6">
        <h1 class="logo-font text-6xl md:text-7xl text-gray-800">{{ config('app.name', "Lia's Dent") }}</h1>
        <p class="text-gray-700 font-semibold mt-2">Monitoring Kesehatan Gusi</p>
    </div>

    <div class="auth-glass rounded-3xl shadow-2xl p-8 border border-white/20">

        @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-gray-700 font-bold mb-1 ml-1" for="email">Email</label>
                <div class="relative">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full px-5 py-3 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-sky-400 focus:border-transparent transition outline-none"
                        placeholder="nama@email.com">
                    <i class="fa-solid fa-envelope absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-1 ml-1" for="password">Password</label>
                <div class="relative" x-data="{ show: false }">
                    <input
                        :type="show ? 'text' : 'password'"
                        id="password"
                        name="password"
                        required
                        class="w-full px-5 py-3 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-sky-400 focus:border-transparent transition outline-none"
                        placeholder="••••••••">

                    <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-sky-500 transition">
                        <!-- <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i> -->
                        <i class="fa-solid" :class="show ? 'fa-unlock' : 'fa-lock'"></i>
                    </button>

                </div>
                <div class="text-right mt-1">
                    <a href="{{ route('password.request') }}" class="text-sm text-sky-600 hover:underline">Lupa Password?</a>
                </div>
            </div>

            <div class="flex items-center ml-1">
                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-sky-500 border-gray-300 rounded focus:ring-sky-400">
                <label for="remember" class="ml-2 text-sm text-gray-600 cursor-pointer">Ingat saya</label>
            </div>

            <button
                type="submit"
                class="w-full bg-[#5DB8D8] hover:bg-[#4da7c7] text-white font-bold py-3 rounded-2xl shadow-lg transition transform hover:scale-[1.02] active:scale-95 text-lg">
                Login
            </button>
        </form>

        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-3 bg-white text-gray-500 rounded-full">atau</span>
            </div>
        </div>

        <a href="{{ route('login.whatsapp') }}" class="flex items-center justify-center w-full bg-[#25D366] hover:bg-[#20ba59] text-white font-bold py-3 rounded-2xl shadow-md transition transform hover:scale-[1.02] active:scale-95">
            <i class="fa-brands fa-whatsapp text-2xl mr-2"></i>
            Login via WhatsApp
        </a>

    </div>
</x-guest-layout>
