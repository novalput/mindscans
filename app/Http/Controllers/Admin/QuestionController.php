<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan tipe soal (default: depression)
        $type = $request->query('type', 'depression');

        // Ambil data sesuai tipe
        $questions = Question::where('type', $type)->orderBy('order')->get();

        return view('admin.questions.index', compact('questions', 'type'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type', 'depression');
        $subtypes = Question::whereNotNull('subtype')
            ->where('subtype', '!=', '')
            ->distinct()
            ->pluck('subtype');
            
        return view('admin.questions.create', compact('type', 'subtypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:depression,anxiety,impact',
            'question_text' => 'required|string',
            'order' => 'required|integer',
            'subtype' => 'nullable|string|max:255',
        ]);

        $questionData = $request->only(['type', 'question_text', 'order', 'subtype']);
        
        // If it is impact, we set the default options. Otherwise, we can leave it null.
        if ($request->type === 'impact') {
            $questionData['options'] = json_encode([
                "0" => "Tidak sulit sama sekali",
                "1" => "Agak sulit",
                "2" => "Sangat sulit",
                "3" => "Sangat sulit sekali"
            ]);
        }

        Question::create($questionData);

        return redirect()->route('admin.questions.index', ['type' => $request->type])
            ->with('success', 'Soal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $subtypes = Question::whereNotNull('subtype')
            ->where('subtype', '!=', '')
            ->distinct()
            ->pluck('subtype');

        return view('admin.questions.edit', compact('question', 'subtypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question_text' => 'required|string',
            'order' => 'required|integer',
            'type' => 'required|string|in:depression,anxiety,impact',
            'subtype' => 'nullable|string|max:255',
        ]);

        $question = Question::findOrFail($id);
        $question->update($request->only(['question_text', 'order', 'type', 'subtype']));

        return redirect()->route('admin.questions.index', ['type' => $question->type])
            ->with('success', 'Soal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $type = $question->type;
        $question->delete();

        return redirect()->route('admin.questions.index', ['type' => $type])
            ->with('success', 'Soal berhasil dihapus');
    }
}
