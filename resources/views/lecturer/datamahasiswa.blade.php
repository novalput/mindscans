@extends('layouts.app')

@section('title', 'Daftar Mahasiswa')

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
            <h1 class="text-2xl font-bold text-[#262C5B]">Daftar Mahasiswa</h1>

            <form action="{{ route('lecturer.datamahasiswa') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="relative group flex-1 md:flex-none">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama..."
                        class="w-full md:w-64 pl-10 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 text-sm outline-none">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-green-500"></i>
                </div>

                <div class="relative group flex-1 md:flex-none">
                    <select name="prodi" class="w-full md:w-48 px-4 py-2.5 rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 text-sm outline-none bg-white">
                        <option value="">Semua Program Studi</option>
                        @foreach($prodiList as $p)
                            <option value="{{ $p }}" {{ request('prodi') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-gray-800 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-black transition-colors text-sm">
                    Filter
                </button>
                @if(request('search') || request('prodi'))
                    <a href="{{ route('lecturer.datamahasiswa') }}" class="px-5 py-2.5 rounded-xl font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 transition-colors text-sm">Reset</a>
                @endif
                <a href="{{ route('lecturer.datamahasiswa.export', request()->all()) }}" class="bg-red-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-red-700 transition-colors text-sm flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto rounded-2xl border border-gray-100" x-data="{ openDelete: false, postUrl: '', studentName: '' }">
            <table class="w-full text-left border-collapse" id="studentTable">
                <thead>
                    <tr class="bg-green-50 text-green-700 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold rounded-tl-xl text-center">No</th>
                        <th class="px-6 py-4 font-bold">Nama</th>
                        <th class="px-6 py-4 font-bold">Gender</th>
                        <th class="px-6 py-4 font-bold">Prodi</th>
                        <th class="px-6 py-4 font-bold">Terakhir Tes</th>
                        <th class="px-6 py-4 font-bold text-center">Status</th>
                        <th class="px-6 py-4 font-bold text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($students as $index => $student)
                        @php
                            $latestTest = $student->screeningResponses->first();
                            $avgScore = $student->screeningResponses->avg('score') ?? 0;
                            // Tentukan status berdasarkan rata-rata skor
                            // Contoh rentang:
                            // 0 - 17: Normal/Aman
                            // 18 - 27: Perlu Perhatian
                            // > 27: Berbahaya (Contoh)
                            $status = 'Belum Ada Tes';
                            $statusColor = 'bg-gray-100 text-gray-600';

                            if ($student->screeningResponses->count() > 0) {
                                if ($avgScore < 18) {
                                    $status = 'Normal/Aman';
                                    $statusColor = 'bg-green-100 text-green-700';
                                } else if ($avgScore <= 27) {
                                    $status = 'Perlu Perhatian';
                                    $statusColor = 'bg-yellow-100 text-yellow-700';
                                } else {
                                    $status = 'Kritis';
                                    $statusColor = 'bg-red-100 text-red-700';
                                }
                            }
                        @endphp
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="px-6 py-4 text-sm text-gray-500 font-medium text-center">
                            {{ $students->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">{{ $student->name ?? '-' }}</div>
                            <div class="text-xs text-gray-400">{{ $student->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-medium">
                            {{ ucfirst($student->biodata->jenis_kelamin ?? '-') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $student->biodata->prodi ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @if($latestTest)
                                <div class="font-medium text-gray-800">{{ $latestTest->created_at->format('d M Y') }}</div>
                                <div class="text-[10px] text-gray-400">{{ $latestTest->created_at->format('H:i') }} WIB</div>
                            @else
                                <span class="text-gray-400 italic text-xs">Belum ada tes</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusColor }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('lecturer.datamahasiswa.history', $student->id) }}" 
                               class="inline-flex items-center justify-center p-2 bg-green-50 text-green-600 hover:bg-green-500 hover:text-white rounded-lg transition-all"
                               title="Lihat Riwayat Kuesioner">
                               <i class="fa-solid fa-clock-rotate-left"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-inbox text-4xl mb-3 text-gray-200"></i>
                                <span class="font-medium">Tidak ada data mahasiswa ditemukan.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>

    </div>
</div>
@endsection
