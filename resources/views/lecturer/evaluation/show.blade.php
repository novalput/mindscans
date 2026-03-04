@extends('layouts.app')

@section('content')
<script>
    function submitScan() {
        const labelBtn = document.getElementById('labelBtn');
        const loading = document.getElementById('loading');
        const scanForm = document.getElementById('scanForm');
        if (scanForm) {
            if (labelBtn) labelBtn.classList.add('hidden');
            if (loading) loading.classList.remove('hidden');
            scanForm.submit();
        }
    }

    function fillAdvice(text) {
        const textarea = document.getElementById('lecturer_advice_textarea');
        if (textarea) {
            textarea.value = text;
            textarea.focus();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const img = document.getElementById('studentImage');
        const canvas = document.getElementById('detectionCanvas');
        const rawData = '{!! $latestScan->detection_result ?? "[]" !!}';
        let predictions = [];

        try {
            predictions = JSON.parse(rawData);
        } catch (e) {
            console.error(e);
        }

        if (!img || !canvas || predictions.length === 0) {
            if (img) img.style.opacity = '1';
            return;
        }

        const ctx = canvas.getContext('2d');

        function drawDetections() {
            canvas.width = img.clientWidth;
            canvas.height = img.clientHeight;
            const ratioX = canvas.width / img.naturalWidth;
            const ratioY = canvas.height / img.naturalHeight;

            predictions.forEach(p => {
                const w = p.width * ratioX;
                const h = p.height * ratioY;
                const x = (p.x * ratioX) - (w / 2);
                const y = (p.y * ratioY) - (h / 2);
                let color = p.class.toLowerCase().includes('mgi4') ? '#f43f5e' : '#f97316';

                ctx.strokeStyle = color;
                ctx.lineWidth = 3;
                ctx.setLineDash([5, 3]); // Membuat garis putus-putus lebih modern
                ctx.strokeRect(x, y, w, h);

                ctx.fillStyle = color;
                ctx.font = "bold 10px Inter, sans-serif";
                ctx.fillRect(x, y - 18, ctx.measureText(p.class).width + 10, 18);
                ctx.fillStyle = "white";
                ctx.fillText(p.class, x + 5, y - 5);
            });
            img.style.opacity = '1';
        }
        if (img.complete) drawDetections();
        else img.onload = drawDetections;
        window.addEventListener('resize', drawDetections);
    });
</script>

<div class="max-w-6xl mx-auto space-y-8 pb-12">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-5">
            <a href="{{ route('lecturer.evaluasi.index') }}" class="group w-12 h-12 flex items-center justify-center rounded-2xl bg-white shadow-sm border border-gray-100 hover:bg-gray-50 transition-all">
                <i class="fa-solid fa-arrow-left text-gray-400 group-hover:text-blue-500"></i>
            </a>
            <div>
                <h2 class="text-2xl font-black text-gray-800 tracking-tight">{{ $student->name }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider">ID: #{{ $student->id }}</span>
                    <span class="text-gray-300 text-xs">•</span>
                    <span class="text-gray-500 text-xs font-medium">{{ $student->student->gender ?? 'Pasien' }}</span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('lecturer.evaluasi.print', $student->id) }}" target="_blank" class="flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-2xl font-bold text-sm shadow-sm hover:shadow-md transition-all">
                <i class="fa-solid fa-print text-blue-500"></i> Cetak Laporan
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        {{-- Left: Scanner & Visual Evidence --}}
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2 text-sm uppercase tracking-widest">
                        <i class="fa-solid fa-scan text-blue-500"></i> Visual Analisa AI
                    </h3>
                    @if($latestScan)
                    <span class="text-[10px] font-bold text-gray-400 italic">Terakhir Scan: {{ $latestScan->created_at->diffForHumans() }}</span>
                    @endif
                </div>

                <div class="p-8">
                    @if($latestScan)
                    <div class="relative rounded-[2rem] overflow-hidden shadow-2xl bg-gray-900 group">
                        <img id="studentImage" src="{{ asset('storage/' . $latestScan->gingivitis_image) }}" class="w-full h-auto block opacity-0 transition-opacity duration-700">
                        <canvas id="detectionCanvas" class="absolute top-0 left-0 w-full h-full pointer-events-none"></canvas>
                    </div>
                    @else
                    <div class="aspect-video bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400">
                        <i class="fa-solid fa-image text-4xl mb-3"></i>
                        <p class="text-sm font-medium">Belum ada data visual</p>
                    </div>
                    @endif

                    {{-- Legend / Dictionary --}}
                    @if($latestScan)
                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @php
                        $preds = json_decode($latestScan->detection_result, true) ?? [];
                        $foundClasses = collect($preds)->pluck('class')->unique()->toArray();
                        @endphp
                        @foreach(['MGI2' => 'Ringan', 'MGI3' => 'Sedang', 'MGI4' => 'Berat'] as $key => $lbl)
                        <div class="p-3 rounded-2xl border {{ in_array($key, $foundClasses) ? 'bg-white border-blue-100 shadow-sm' : 'bg-gray-50 border-transparent opacity-50' }}">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full {{ $key == 'MGI4' ? 'bg-rose-500' : 'bg-orange-500' }}"></span>
                                <span class="text-[10px] font-black text-gray-800 uppercase">{{ $key }}</span>
                            </div>
                            <p class="text-[10px] text-gray-500 font-medium">Kategori: {{ $lbl }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Action: Upload New --}}
            <form action="{{ route('lecturer.evaluasi.scan', $student->id) }}" method="POST" enctype="multipart/form-data" id="scanForm">
                @csrf
                <input type="file" name="image" id="fileScan" class="hidden" accept="image/*" capture="environment" onchange="submitScan()">
                <label for="fileScan" id="labelBtn" class="flex items-center justify-between p-6 bg-blue-600 rounded-[2rem] cursor-pointer hover:bg-blue-700 transition-all shadow-xl shadow-blue-100 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-white text-xl">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                        <div>
                            <p class="text-white font-bold text-sm">Ambil Foto Gusi Baru</p>
                            <p class="text-blue-100 text-[10px] uppercase tracking-wider font-medium">AI akan menganalisa secara otomatis</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-plus text-white/50 group-hover:translate-x-1 transition-transform"></i>
                </label>
                <div id="loading" class="hidden p-6 bg-white rounded-[2rem] border border-gray-100 shadow-sm text-center">
                    <div class="flex items-center justify-center gap-3">
                        <div class="w-5 h-5 border-3 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                        <span class="text-sm font-bold text-blue-600 tracking-widest uppercase">AI Sedang Menganalisa...</span>
                    </div>
                </div>
            </form>
        </div>

        {{-- Right: Medical Records & Advice --}}
        <div class="lg:col-span-5 space-y-6">
            {{-- Score Card --}}
            <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl">
                <div class="relative z-10">
                    <h3 class="text-xs font-black text-blue-400 uppercase tracking-widest mb-6">Hasil Kuesioner</h3>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between group">
                            <div>
                                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-tighter">Pre-Test Knowledge</p>
                                <p class="text-lg font-bold">{{ $preTest->category ?? 'N/A' }}</p>
                            </div>
                            <div class="text-3xl font-black text-blue-500 opacity-80 group-hover:opacity-100 transition-all">{{ $preTest->score ?? '-' }}</div>
                        </div>
                        <div class="h-px bg-white/10 w-full"></div>
                        <div class="flex items-center justify-between group">
                            <div>
                                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-tighter">Post-Test Knowledge</p>
                                <p class="text-lg font-bold">{{ $postTest->category ?? 'N/A' }}</p>
                            </div>
                            <div class="text-3xl font-black text-green-500 opacity-80 group-hover:opacity-100 transition-all">{{ $postTest->score ?? '-' }}</div>
                        </div>
                    </div>
                </div>
                {{-- Decorative element --}}
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl"></div>
            </div>

            {{-- Lecturer Advice --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
                <h3 class="font-bold text-gray-800 text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-user-md text-green-500"></i> Saran Profesional
                </h3>

                <form action="{{ route('lecturer.evaluasi.update-advice', $latestScan->id ?? 0) }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')
                    <textarea id="lecturer_advice_textarea" name="lecturer_advice" rows="5"
                        class="w-full rounded-[1.5rem] border-gray-100 bg-gray-50/50 p-5 text-sm focus:ring-4 focus:ring-blue-500/10 focus:bg-white outline-none border transition-all placeholder:text-gray-400 leading-relaxed"
                        placeholder="Tuliskan diagnosa manual atau instruksi perawatan...">{{ $latestScan->lecturer_advice ?? '' }}</textarea>

                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="fillAdvice('Hasil tergolong Minimal/Normal. Tetap jaga gaya hidup sehat dan istirahat yang cukup.')" class="px-4 py-2 bg-gray-50 hover:bg-green-50 hover:text-green-700 rounded-xl text-[10px] font-bold text-gray-500 transition-all border border-transparent hover:border-green-100">Normal</button>
                        
                        <button type="button" onclick="fillAdvice('Terdapat indikasi Ringan (Mild). Lakukan edukasi mandiri, meditasi, dan pemantauan berkala.')" class="px-4 py-2 bg-gray-50 hover:bg-yellow-50 hover:text-yellow-700 rounded-xl text-[10px] font-bold text-gray-500 transition-all border border-transparent hover:border-yellow-100">Ringan</button>
                        
                        <button type="button" onclick="fillAdvice('Terdapat indikasi Sedang (Moderate). Disarankan segera menjadwalkan konsultasi dengan konselor atau psikolog.')" class="px-4 py-2 bg-gray-50 hover:bg-orange-50 hover:text-orange-700 rounded-xl text-[10px] font-bold text-gray-500 transition-all border border-transparent hover:border-orange-100">Sedang</button>
                        
                        <button type="button" onclick="fillAdvice('Terdapat indikasi Sedang-Berat (Moderate to Severe). Sangat disarankan mencari bantuan profesional segera.')" class="px-4 py-2 bg-gray-50 hover:bg-orange-50 hover:text-orange-700 rounded-xl text-[10px] font-bold text-gray-500 transition-all border border-transparent hover:border-orange-100">Sedang-Berat</button>

                        <button type="button" onclick="fillAdvice('Indikasi Berat (Severe). Intervensi medis/psikiatri dan pendampingan segera diperlukan.')" class="px-4 py-2 bg-gray-50 hover:bg-red-50 hover:text-red-700 rounded-xl text-[10px] font-bold text-gray-500 transition-all border border-transparent hover:border-red-100">Berat</button>
                    </div>

                    <button type="submit" @if(!$latestScan) disabled @endif class="w-full bg-gray-900 hover:bg-black text-white font-bold py-4 rounded-2xl text-[11px] uppercase tracking-[0.2em] shadow-xl transition-all flex items-center justify-center gap-2 disabled:opacity-20">
                        Simpan Evaluasi <i class="fa-solid fa-paper-plane text-[9px] text-blue-400"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');

    body {
        font-family: 'Inter', sans-serif;
        background-color: #fcfcfd;
    }
</style>
@endsection
