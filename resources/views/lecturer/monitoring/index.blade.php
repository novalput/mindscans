@extends('layouts.app')

@section('content')
<div class="space-y-6 p-2 md:p-0">
    <h3 class="text-xl md:text-2xl font-bold text-gray-800 px-2">Monitoring Daily Activity Pasien</h3>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Wrapper agar tabel bisa di-scroll ke samping di layar kecil --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[500px]">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs md:text-sm border-b uppercase tracking-wider">
                        <th class="p-4 md:p-6 font-black">Nama Pasien</th>
                        <th class="p-4 md:p-6 text-center font-black">Usia Hamil</th>
                        <th class="p-4 md:p-6 text-right font-black">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($students as $p)
                    <tr class="hover:bg-blue-50/50 transition-colors group">
                        <td class="p-4 md:p-6">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-700 text-sm md:text-base">{{ $p->name }}</span>
                                <span class="text-[10px] md:text-xs text-gray-400 leading-tight">{{ $p->email }}</span>
                            </div>
                        </td>
                        <td class="p-4 md:p-6 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] md:text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                {{ $p->student->pregnancy_week ?? '-' }} Minggu
                            </span>
                        </td>
                        <td class="p-4 md:p-6 text-right">
                            <a href="{{ route('lecturer.monitoring.show', $p->id) }}"
                                class="inline-flex items-center bg-[#5DB8D8] text-white px-4 py-2 md:py-2.5 rounded-xl font-bold text-xs md:text-sm hover:bg-blue-500 shadow-md hover:shadow-blue-200 transition-all active:scale-95">
                                <i class="fa-solid fa-calendar-check mr-2 hidden md:inline"></i>
                                Cek Kalender
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4 md:p-6 bg-gray-50/30 border-t border-gray-50">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
