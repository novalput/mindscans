@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    {{-- Total Admin --}}
    <div class="bg-white rounded-xl p-6 shadow-md border-l-8 border-green-500 hover:shadow-lg transition-transform transform hover:-translate-y-1">
        <div class="text-green-500 text-4xl mb-3">
            <i class="fa-solid fa-user-shield"></i>
        </div>
        <div class="text-3xl font-bold mb-1">{{ number_format($adminCount) }}</div>
        <div class="text-gray-600 font-semibold">Total Admin</div>
    </div>

    {{-- Total Responden --}}
    <div class="bg-white rounded-xl p-6 shadow-md border-l-8 border-emerald-500 hover:shadow-lg transition-transform transform hover:-translate-y-1">
        <div class="text-emerald-500 text-4xl mb-3">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="text-3xl font-bold mb-1">{{ number_format($respondenCount) }}</div>
        <div class="text-gray-600 font-semibold">Total Responden</div>
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

<section class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 mt-6">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
        <div>
            <h3 class="text-xl font-bold text-slate-800 tracking-tight">Tren Grafik Pengisian Kuesioner</h3>
            <p class="text-sm text-slate-500">Statistik harian untuk periode ini</p>
        </div>
        
        <form id="monthFilterForm" action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-3">
            <label for="month" class="text-sm font-medium text-slate-600">Pilih Bulan:</label>
            <input type="month" id="month" name="month" value="{{ $filterMonth }}" 
                   class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors"
                   onchange="document.getElementById('monthFilterForm').submit();">
        </form>
    </div>

    <div class="w-full h-[350px]">
        <canvas id="screeningChart"></canvas>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('screeningChart').getContext('2d');
        
        const chartLabels = {!! json_encode($chartLabels) !!};
        const chartTotalKuesioner = {!! json_encode($chartTotalKuesioner) !!};
        const chartTotalWarning = {!! json_encode($chartTotalWarning) !!};
        const chartScoreDetails = {!! json_encode($chartScoreDetails) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Total Kuesioner',
                        data: chartTotalKuesioner,
                        borderColor: '#4f46e5', // indigo-600
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#4f46e5',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Skor Warning (18-27)',
                        data: chartTotalWarning,
                        borderColor: '#e11d48', // rose-600
                        backgroundColor: 'rgba(225, 29, 72, 0.1)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#e11d48',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: "'Quicksand', sans-serif",
                                size: 13
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)', // slate-900
                        titleFont: {
                            family: "'Quicksand', sans-serif",
                            size: 14
                        },
                        bodyFont: {
                            family: "'Quicksand', sans-serif",
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            afterBody: function(context) {
                                const dataIndex = context[0].dataIndex;
                                const details = chartScoreDetails[dataIndex];
                                
                                if (!details || Object.keys(details).length === 0) {
                                    return '';
                                }

                                let lines = ['', 'Detail Poin (Skor):'];
                                for (const [score, count] of Object.entries(details)) {
                                    lines.push(`- Skor ${score}: ${count} orang`);
                                }
                                return lines;
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
                            font: {
                                family: "'Quicksand', sans-serif"
                            },
                            color: '#64748b' // slate-500
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9', // slate-100
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                family: "'Quicksand', sans-serif"
                            },
                            color: '#64748b' // slate-500
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
