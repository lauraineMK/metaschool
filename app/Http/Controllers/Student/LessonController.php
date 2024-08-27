<?php

namespace App\Http\Controllers\Student;

use App\Models\Lesson;
use App\Http\Controllers\Controller;

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
        return view('student.lessons.index', ['lessons' => $lessons]);
    }

    /**
     * Show details of a specific lesson by its id
     *
     * @param [type] $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Retrieve the lesson
        $lesson = Lesson::find($id);

        // If the lesson is not found, redirect or show an error page
        if (!$lesson) {
            return response()->json(['message' => 'Lesson not found'], 404);
        }
        // Pass the lesson details to the view
        return view('student.lessons.show', ['lesson' => $lesson]);
    }
}
