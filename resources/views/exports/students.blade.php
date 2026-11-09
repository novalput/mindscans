@extends('exports.layout')
@section('content')
<div class="text-center mb-20">
    <div class="title-box">
        <h3 style="margin:0; font-size: 16px;">PATIENT DATA REPORT</h3>
    </div>
    @if($prodi)
    <p style="margin:5px 0; font-weight: bold; color: #047857;">Program Studi: {{ $prodi }}</p>
    @endif
</div>

<table class="table-data mb-20">
    <tr>
        <th>Total Patients</th>
        <th>Total Tes Kuesioner</th>
        <th>Rata-rata Skor Mental</th>
    </tr>
    <tr class="text-center">
        <td>{{ $totalStudents }}</td>
        <td>{{ $totalTests }}</td>
        <td>{{ number_format($averageScore, 1) }}</td>
    </tr>
</table>

<table class="table-data">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Gender</th>
            <th>Prodi</th>
            <th>Total Tes</th>
            <th>Terakhir Tes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $index => $student)
        @php
            $tests = $student->screeningResponses;
            $testCount = $tests->count();
            $lastTest = $testCount > 0 ? $tests->first()->created_at->format('d M Y') : 'Belum Pernah';
        @endphp
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $student->name ?? '-' }}</td>
            <td>{{ ucfirst($student->biodata?->jenis_kelamin ?? '-') }}</td>
            <td>{{ $student->biodata?->prodi ?? '-' }}</td>
            <td class="text-center">{{ $testCount }}</td>
            <td class="text-center">{{ $lastTest }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
