<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;

class ModuleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Vérifie si un module du même nom existe déjà pour ce cours
        $exists = \App\Models\Module::where('course_id', $request->input('course_id'))
            ->where('name', $request->input('name'))
            ->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Un module avec ce nom existe déjà pour ce cours.');
        }

        $module = new Module();
        $module->course_id = $request->input('course_id');
        $module->name = $request->input('name');
        $module->description = $request->input('description');
        $module->save();

        return redirect()->route('teacher.courses.edit', $module->course_id)
            ->with('success', 'Module ajouté avec succès.');
    }
}
