<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Course;
use App\Models\Section;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Teachers' access
     *
     * @return void
     */
    public function teacher_dashboard()
    {
        // Return the view for the teacher dashboard
        return view('teacher.dashboard');
    }

    /**
     * Display the course list
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $courses = Course::all();
        return view('teacher.courses.index', ['courses' => $courses]);
    }

    /**
     * Show details of a specific course by its id
     *
     * @param [type] $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Retrieve the course with related sections, modules, and lessons
        $course = Course::with('sections.modules.lessons')->find($id);

        // If the course is not found, redirect or show an error page
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        // Pass the course details to the view
        return view('teacher.courses.show', ['course' => $course]);
    }

    //! Not working------------------------------
    /**
     * Display the new course creation form
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $modules = Module::all();
        $sections = Section::all();
        return view('teacher.courses.create', compact('modules', 'sections'));
    }
    //! -----------------------------------------

    /**
     * Store a newly created course
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Data validation
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'creation_date' => 'nullable|date',
            'author_id' => 'required|exists:users,id',
            'sections' => 'nullable|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.description' => 'nullable|string',
            'sections.*.level' => 'nullable|integer',
            'modules' => 'nullable|array',
            'modules.*.title' => 'nullable|string|max:255',
            'modules.*.description' => 'nullable|string',
            'modules.*.level' => 'nullable|integer',
            'modules.*.section_id' => 'nullable|exists:sections,id',

        ]);

        // Course creation
        $course = Course::create($request->only(['title', 'description', 'level', 'price', 'creation_date', 'author_id']));

        // Section creation if provided
        if ($request->has('sections')) {
            foreach ($request->sections as $sectionData) {
                $section = Section::create([
                    'title' => $sectionData['title'],
                    'description' => $sectionData['description'],
                    'course_id' => $course->id,
                    'level' => $sectionData['level'] ?? null,
                ]);

                // Module creation if provided
                if ($request->has('modules')) {
                    foreach ($request->modules as $moduleData) {
                        if ($moduleData['section_id'] == $section->id) {
                            Module::create([
                                'title' => $moduleData['title'],
                                'description' => $moduleData['description'],
                                'section_id' => $section->id,
                                'course_id' => $course->id,
                                'level' => $moduleData['level'] ?? null,
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('teacher.courses.show', $course->id)
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the new course edition form
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);

        return view('teacher.courses.edit', compact('course'));
    }

    /**
     * Update an existing course by its id
     *
     * @param Request $request
     * @param [type] $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Data validation
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'creation_date' => 'nullable|date',
            'author_id' => 'sometimes|required|exists:users,id',
            'sections' => 'nullable|array',
            'sections.*.id' => 'nullable|exists:sections,id',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.description' => 'nullable|string',
            'sections.*.level' => 'nullable|integer',
            'modules' => 'nullable|array',
            'modules.*.id' => 'nullable|exists:modules,id',
            'modules.*.title' => 'nullable|string|max:255',
            'modules.*.description' => 'nullable|string',
            'modules.*.level' => 'nullable|integer',
            'modules.*.section_id' => 'nullable|exists:sections,id',
        ]);

        $course = Course::find($id);
        if (!$course) {
            return redirect()->route('teacher.courses.index')
            ->with('error', 'Course not found');
        }

        // Check if the authenticated user is the author of the course
        if (Auth::user()->id !== $course->author_id) {
            return redirect()->route('teacher.courses.index')
            ->with('error', 'Unauthorized');
        }

        try {
        // Course update
        $course->update($validated);

        // Section update
        if ($request->has('sections')) {
            foreach ($request->sections as $sectionData) {
                if (isset($sectionData['id'])) {
                    $section = Section::find($sectionData['id']);
                    if ($section) {
                        $section->update([
                            'title' => $sectionData['title'] ?? $section->title,
                            'description' => $sectionData['description'] ?? $section->description,
                            'level' => $sectionData['level'] ?? $section->level,
                        ]);
                    }
                } else {
                    // New section creation if id is not provided
                    Section::create([
                        'title' => $sectionData['title'],
                        'description' => $sectionData['description'],
                        'course_id' => $course->id,
                        'level' => $sectionData['level'],
                    ]);
                }
            }
        }

        // Module update
        if ($request->has('modules')) {
            foreach ($request->modules as $moduleData) {
                if (isset($moduleData['id'])) {
                    $module = Module::find($moduleData['id']);
                    if ($module) {
                        $module->update([
                            'title' => $moduleData['title'] ?? $module->title,
                            'description' => $moduleData['description'] ?? $module->description,
                            'level' => $moduleData['level'] ?? $module->level,
                        ]);
                    }
                } else {
                    // New module creation if id is not provided
                    Module::create([
                        'title' => $moduleData['title'],
                        'description' => $moduleData['description'],
                        'course_id' => $course->id,
                        'section_id' => $moduleData['section_id'] ?? null,
                        'level' => $moduleData['level'],
                    ]);
                }
            }
        }

    } catch (\Exception $e) {
        // Log the exception for debugging purposes
        Log::error('Failed to update course: ' . $e->getMessage());

        // Redirect on update error with error message
        return redirect()->route('teacher.courses.index')
            ->with('error', 'Failed to update course');
        }

        // Redirect to course view with success message
        return redirect()->route('teacher.courses.show', $course->id)
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Delete a course by its id
     *
     * @param [type] $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return redirect()->route('teacher.courses.index')
                ->with('error', 'Course not found');
        }

        // Check if the authenticated user is the author of the course
        if (Auth::user()->id !== $course->author_id) {
            return redirect()->route('teacher.courses.index')
                ->with('error', 'Unauthorized');
        }


        $course->delete();

        return redirect()->route('teacher.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
