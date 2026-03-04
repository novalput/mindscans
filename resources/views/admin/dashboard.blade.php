@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    {{-- Total Lecturer --}}
    <div class="bg-white rounded-xl p-6 shadow-md border-l-8 border-blue-400 hover:shadow-lg transition-transform transform hover:-translate-y-1">
        <div class="text-blue-400 text-4xl mb-3">
            <i class="fa-solid fa-user-nurse"></i>
        </div>
        <div class="text-3xl font-bold mb-1">120</div>
        <div class="text-gray-600 font-semibold">Total Tenaga Kesehatan</div>
    </div>

    {{-- Total Pasien --}}
    <div class="bg-white rounded-xl p-6 shadow-md border-l-8 border-green-400 hover:shadow-lg transition-transform transform hover:-translate-y-1">
        <div class="text-green-400 text-4xl mb-3">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="text-3xl font-bold mb-1">120</div>
        <div class="text-gray-600 font-semibold">Total Pasien</div>
    </div>

    {{-- Total Evaluasi --}}
    <div class="bg-white rounded-xl p-6 shadow-md border-l-8 border-purple-400 hover:shadow-lg transition-transform transform hover:-translate-y-1">
        <div class="text-purple-400 text-4xl mb-3">
            <i class="fa-solid fa-clipboard-check"></i>
        </div>
        <div class="text-3xl font-bold mb-1">120</div>
        <div class="text-gray-600 font-semibold">Total Hasil Evaluasi</div>
    </div>

</div>
@endsection
