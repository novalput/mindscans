<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\User;
use App\Models\ScreeningResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LecturerController extends Controller
{
    public function dashboard(Request $request)
    {
        $lecturerKampus = auth()->user()->biodata->nama_kampus ?? null;

        $baseQuery = ScreeningResponse::query();
        if ($lecturerKampus) {
            $baseQuery->whereHas('user.biodata', function ($q) use ($lecturerKampus) {
                $q->where('nama_kampus', $lecturerKampus);
            });
        }

        // 1. Total kuisioner diisi
        $totalQuestionnaires = (clone $baseQuery)->count();

        // 2. Rata-rata skor mental
        $averageScore = (clone $baseQuery)->avg('score') ?? 0;

        // 3. Warning perlu perhatian: jumlah unique user yang rata-rata skor = 18-27
        $userAverages = (clone $baseQuery)->select('user_id', DB::raw('AVG(score) as avg_score'))
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

        // Get daily data within the month, including scores for detail
        $dailyDataRaw = (clone $baseQuery)->select(
                DB::raw('DATE(created_at) as date'),
                'score'
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $dailyStats = [];
        foreach ($dailyDataRaw as $row) {
            $date = $row->date;
            if (!isset($dailyStats[$date])) {
                $dailyStats[$date] = [
                    'total_kuesioner' => 0,
                    'total_warning' => 0,
                    'scores' => []
                ];
            }

            $dailyStats[$date]['total_kuesioner']++;
            if ($row->score >= 18 && $row->score <= 27) {
                $dailyStats[$date]['total_warning']++;
            }

            // Count occurrences of each score
            if (!isset($dailyStats[$date]['scores'][$row->score])) {
                $dailyStats[$date]['scores'][$row->score] = 0;
            }
            $dailyStats[$date]['scores'][$row->score]++;
        }

        // Prepare chart labels and datasets
        $chartLabels = [];
        $chartTotalKuesioner = [];
        $chartTotalWarning = [];
        $chartScoreDetails = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $chartLabels[] = $date->format('d M');
            
            if (isset($dailyStats[$dateString])) {
                $chartTotalKuesioner[] = $dailyStats[$dateString]['total_kuesioner'];
                $chartTotalWarning[] = $dailyStats[$dateString]['total_warning'];
                
                krsort($dailyStats[$dateString]['scores']);
                $chartScoreDetails[] = $dailyStats[$dateString]['scores'];
            } else {
                $chartTotalKuesioner[] = 0;
                $chartTotalWarning[] = 0;
                $chartScoreDetails[] = new \stdClass();
            }
        }

        // 5. List mahasiswa 5 terakhir yang melakukan tes
        $recentStudents = (clone $baseQuery)->with('user')
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
            'chartScoreDetails'   => $chartScoreDetails,
            'recentStudents'      => $recentStudents,
        ]);
    }

    public function studentHistory($id)
    {
        $student = User::with('biodata')->where('sub_role', 'student')->findOrFail($id);
        
        $lecturerKampus = auth()->user()->biodata->nama_kampus ?? null;
        if ($lecturerKampus && ($student->biodata->nama_kampus ?? null) !== $lecturerKampus) {
            abort(403, 'Unauthorized access to student from different institution.');
        }

        $history = ScreeningResponse::where('user_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('lecturer.student_history', compact('student', 'history'));
    }
}
