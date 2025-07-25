<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;

class SectionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Vérifie si une section du même nom existe déjà pour ce cours
        $exists = \App\Models\Section::where('course_id', $request->input('course_id'))
            ->where('name', $request->input('name'))
            ->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Une section avec ce nom existe déjà pour ce cours.');
        }

        $section = new Section();
        $section->course_id = $request->input('course_id');
        $section->name = $request->input('name');
        $section->description = $request->input('description');
        $section->save();

        return redirect()->route('teacher.courses.edit', $section->course_id)
            ->with('success', 'Section ajoutée avec succès.');
    }
}
