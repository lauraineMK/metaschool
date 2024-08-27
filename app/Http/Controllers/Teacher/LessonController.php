<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
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
            return redirect()->route('teacher.lessons.index')
            ->with('error', 'Lesson not found');
        }

        // Check whether the course associated with the lesson belongs to the authenticated user
        if ($lesson->course_id) {
            $course = Course::find($lesson->course_id);
            if (!$course) {
                return redirect()->route('teacher.lessons.index')
                    ->with('error', 'Course associated with the lesson not found');
            }

            if (Auth::user()->id !== $course->author_id) {
                return redirect()->route('teacher.lessons.index')
                    ->with('error', 'Unauthorized');
            }
        }

        try {
            // Update lesson
            $lesson->update($validated);
        } catch (\Exception $e) {
            // Redirect on update error with error message
            return redirect()->route('teacher.lessons.index')
                ->with('error', 'Failed to update lesson');
        }

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
        return redirect()->route('teacher.lessons.index')
            ->with('error', 'Lesson not found');
    }

    // Initialize course as null
    $course = null;

    // Check if the lesson is associated with a module
    if ($lesson->module) {
        // Check if the module is associated with a section and then a course
        if ($lesson->module->section) {
            $course = $lesson->module->section->course;
        } else {
            // If no section, check if the module is directly associated with a course
            $course = $lesson->module->course;
        }
    } else {
        // If no module, check if the lesson is directly associated with a course
        if ($lesson->course) {
            $course = $lesson->course;
        }
    }

    // Check if the authenticated user is the author of the course
    if ($course && Auth::user()->id !== $course->author_id) {
        return redirect()->route('teacher.lessons.index')
            ->with('error', 'Unauthorized');
    }

    // Delete the lesson
    $lesson->delete();

    return redirect()->route('teacher.lessons.index')
        ->with('success', 'Lesson deleted successfully.');
    }
}
