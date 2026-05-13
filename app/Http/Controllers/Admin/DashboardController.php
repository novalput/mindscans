<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ScreeningResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $respondenCount = User::where('role', 'responden')->count();
        $adminCount = User::where('role', 'admin')->count();
        $evaluationCount = ScreeningResponse::count();

        $filterMonth = $request->input('month', now()->format('Y-m'));
        $startDate = Carbon::parse($filterMonth . '-01')->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Calculate dynamic thresholds
        $totalQuestions = \App\Models\Question::count();
        $maxTotalScore = $totalQuestions * 3;
        $warningThreshold = floor(2 * $maxTotalScore / 3) + 1; // Start of "Parah" category

        // Get daily data within the month, including scores for detail
        $dailyDataRaw = ScreeningResponse::select(
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
            if ($row->score >= $warningThreshold) {
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
        $chartScoreDetails = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $chartLabels[] = $date->format('d M');
            
            if (isset($dailyStats[$dateString])) {
                $chartTotalKuesioner[] = $dailyStats[$dateString]['total_kuesioner'];
                $chartTotalWarning[] = $dailyStats[$dateString]['total_warning'];
                
                // Sort scores descending for display
                krsort($dailyStats[$dateString]['scores']);
                $chartScoreDetails[] = $dailyStats[$dateString]['scores'];
            } else {
                $chartTotalKuesioner[] = 0;
                $chartTotalWarning[] = 0;
                $chartScoreDetails[] = new \stdClass(); // empty object
            }
        }

        return view('admin.dashboard', compact(
            'respondenCount',
            'adminCount',
            'evaluationCount',
            'filterMonth',
            'chartLabels',
            'chartTotalKuesioner',
            'chartTotalWarning',
            'chartScoreDetails',
            'warningThreshold',
            'maxTotalScore'
        ));
    }
}
