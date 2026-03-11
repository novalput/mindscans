@extends('exports.layout')
@section('content')
<div class="text-center mb-20">
    <div>
        <h3 style="margin:0; font-size: 16px;">RIWAYAT HASIL KUESIONER MAHASISWA</h3>
    </div>
</div>

<table class="info-table mb-20">
    <tr>
        <td width="15%" class="info-label">Nama Lengkap</td>
        <td width="35%" class="fw-bold" style="font-size: 14px; color: #065f46;">: {{ $student->user->name ?? '-' }}</td>
        <td width="15%" class="info-label">NIM</td>
        <td width="35%" class="fw-bold">: {{ $student->nim }}</td>
    </tr>
    <tr>
        <td class="info-label">Program Studi</td>
        <td class="fw-bold">: {{ $student->program_studi }}</td>
        <td class="info-label">Jenis Kelamin</td>
        <td class="fw-bold">: {{ ucfirst($student->gender) }}</td>
    </tr>
    <tr>
        <td class="info-label">Total Tes</td>
        <td class="fw-bold" style="color: #059669;">: {{ $history->count() }} Kali Evaluasi</td>
    </tr>
</table>

@foreach($history as $index => $test)
    @php
        $detail = json_decode($test->answers_detail, true);
        $depDet = $detail['depression'] ?? null;
        $anxDet = $detail['anxiety'] ?? null;
        $impDet = $detail['impact'] ?? null;
    @endphp
    <div class="card" style="page-break-inside: avoid;">
        <div class="card-header">
            EVALUASI #{{ $history->count() - $index }} &nbsp;&nbsp;|&nbsp;&nbsp; TANGGAL: {{ $test->created_at->format('d M Y, H:i') }} WIB
        </div>
        <table class="table-data mb-10">
            <tr>
                <th width="40%">Kategori Evaluasi</th>
                <th width="20%">Skor</th>
                <th width="40%">Tingkat Keparahan</th>
            </tr>
            <tr>
                <td style="font-weight: bold; color: #334155;">Indikasi Depresi</td>
                <td class="text-center highlight-text">{{ $depDet['score'] ?? '-' }}</td>
                <td class="text-center">{{ $depDet['category'] ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; color: #334155;">Indikasi Kecemasan</td>
                <td class="text-center highlight-text">{{ $anxDet['score'] ?? '-' }}</td>
                <td class="text-center">{{ $anxDet['category'] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="3" style="border: none; padding: 4px;"></td>
            </tr>
            <tr class="highlight-row">
                <td class="fw-bold" style="color: #065f46; text-transform: uppercase;">Total Diagnosis</td>
                <td class="fw-bold text-center" style="color: #065f46; font-size: 14px;">{{ $test->score }}</td>
                <td class="fw-bold text-center" style="color: #065f46;">{{ $test->category }}</td>
            </tr>
        </table>
        
        <div style="background-color: #f8fafc; padding: 10px; border-radius: 4px; border-left: 3px solid #34d399; font-size: 11px;">
            <p style="margin:0 0 4px 0;"><strong><span style="color: #0f172a;">Dampak Kegiatan Sehari-hari:</span></strong> <span style="color: #475569;">{{ $impDet['text_answer'] ?? '-' }}</span></p>
            <p style="margin:0 0 4px 0;"><strong><span style="color: #0f172a;">Rekomendasi Depresi:</span></strong> <span style="color: #475569;">{{ $depDet['recommendation'] ?? '-' }}</span></p>
            <p style="margin:0;"><strong><span style="color: #0f172a;">Rekomendasi Kecemasan:</span></strong> <span style="color: #475569;">{{ $anxDet['recommendation'] ?? '-' }}</span></p>
        </div>
    </div>
@endforeach

@endsection
