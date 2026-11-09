<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - MindScans</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo.png') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body, html {
            height: 100%;
            font-family: 'Roboto', sans-serif;
            overflow: hidden; 
            background-color: #F0FDF4; 
        }

        .login-container {
            display: flex;
            width: 100vw;
            height: 100vh;
        }

        /* Bagian Kiri (Form) */
        .left-section {
            flex: 0 0 500px;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            padding: 30px 40px; 
            z-index: 10;
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.05);
            overflow-y: auto; /* Allow scrolling for register form */
        }

        /* Webkit scrollbar for left-section */
        .left-section::-webkit-scrollbar {
            width: 6px;
        }
        .left-section::-webkit-scrollbar-track {
            background: transparent;
        }
        .left-section::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .form-wrapper {
            margin: auto 0;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-title {
            font-size: 28px;
            font-weight: 800;
            color: #1e293b; 
            letter-spacing: -0.5px;
        }

        .divider {
            height: 1px;
            background: #f1f5f9;
            margin: 15px 0;
        }

        .form-group {
            position: relative;
            margin-bottom: 16px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: #22C55E; 
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
        }

        select.form-control {
            appearance: none;
            padding-right: 40px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #22C55E 0%, #16A34A 100%); 
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
        }

        /* Bagian Kanan (Background) */
        .right-section {
            flex: 1;
            position: relative;
            background-image: url('{{ asset("images/login.jpg") }}');
            background-color: #F0FDF4; 
            background-size: cover;
            background-position: center;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.2) 0%, rgba(15, 23, 42, 0.5) 100%); 
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
            .left-section { flex: 1; max-width: 100%; width: 100%; padding: 30px; justify-content: flex-start; }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="left-section">
        <div class="form-wrapper py-6">
            
            <div class="logo-section flex flex-col items-center">
                <img src="{{ asset('images/medical-logo.svg') }}" alt="MindScans medical logo" class="h-16 w-auto mb-3">
                <h1 class="logo-title text-2xl">{{ config('app.name', 'MindScans') }}</h1>
                <p class="text-[10px] font-bold text-[#22C55E] uppercase tracking-widest mt-1">Buat Akun Baru</p>
            </div>

            @if($errors->any())
                <div class="mb-4 text-red-600 text-xs bg-red-50 p-3 rounded-lg border border-red-200">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="gender" class="form-control" required>
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Daftar Sebagai</label>
                    <select id="role" name="role" class="form-control" required>
                        <option value="" disabled selected>Pilih Peran</option>
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Patient</option>
                        <option value="lecturer" {{ old('role') == 'lecturer' ? 'selected' : '' }}>Healthcare Professional</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="flex items-center justify-between mt-6 mb-2">
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-500 hover:text-[#22C55E] transition">Sudah punya akun? Masuk</a>
                </div>

                <button type="submit" class="btn-login">Daftar Sekarang</button>
            </form>

        </div>

        <div class="mt-4 pb-4 text-center text-[10px] text-slate-400">
            <div>&copy; {{ date('Y') }} {{ config('app.name', 'MindScans') }}. All rights reserved.</div>
        </div>
    </div>

    <div class="right-section">
        <div class="overlay"></div>
        
        <div class="info-card">
            <h4 class="text-lg font-bold text-[#22C55E] mb-1 uppercase tracking-wide">Layanan Pendampingan Psikologis</h4>
            <p class="text-slate-600 text-xs leading-relaxed font-medium">
                Daftar sekarang untuk memulai pemantauan kesehatan mental Anda.<br> 
                Data Anda dikelola dengan standar kerahasiaan medis yang ketat demi kenyamanan Anda.
            </p>
        </div>
    </div>
</div>

<script>
    /* Registration no longer requires role-specific profile fields. */
    /*
    function toggleRoleFields() {
        var role = document.getElementById('role').value;
        var studentFields = document.getElementById('student_fields');
        var lecturerFields = document.getElementById('lecturer_fields');
        var othersFields = document.getElementById('others_fields');

        if (role === 'student') {
            studentFields.style.display = 'block';
            lecturerFields.style.display = 'none';
            othersFields.style.display = 'none';
        } else if (role === 'lecturer') {
            studentFields.style.display = 'none';
            lecturerFields.style.display = 'block';
            othersFields.style.display = 'none';
        } else if (role === 'others') {
            studentFields.style.display = 'none';
            lecturerFields.style.display = 'none';
            othersFields.style.display = 'block';
        } else {
            studentFields.style.display = 'none';
            lecturerFields.style.display = 'none';
            othersFields.style.display = 'none';
        }
    }

    function setupAutocomplete(inputId, dropdownId, type) {
        const input = document.getElementById(inputId);
        const dropdown = document.getElementById(dropdownId);
        let timeout = null;

        if(!input || !dropdown) return;

        input.addEventListener('input', function() {
            clearTimeout(timeout);
            const keyword = this.value.trim();
            
            if (keyword.length < 3) {
                dropdown.classList.add('hidden');
                dropdown.innerHTML = '';
                return;
            }

            timeout = setTimeout(() => {
                dropdown.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500 text-left">Mencari...</div>';
                dropdown.classList.remove('hidden');

                fetch(`/api-proxy/pddikti/${type}/${encodeURIComponent(keyword)}`)
                    .then(res => res.json())
                    .then(data => {
                        dropdown.innerHTML = '';
                        if (data && data.length > 0) {
                            data.forEach(item => {
                                const div = document.createElement('div');
                                div.className = 'px-4 py-2 cursor-pointer hover:bg-green-50 text-sm border-b border-gray-100 last:border-b-0 text-left';
                                
                                const nama = item.nama;
                                const singleDesc = type === 'pt' ? (item.nama_singkat ? `(${item.nama_singkat})` : '') : (item.jenjang || '');
                                
                                let html = `<div class="font-medium text-gray-800">${nama}</div>`;
                                if (singleDesc) html += `<div class="text-xs text-gray-500">${singleDesc}</div>`;
                                
                                div.innerHTML = html;
                                
                                div.addEventListener('click', function() {
                                    input.value = nama;
                                    dropdown.classList.add('hidden');
                                });
                                dropdown.appendChild(div);
                            });
                        } else {
                            dropdown.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500 text-left">Tidak ditemukan</div>';
                        }
                    })
                    .catch(err => {
                        console.error('Error fetching data:', err);
                        dropdown.innerHTML = '<div class="px-4 py-2 text-sm text-red-500 text-left">Terjadi kesalahan koneksi</div>';
                    });
            }, 500); // Debounce 500ms
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Show dropdown again when focused if it has content
        input.addEventListener('focus', function() {
            if (this.value.trim().length >= 3 && dropdown.innerHTML.trim() !== '') {
                dropdown.classList.remove('hidden');
            }
        });
    }

    // Run on page load in case there is old input from validation errors
    document.addEventListener("DOMContentLoaded", function() {
        toggleRoleFields();
        
        // Initialize autocomplete for inputs
        setupAutocomplete('kampus', 'kampus-dropdown', 'pt');
        setupAutocomplete('program_studi', 'program_studi-dropdown', 'prodi');
        setupAutocomplete('kampus_lecturer', 'kampus_lecturer-dropdown', 'pt');
        setupAutocomplete('program_studi_lecturer', 'program_studi_lecturer-dropdown', 'prodi');
        
        // Auto-fill logic for student based on Name, Kampus, Prodi
        const nameInput = document.querySelector('input[name="name"]');
        const kampusInput = document.getElementById('kampus');
        const prodiInput = document.getElementById('program_studi');
        let mhsTimeout = null;

        function checkStudentAutofill() {
            if (document.getElementById('role').value !== 'student') return;
            const name = nameInput ? nameInput.value.trim() : '';
            const kampus = kampusInput ? kampusInput.value.trim() : '';
            const prodi = prodiInput ? prodiInput.value.trim() : '';

            // We need at least the name to search
            if (name.length >= 3) {
                clearTimeout(mhsTimeout);
                mhsTimeout = setTimeout(() => {
                    fetch('/api-proxy/pddikti/mhs/' + encodeURIComponent(name))
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                let match = null;
                                
                                // Filter based on available input to find the exact match
                                let filteredData = data;
                                
                                if (kampus) {
                                    filteredData = filteredData.filter(item => item.nama_pt && item.nama_pt.toLowerCase().includes(kampus.toLowerCase()));
                                }
                                
                                if (prodi) {
                                    filteredData = filteredData.filter(item => item.nama_prodi && item.nama_prodi.toLowerCase().includes(prodi.toLowerCase()));
                                }

                                // If after filtering we have exactly 1 match, we use it. 
                                // If we didn't filter but there's only 1 total match, use it.
                                if (filteredData.length === 1) {
                                    match = filteredData[0];
                                } else if (filteredData.length > 1) {
                                    // Still multiple matches, we might just take the first one if we're feeling lucky,
                                    // or do nothing and wait for more filters (kampus/prodi/nim) to be filled.
                                    // For now, let's just log it and wait for user to input more specific info.
                                    console.log('Multiple matches found. Please provide more specific information (Kampus, Prodi, or NIM).');
                                }

                                if (match && match.id) {
                                    // Step 2: Fetch detailed profile using ID
                                    fetch('/api-proxy/pddikti/detail/mhs/' + encodeURIComponent(match.id))
                                        .then(res => res.json())
                                        .then(detailData => {
                                            if (detailData) {
                                                const p = Array.isArray(detailData) ? detailData[0] : detailData;
                                                
                                                if(kampusInput && !kampusInput.value) kampusInput.value = p.nama_pt || '';
                                                if(prodiInput && !prodiInput.value) prodiInput.value = p.prodi || ''; // prodi in detail API
                                                
                                                const genderSelect = document.querySelector('select[name="gender"]');
                                                if (genderSelect && !genderSelect.value) {
                                                    // Handle mapping for student gender if available in detail.
                                                    if (p.jenis_kelamin === 'Laki-laki' || p.jenis_kelamin === 'L') genderSelect.value = 'male';
                                                    else if (p.jenis_kelamin === 'Perempuan' || p.jenis_kelamin === 'P') genderSelect.value = 'female';
                                                }
                                                
                                                const statusInput = document.querySelector('input[name="status"]');
                                                if (statusInput && !statusInput.value) statusInput.value = p.status_saat_ini || '';
                                            }
                                        })
                                        .catch(err => console.error('Error fetching detail:', err));

                                } else if (match) {
                                    // Fallback to basic data if no ID
                                    if(kampusInput && !kampusInput.value) kampusInput.value = match.nama_pt || '';
                                    if(prodiInput && !prodiInput.value) prodiInput.value = match.nama_prodi || '';
                                }
                            }
                        })
                        .catch(err => console.error(err));
                }, 800);
            }
        }
        
        // Add event listeners to all student filter fields
        if (nameInput) nameInput.addEventListener('blur', checkStudentAutofill);
        if (kampusInput) kampusInput.addEventListener('blur', checkStudentAutofill);
        if (prodiInput) prodiInput.addEventListener('blur', checkStudentAutofill);

        // Auto-fill logic for lecturer based on Name and Kampus
        const lecturerNameInput = document.querySelector('input[name="name"]');
        const kampusLecturerInput = document.getElementById('kampus_lecturer');
        const prodiLecturerInput = document.getElementById('program_studi_lecturer');
        let nameTimeout = null;

        function checkLecturerAutofill() {
            if (document.getElementById('role').value !== 'lecturer') return;
            const name = lecturerNameInput ? lecturerNameInput.value.trim() : '';
            const kampus = kampusLecturerInput ? kampusLecturerInput.value.trim() : '';
            
            if (name.length >= 3) {
                clearTimeout(nameTimeout);
                nameTimeout = setTimeout(() => {
                    fetch('/api-proxy/pddikti/dosen/' + encodeURIComponent(name))
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                let match = null;
                                // If kampus is provided, match by it, otherwise if there's only 1 record, use it
                                if (kampus.length > 0) {
                                    match = data.find(item => 
                                        item.nama_pt && item.nama_pt.toLowerCase().includes(kampus.toLowerCase())
                                    );
                                } else if (data.length === 1) {
                                    match = data[0];
                                }
                                
                                if (match && match.id) {
                                    // Step 2: Fetch detailed profile using ID
                                    fetch('/api-proxy/pddikti/profile/dosen/' + encodeURIComponent(match.id))
                                        .then(res => res.json())
                                        .then(profileData => {
                                            if (profileData) {
                                                const p = Array.isArray(profileData) ? profileData[0] : profileData;
                                                
                                                if(kampusLecturerInput && !kampusLecturerInput.value) kampusLecturerInput.value = p.nama_pt || '';
                                                if(prodiLecturerInput && !prodiLecturerInput.value) prodiLecturerInput.value = p.nama_prodi || '';
                                                
                                                // Map other detailed fields
                                                const genderSelect = document.querySelector('select[name="gender"]');
                                                if (genderSelect && !genderSelect.value) {
                                                    if (p.jenis_kelamin === 'Laki-laki') genderSelect.value = 'male';
                                                    else if (p.jenis_kelamin === 'Perempuan') genderSelect.value = 'female';
                                                }
                                                
                                                const aktivitasInput = document.querySelector('input[name="status_aktivitas"]');
                                                if (aktivitasInput && !aktivitasInput.value) aktivitasInput.value = p.status_aktivitas || '';
                                            }
                                        })
                                        .catch(err => console.error('Error fetching profile:', err));

                                } else if (match) {
                                    // Fallback if no ID is found but we have basic match data
                                    if(kampusLecturerInput && !kampusLecturerInput.value) kampusLecturerInput.value = match.nama_pt || '';
                                    if(prodiLecturerInput && !prodiLecturerInput.value) prodiLecturerInput.value = match.nama_prodi || '';
                                }
                            }
                        })
                        .catch(err => console.error(err));
                }, 800);
            }
        }
        
        if (lecturerNameInput) lecturerNameInput.addEventListener('blur', checkLecturerAutofill);
        if (kampusLecturerInput) kampusLecturerInput.addEventListener('blur', checkLecturerAutofill);
    });
    */
</script>

</body>
</html>
