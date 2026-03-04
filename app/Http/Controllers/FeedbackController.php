<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // SISI PASIEN: Menampilkan halaman form
    public function create()
    {
        return view('student.feedback');
    }

    // SISI PASIEN: Menyimpan data
    public function feedbackStore(Request $request)
    {
        $request->validate([
            'content' => 'required|min:5',
            'rating'  => 'nullable|integer|min:1|max:5'
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'rating'  => $request->input('rating'),
        ]);

        return back()->with('success', 'Terima kasih atas feedback Bunda!');
    }

    // SISI LECTURER: Melihat semua feedback pasien
    public function feedbackIndex()
    {
        $feedbacks = Feedback::with('user')->latest()->paginate(10);
        return view('lecturer.feedback', compact('feedbacks'));
    }
}
