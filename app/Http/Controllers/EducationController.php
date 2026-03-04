<?php

namespace App\Http\Controllers;

use App\Models\EducationalMaterial;
use App\Models\ScreeningResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function index()
    {
        $materials = EducationalMaterial::all();
        return view('student.education.index', compact('materials'));
    }

    public function show($slug)
    {
        $education = EducationalMaterial::where('slug', $slug)->firstOrFail();

        // Cek apakah user sudah pre-test
        $hasPreTest = ScreeningResponse::where('user_id', Auth::id())
            ->where('type', 'pre_test')
            ->exists();

        return view('student.education.show', compact('education', 'hasPreTest'));
    }
}
