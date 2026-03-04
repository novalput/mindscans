<?php

namespace App\Http\Controllers;

use App\Models\EducationalContent;
use App\Models\EducationalMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentManagementController extends Controller
{
    public function index()
    {
        $contents = EducationalMaterial::latest()->get();
        return view('lecturer.education.index', compact('contents'));
    }

    public function create()
    {
        return view('lecturer.education.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
            'content' => 'required',
            'video_url' => 'nullable|url',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        EducationalMaterial::create($data);
        return redirect()->route('lecturer.materi.index')->with('success', 'Materi edukasi berhasil dibuat.');
    }

    public function edit($id)
    {
        $materi = EducationalMaterial::findOrFail($id);
        return view('lecturer.education.edit', compact('materi'));
    }

    public function update(Request $request, $id)
    {
        $materi = EducationalMaterial::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
            'content' => 'required',
            'video_url' => 'nullable|url',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            if ($materi->thumbnail) Storage::disk('public')->delete($materi->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $materi->update($data);
        return redirect()->route('lecturer.materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $materi = EducationalMaterial::findOrFail($id);
        if ($materi->thumbnail) Storage::disk('public')->delete($materi->thumbnail);
        $materi->delete();
        return back()->with('success', 'Materi berhasil dihapus.');
    }
}
