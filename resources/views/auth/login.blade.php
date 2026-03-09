<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - LoveCaring-Rr.Nursing</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body, html {
            height: 100%;
            font-family: 'Roboto', sans-serif;
            overflow: hidden; /* Mencegah scrollbar di seluruh halaman */
            background-color: #F0FDF4; /* Hijau sangat muda (background luar) */
        }

        .login-container {
            display: flex;
            width: 100vw;
            height: 100vh;
        }

        /* Bagian Kiri (Form) */
        .left-section {
            flex: 0 0 450px;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            padding: 30px 40px; 
            z-index: 10;
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.05);
            /* Tidak ada overflow-y agar frame kiri tetap fix */
        }

        .form-wrapper {
            margin: auto 0;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo-title {
            font-size: 28px;
            font-weight: 800;
            color: #1e293b; /* slate-800 */
            letter-spacing: -0.5px;
        }

        .divider {
            height: 1px;
            background: #f1f5f9;
            margin: 15px 0;
        }

        .form-group {
            position: relative;
            margin-bottom: 18px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            padding-right: 45px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: #22C55E; /* Hijau utama */
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 15px;
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .input-icon:hover {
            color: #22C55E;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #22C55E 0%, #16A34A 100%); /* Gradasi Hijau */
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
        }

        .btn-wa {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #25D366 0%, #20ba59 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-wa:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
        }

        /* Bagian Kanan (Background) */
        .right-section {
            flex: 1;
            position: relative;
            background-image: url('{{ asset("images/login.jpg") }}'); /* Gambar diubah ke login.jpg */
            background-color: #F0FDF4; /* Fallback hijau muda */
            background-size: cover;
            background-position: center;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.2) 0%, rgba(15, 23, 42, 0.5) 100%); /* Tint hijau tua */
        }

        .info-card {
            position: absolute;
            bottom: 40px;
            left: 40px;
            right: 40px;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }

        @media (max-width: 992px) {
            .right-section { display: none; }
            .left-section { flex: 1; max-width: 100%; width: 100%; padding: 30px; justify-content: center; }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="left-section">
        <div class="form-wrapper">
            
            <div class="logo-section flex flex-col items-center">
                <img src="{{ asset('images/logo-poltekkes.png') }}" alt="Logo Poltekkes" class="h-20 w-auto mb-4">
                <h1 class="logo-title">{{ config('app.name', "LoveCaring-Rr.Nursing") }}</h1>
                <p class="text-[11px] font-bold text-[#22C55E] uppercase tracking-widest mt-1">Monitoring Kesehatan Mental</p>
            </div>

            @if(session('status'))
                <div class="mb-3 text-green-700 text-xs bg-green-50 p-2 rounded-lg border border-green-200 text-center font-medium">
                    {{ session('status') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-3 text-green-700 text-xs bg-green-50 p-2 rounded-lg border border-green-200 text-center font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-3 text-red-600 text-xs bg-red-50 p-2 rounded-lg border border-red-200">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="divider"></div>

            <div class="mb-4 text-center">
                <h3 class="text-lg font-bold text-slate-800">Selamat Datang</h3>
                <p class="text-xs text-slate-500 mt-1">Pilih metode masuk ke akun Anda</p>
            </div>

            <div class="flex bg-slate-100 rounded-xl p-1 mb-5">
                <button onclick="switchTab('email')" id="tab-email" class="flex-1 py-2 text-sm font-bold rounded-lg bg-white shadow text-[#22C55E] transition-all">
                    <i class="fa-solid fa-envelope mr-1"></i> Email
                </button>
                <button onclick="switchTab('wa')" id="tab-wa" class="flex-1 py-2 text-sm font-bold rounded-lg text-slate-500 hover:text-slate-700 transition-all">
                    <i class="fa-brands fa-whatsapp mr-1 text-lg align-middle"></i> WhatsApp
                </button>
            </div>

            {{-- FORM LOGIN EMAIL --}}
            <div id="form-email">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Alamat Email" value="{{ old('email') }}" required autofocus>
                        <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Kata Sandi" required>
                        <span class="input-icon" onclick="togglePass()">
                            <i class="fa-solid fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>

                    <div class="flex items-center justify-between mb-5">
                        <label class="flex items-center text-xs text-slate-600 cursor-pointer font-medium hover:text-slate-800 transition">
                            <input type="checkbox" name="remember" class="mr-2 w-3.5 h-3.5 text-[#22C55E] border-gray-300 rounded focus:ring-[#22C55E]"> Ingat saya
                        </label>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-xs font-bold text-[#22C55E] hover:underline">Daftar Akun</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-login">Masuk dengan Email</button>
                </form>
            </div>

            {{-- FORM LOGIN WHATSAPP --}}
            <div id="form-wa" class="hidden text-center">
                <div class="bg-green-50 border border-green-100 p-4 rounded-xl mb-5">
                    <i class="fa-brands fa-whatsapp text-3xl text-[#25D366] mb-2 block"></i>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium">
                        Klik tombol di bawah ini untuk masuk menggunakan nomor WhatsApp Anda. Proses cepat, aman, dan tanpa sandi.
                    </p>
                </div>
                
                <a href="{{ route('login.whatsapp') }}" class="btn-wa">
                    Masuk dengan WhatsApp
                </a>
            </div>

        </div>

        <div class="mt-auto pt-4 text-center text-[11px] text-slate-400">
            <div class="mb-1 font-medium">
                <i class="fa-solid fa-shield-check text-[#22C55E] mr-1"></i> 
                Privasi dan data psikologis Anda dilindungi dengan aman.
            </div>
            <div>
                &copy; {{ date('Y') }} {{ config('app.name', "LoveCaring-Rr.Nursing") }}. All rights reserved.
            </div>
        </div>
    </div>

    <div class="right-section">
        <div class="overlay"></div>
        
        <div class="info-card">
            <h4 class="text-lg font-bold text-[#22C55E] mb-1 uppercase tracking-wide">Layanan Pendampingan Psikologis</h4>
            <p class="text-slate-600 text-xs leading-relaxed font-medium">
                Platform terintegrasi untuk pemantauan kesehatan mental secara berkala. 
                Kami memastikan setiap asesmen dikelola dengan standar kerahasiaan medis yang ketat demi kenyamanan Anda.
            </p>
        </div>
    </div>
</div>

<script>
    function togglePass() {
        const p = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (p.type === "password") {
            p.type = "text";
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            p.type = "password";
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    function switchTab(method) {
        const formEmail = document.getElementById('form-email');
        const formWa = document.getElementById('form-wa');
        const tabEmail = document.getElementById('tab-email');
        const tabWa = document.getElementById('tab-wa');

        if(method === 'email') {
            formEmail.classList.remove('hidden');
            formWa.classList.add('hidden');
            
            tabEmail.classList.add('bg-white', 'shadow', 'text-[#22C55E]');
            tabEmail.classList.remove('text-slate-500');
            
            tabWa.classList.remove('bg-white', 'shadow', 'text-[#25D366]');
            tabWa.classList.add('text-slate-500');
        } else {
            formWa.classList.remove('hidden');
            formEmail.classList.add('hidden');
            
            tabWa.classList.add('bg-white', 'shadow', 'text-[#25D366]');
            tabWa.classList.remove('text-slate-500');
            
            tabEmail.classList.remove('bg-white', 'shadow', 'text-[#22C55E]');
            tabEmail.classList.add('text-slate-500');
        }
    }
</script>

</body>
</html>