<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::where('role', 'student')
            ->with('student')
            ->paginate(10);

        return view('admin.student.index', compact('students'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user->role !== 'student') {
            abort(403, 'Unauthorized');
        }

        $user->load('student');

        return view('admin.student.show', compact('user'));
    }
}
