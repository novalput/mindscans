<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan tipe soal (default: knowledge)
        $type = $request->query('type', 'knowledge');

        // Ambil data sesuai tipe
        $questions = Question::where('type', $type)->orderBy('order')->get();

        return view('lecturer.questions.index', compact('questions', 'type'));
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        return view('lecturer.questions.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'nullable|string', // Untuk knowledge/gingivitis
        ]);

        $question = Question::findOrFail($id);
        $question->update($request->all());

        return redirect()->route('lecturer.questions.index', ['type' => $question->type])
            ->with('success', 'Soal berhasil diperbarui');
    }
}
