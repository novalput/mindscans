<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ScreeningResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $lecturerCount = User::where('role', 'lecturer')->count();
        $studentCount = User::where('role', 'student')->count();
        $evaluationCount = ScreeningResponse::count();

        return view('admin.dashboard', compact('lecturerCount', 'studentCount', 'evaluationCount'));
    }
}
