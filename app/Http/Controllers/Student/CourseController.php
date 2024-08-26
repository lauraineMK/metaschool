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

}
