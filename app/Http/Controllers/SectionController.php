<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display the section list
     *
     * @return void
     */
    public function index()
    {
        $sections = Section::all();
        return response()->json($sections);
    }

    /**
     * Show details of a specific section by its id
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $section = Section::find($id);
        if (!$section) {
            return response()->json(['message' => 'Section not found'], 404);
        }
        return response()->json($section);
    }

    /**
     * Create a new section
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'level' => 'nullable|integer',
        ]);

        $section = Section::create($request->all());
        return response()->json($section, 201);
    }

    /**
     * Update an existing section by its id
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'course_id' => 'sometimes|required|exists:courses,id',
            'level' => 'nullable|integer',
        ]);

        $section = Section::find($id);
        if (!$section) {
            return response()->json(['message' => 'Section not found'], 404);
        }

        $section->update($request->all());
        return response()->json($section);
    }

    /**
     * Delete a section by its id
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        $section = Section::find($id);
        if (!$section) {
            return response()->json(['message' => 'Section not found'], 404);
        }

        $section->delete();
        return response()->json(['message' => 'Section deleted']);
    }
}
