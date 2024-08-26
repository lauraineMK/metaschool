<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Section;
use Illuminate\Http\Request;
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
        return view('teacher.lessons.index', ['lessons' => $lessons]);
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
        return view('teacher.lessons.show', ['lesson' => $lesson]);
    }

    //! To be checked----------------------------
    /**
     * Display the new lesson creation form
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $courses = Course::all();
        $modules = Module::all();
        $sections = Section::all();

        return view('teacher.lessons.create', compact('courses', 'modules', 'sections'));
    }
    //! -----------------------------------------

    /**
     * Store a newly created lesson
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string|url',
            'section_id' => 'nullable|exists:sections,id',
            'module_id' => 'nullable|exists:modules,id',
            'lesson_id' => 'required|exists:courses,id',
            'level' => 'nullable|integer',
        ]);

        $lesson = Lesson::create($request->only(['title', 'content', 'video_url', 'section_id', 'module_id', 'course_id', 'level']));

        return redirect()->route('teacher.lessons.show', $lesson->id)
                     ->with('success', 'Lesson created successfully.');
    }

    /**
     * Display the new lesson edition form
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Find lesson by ID
        $lesson = Lesson::findOrFail($id);

        // Retrieve lists of courses, modules and sections
        $courses = Course::all();
        $modules = Module::all();
        $sections = Section::all();

        return view('teacher.lessons.edit', compact('lesson', 'courses', 'modules', 'sections'));
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

        return redirect()->route('teacher.lessons.show', $lesson->id)
                     ->with('success', 'Lesson updated successfully.');
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
