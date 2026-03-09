<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\Admin\LecturerController as AdminLecturerController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\ContentManagementController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ScreeningController;
use App\Models\HealthVisit;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

/*
|--------------------------------------------------------------------------
| Dashboard (Role Based)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $role = Auth::user()->role;

    return match ($role) {
        'lecturer'   => redirect()->route('lecturer.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        'admin'   => redirect()->route('admin.dashboard'),
        default   => abort(403),
    };
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile (Default Laravel)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| LECTURER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:lecturer'])
    ->prefix('lecturer')
    ->name('lecturer.')
    ->group(function () {

        // Dashboard Lecturer
        Route::get('/dashboard', [LecturerController::class, 'dashboard'])->name('dashboard');

        // 1. CMS Kuesioner (Manajemen Soal)
        // Menampilkan list soal berdasarkan tipe
        Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
        Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
        Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');

        // 2. Menu Evaluasi & Export (Medical Checkup)
        Route::get('/evaluasi', [EvaluationController::class, 'index'])->name('evaluasi.index');
        Route::get('/evaluasi/{id}', [EvaluationController::class, 'show'])->name('evaluasi.show');
        Route::get('/evaluasi/{id}/print', [EvaluationController::class, 'printPdf'])->name('evaluasi.print');
        Route::post('/evaluasi/{id}/scan', [EvaluationController::class, 'scanGingivitis'])->name('evaluasi.scan');
        Route::put('/evaluasi/advice/{id}', [EvaluationController::class, 'updateAdvice'])->name('evaluasi.update-advice');

        // 3. Menu Daily Activity (Monitoring)
        Route::get('/monitoring', [MonitoringController::class, 'lecturerIndex'])->name('monitoring.index');
        Route::get('/monitoring/{id}', [MonitoringController::class, 'lecturerShow'])->name('monitoring.show');

        // Manajemen Data Mahasiswa (Hanya Read & History)
        Route::get('/datamahasiswa', [StudentController::class, 'index'])->name('datamahasiswa');
        Route::get('/datamahasiswa/{id}/riwayat', [LecturerController::class, 'studentHistory'])->name('datamahasiswa.history');

        Route::resource('education', ContentManagementController::class);

        Route::post('/visits', function (Illuminate\Http\Request $request) {
            HealthVisit::create([
                'user_id' => $request->user_id,
                'lecturer_id' => Auth::id(),
                'visit_date' => $request->visit_date,
                'consultation_notes' => $request->consultation_notes,
                'treatment_notes' => $request->treatment_notes,
            ]);
            return back()->with('success', 'Data kunjungan berhasil dicatat.');
        })->name('visits.store');
        // Feedback Pasien
        Route::get('/feedback', [FeedbackController::class, 'feedbackIndex'])->name('feedback');
    });

/*
|--------------------------------------------------------------------------
| PASIEN (Student) - Mengikuti struktur Navbar lo
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');

        // Daily Activity (Monitoring) - LOGIC PRE-TEST CHECK ADA DI CONTROLLER
        Route::get('/daily', [MonitoringController::class, 'index'])->name('monitoring.index');
        Route::post('/daily/toggle', [MonitoringController::class, 'toggleBrushing'])->name('monitoring.toggle');

        // Edukasi
        Route::get('/education', [EducationController::class, 'index'])->name('education.index');
        Route::get('/education/{material}', [EducationController::class, 'show'])->name('education.show');

        // Screening / Tes
        // Halaman Riwayat Kuesioner
        Route::get('/kuesioner', [ScreeningController::class, 'index'])->name('screening.index');
        // Halaman Form Soal
        Route::get('/kuesioner/form', [ScreeningController::class, 'show'])->name('screening.show');
        // Simpan Jawaban
        Route::post('/kuesioner/form', [ScreeningController::class, 'store'])->name('screening.store');

        // Sesuai url('/profil') di navbar lo
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Feedback Pasien
        Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
        Route::post('/feedback', [FeedbackController::class, 'feedbackStore'])->name('feedback.store');
    });

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('lecturer', AdminLecturerController::class);

        Route::get('student', [AdminStudentController::class, 'index'])
            ->name('student.index');

        Route::get('student/{user}', [AdminStudentController::class, 'show'])
            ->name('student.show');
    });

/*
|--------------------------------------------------------------------------
| Internal Proxy for External APIs
|--------------------------------------------------------------------------
*/
Route::get('/api-proxy/pddikti/{type}/{keyword}', function($type, $keyword) {
    try {
        $response = Illuminate\Support\Facades\Http::timeout(15)->get("https://api-pddikti.rone.dev/search/{$type}/{$keyword}");
        return response()->json($response->json());
    } catch (\Exception $e) {
        return response()->json(['error' => 'API fetch failed', 'message' => $e->getMessage()], 500);
    }
});

Route::get('/api-proxy/pddikti/profile/dosen/{id}', function($id) {
    try {
        $response = Illuminate\Support\Facades\Http::timeout(15)->get("https://api-pddikti.rone.dev/dosen/profile/{$id}");
        return response()->json($response->json());
    } catch (\Exception $e) {
        return response()->json(['error' => 'API fetch failed', 'message' => $e->getMessage()], 500);
    }
});

Route::get('/api-proxy/pddikti/detail/mhs/{id}', function($id) {
    try {
        $response = Illuminate\Support\Facades\Http::timeout(15)->get("https://api-pddikti.rone.dev/mhs/detail/{$id}");
        return response()->json($response->json());
    } catch (\Exception $e) {
        return response()->json(['error' => 'API fetch failed', 'message' => $e->getMessage()], 500);
    }
});

/*
|--------------------------------------------------------------------------
| Fallback Route (404)
|--------------------------------------------------------------------------
*/
// Menangani semua URL yang tidak terdefinisi
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

require __DIR__ . '/auth.php';
