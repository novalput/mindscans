@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
<div class="w-full max-w-full">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Data Pasien</h1>
        <p class="text-gray-600 text-sm mt-2">Daftar pasien yang terdaftar dalam sistem</p>
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
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-[#4da4e3] to-[#367cae] text-white">
                    <tr>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-semibold">Nama</th>
                        <th class="hidden sm:table-cell px-6 py-4 text-left font-semibold">Email</th>
                        <th class="hidden md:table-cell px-6 py-4 text-left font-semibold">No. HP</th>
                        <th class="hidden lg:table-cell px-6 py-4 text-left font-semibold">NIK</th>
                        <th class="hidden lg:table-cell px-6 py-4 text-left font-semibold">Gender</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($students as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-3 sm:px-6 py-3 sm:py-4 font-medium text-gray-900">
                            <div class="text-xs sm:text-sm">{{ $item->name }}</div>
                            <div class="sm:hidden text-xs text-gray-500 mt-1">{{ $item->email }}</div>
                        </td>
                        <td class="hidden sm:table-cell px-6 py-4 text-gray-700 text-sm">{{ $item->email }}</td>
                        <td class="hidden md:table-cell px-6 py-4 text-gray-700 text-sm">{{ $item->phone }}</td>
                        <td class="hidden lg:table-cell px-6 py-4 text-gray-700 text-sm">{{ $item->student?->nik ?? '-' }}</td>
                        <td class="hidden lg:table-cell px-6 py-4 text-gray-700 text-sm">
                            @if($item->student?->gender)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                    {{ ucfirst($item->student->gender) }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.student.show', $item->id) }}"
                                    class="text-green-600 hover:text-green-900 text-xs sm:text-sm px-2 sm:px-3 py-1 rounded bg-green-100 hover:bg-green-200 transition"
                                    title="Lihat Detail">
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
            {{ $students->links() }}
        </div>
        @else
        <div class="p-6 sm:p-8 text-center">
            <i class="fas fa-inbox text-4xl sm:text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-base sm:text-lg">Belum ada data Pasien</p>
        </div>
        @endif
    </div>
</div>
@endsection
