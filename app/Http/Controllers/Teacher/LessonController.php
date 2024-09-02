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

    /** //? previous/next module buttons to be added
     * Show details of a specific lesson
     *
     * @param [type] $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Retrieve the lesson
        $lesson = Lesson::find($id);

        // If the lesson is not found, redirect to the lesson index with an error message
        if (!$lesson) {
            return redirect()->route('teacher.lessons.index')
                ->with('error', 'Lesson not found');
        }

        // Retrieve the course associated with the lesson
        $course = $lesson->course;

        if ($course) {
            // Sort lessons by their order within the course
            $lessons = $course->lessons->sortBy('order');

            // Find the index of the current lesson
            $lessonIndex = $lessons->search(fn($item) => $item->id === $lesson->id);

            // Determine the previous and next lessons
            $previousLesson = $lessonIndex > 0 ? $lessons->slice($lessonIndex - 1, 1)->first() : null;
            $nextLesson = $lessonIndex < $lessons->count() - 1 ? $lessons->slice($lessonIndex + 1, 1)->first() : null;
        } else {
            $previousLesson = null;
            $nextLesson = null;
        }

        // Pass the lesson details to the view
        return view('teacher.lessons.show', [
            'lesson' => $lesson,
            'course' => $lesson->course,
            'previousLesson' => $previousLesson,
            'nextLesson' => $nextLesson
        ]);
    }

    //! To be checked----------------------------
    /**
     * Display the form for creating a new lesson
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $courses = Course::all();
        $sections = Section::all();
        $modules = Module::all();

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
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to create a lesson.');
        }

        // Data validation
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string|url',
            'section_id' => 'nullable|exists:sections,id',
            'module_id' => 'nullable|exists:modules,id',
            'course_id' => 'required|exists:courses,id', // Corrected here
            'level' => 'nullable|integer',
        ]);

        // Check whether the course associated with the lesson belongs to the authenticated user
        $course = Course::find($validated['course_id']);
        if (!$course || Auth::user()->id !== $course->author_id) {
            return redirect()->route('teacher.lessons.index')
                ->with('error', 'Unauthorized');
        }

        try {
            // Calculate the order for the new lesson
            $maxOrder = Lesson::where('module_id', $validated['module_id'])
                ->max('order') ?? 0;
            $order = $maxOrder + 1;

            // Create the lesson with the calculated order
            $lesson = Lesson::create(array_merge($validated, ['order' => $order]));

            // Associate the lesson with the selected section and module
            if ($validated['section_id']) {
                $lesson->section_id = $validated['section_id'];
                $lesson->save();
            }

            if ($validated['module_id']) {
                $lesson->module_id = $validated['module_id'];
                $lesson->save();
            }
        } catch (\Exception $e) {
            // In case of creation error, redirection with error message
            return redirect()->route('teacher.lessons.index')
                ->with('error', 'Failed to create lesson');
        }

        return redirect()->route('teacher.lessons.show', $lesson->id)
            ->with('success', 'Lesson created successfully.');
    }


    /**
     * Display the form for editing an existing lesson
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Find lesson by ID
        $lesson = Lesson::findOrFail($id);

        // Retrieve the course associated with the lesson
        $course = Course::find($lesson->course_id);

        // Check if the authenticated user is the author of the course
        if ($course && Auth::user()->id !== $course->author_id) {
            return redirect()->route('teacher.lessons.index')
                ->with('error', 'Unauthorized');
        }

        // Retrieve lists of courses, modules and sections
        $courses = Course::all();
        $sections = Section::all();
        $modules = Module::all();

        return view('teacher.lessons.edit', compact('lesson', 'courses', 'modules', 'sections'));
    }

    /**
     * Update an existing lesson
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
