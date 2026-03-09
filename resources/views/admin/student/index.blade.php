@extends('layouts.app')

@section('title', 'Kelola Mahasiswa')

@section('content')
<div x-data="studentCrud()" class="w-full max-w-full">
    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola Mahasiswa</h1>
            <p class="text-gray-600 text-sm mt-2">Daftar mahasiswa yang terdaftar dalam sistem</p>
        </div>
        <button @click="openCreate()" class="px-4 sm:px-6 py-2 bg-[#22C55E] text-white rounded-lg font-semibold hover:bg-green-700 text-sm sm:text-base flex items-center shadow-sm transition-all duration-200">
            <i class="fas fa-plus mr-2"></i> Tambah Mahasiswa
        </button>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm" role="alert">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    {{-- Table Container --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        @if ($students->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[800px]">
                <thead class="bg-gradient-to-r from-[#16A34A] to-green-700 text-white">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left font-semibold">Nama</th>
                        <th class="px-4 py-4 text-left font-semibold">NIM</th>
                        <th class="px-4 py-4 text-left font-semibold whitespace-nowrap">Kampus</th>
                        <th class="px-4 py-4 text-left font-semibold">Program Studi</th>
                        <th class="px-4 py-4 text-left font-semibold">Status</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($students as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-3 sm:py-4 font-medium text-gray-900">
                            <div class="text-sm">{{ $item->name }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $item->email }}</div>
                        </td>
                        <td class="px-4 py-4 text-gray-700 text-sm">{{ $item->student?->nim ?? '-' }}</td>
                        <td class="px-4 py-4 text-gray-700 text-sm break-words max-w-[200px]">{{ $item->student?->kampus ?? '-' }}</td>
                        <td class="px-4 py-4 text-gray-700 text-sm">{{ $item->student?->program_studi ?? '-' }}</td>
                        <td class="px-4 py-4 text-gray-700 text-sm">
                            @if($item->student?->status)
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-800 rounded text-xs font-medium">
                                    {{ ucfirst($item->student->status) }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.student.show', $item->id) }}"
                                    class="text-emerald-600 hover:text-emerald-900 text-xs sm:text-sm px-2 sm:px-3 py-1.5 rounded bg-emerald-50 hover:bg-emerald-100 transition"
                                    title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button @click='openEdit({
                                    id: {{ $item->id }},
                                    name: "{{ $item->name }}",
                                    email: "{{ $item->email }}",
                                    phone: "{{ $item->phone }}",
                                    nim: "{{ $item->student?->nim ?? '' }}",
                                    kampus: "{{ $item->student?->kampus ?? '' }}",
                                    jenjang: "{{ $item->student?->jenjang ?? '' }}",
                                    program_studi: "{{ $item->student?->program_studi ?? '' }}",
                                    gender: "{{ $item->student?->gender ?? '' }}",
                                    status: "{{ $item->student?->status ?? '' }}"
                                })'
                                    class="text-blue-600 hover:text-blue-900 text-xs sm:text-sm px-2 sm:px-3 py-1.5 rounded bg-blue-50 hover:bg-blue-100 transition"
                                    title="Edit Mahasiswa">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button @click="openDelete({{ $item->id }})"
                                    class="text-rose-600 hover:text-rose-900 text-xs sm:text-sm px-2 sm:px-3 py-1.5 rounded bg-rose-50 hover:bg-rose-100 transition"
                                    title="Hapus Mahasiswa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-gray-50 px-4 sm:px-6 py-4 border-t border-gray-200">
            {{ $students->links() }}
        </div>
        @else
        <div class="p-6 sm:p-8 text-center flex flex-col justify-center items-center">
            <i class="fas fa-user-graduate text-4xl sm:text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-base sm:text-lg">Belum ada data Mahasiswa</p>
        </div>
        @endif
    </div>

    {{-- ================= MODAL FORM ================= --}}
    <div x-show="modalForm" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="close()"></div>

        {{-- Modal --}}
        <div class="relative z-10 bg-white rounded-2xl shadow-2xl overflow-hidden w-full max-w-full sm:max-w-lg md:max-w-2xl mx-2 sm:mx-4">
            
            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-[#16A34A] to-green-700 text-white">
                <div class="flex items-center gap-3">
                    <i class="fas fa-user-graduate text-xl"></i>
                    <h2 class="text-lg font-semibold" x-text="formMode === 'create' ? 'Tambah Mahasiswa' : 'Edit Mahasiswa'"></h2>
                </div>
                <button @click="close()" class="text-white/80 hover:text-white transition">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            {{-- Body --}}
            <form @submit.prevent="submitForm" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Nama --}}
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Nama</label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input x-model="form.name" required class="w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:border-[#22C55E] focus:ring-1 focus:ring-[#22C55E] outline-none transition">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Email</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input x-model="form.email" type="email" class="w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:border-[#22C55E] focus:ring-1 focus:ring-[#22C55E] outline-none transition">
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">No HP</label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input x-model="form.phone" class="w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:border-[#22C55E] focus:ring-1 focus:ring-[#22C55E] outline-none transition">
                        </div>
                    </div>

                    {{-- Password --}}
                    <template x-if="formMode === 'create'">
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-gray-600 mb-1 block">Password</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" x-model="form.password" required class="w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:border-[#22C55E] focus:ring-1 focus:ring-[#22C55E] outline-none transition">
                            </div>
                        </div>
                    </template>

                    {{-- Data Akademik Division --}}
                    <div class="md:col-span-2 mt-4 mb-2 border-b border-gray-100 pb-2">
                        <h3 class="text-base font-semibold text-gray-800"><i class="fas fa-university mr-2 text-green-600"></i>Data Akademik</h3>
                    </div>

                    {{-- NIM --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">NIM</label>
                        <input x-model="form.nim" required class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:border-[#22C55E] focus:ring-1 focus:ring-[#22C55E] outline-none transition" placeholder="Nomor Induk Mahasiswa">
                    </div>

                    {{-- Kampus --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Kampus</label>
                        <input x-model="form.kampus" required class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:border-[#22C55E] focus:ring-1 focus:ring-[#22C55E] outline-none transition" placeholder="Universitas / Kampus">
                    </div>

                    {{-- Jenjang --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Jenjang</label>
                        <input x-model="form.jenjang" required class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:border-[#22C55E] focus:ring-1 focus:ring-[#22C55E] outline-none transition" placeholder="Diploma tiga/Diploma empat/Sarjana">
                    </div>

                    {{-- Program Studi --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Program Studi</label>
                        <input x-model="form.program_studi" required class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:border-[#22C55E] focus:ring-1 focus:ring-[#22C55E] outline-none transition" placeholder="Teknik Informatika dst">
                    </div>

                    {{-- Gender --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Jenis Kelamin</label>
                        <select x-model="form.gender" required class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:border-[#22C55E] focus:ring-1 focus:ring-[#22C55E] outline-none transition">
                            <option value="">Pilih...</option>
                            <option value="male">Laki-laki</option>
                            <option value="female">Perempuan</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Status Akademik</label>
                        <input x-model="form.status" required class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:border-[#22C55E] focus:ring-1 focus:ring-[#22C55E] outline-none transition" placeholder="Misal: Aktif">
                    </div>
                </div>

                {{-- Error --}}
                <div x-show="errorMessage" x-transition class="mt-4 p-3 bg-rose-50 border border-rose-200 rounded-lg flex items-start gap-2 text-rose-600">
                    <i class="fas fa-exclamation-circle mt-0.5"></i>
                    <p x-text="errorMessage" class="text-sm font-medium"></p>
                </div>

                {{-- Footer --}}
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-100">
                    <button type="button" @click="close()" class="px-5 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 font-medium transition">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-[#22C55E] hover:bg-green-700 text-white font-semibold transition shadow-sm hover:shadow flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= DELETE MODAL ================= --}}
    <div x-show="modalDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="modalDelete = false"></div>
        <div class="relative z-10 bg-white rounded-xl shadow-xl p-6 w-full max-w-sm mx-auto text-center transform transition-all">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-rose-100 mb-4">
                <i class="fas fa-exclamation-triangle text-2xl text-rose-600"></i>
            </div>
            <h3 class="text-lg font-bold mb-2 text-gray-900">Konfirmasi Hapus</h3>
            <p class="text-gray-500 mb-6 text-sm">Apakah Anda yakin ingin menghapus data mahasiswa ini secara permanen?</p>
            <div class="flex justify-center gap-3">
                <button @click="modalDelete = false" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg transition">Batal</button>
                <button @click="deleteData" class="px-5 py-2.5 bg-rose-600 text-white font-medium hover:bg-rose-700 rounded-lg transition shadow-sm">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    function studentCrud() {
        return {
            modalForm: false,
            modalDelete: false,
            formMode: 'create',
            deleteId: null,
            errorMessage: '',
            form: {
                id: null,
                name: '',
                email: '',
                phone: '',
                password: '',
                nim: '',
                kampus: '',
                jenjang: '',
                program_studi: '',
                gender: '',
                status: ''
            },

            openCreate() {
                this.formMode = 'create';
                this.reset();
                this.modalForm = true;
            },

            openEdit(data) {
                this.formMode = 'edit';
                this.form = {
                    ...data,
                    password: ''
                };
                this.errorMessage = '';
                this.modalForm = true;
            },

            openDelete(id) {
                this.deleteId = id;
                this.modalDelete = true;
            },

            close() {
                this.modalForm = false;
                this.errorMessage = '';
            },

            reset() {
                this.form = {
                    id: null,
                    name: '',
                    email: '',
                    phone: '',
                    password: '',
                    nim: '',
                    kampus: '',
                    jenjang: '',
                    program_studi: '',
                    gender: '',
                    status: ''
                };
                this.errorMessage = '';
            },

            async submitForm() {
                this.errorMessage = '';
                try {
                    let url = this.formMode === 'create' ? 
                        "{{ route('admin.student.store') }}" : 
                        `/admin/student/${this.form.id}`;
                    let method = this.formMode === 'create' ? 'POST' : 'PUT';

                    const res = await fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.form)
                    });

                    let data;
                    try { data = await res.json(); } 
                    catch { data = { message: 'Terjadi kesalahan server saat membaca respon' }; }

                    if (!res.ok) {
                        this.errorMessage = data?.errors ? 
                            Object.values(data.errors).flat()[0] : 
                            data?.message || 'Terjadi kesalahan pada server';
                        return;
                    }

                    // Success
                    location.reload();
                } catch (err) {
                    this.errorMessage = 'Terjadi kesalahan jaringan atau koneksi terputus';
                    console.error(err);
                }
            },

            async deleteData() {
                try {
                    await fetch(`/admin/student/${this.deleteId}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                    location.reload();
                } catch(err) {
                    console.error('Failed to delete', err);
                    alert('Gagal menghapus data.');
                }
            }
        }
    }
</script>
@endsection
