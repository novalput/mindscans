<?php

namespace App\Http\Controllers;

use App\Models\BrushingLog;
use App\Models\HealthVisit;
use App\Models\ScreeningResponse;
use App\Models\User; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    // === UNTUK PASIEN ===
    public function index()
    {
        $user = Auth::user();

        $logs = BrushingLog::where('user_id', $user->id)
            ->whereMonth('log_date', now()->month)
            ->get()
            ->keyBy(function ($item) {
                return $item->log_date->format('Y-m-d');
            });

        $visits = HealthVisit::where('user_id', $user->id)
            ->with('lecturer') // Penting agar $visit->lecturer->name muncul
            ->orderBy('visit_date', 'desc')
            ->get();

        return view('student.monitoring.index', compact('logs', 'visits'));
    }

    // === UNTUK LECTURER: List Pasien ===
    public function lecturerIndex()
    {
        $students = User::where('role', 'student')->with('student')->latest()->paginate(15);
        return view('lecturer.monitoring.index', compact('students'));
    }

    // === UNTUK LECTURER: Detail Activity Pasien tertentu ===
    public function lecturerShow($id)
    {
        $student = User::with('student')->findOrFail($id);

        // Ambil log sikat gigi pasien bulan ini
        $logs = BrushingLog::where('user_id', $id)
            ->whereMonth('log_date', now()->month)
            ->whereYear('log_date', now()->year)
            ->get()
            ->keyBy(function ($item) {
                return $item->log_date->format('Y-m-d');
            });

        // Ambil riwayat kunjungan
        $visits = HealthVisit::where('user_id', $id)
            ->orderBy('visit_date', 'desc')
            ->get();

        return view('lecturer.monitoring.show', compact('student', 'logs', 'visits'));
    }

    public function toggleBrushing(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|in:morning,night'
        ]);

        $log = BrushingLog::firstOrCreate(
            ['user_id' => Auth::id(), 'log_date' => $request->date]
        );

        $field = $request->time;
        $log->$field = !$log->$field;
        $log->save();

        return response()->json(['status' => 'success', 'state' => $log->$field]);
    }

    public function visits()
    {
        $visits = HealthVisit::where('user_id', Auth::id())->latest()->get();
        return view('student.monitoring.visits', compact('visits'));
    }
}
