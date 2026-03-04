@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
<div class="p-4 md:p-8" x-data="studentManager()">
    {{-- Alert Success --}}
    @if (session('success'))
    <div class="mb-6 flex items-center gap-3 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-xl shadow-sm">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <h1 class="text-2xl font-bold text-[#262C5B]">Data Pasien</h1>

            <div class="flex flex-wrap items-center gap-3">
                <div class="relative group flex-1 md:flex-none">
                    <input type="text" x-model="searchQuery" @keyup="filterTable()" placeholder="Cari nama atau NIK..."
                        class="w-full md:w-64 pl-10 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-[#5DB8D8] focus:ring-[#5DB8D8] text-sm outline-none">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#5DB8D8]"></i>
                </div>

                <button @click="openModal('add')"
                    class="flex items-center gap-2 bg-[#5DB8D8] hover:bg-[#4A9FBD] text-white px-5 py-2.5 rounded-xl font-semibold transition-all transform hover:-translate-y-0.5 shadow-md shadow-sky-100">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span>Tambah Pasien</span>
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto rounded-2xl border border-gray-100" x-data="{ openDelete: false, postUrl: '', studentName: '' }">
            <table class="w-full text-left border-collapse" id="studentTable">
                <thead>
                    <tr class="bg-sky-50 text-[#4A9FBD] text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold">NIK</th>
                        <th class="px-6 py-4 font-bold">Nama Pasien</th>
                        <th class="px-6 py-4 font-bold">Kontak</th>
                        <th class="px-6 py-4 font-bold">Info Kehamilan</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($students as $student)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="px-6 py-4 text-sm text-gray-500 font-medium">{{ $student->nik ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">{{ $student->user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->translatedFormat('d M Y') : 'Tgl Lahir -' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <i class="fa-brands fa-whatsapp text-green-500"></i>
                                {{ $student->user->phone ? '+62' . substr($student->user->phone, 1) : '-' }}
                            </div>
                            <div class="text-[10px] text-gray-400">{{ $student->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="px-2 py-0.5 bg-sky-100 text-sky-600 rounded-md text-[10px] font-bold uppercase">
                                {{-- Jika I, II, III tetap muncul I, II, III --}}
                                Trimester {{ $student->trimester ?? '-' }}
                            </span>
                            <div class="mt-1 text-xs">Minggu ke-{{ $student->pregnancy_week ?? '0' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="openModal('edit', {{ json_encode($student) }}, '{{ $student->user->name }}', '{{ $student->user->email }}', '{{ $student->user->phone }}')"
                                    class="p-2 bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white rounded-lg transition-all">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button @click="openDelete = true;
                                postUrl = '{{ route('lecturer.datapasien.destroy', $student->id) }}';
                                studentName = '{{ $student->name }}'"
                                    class="p-2 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-all">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                                {{-- Tombol Edit Password --}}
                                <button @click="openPasswordModal({{ $student->user->id }}, '{{ $student->user->name }}')"
                                    class="p-2 bg-yellow-50 text-yellow-600 hover:bg-yellow-500 hover:text-white rounded-lg transition-all"
                                    title="Ganti Password Pasien">
                                    <i class="fa-solid fa-key"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-gray-400">Belum ada data pasien.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>

    {{-- Modal --}}
    <template x-if="isOpen">
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeModal()"></div>
            <div class="relative bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h2 class="text-xl font-bold text-[#262C5B]" x-text="mode === 'edit' ? 'Edit Data Pasien' : 'Tambah Pasien'"></h2>
                    <button @click="closeModal()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
                </div>

                <form @submit.prevent="submitForm" class="p-8 max-h-[80vh] overflow-y-auto no-scrollbar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Data Akun --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap Pasien</label>
                            <input type="text" x-model="formData.name" required class="w-full rounded-xl border-gray-200 focus:ring-[#5DB8D8]">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email (Untuk Login)</label>
                            <input type="email" x-model="formData.email" required class="w-full rounded-xl border-gray-200 focus:ring-[#5DB8D8]">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp</label>
                            <input type="text"
                                x-model="formData.phone"
                                @input="if(!formData.phone.startsWith('+62')) formData.phone = '+62'" required placeholder="+62812..." class="w-full rounded-xl border-gray-200 focus:ring-[#5DB8D8]">
                        </div>

                        <div class="md:col-span-2">
                            <hr class="border-gray-100">
                        </div>

                        {{-- Data Medis/Profile --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">NIK</label>
                            <input type="text" x-model="formData.nik" required maxlength="16" class="w-full rounded-xl border-gray-200 focus:ring-[#5DB8D8]">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Lahir</label>
                            <input type="date" x-model="formData.dob" required class="w-full rounded-xl border-gray-200 focus:ring-[#5DB8D8]">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
                            <select x-model="formData.gender" class="w-full rounded-xl border-gray-200 focus:ring-[#5DB8D8]">
                                <option value="female">Perempuan</option>
                                <option value="male">Laki-laki</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Pendidikan</label>
                            <select x-model="formData.education" class="w-full rounded-xl border-gray-200">
                                <option value="">Pilih Pendidikan</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <hr class="border-gray-100">
                        </div>

                        {{-- Data Kehamilan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Trimester</label>
                            <select x-model="formData.trimester" class="w-full rounded-xl border-gray-200">
                                <option value="">Pilih Trimester</option>
                                <option value="I">Trimester I</option>
                                <option value="II">Trimester II</option>
                                <option value="III">Trimester III</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Minggu Kehamilan</label>
                            <input type="number" x-model="formData.pregnancy_week" class="w-full rounded-xl border-gray-200">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">HPHT (Hari Pertama Haid Terakhir)</label>
                            <input type="date" x-model="formData.last_period_date" class="w-full rounded-xl border-gray-200">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea x-model="formData.address" rows="2" class="w-full rounded-xl border-gray-200"></textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-4">
                        <button type="button" @click="closeModal()" class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit" class="flex-1 py-3 bg-[#5DB8D8] text-white font-bold rounded-xl hover:bg-[#4A9FBD] shadow-lg shadow-sky-100 transition-all">
                            <span x-show="!loading" x-text="mode === 'edit' ? 'Simpan Perubahan' : 'Daftarkan Pasien'"></span>
                            <i x-show="loading" class="fas fa-circle-notch animate-spin"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="openDelete"
            class="fixed inset-0 z-[999] flex items-center justify-center p-4 overflow-hidden"
            x-cloak>

            <div x-show="openDelete"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                @click="openDelete = false"
                class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

            <div x-show="openDelete"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                class="relative w-full max-w-sm bg-white p-8 md:p-10 rounded-[2.5rem] shadow-2xl border border-gray-100 text-center">

                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                    <i class="fa-solid fa-triangle-exclamation animate-pulse"></i>
                </div>

                <h3 class="text-2xl font-black text-gray-800 uppercase tracking-tighter leading-tight">Hapus Data?</h3>
                <p class="text-gray-500 mt-2 text-sm leading-relaxed">
                    Anda akan menghapus data <span class="font-bold text-gray-700" x-text="studentName"></span>. Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 mt-10">
                    <button @click="openDelete = false"
                        class="order-2 sm:order-1 flex-1 py-4 bg-gray-100 text-gray-400 rounded-2xl font-black text-xs tracking-widest hover:bg-gray-200 transition-all">
                        BATAL
                    </button>

                    <form :action="postUrl" method="POST" class="order-1 sm:order-2 flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full py-4 bg-red-500 text-white rounded-2xl font-black text-xs tracking-widest shadow-lg shadow-red-100 hover:bg-red-600 transition-all active:scale-95">
                            YA, HAPUS
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
    <template x-if="showCreds">
        <div class="fixed inset-0 z-[70] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-[#262C5B]/80 backdrop-blur-md"></div>
            <div class="relative bg-white w-full max-w-md rounded-3xl shadow-2xl p-8 text-center">
                <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                    <i class="fas fa-key"></i>
                </div>
                <h2 class="text-2xl font-bold text-[#262C5B] mb-2">Pendaftaran Berhasil!</h2>
                <p class="text-gray-500 mb-6">Berikan informasi login berikut kepada pasien:</p>

                <div class="bg-gray-50 rounded-2xl p-6 mb-6 text-left border border-dashed border-gray-300">
                    <div class="mb-3">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Email</span>
                        <p class="font-bold text-gray-800" x-text="newStudent.email"></p>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Password</span>
                        <p class="font-mono text-xl font-black text-[#5DB8D8]" x-text="newStudent.password"></p>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button @click="copyToClipboard()" class="w-full py-3 bg-[#5DB8D8] text-white font-bold rounded-xl hover:bg-[#4A9FBD] transition-all">
                        <i class="fa-solid fa-copy mr-2"></i> Salin Pesan Login
                    </button>
                    <button @click="window.location.reload()" class="w-full py-3 text-gray-400 font-semibold hover:text-gray-600 transition-colors">
                        Tutup & Reload
                    </button>
                </div>
            </div>
        </div>
    </template>
    {{-- MODAL RESET PASSWORD PASIEN --}}
    <template x-if="isPasswordOpen">
        <div class="fixed inset-0 z-[70] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="isPasswordOpen = false"></div>
            <div class="relative bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl overflow-hidden p-8">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-yellow-50 text-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h2 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Reset Password</h2>
                    <p class="text-gray-500 text-sm">Pasien: <span class="font-bold text-gray-700" x-text="targetStudentName"></span></p>
                </div>

                <form @submit.prevent="submitPassword" class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-2">Password Baru</label>
                        <input type="password" x-model="passData.password" required
                            class="w-full px-5 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-yellow-400 font-bold"
                            placeholder="Minimal 8 karakter">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-2">Konfirmasi Password</label>
                        <input type="password" x-model="passData.password_confirmation" required
                            class="w-full px-5 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-yellow-400 font-bold"
                            placeholder="Ulangi password">
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="isPasswordOpen = false"
                            class="flex-1 py-4 bg-gray-100 text-gray-400 rounded-2xl font-black text-xs tracking-widest">
                            BATAL
                        </button>
                        <button type="submit" :disabled="loading"
                            class="flex-1 py-4 bg-gray-900 text-white rounded-2xl font-black text-xs tracking-widest shadow-lg hover:bg-black transition-all">
                            <span x-show="!loading uppercase">Update</span>
                            <i x-show="loading" class="fas fa-circle-notch animate-spin"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>

@push('scripts')
<script>
    function studentManager() {
        return {
            showCreds: false, // Untuk kontrol modal password
            newStudent: {}, // Untuk simpan data pasien yang baru dibuat
            isOpen: false,
            mode: 'add',
            loading: false,
            searchQuery: '',
            editingId: null,
            isPasswordOpen: false,
            targetUserId: null,
            targetStudentName: '',
            passData: {
                password: '',
                password_confirmation: ''
            },
            formData: {
                name: '',
                email: '',
                phone: '',
                nik: '',
                dob: '',
                gender: 'female',
                address: '',
                education: '',
                trimester: '',
                pregnancy_week: '',
                last_period_date: ''
            },

            openPasswordModal(userId, name) {
                this.targetUserId = userId;
                this.targetStudentName = name;
                this.passData.password = '';
                this.passData.password_confirmation = '';
                this.isPasswordOpen = true;
            },

            openModal(mode, data = null, name = '', email = '', phone = '') {
                this.mode = mode;
                this.isOpen = true;
                if (mode === 'edit' && data) {
                    this.editingId = data.id;
                    let phoneForUi = phone;
                    if (phone && phone.startsWith('0')) {
                        phoneForUi = '+62' + phone.substring(1);
                    }
                    this.formData = {
                        name: name,
                        email: email,
                        phone: phoneForUi,
                        nik: data.nik,
                        dob: data.dob ? data.dob.split('T')[0] : '',
                        gender: data.gender,
                        address: data.address,
                        education: data.education,
                        trimester: data.trimester,
                        pregnancy_week: data.pregnancy_week,
                        last_period_date: data.last_period_date ? data.last_period_date.split('T')[0] : ''
                    };
                } else {
                    this.resetForm();
                    this.formData.phone = '+62';
                }
            },

            closeModal() {
                this.isOpen = false;
            },

            resetForm() {
                this.formData = {
                    name: '',
                    email: '',
                    phone: '',
                    nik: '',
                    dob: '',
                    gender: 'female',
                    address: '',
                    education: '',
                    trimester: '',
                    pregnancy_week: '',
                    last_period_date: ''
                };
                this.editingId = null;
            },

            async submitPassword() {
                if (this.passData.password.length < 8) {
                    alert('Password minimal 8 karakter');
                    return;
                }
                if (this.passData.password !== this.passData.password_confirmation) {
                    alert('Konfirmasi password tidak cocok');
                    return;
                }

                this.loading = true;
                try {
                    // Sesuaikan route ini dengan route backend Anda (misal: lecturer.datapasien.resetPassword)
                    const response = await fetch(`/lecturer/pasien/reset-password/${this.targetUserId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.passData)
                    });

                    const result = await response.json();
                    if (response.ok) {
                        alert('Password berhasil diperbarui!');
                        this.isPasswordOpen = false;
                    } else {
                        alert(result.message || 'Gagal mengubah password');
                    }
                } catch (err) {
                    alert('Terjadi kesalahan sistem.');
                } finally {
                    this.loading = false;
                }
            },

            async submitForm() {
                this.loading = true;
                const url = this.mode === 'edit' ? `/lecturer/pasien/${this.editingId}` : `{{ route('lecturer.datapasien.store') }}`;
                const method = this.mode === 'edit' ? 'PUT' : 'POST';

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            ...this.formData,
                            _method: method
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        if (this.mode === 'add') {
                            // Jika tambah baru, jangan reload dulu, tampilkan password
                            this.newStudent = result.credentials;
                            this.showCreds = true;
                            this.isOpen = false; // tutup modal form
                        } else {
                            window.location.reload();
                        }
                    } else {
                        alert(result.message);
                    }
                } catch (err) {
                    console.error(err);
                    alert('Gagal terhubung ke server.');
                } finally {
                    this.loading = false;
                }
            },

            copyToClipboard() {
                const text = `Halo Ibu ${this.newStudent.name},\nAkun MindScans Anda telah dibuat.\nEmail: ${this.newStudent.email}\nPassword: ${this.newStudent.password}\nSilakan login di aplikasi.`;
                navigator.clipboard.writeText(text);
                alert('Pesan berhasil disalin!');
            },

            confirmDelete(id) {
                if (confirm('Hapus data pasien ini secara permanen? Akun login juga akan dihapus.')) {
                    fetch(`/lecturer/pasien/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            _method: 'DELETE'
                        })
                    }).then(() => window.location.reload());
                }
            },

            filterTable() {
                let filter = this.searchQuery.toUpperCase();
                document.querySelectorAll("#studentTable tbody tr").forEach(row => {
                    row.style.display = row.innerText.toUpperCase().includes(filter) ? "" : "none";
                });
            }
        }
    }
</script>
@endpush
@endsection
