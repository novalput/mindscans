<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScreeningResponse;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of all student screening histories.
     */
    public function index(Request $request)
    {
        $role = $request->query('role', 'all');

        $query = ScreeningResponse::with('user.biodata')
            ->whereHas('user', function($q) {
                // Exclude admin tests from general history
                $q->where('role', '!=', 'admin');
            });

        if ($role !== 'all') {
            $query->whereHas('user', function($q) use ($role) {
                $q->where('sub_role', $role);
            });
        }

        $histories = $query->orderBy('created_at', 'desc')->paginate(15);
        $metrics = \App\Models\Question::getScoringMetrics();

        return view('admin.history.index', compact('histories', 'role', 'metrics'));
    }

    /**
     * Display the specified screening history detail.
     */
    public function show($id)
    {
        $history = ScreeningResponse::with('user.biodata')->findOrFail($id);
        $detail = $history->answers_detail;
        $metrics = \App\Models\Question::getScoringMetrics();

        return view('admin.history.show', compact('history', 'detail', 'metrics'));
    }

    /**
     * Update the admin intervention/advice for a specific screening history.
     */
    public function updateIntervention(Request $request, $id)
    {
        $request->validate([
            'admin_intervention' => 'nullable|string'
        ]);

        $history = ScreeningResponse::findOrFail($id);
        
        $history->update([
            'admin_intervention' => $request->admin_intervention
        ]);

        return redirect()->route('admin.history.show', $id)
            ->with('success', 'Rekomendasi penanganan berhasil disimpan.');
    }
}
