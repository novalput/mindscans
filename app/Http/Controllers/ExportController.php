<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ScreeningResponse;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    // 1. Student Export Their Own History
    public function studentExportHistory(Request $request)
    {
        $userId = Auth::id();
        $student = Student::with('user')->where('user_id', $userId)->first();
        $history = ScreeningResponse::where('user_id', $userId)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        // If not a student profile, still allow export using User mode
        $user = Auth::user();

        $pdf = Pdf::loadView('exports.my_history', compact('student', 'user', 'history'));
        // paper options
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Riwayat_Tes_Saya.pdf');
    }

    // 2. Lecturer Export Summary of Students
    public function lecturerExportStudents(Request $request)
    {
        $search = $request->input('search');
        $prodi = $request->input('prodi');

        $studentsQuery = Student::with(['user', 'screenings' => function($q) {
            $q->orderBy('created_at', 'desc');
        }]);

        if ($search) {
            $studentsQuery->where(function($q) use ($search) {
                $q->whereHas('user', function($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%");
                })->orWhere('nim', 'like', "%{$search}%");
            });
        }

        if ($prodi) {
            $studentsQuery->where('program_studi', 'like', "%{$prodi}%");
        }

        $students = $studentsQuery->latest()->get();

        // Calculate aggregate stats for the filtered students
        $totalStudents = $students->count();
        $totalTests = 0;
        $totalScore = 0;
        $testCountForAvg = 0;

        foreach ($students as $student) {
            $tests = collect($student->screenings);
            $totalTests += $tests->count();
            foreach ($tests as $t) {
                $totalScore += $t->score;
                $testCountForAvg++;
            }
        }

        $averageScore = $testCountForAvg > 0 ? $totalScore / $testCountForAvg : 0;

        $pdf = Pdf::loadView('exports.students', compact('students', 'totalStudents', 'totalTests', 'averageScore', 'search', 'prodi'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Daftar_Mahasiswa.pdf');
    }

    // 3. Lecturer Export Specific Student Detailed History
    public function lecturerExportStudentHistory($id)
    {
        $student = Student::with('user')->findOrFail($id);
        
        $history = ScreeningResponse::where('user_id', $student->user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('exports.student_history', compact('student', 'history'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Riwayat_Tes_' . $student->nim . '.pdf');
    }
}
