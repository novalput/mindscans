@extends('layouts.app')

@section('content')
<div class="py-12 bg-[#F8FCFE] min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        {{-- Header Section --}}
        <div class="mb-10 text-center">
            <h1 class="text-4xl md:text-5xl font-sansita font-bold text-slate-800 tracking-tight">Riwayat Evaluasi Harian</h1>
            <p class="text-slate-500 mt-3 md:text-lg max-w-2xl mx-auto">Pantau perkembangan kesehatan mental Anda dari waktu ke waktu melalui grafik dan catatan evaluasi.</p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-600 flex items-center gap-3 shadow-sm animate-fadeIn">
                <i class="fas fa-exclamation-circle text-xl"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 flex items-center gap-3 shadow-sm animate-fadeIn">
                <i class="fas fa-check-circle text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Top Action Card & Info --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="md:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-slate-100 flex flex-col justify-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-sky-50 rounded-bl-full opacity-50"></div>
                
                <h2 class="text-2xl font-bold text-slate-800 mb-2 relative z-10">Evaluasi Hari Ini</h2>
                <p class="text-slate-500 mb-6 relative z-10">Isi kuesioner harian untuk mencatat kondisi psikologis Anda. Evaluasi ini hanya dapat dilakukan 1 kali sehari (Waktu reset: 00:00 WIB).</p>
                
                <div class="relative z-10">
                    @if($canTakeTest)
                        <a href="{{ route('lecturer.screening.show') }}" class="inline-flex items-center justify-center gap-2 px-4 md:px-8 py-3 w-full sm:w-auto bg-[#5FAFC1] text-white font-bold rounded-xl hover:bg-[#4d97a7] transition-all shadow-lg shadow-[#5FAFC1]/30 hover:-translate-y-0.5">
                            <i class="fas fa-clipboard-check text-lg"></i>
                            Mulai Evaluasi Sekarang
                        </a>
                    @else
                        <button disabled class="inline-flex items-center justify-center gap-2 px-4 md:px-8 py-3 w-full sm:w-auto bg-slate-100 text-slate-400 font-bold rounded-xl border border-slate-200 cursor-not-allowed">
                            <i class="fas fa-check-circle text-lg text-emerald-500"></i>
                            Evaluasi Hari Ini Selesai
                        </button>
                        <p class="text-xs text-orange-500 font-medium mt-3 italic">* Anda sudah menyelesaikan tes untuk hari ini. Silakan kembali besok setelah pukul 00:00 WIB.</p>
                    @endif
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#5FAFC1] to-[#408f9f] rounded-3xl p-8 shadow-md text-white flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm mb-4">
                    <i class="fas fa-chart-line text-3xl"></i>
                </div>
                <h3 class="text-4xl font-sansita font-bold mb-1">{{ count($history) }}</h3>
                <p class="text-sky-100 font-medium text-sm md:text-base uppercase tracking-wider">Total Evaluasi</p>
            </div>
        </div>

        {{-- Chart Section --}}
        @if(count($history) > 0)
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 mb-10">
            <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                <i class="fas fa-chart-area text-[#5FAFC1]"></i> Tren Kondisi Psikologis
            </h2>
            <div class="h-[300px] md:h-[400px] w-full relative">
                <canvas id="historyChart"></canvas>
            </div>
            <p class="text-center text-xs text-slate-400 mt-4">* Grafik menunjukkan fluktuasi skor total (Depresi + Kecemasan). Skor yang lebih tinggi mengindikasikan tingkat gejala yang lebih berat.</p>
        </div>

        {{-- History Table --}}
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 mb-10 overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-list text-[#5FAFC1]"></i> Catatan Riwayat Lengkap
                </h2>
                <a href="{{ route('lecturer.screening.export') }}" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl transition-all shadow-sm flex items-center gap-2 text-sm">
                    <i class="fas fa-file-pdf"></i> Export Riwayat ke PDF
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 rounded-tl-xl whitespace-nowrap">Tanggal & Waktu</th>
                            <th scope="col" class="px-6 py-4 text-center whitespace-nowrap">Skor Total</th>
                            <th scope="col" class="px-6 py-4 min-w-[250px]">Kategori & Rekomendasi</th>
                            <th scope="col" class="px-6 py-4 text-center rounded-tr-xl whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $item)
                        @php
                            $details = is_array($item->answers_detail) ? $item->answers_detail : json_decode($item->answers_detail, true);
                            $isHighRisk = str_contains($item->category, '[! RISIKO TINGGI !]');
                        @endphp
                        <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="font-bold text-slate-800">{{ $item->created_at->timezone('Asia/Jakarta')->format('d M Y') }}</div>
                                <div class="text-xs text-slate-400 mt-1"><i class="far fa-clock mr-1"></i> {{ $item->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full font-bold text-sm
                                    {{ $item->score >= 15 ? 'bg-red-100 text-red-600' : 
                                    ($item->score >= 10 ? 'bg-orange-100 text-orange-600' : 
                                    ($item->score >= 5 ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600')) }}">
                                    {{ $item->score }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-[13px] leading-relaxed">
                                    <div class="mb-1">{!! str_replace(' | ', '<br>', e($item->category)) !!}</div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <button onclick="openDetailModal({{ $item->id }})" class="px-4 py-2 bg-sky-50 text-sky-600 hover:bg-sky-100 font-semibold rounded-lg text-xs transition-colors whitespace-nowrap">
                                    <i class="fas fa-eye mr-1"></i> Lihat
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Detail untuk Item Ini -->
                        <div id="modal-{{ $item->id }}" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300 flex items-center justify-center px-4">
                            <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col transform scale-95 transition-transform duration-300">
                                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-800">Detail Evaluasi</h3>
                                        <p class="text-xs text-slate-500 mt-1">{{ $item->created_at->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB</p>
                                    </div>
                                    <button onclick="closeDetailModal({{ $item->id }})" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-200 text-slate-500 hover:bg-red-100 hover:text-red-500 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="p-6 overflow-y-auto">
                                    
                                    @if($isHighRisk)
                                    <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4 flex gap-4">
                                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-red-700 text-sm mb-1">Peringatan Kondisi Risiko Tinggi</h4>
                                            <p class="text-xs text-red-600 leading-relaxed">Hasil evaluasi ini menunjukkan indikasi kuat yang memerlukan perhatian khusus. Sangat disarankan untuk segera berkonsultasi dengan profesional kesehatan mental, konselor, atau layanan bantuan darurat terdekat.</p>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                        {{-- Depresi --}}
                                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4">
                                            <div class="flex justify-between items-start mb-2">
                                                <h4 class="font-bold text-blue-800 text-sm">Indikasi Depresi</h4>
                                                <span class="bg-white text-blue-600 px-2 py-1 rounded text-xs font-bold shadow-sm">Skor: {{ $details['depression']['score'] ?? '-' }}</span>
                                            </div>
                                            <p class="text-xs font-semibold text-blue-700 mb-1">Kategori: {{ $details['depression']['category'] ?? '-' }}</p>
                                            <p class="text-[11px] text-blue-600 leading-relaxed">{{ $details['depression']['recommendation'] ?? 'Tidak ada rekomendasi spesifik.' }}</p>
                                        </div>

                                        {{-- Kecemasan --}}
                                        <div class="bg-green-50 border border-green-100 rounded-2xl p-4">
                                            <div class="flex justify-between items-start mb-2">
                                                <h4 class="font-bold text-green-800 text-sm">Indikasi Kecemasan</h4>
                                                <span class="bg-white text-green-600 px-2 py-1 rounded text-xs font-bold shadow-sm">Skor: {{ $details['anxiety']['score'] ?? '-' }}</span>
                                            </div>
                                            <p class="text-xs font-semibold text-green-700 mb-1">Kategori: {{ $details['anxiety']['category'] ?? '-' }}</p>
                                            <p class="text-[11px] text-green-600 leading-relaxed">{{ $details['anxiety']['recommendation'] ?? 'Tidak ada rekomendasi spesifik.' }}</p>
                                        </div>
                                    </div>

                                    {{-- Dampak Fungsional --}}
                                    @if(isset($details['impact']))
                                    <div class="bg-purple-50 border border-purple-100 rounded-2xl p-4 mb-4">
                                        <h4 class="font-bold text-purple-800 text-sm mb-2"><i class="fas fa-briefcase-medical mr-2"></i>Dampak Terhadap Fungsi Sehari-hari</h4>
                                        <div class="bg-white rounded-xl p-3 border border-purple-100">
                                            <span class="text-xs font-medium text-slate-500 block mb-1">Tingkat Kesulitan:</span>
                                            <span class="text-sm font-bold text-purple-700">{{ $details['impact']['text_answer'] ?? 'Tidak Terjawab' }}</span>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Rekomendasi Penanganan Admin --}}
                                    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4 mb-4">
                                        <h4 class="font-bold text-indigo-800 text-sm mb-2"><i class="fas fa-user-md mr-2"></i>Rekomendasi Penanganan / Kegiatan dari Admin</h4>
                                        <div class="bg-white rounded-xl p-3 border border-indigo-100">
                                            <p class="text-sm text-indigo-700 leading-relaxed">{{ $item->admin_intervention ?? 'Admin belum memberikan rekomendasi penanganan/kegiatan.' }}</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="p-5 border-t border-slate-100 bg-slate-50 flex justify-end">
                                    <button onclick="closeDetailModal({{ $item->id }})" class="px-6 py-2.5 bg-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-300 transition-colors text-sm">Tutup</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="bg-white rounded-3xl p-12 shadow-sm border border-slate-100 text-center mb-10">
            <div class="w-24 h-24 mx-auto bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-6">
                <i class="fas fa-clipboard text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Riwayat Kuesioner</h3>
            <p class="text-slate-500 max-w-md mx-auto">Anda belum pernah mengisi kuesioner evaluasi harian. Silakan isi evaluasi pertama Anda melalui tombol di atas.</p>
        </div>
        @endif

    </div>
</div>

{{-- Tambahkan Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Modal Logic
    function openDetailModal(id) {
        const modal = document.getElementById('modal-' + id);
        const modalInner = modal.querySelector('div');
        
        modal.classList.remove('hidden');
        // Force reflow
        void modal.offsetWidth;
        
        modal.classList.remove('opacity-0');
        modalInner.classList.remove('scale-95');
        modalInner.classList.add('scale-100');
    }

    function closeDetailModal(id) {
        const modal = document.getElementById('modal-' + id);
        const modalInner = modal.querySelector('div');
        
        modal.classList.add('opacity-0');
        modalInner.classList.remove('scale-100');
        modalInner.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Tutup modal jika klik background gelap
    document.addEventListener('click', function(event) {
        const openModals = document.querySelectorAll('div[id^="modal-"]:not(.hidden)');
        openModals.forEach(modal => {
            if (event.target === modal) {
                const id = modal.id.replace('modal-', '');
                closeDetailModal(id);
            }
        });
    });

    // Chart.js Logic
    @if(count($history) > 0)
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('historyChart').getContext('2d');
        
        // Data dari PHP
        const rawLabels = {!! json_encode($chartLabels) !!};
        const rawData = {!! json_encode($chartScores) !!};
        
        // Buat gradien untuk area di bawah garis
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(95, 175, 193, 0.5)'); // Area atas (warna sekunder)
        gradient.addColorStop(1, 'rgba(95, 175, 193, 0.0)'); // Transparan di bawah

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: rawLabels,
                datasets: [{
                    label: 'Skor Total (Depresi + Kecemasan)',
                    data: rawData,
                    borderColor: '#5FAFC1',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#FFFFFF',
                    pointBorderColor: '#5FAFC1',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4 // Membuat garis melengkung halus
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda bawaan
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { size: 13, family: "'Roboto', sans-serif" },
                        bodyFont: { size: 14, weight: 'bold', family: "'Roboto', sans-serif" },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Skor: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: { family: "'Roboto', sans-serif", size: 11 },
                            color: '#94a3b8',
                            maxRotation: 45,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: 54, // Maksimal skor: 27 (Depresi) + 21 (Kecemasan) + sedikit margin
                        border: { display: false },
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false
                        },
                        ticks: {
                            font: { family: "'Roboto', sans-serif", size: 11 },
                            color: '#94a3b8',
                            stepSize: 10
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
    @endif
</script>
@endsection
