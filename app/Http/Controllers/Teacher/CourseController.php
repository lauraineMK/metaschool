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
     * Show details of a specific course
     *
     * @param [type] $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Retrieve the course with related sections, modules, and lessons
        $course = Course::with('sections.modules.lessons')->find($id);

        // If the course is not found, redirect to the course index with an error message
        if (!$course) {
            return redirect()->route('teacher.courses.index')
                ->with('error', 'Course not found');
        }

        // Pass the course details to the view
        return view('teacher.courses.show', ['course' => $course]);
    }

    /**
     * Display the form for creating a new course
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $sections = Section::all();
        $modules = Module::all();
        return view('teacher.courses.create', compact('modules', 'sections'));
    }

    /**
     * Store a newly created course
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to create a course.');
        }

        // Data validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'creation_date' => 'nullable|date',
            'author_id' => 'required|exists:users,id',
            'sections' => 'nullable|array',
            'sections.*.name' => 'nullable|string|max:255',
            'sections.*.description' => 'nullable|string',
            'sections.*.level' => 'nullable|integer',
            'sections.*.modules' => 'nullable|array',
            'sections.*.modules.*.name' => 'nullable|string|max:255',
            'sections.*.modules.*.description' => 'nullable|string',
            'sections.*.modules.*.level' => 'nullable|integer',
            'modules' => 'nullable|array',
            'modules.*.name' => 'nullable|string|max:255',
            'modules.*.description' => 'nullable|string',
            'modules.*.level' => 'nullable|integer',
        ]);

        // Set the author_id to the authenticated user
        $validated['author_id'] = Auth::id();

        // Course creation
        $course = Course::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'creation_date' => $validated['creation_date'],
            'author_id' => $validated['author_id'],
        ]);

        // Section creation if provided
        if (!empty($validated['sections'])) {
            foreach ($validated['sections'] as $sectionData) {
                $section = Section::create([
                    'name' => $sectionData['name'],
                    'description' => $sectionData['description'],
                    'course_id' => $course->id,
                    'level' => $sectionData['level'] ?? null,
                ]);

                // Section module creation
                if (!empty($sectionData['modules'])) {
                    foreach ($sectionData['modules'] as $moduleData) {
                        Module::create([
                            'name' => $moduleData['name'],
                            'description' => $moduleData['description'],
                            'course_id' => $course->id,
                            'section_id' => $section->id,
                            'level' => $moduleData['level'] ?? null,
                        ]);
                    }
                }
            }
        }

        // Standalone module creation if provided
        if (!empty($validated['modules'])) {
            foreach ($validated['modules'] as $moduleData) {
                Module::create([
                    'name' => $moduleData['name'],
                    'description' => $moduleData['description'],
                    'course_id' => $course->id,
                    'section_id' => null,
                    'level' => $moduleData['level'] ?? null,
                ]);
            }
        }

        return redirect()->route('teacher.courses.show', $course->id)
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the form for editing an existing course
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $course = Course::with('sections.modules')->findOrFail($id);

        if (!$course) {
            return redirect()->route('teacher.courses.index')
                ->with('error', 'Course not found');
        }

        if (Auth::user()->id !== $course->author_id) {
            return redirect()->route('teacher.courses.index')
                ->with('error', 'Unauthorized');
        }

        return view('teacher.courses.edit', compact('course'));
    }

    //! Method to be reworked:
    //? Updating works most of the time but — creation and modification largely
    //? functional but deletion does not work as it should — there's a problem
    //? with modules belonging to any section becoming independant when
    //? that section is deleted, instead of being deleted with it.
    //TODO: 1. Work on deletion so that each section, each section module
    //TODO:    and each standalone module can be deleted down to the last.
    //TODO: 2. Check that the creation still works after two or three sections
    //TODO:    containing several modules have been created.
    //TODO: 3. Finally, check that the update works, having created a new section
    //TODO:    and a module in that section, modified fields in a module and
    //TODO:    its section, deleted all modules in a section and then the section,
    //TODO:    deleted another section with modules, without having deleted them,
    //TODO:    and make sure that all modifications have been carried out correctly.
    //TODO:    Same check with a course containing standalone modules:
    //TODO:    Create a new one, edit a one's fields and delete another one.
    /**
     * Update an existing course
     *
     * @param Request $request
     * @param [type] $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Data validation
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'creation_date' => 'nullable|date',
            'author_id' => 'sometimes|required|exists:users,id',
            'sections' => 'nullable|array',
            'sections.*.id' => 'nullable|exists:sections,id',
            'sections.*.name' => 'nullable|string|max:255',
            'sections.*.description' => 'nullable|string',
            'sections.*.level' => 'nullable|integer',
            'sections.*.modules' => 'nullable|array',
            'sections.*.modules.*.id' => 'nullable|exists:modules,id',
            'sections.*.modules.*.name' => 'nullable|string|max:255',
            'sections.*.modules.*.description' => 'nullable|string',
            'sections.*.modules.*.level' => 'nullable|integer',
            'sections.*.modules.*.section_id' => 'nullable|exists:sections,id',
            'modules' => 'nullable|array',
            'modules.*.id' => 'nullable|exists:modules,id',
            'modules.*.name' => 'nullable|string|max:255',
            'modules.*.description' => 'nullable|string',
            'modules.*.level' => 'nullable|integer',
        ]);

        $course = Course::findOrFail($id);

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
                $currentSectionIds = [];
                foreach ($request->sections as $sectionData) {
                    if (isset($sectionData['id'])) {
                        $section = Section::find($sectionData['id']);
                        if ($section) {
                            $section->update([
                                'name' => $sectionData['name'] ?? $section->name,
                                'description' => $sectionData['description'] ?? $section->description,
                                'level' => $sectionData['level'] ?? $section->level,
                            ]);
                            $currentSectionIds[] = $section->id;
                        }
                    } else {
                        $newSection = Section::create([
                            'name' => $sectionData['name'],
                            'description' => $sectionData['description'],
                            'course_id' => $course->id,
                            'level' => $sectionData['level'],
                        ]);
                        $currentSectionIds[] = $newSection->id;
                    }

                    // Section's module update
                    if (!empty($sectionData['modules'])) {
                        $currentModuleIds = [];
                        foreach ($sectionData['modules'] as $moduleData) {
                            if (isset($moduleData['id'])) {
                                $module = Module::find($moduleData['id']);
                                if ($module) {
                                    $module->update([
                                        'name' => $moduleData['name'] ?? $module->name,
                                        'description' => $moduleData['description'] ?? $module->description,
                                        'level' => $moduleData['level'] ?? $module->level,
                                    ]);
                                    $currentModuleIds[] = $module->id;
                                }
                            } else {
                                $newModule = Module::create([
                                    'name' => $moduleData['name'],
                                    'description' => $moduleData['description'],
                                    'course_id' => $course->id,
                                    'section_id' => $section->id,
                                    'level' => $moduleData['level'],
                                ]);
                                $currentModuleIds[] = $newModule->id;
                            }
                        }
                        // Deletion of modules not present in the request data
                        Module::where('section_id', $section->id)
                            ->whereNotIn('id', $currentModuleIds)
                            ->delete();
                    }
                }
                // Deletion of sections not present in the request data
                Section::where('course_id', $course->id)
                ->whereNotIn('id', $currentSectionIds)
                ->each(function($section) {
                    // Delete associated modules when deleting section
                    Module::where('section_id', $section->id)->delete();
                    $section->delete();
                });
            }

            // Standalone modules update
            if ($request->has('modules')) {
                $currentModuleIds = [];
                foreach ($request->modules as $moduleData) {
                    if (isset($moduleData['id'])) {
                        $module = Module::find($moduleData['id']);
                        if ($module) {
                            $module->update([
                                'name' => $moduleData['name'] ?? $module->name,
                                'description' => $moduleData['description'] ?? $module->description,
                                'level' => $moduleData['level'] ?? $module->level,
                                'section_id' => $moduleData['section_id'] ?? $module->section_id,
                            ]);
                            $currentModuleIds[] = $module->id;
                        }
                    } else {
                        $newModule = Module::create([
                            'name' => $moduleData['name'],
                            'description' => $moduleData['description'],
                            'course_id' => $course->id,
                            'section_id' => $moduleData['section_id'] ?? null,
                            'level' => $moduleData['level'],
                        ]);
                        $currentModuleIds[] = $newModule->id;
                    }
                }
                // Deletion of modules not present in the request data
                Module::where('course_id', $course->id)
                    ->whereNull('section_id')
                    ->whereNotIn('id', $currentModuleIds)
                    ->delete();
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
     * Delete a course
     *
     * @param [type] $id
     * @return \Illuminate\Http\RedirectResponse
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
