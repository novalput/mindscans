@extends('layouts.student')

@section('content')
<div class="py-12 bg-[#F8FCFE] min-h-screen">
    <div class="max-w-6xl mx-auto px-6">

        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-100">
            <div class="text-center mb-6">
                <span class="px-4 py-1 bg-sky-100 text-sky-600 rounded-full text-xs font-bold uppercase tracking-widest">
                    {{ $type == 'pre_test' ? 'Evaluasi Awal' : 'Evaluasi Akhir' }}
                </span>
                <h1 class="text-3xl font-sansita font-bold text-slate-800 mt-4">Kuesioner Psikologis</h1>
                <p class="text-slate-500 mt-2">Pilih jawaban yang paling sesuai dengan kondisi yang Anda rasakan selama 2 minggu terakhir.</p>
            </div>

            <div class="mb-8 bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm font-bold text-slate-700">Progres Pengerjaan</span>
                    <span id="progress-text" class="text-sm font-bold text-[#5FAFC1]">0/17 (0%)</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-3">
                    <div id="progress-bar" class="bg-[#5FAFC1] h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <form action="{{ route('student.screening.store', $type) }}" method="POST" id="screeningForm">
                @csrf
                
                @php $stepCounter = 1; @endphp

                {{-- SECTION 1: INSTRUMEN DEPRESI (9 Soal) - Dipecah per 5 --}}
                @foreach($depressionQs->chunk(5) as $index => $chunk)
                <div class="step-container hidden" data-step="{{ $stepCounter }}">
                    <div class="mb-10 p-6 bg-blue-50 rounded-3xl border border-blue-100">
                        <h2 class="text-xl font-bold text-blue-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-brain"></i> 1. Instrumen Depresi (Bagian {{ $index + 1 }})
                        </h2>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-slate-600">
                                <thead class="bg-blue-100 text-blue-800 uppercase text-xs">
                                    <tr>
                                        <th class="px-4 py-3 rounded-l-lg min-w-[250px]">Pernyataan</th>
                                        <th class="px-2 py-3 text-center w-24">Tidak Pernah Sama Sekali (0)</th>
                                        <th class="px-2 py-3 text-center w-24">Beberapa Hari (1)</th>
                                        <th class="px-2 py-3 text-center w-24">Lebih dari Separuh Waktu (2)</th>
                                        <th class="px-2 py-3 text-center rounded-r-lg w-24">Hampir Setiap Hari (3)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chunk as $q)
                                    <tr class="border-b border-blue-100 hover:bg-blue-50/50">
                                        <td class="px-4 py-3 font-medium">{{ $q->order }}. {{ $q->question_text }}</td>
                                        {{-- Beri ID khusus untuk soal nomor 9 agar ditangkap oleh JS --}}
                                        <td class="text-center"><input type="radio" name="q_{{ $q->id }}" value="0" required class="text-blue-500 w-4 h-4 trigger-q9"></td>
                                        <td class="text-center"><input type="radio" name="q_{{ $q->id }}" value="1" required class="text-blue-500 w-4 h-4 trigger-q9"></td>
                                        <td class="text-center"><input type="radio" name="q_{{ $q->id }}" value="2" required class="text-blue-500 w-4 h-4 trigger-q9"></td>
                                        <td class="text-center"><input type="radio" name="q_{{ $q->id }}" value="3" required class="text-blue-500 w-4 h-4 trigger-q9"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @php $stepCounter++; @endphp
                @endforeach

                {{-- SECTION 2: INSTRUMEN KECEMASAN (7 Soal) - Dipecah per 5 --}}
                @foreach($anxietyQs->chunk(5) as $index => $chunk)
                <div class="step-container hidden" data-step="{{ $stepCounter }}">
                    <div class="mb-10 p-6 bg-green-50 rounded-3xl border border-green-100">
                        <h2 class="text-xl font-bold text-green-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-heartbeat"></i> 2. Instrumen Kecemasan (Bagian {{ $index + 1 }})
                        </h2>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-slate-600">
                                <thead class="bg-green-100 text-green-800 uppercase text-xs">
                                    <tr>
                                        <th class="px-4 py-3 rounded-l-lg min-w-[250px]">Pernyataan</th>
                                        <th class="px-2 py-3 text-center w-24">Tidak Pernah Sama Sekali (0)</th>
                                        <th class="px-2 py-3 text-center w-24">Beberapa Hari (1)</th>
                                        <th class="px-2 py-3 text-center w-24">Lebih dari Separuh Waktu (2)</th>
                                        <th class="px-2 py-3 text-center rounded-r-lg w-24">Hampir Setiap Hari (3)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chunk as $q)
                                    <tr class="border-b border-green-100 hover:bg-green-50/50">
                                        <td class="px-4 py-3 font-medium">{{ $q->order }}. {{ $q->question_text }}</td>
                                        <td class="text-center"><input type="radio" name="q_{{ $q->id }}" value="0" required class="text-green-500 w-4 h-4"></td>
                                        <td class="text-center"><input type="radio" name="q_{{ $q->id }}" value="1" required class="text-green-500 w-4 h-4"></td>
                                        <td class="text-center"><input type="radio" name="q_{{ $q->id }}" value="2" required class="text-green-500 w-4 h-4"></td>
                                        <td class="text-center"><input type="radio" name="q_{{ $q->id }}" value="3" required class="text-green-500 w-4 h-4"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @php $stepCounter++; @endphp
                @endforeach

                {{-- SECTION 3: PERTANYAAN DAMPAK FUNGSIONAL (1 Soal) --}}
                @if($impactQ)
                <div class="step-container hidden" data-step="{{ $stepCounter }}">
                    <div class="mb-10 p-6 bg-purple-50 rounded-3xl border border-purple-100">
                        <h2 class="text-xl font-bold text-purple-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-clipboard-list"></i> 3. Dampak Fungsional
                        </h2>
                        <p class="font-medium text-slate-700 mb-4">{{ $impactQ->question_text }}</p>
                        
                        @php $opts = json_decode($impactQ->options, true); @endphp
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach($opts as $key => $val)
                            <label class="flex items-center gap-3 p-4 bg-white border rounded-xl cursor-pointer hover:bg-purple-50 transition-colors">
                                <input type="radio" name="q_{{ $impactQ->id }}" value="{{ $key }}" required class="text-purple-500 focus:ring-purple-500 w-5 h-5">
                                <span class="text-sm font-medium text-slate-700">{{ $val }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @php $stepCounter++; @endphp
                @endif

                {{-- NAVIGATION BUTTONS --}}
                <div class="mt-8 bg-white p-4 rounded-2xl shadow-sm border border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <button type="button" id="btnPrev" class="w-full sm:w-auto px-6 py-3 bg-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-300 transition-all hidden">
                        <i class="fas fa-arrow-left mr-2"></i> Sebelumnya
                    </button>
                    
                    <button type="button" id="btnNext" class="w-full sm:w-auto px-8 py-3 bg-[#5FAFC1] text-white font-bold rounded-xl hover:bg-[#4d97a7] transition-all shadow-md shadow-[#5FAFC1]/30 ml-auto">
                        Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                    </button>

                    <button type="submit" id="btnSubmit" class="w-full sm:w-auto px-10 py-3 bg-[#5FAFC1] text-white font-bold rounded-xl hover:bg-[#4d97a7] transition-all shadow-lg shadow-[#5FAFC1]/30 hidden ml-auto">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Jawaban
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- EMERGENCY MODAL -->
<div id="emergencyModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-8 mx-4 animate-fadeIn">
        
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-2xl"></i>
            </div>

            <h3 class="text-xl font-bold text-slate-800 mb-3">
                Dukungan Penting Untuk Anda
            </h3>

            <p class="text-slate-600 text-sm leading-relaxed mb-6">
                Kami sangat peduli dengan keselamatan Anda. Jawaban Anda menunjukkan bahwa 
                Anda mungkin sedang melalui masa yang berat.
                <br><br>
                Anda tidak perlu menghadapi ini sendirian. Cobalah berbicara dengan seseorang 
                yang Anda percaya — bisa keluarga, sahabat, teman dekat, atau profesional kesehatan mental.
                <br><br>
                Jika Anda merasa dalam kondisi darurat, segera hubungi layanan bantuan atau hotline psikologi terdekat.
                <br><br>
                <strong>Bantuan itu ada, dan Anda layak untuk mendapatkannya.</strong>
            </p>

            <button id="closeEmergencyModal"
                class="px-6 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition">
                Saya Mengerti
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = {{ $stepCounter - 1 }};
    const totalQuestions = 17; // Telah disesuaikan menjadi 17 soal

    const steps = document.querySelectorAll('.step-container');
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const btnSubmit = document.getElementById('btnSubmit');
    const progressText = document.getElementById('progress-text');
    const progressBar = document.getElementById('progress-bar');

    // -- LOGIKA TRIGGER DARURAT (SOAL ID 9) --
    // Mendengarkan perubahan pada radio button khusus soal ID 9
    const triggerRadios = document.querySelectorAll('input[name="q_9"]');
    triggerRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (parseInt(this.value) >= 1) {
                const modal = document.getElementById('emergencyModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    });

    const emergencyModal = document.getElementById('emergencyModal');
    const closeEmergencyModal = document.getElementById('closeEmergencyModal');

    closeEmergencyModal.addEventListener('click', function() {
        emergencyModal.classList.add('hidden');
        emergencyModal.classList.remove('flex');
    });

    // Optional: klik luar modal untuk menutup
    emergencyModal.addEventListener('click', function(e) {
        if (e.target === emergencyModal) {
            emergencyModal.classList.add('hidden');
            emergencyModal.classList.remove('flex');
        }
    });

    // ----------------------------------------

    function updateProgress() {
        const answered = document.querySelectorAll('input[type="radio"]:checked').length;
        const percent = Math.round((answered / totalQuestions) * 100);
        
        progressText.innerText = `${answered}/${totalQuestions} (${percent}%)`;
        progressBar.style.width = `${percent}%`;
    }

    function showStep(step) {
        steps.forEach(s => s.classList.add('hidden'));
        document.querySelector(`.step-container[data-step="${step}"]`).classList.remove('hidden');

        if(step === 1) {
            btnPrev.classList.add('hidden');
        } else {
            btnPrev.classList.remove('hidden');
        }

        if(step === totalSteps) {
            btnNext.classList.add('hidden');
            btnSubmit.classList.remove('hidden');
        } else {
            btnNext.classList.remove('hidden');
            btnSubmit.classList.add('hidden');
        }
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateCurrentStep() {
        const currentStepEl = document.querySelector(`.step-container[data-step="${currentStep}"]`);
        const radios = currentStepEl.querySelectorAll('input[type="radio"]');
        const names = new Set();
        radios.forEach(r => names.add(r.name));

        let allAnswered = true;
        names.forEach(name => {
            if(!currentStepEl.querySelector(`input[name="${name}"]:checked`)) {
                allAnswered = false;
            }
        });

        if(!allAnswered) {
            alert('Mohon jawab semua pertanyaan pada bagian ini sebelum melanjutkan.');
            return false;
        }
        return true;
    }

    btnNext.addEventListener('click', () => {
        if(validateCurrentStep()) {
            currentStep++;
            showStep(currentStep);
        }
    });

    btnPrev.addEventListener('click', () => {
        currentStep--;
        showStep(currentStep);
    });

    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', updateProgress);
    });

    showStep(currentStep);
    updateProgress();
});
</script>
@endsection