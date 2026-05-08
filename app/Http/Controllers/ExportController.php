<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biodata;
use App\Models\User;
use App\Models\ScreeningResponse;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    // 1. Student Export Their Own History
    public function studentExportHistory(Request $request)
    {
        $userId = Auth::id();
        $user = User::with('biodata')->findOrFail($userId);
        $history = ScreeningResponse::where('user_id', $userId)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        $pdf = Pdf::loadView('exports.my_history', compact('user', 'history'));
        // paper options
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Riwayat_Tes_Saya.pdf');
    }

    // 2. Lecturer Export Summary of Students
    public function lecturerExportStudents(Request $request)
    {
        $search = $request->input('search');
        $prodi = $request->input('prodi');

        $studentsQuery = User::where('sub_role', 'student')->with(['biodata', 'screeningResponses' => function($q) {
            $q->orderBy('created_at', 'desc');
        }]);

        if ($search) {
            $studentsQuery->where('name', 'like', "%{$search}%");
        }

        if ($prodi) {
            $studentsQuery->whereHas('biodata', function ($q) use ($prodi) {
                $q->where('prodi', 'like', "%{$prodi}%");
            });
        }

        $students = $studentsQuery->latest()->get();

        // Calculate aggregate stats for the filtered students
        $totalStudents = $students->count();
        $totalTests = 0;
        $totalScore = 0;
        $testCountForAvg = 0;

        foreach ($students as $student) {
            $tests = collect($student->screeningResponses);
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
        $student = User::where('sub_role', 'student')->with('biodata')->findOrFail($id);
        
        $history = ScreeningResponse::where('user_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('exports.student_history', compact('student', 'history'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Riwayat_Tes_' . $student->id . '.pdf');
    }
}
