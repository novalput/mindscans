<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function dashboard()
    {
        return view('lecturer.dashboard', [
            'totalStudents'      => Student::count(),
            'studentsThisYear'   => Student::whereYear('created_at', now()->year)->count(),
            'totalLecturer'         => User::where('role', 'lecturer')->count(),
            'activeLecturer'        => User::where('role', 'lecturer')->count(),
        ]);
    }
}
