@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    {{-- Total Dosen --}}
    <div class="bg-white rounded-xl p-6 shadow-md border-l-8 border-green-500 hover:shadow-lg transition-transform transform hover:-translate-y-1">
        <div class="text-green-500 text-4xl mb-3">
            <i class="fa-solid fa-chalkboard-teacher"></i>
        </div>
        <div class="text-3xl font-bold mb-1">{{ number_format($lecturerCount) }}</div>
        <div class="text-gray-600 font-semibold">Total Dosen</div>
    </div>

    {{-- Total Mahasiswa --}}
    <div class="bg-white rounded-xl p-6 shadow-md border-l-8 border-emerald-500 hover:shadow-lg transition-transform transform hover:-translate-y-1">
        <div class="text-emerald-500 text-4xl mb-3">
            <i class="fa-solid fa-user-graduate"></i>
        </div>
        <div class="text-3xl font-bold mb-1">{{ number_format($studentCount) }}</div>
        <div class="text-gray-600 font-semibold">Total Mahasiswa</div>
    </div>

    {{-- Total Evaluasi --}}
    <div class="bg-white rounded-xl p-6 shadow-md border-l-8 border-teal-500 hover:shadow-lg transition-transform transform hover:-translate-y-1">
        <div class="text-teal-500 text-4xl mb-3">
            <i class="fa-solid fa-clipboard-check"></i>
        </div>
        <div class="text-3xl font-bold mb-1">{{ number_format($evaluationCount) }}</div>
        <div class="text-gray-600 font-semibold">Total Hasil Evaluasi</div>
    </div>

</div>
@endsection
