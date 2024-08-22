<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display the lesson list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $lessons = Lesson::all();
        return response()->json($lessons);
    }

    /**
     * Show details of a specific lesson by its id
     *
     * @param [type] $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $lesson = Lesson::find($id);
        if (!$lesson) {
            return response()->json(['message' => 'Lesson not found'], 404);
        }
        return response()->json($lesson);
    }

    /**
     * Create a new lesson
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string|url',
            'section_id' => 'nullable|exists:sections,id',
            'module_id' => 'nullable|exists:modules,id',
            'course_id' => 'required|exists:courses,id',
            'level' => 'nullable|integer',
        ]);

        $lesson = Lesson::create($request->all());
        return response()->json($lesson, 201);
    }

    /**
     * Update an existing lesson by its id
     *
     * @param Request $request
     * @param [type] $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string|url',
            'section_id' => 'nullable|exists:sections,id',
            'module_id' => 'nullable|exists:modules,id',
            'course_id' => 'sometimes|required|exists:courses,id',
            'level' => 'nullable|integer',
        ]);

        $lesson = Lesson::find($id);
        if (!$lesson) {
            return response()->json(['message' => 'Lesson not found'], 404);
        }

        $lesson->update($request->all());
        return response()->json($lesson);
    }

    /**
     * Delete a lesson by its id
     *
     * @param [type] $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $lesson = Lesson::find($id);
        if (!$lesson) {
            return response()->json(['message' => 'Lesson not found'], 404);
        }

        $lesson->delete();
        return response()->json(['message' => 'Lesson deleted']);
    }
}
