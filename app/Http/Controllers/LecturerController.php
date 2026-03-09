<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\ScreeningResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LecturerController extends Controller
{
    public function dashboard(Request $request)
    {
        // 1. Total kuisioner diisi
        $totalQuestionnaires = ScreeningResponse::count();

        // 2. Rata-rata skor mental
        $averageScore = ScreeningResponse::avg('score') ?? 0;

        // 3. Warning perlu perhatian: jumlah unique user yang rata-rata skor = 18-27
        $userAverages = ScreeningResponse::select('user_id', DB::raw('AVG(score) as avg_score'))
            ->groupBy('user_id')
            ->get();
        
        $warningCount = $userAverages->filter(function ($item) {
            return $item->avg_score >= 18 && $item->avg_score <= 27;
        })->count();

        // 4. Line Chart Data (Filter by Month)
        // Default to current month and year if no filter
        $filterMonth = $request->input('month', now()->format('Y-m'));
        $startDate = Carbon::parse($filterMonth . '-01')->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Get daily data within the month
        $dailyData = ScreeningResponse::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_kuesioner'),
                DB::raw('SUM(CASE WHEN score >= 18 AND score <= 27 THEN 1 ELSE 0 END) as total_warning')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Prepare chart labels and datasets
        $chartLabels = [];
        $chartTotalKuesioner = [];
        $chartTotalWarning = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $chartLabels[] = $date->format('d M');
            
            if ($dailyData->has($dateString)) {
                $chartTotalKuesioner[] = $dailyData[$dateString]->total_kuesioner;
                $chartTotalWarning[] = $dailyData[$dateString]->total_warning;
            } else {
                $chartTotalKuesioner[] = 0;
                $chartTotalWarning[] = 0;
            }
        }

        // 5. List mahasiswa 5 terakhir yang melakukan tes
        $recentStudents = ScreeningResponse::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('lecturer.dashboard', [
            'totalQuestionnaires' => $totalQuestionnaires,
            'averageScore'        => number_format($averageScore, 1),
            'warningCount'        => $warningCount,
            'filterMonth'         => $filterMonth,
            'chartLabels'         => $chartLabels,
            'chartTotalKuesioner' => $chartTotalKuesioner,
            'chartTotalWarning'   => $chartTotalWarning,
            'recentStudents'      => $recentStudents,
        ]);
    }

    public function studentHistory($id)
    {
        $student = Student::with('user')->findOrFail($id);
        
        $history = ScreeningResponse::where('user_id', $student->user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('lecturer.student_history', compact('student', 'history'));
    }
}
