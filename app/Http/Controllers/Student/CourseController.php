<?php

namespace App\Http\Controllers\Student;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Students' access
     *
     * @return void
     */
    public function student_dashboard()
    {
        $user = Auth::user();
        $currentCourse = null;
        $completedLessons = 0;
        $totalLessons = 0;
        $progress = 0;
        if ($user->current_course_id) {
            $currentCourse = Course::with('sections.modules.lessons', 'author')->find($user->current_course_id);
            $completedLessons = $user->lessons()->wherePivot('completed', true)->whereHas('module', function($q) use ($currentCourse) {
                $q->whereHas('section', function($q2) use ($currentCourse) {
                    $q2->where('course_id', $currentCourse->id);
                });
            })->count();
            $totalLessons = $currentCourse->sections->flatMap(fn($section) => $section->modules->flatMap(fn($module) => $module->lessons))->count();
            $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
        }
        return view('student.dashboard', [
            'currentCourse' => $currentCourse,
            'completedLessons' => $completedLessons,
            'totalLessons' => $totalLessons,
            'progress' => $progress
        ]);
    }

    /**
     * Display the course list
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $allCourses = Course::with(['sections.modules.lessons', 'author', 'lessons'])->get();

        $notStartedCourses = collect();
        $inProgressCourses = collect();
        $completedCourses = collect();

        // Récupère le cours en cours comme sur le dashboard
        $currentCourse = null;
        if ($user->current_course_id) {
            $currentCourse = Course::with('lessons')->find($user->current_course_id);
        }

        foreach ($allCourses as $course) {
            // Ne pas dupliquer le cours en cours dans les autres listes
            if ($currentCourse && $course->id == $currentCourse->id) {
                continue;
            }
            $lessons = $course->lessons;
            if ($lessons->isEmpty()) {
                continue; // skip courses with no lessons
            }
            $lessonIds = $lessons->pluck('id');
            $progressRecords = \App\Models\Progress::whereIn('lesson_id', $lessonIds)
                ->where('user_id', $user->id)
                ->get();

            $completedCount = $progressRecords->where('completed', true)->count();
            $totalCount = $lessons->count();
            $hasAnyProgress = $progressRecords->count() > 0;
            $progressPercent = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;
            $course->progress = $progressPercent;

            // Eager load first section, module, lesson for display
            $course->first_section = ($course->sections && $course->sections->count()) ? $course->sections->first() : null;
            $course->first_module = ($course->first_section && $course->first_section->modules && $course->first_section->modules->count()) ? $course->first_section->modules->first() : null;
            $course->first_lesson = ($course->first_module && $course->first_module->lessons && $course->first_module->lessons->count()) ? $course->first_module->lessons->first() : null;

            if (!$hasAnyProgress) {
                $notStartedCourses->push($course);
            } elseif ($completedCount === $totalCount) {
                $completedCourses->push($course);
            } else {
                $inProgressCourses->push($course);
            }
        }

        // Filtrage par statut et création de $filteredCourses
        $status = request('status');
        if ($status === 'completed') {
            $filteredCourses = $completedCourses;
        } else {
            $filteredCourses = $inProgressCourses;
        }

        return view('student.courses.index', [
            'filteredCourses' => $filteredCourses,
            'status' => $status,
            'currentCourse' => $currentCourse,
        ]);
    }

    /**
     * Show details of a specific course by its id
     *
     * @param [type] $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Récupérer le cours avec ses sections, modules et leçons
        $course = Course::with('sections.modules.lessons')->find($id);

        if (!$course) {
            return redirect()->route('student.courses.index')
                ->with('error',  __('messages.course_not_found'));
        }

        // Trouver la première leçon non terminée (en cours)
        $user = Auth::user();
        $currentLesson = null;
        $allLessons = collect();
        foreach ($course->sections as $section) {
            foreach ($section->modules as $module) {
                foreach ($module->lessons as $lesson) {
                    $allLessons->push($lesson);
                    $isCompleted = $user->lessons->contains(function($l) use ($lesson) {
                        return $l->id === $lesson->id && $l->pivot->completed;
                    });
                    if (!$isCompleted && !$currentLesson) {
                        $currentLesson = $lesson;
                    }
                }
            }
        }
        // Si toutes les leçons sont terminées, prendre la première
        if (!$currentLesson && $allLessons->count()) {
            $currentLesson = $allLessons->first();
        }
        // Rediriger vers la leçon en cours
        if ($currentLesson) {
            return redirect()->route('student.lessons.show', $currentLesson->id);
        }

        // Sinon, afficher la page du cours normalement
        $user = Auth::user();
        $completedLessons = $user->lessons()->wherePivot('completed', true)->pluck('lesson_id')->toArray();
        $literature = collect();
        foreach ($course->sections as $section) {
            foreach ($section->modules as $module) {
                foreach ($module->lessons as $lesson) {
                    foreach ($lesson->documents as $doc) {
                        if ($doc->type === 'literature') {
                            $literature->push($doc);
                        }
                    }
                }
            }
        }
        return view('student.courses.show', [
            'course' => $course,
            'completedLessons' => $completedLessons,
            'literature' => $literature
        ]);
    }

    /**
     * Display the current course for the user
     *
     * @return \Illuminate\View\View
     */
    public function myCourses()
    {
        $user = Auth::user();
        // Eager load toutes les relations nécessaires pour les QCM
        $enrolledCourses = $user->enrolledCourses()->load([
            'sections.modules.lessons.quiz.questions.answers',
            'author'
        ]);
        $completedCourses = $user->completedCourses();
        $inProgressCourses = $user->inProgressCourses();
        return view('student.courses', [
            'enrolledCourses' => $enrolledCourses,
            'completedCourses' => $completedCourses,
            'inProgressCourses' => $inProgressCourses
        ]);
    }

    /**
     * Browse all courses with a link to the course page
     *
     * @return \Illuminate\View\View
     */
    public function browse()
    {
        $courses = Course::with('author')->get();
        return view('courses.browse', ['courses' => $courses]);
    }

    /**
     * Start a course for the student (set current_course_id)
     */
    public function start($id)
    {
        $user = Auth::user();
        $user->current_course_id = $id;
        $user->save();
        return redirect()->route('student.courses.show', $id);
    }
}
