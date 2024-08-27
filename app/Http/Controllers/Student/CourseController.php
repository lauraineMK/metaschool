<?php

namespace App\Http\Controllers\Student;

use App\Models\Course;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Students' access
     *
     * @return void
     */
    public function student_dashboard()
    {
        // Return the view for the student dashboard
        return view('student.dashboard');
    }

    /**
     * Display the course list
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $courses = Course::all();
        return view('student.courses.index', ['courses' => $courses]);
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

        // If the course is not found, redirect to the course index with an error message
        if (!$course) {
            return redirect()->route('student.courses.index')
                ->with('error', 'Course not found');
        }

        // Pass the course details to the view
        return view('student.courses.show', ['course' => $course]);
    }
}
