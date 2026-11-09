@extends('layouts.app')

@section('title', 'Healthcare Professional Dashboard')

@section('content')

<div class="space-y-6 pt-6">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Dashboard</h2>
            <p class="text-slate-500 mt-1">Monitor patient screening summaries</p>
        </div>
    </div>

    {{-- =================== SECTION SUMMARY CARDS =================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        {{-- Card 1: Total Kuisioner Diisi --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-indigo-50 rounded-full group-hover:bg-indigo-100 transition-colors z-0"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <span class="text-slate-500 text-sm font-semibold uppercase tracking-wider">Patient Screenings</span>
                    <h3 class="text-4xl font-bold text-slate-800 mt-2">{{ $totalQuestionnaires }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-file-contract"></i>
                </div>
            </div>
            <div class="relative z-10 mt-2 text-xs text-slate-400 font-medium tracking-wide">
                {{ auth()->user()->biodata->nama_kampus ?? 'Semua Kampus' }}
            </div>
        </div>

        {{-- Card 2: Rata-Rata Skor Mental --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-cyan-50 rounded-full group-hover:bg-cyan-100 transition-colors z-0"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <span class="text-slate-500 text-sm font-semibold uppercase tracking-wider">Rata-Rata Skor Mental</span>
                    <h3 class="text-4xl font-bold text-slate-800 mt-2">{{ $averageScore }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-brain"></i>
                </div>
            </div>
        </div>

        {{-- Card 3: Warning Perlu Perhatian (Skor 18-27) --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-rose-50 rounded-full group-hover:bg-rose-100 transition-colors z-0"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <span class="text-slate-500 text-sm font-semibold uppercase tracking-wider">Warning Perlu Perhatian</span>
                    <h3 class="text-4xl font-bold text-rose-600 mt-2">{{ $warningCount }} <span class="text-base font-medium text-slate-500">Orang</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
            <div class="relative z-10 mt-2 text-xs text-slate-400">Terhitung dari rata-rata individu dengan skor {{ $warningThreshold }} - {{ $maxTotalScore }}</div>
        </div>

    </div>

    {{-- =================== SECTION CHART & FILTER =================== --}}
    <section class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 mt-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
            <div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">Grafik Pengisian Kuesioner</h3>
                <p class="text-sm text-slate-500">Statistik harian untuk periode ini</p>
            </div>
            
            <form id="monthFilterForm" action="{{ route('lecturer.dashboard') }}" method="GET" class="flex items-center gap-3">
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

    {{-- =================== SECTION RECENT STUDENTS =================== --}}
    <section class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 mt-6 overflow-hidden">
        <h3 class="text-xl font-bold text-slate-800 mb-6 tracking-tight">5 Most Recent Patients</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-200">
                        <th class="py-3 px-4 font-semibold text-center">No</th>
                        <th class="py-3 px-4 font-semibold">Patient Name</th>
                        <th class="py-3 px-4 font-semibold">Tanggal & Waktu</th>
                        <th class="py-3 px-4 font-semibold text-center">Skor Mental</th>
                        <th class="py-3 px-4 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentStudents as $index => $response)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-4 text-center text-slate-500">{{ $index + 1 }}</td>
                            <td class="py-4 px-4 font-medium text-slate-800">
                                {{ $response->user->name ?? 'Patient (No Data)' }}
                            </td>
                            <td class="py-4 px-4 text-slate-600">
                                {{ \Carbon\Carbon::parse($response->created_at)->format('d M Y - H:i') }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="font-bold {{ $response->score >= $warningThreshold ? 'text-rose-600' : 'text-slate-800' }}">
                                    {{ $response->score }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if($response->score >= $warningThreshold)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 border border-rose-200">
                                        Perlu Perhatian
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Normal / Aman
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fa-solid fa-folder-open text-3xl"></i>
                                    <p>Belum ada data kuesioner yang diisi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>

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
                        label: 'Skor Warning (> ' + {{ $warningThreshold - 1 }} + ')',
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
