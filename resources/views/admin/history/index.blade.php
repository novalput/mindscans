@extends('layouts.app')

@section('title', 'Riwayat Kuesioner')

@section('content')
<div class="w-full max-w-full">
    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Riwayat Kuesioner</h1>
            <p class="text-gray-600 text-sm mt-2">Seluruh rekap hasil skrining mental responden.</p>
        </div>
    </div>

    {{-- Tabs Filter Role --}}
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-4 overflow-x-auto" aria-label="Tabs">
            <a href="{{ route('admin.history.index', ['role' => 'all']) }}" 
                class="{{ $role === 'all' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all">
                Semua Responden
            </a>
            <a href="{{ route('admin.history.index', ['role' => 'student']) }}" 
                class="{{ $role === 'student' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all">
                Mahasiswa
            </a>
            <a href="{{ route('admin.history.index', ['role' => 'lecturer']) }}" 
                class="{{ $role === 'lecturer' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all">
                Dosen / Staf
            </a>
            <a href="{{ route('admin.history.index', ['role' => 'others']) }}" 
                class="{{ $role === 'others' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all">
                Pekerja Lainnya
            </a>
        </nav>
    </div>

    {{-- Result Table --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        @if ($histories->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-[#16A34A] to-green-700 text-white">
                    <tr>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-semibold">Waktu Tes</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-semibold">Nama Responden</th>
                        <th class="hidden sm:table-cell px-6 py-4 text-left font-semibold">Peran</th>
                        <th class="hidden sm:table-cell px-6 py-4 text-left font-semibold">Gender</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-center font-semibold">Skor</th>
                        <th class="hidden lg:table-cell px-6 py-4 text-center font-semibold">Status</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($histories as $history)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-gray-700 font-medium">
                            <div class="text-sm">{{ $history->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $history->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4 font-medium text-gray-900">
                            {{ $history->user->name ?? 'User Terhapus' }}
                        </td>
                        <td class="hidden sm:table-cell px-6 py-4 text-gray-700 text-sm">
                            {{ ucfirst($history->user->sub_role ?? '-') }}
                        </td>
                        <td class="hidden sm:table-cell px-6 py-4 text-gray-700 text-sm">
                            {{ ucfirst($history->user->biodata?->jenis_kelamin ?? '-') }}
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                            <span class="inline-flex items-center justify-center px-2 py-1 bg-gray-100 rounded text-gray-800 font-bold">
                                {{ $history->score }}
                            </span>
                        </td>
                        <td class="hidden lg:table-cell px-6 py-4 text-center">
                            @php
                                $badgeColor = 'bg-gray-100 text-gray-800';
                                if($history->category == 'Normal') $badgeColor = 'bg-emerald-100 text-emerald-800';
                                elseif($history->category == 'Sedang') $badgeColor = 'bg-yellow-100 text-yellow-800';
                                elseif($history->category == 'Berat' || $history->category == 'Sangat Berat' || $history->category == 'Perlu Perhatian') $badgeColor = 'bg-rose-100 text-rose-800';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                                {{ $history->category ?? '-' }}
                            </span>
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.history.show', $history->id) }}" 
                                    class="text-green-600 hover:text-green-900 text-xs sm:text-sm px-2 sm:px-3 py-1 rounded bg-green-100 hover:bg-green-200 transition"
                                    title="Lihat Detail Kuesioner">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-gray-50 px-4 sm:px-6 py-4 border-t border-gray-200">
            {{ $histories->links() }}
        </div>
        @else
        <div class="p-6 sm:p-8 text-center py-12">
            <i class="fas fa-clipboard-list text-4xl sm:text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-base sm:text-lg">Belum ada riwayat kuesioner pada kategori ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection
