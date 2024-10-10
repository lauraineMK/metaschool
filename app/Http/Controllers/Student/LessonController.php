<?php

namespace App\Http\Controllers\Student;

use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

    /** //? previous/next module buttons to be added! and content drip to handle
     * Show details of a specific lesson by its id
     *
     * @param \Illuminate\Http\Request $request
     * @param [type] $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        // Retrieve the lesson
        $lesson = Lesson::find($id);

        // If the lesson is not found, redirect to the lesson index with an error message
        if (!$lesson) {
            return redirect()->route('student.lessons.index')
                ->with('error', 'Lesson not found');
        }

        // Retrieve the course associated with the lesson
        $course = $lesson->course;

        // Initialize variables for the next and previous lessons
        $previousLesson = null;
        $nextLesson = null;

        // Determine the next and previous lessons
        if ($course) {
            // Sort lessons by their order within the course
            $lessons = $course->lessons->sortBy('order');

            // Find the index of the current lesson
            $lessonIndex = $lessons->search(fn($item) => $item->id === $lesson->id);

            // Determine the previous and next lessons
            $previousLesson = $lessonIndex > 0 ? $lessons->slice($lessonIndex - 1, 1)->first() : null;
            $nextLesson = $lessonIndex < $lessons->count() - 1 ? $lessons->slice($lessonIndex + 1, 1)->first() : null;

            // If there is a previous lesson, check if the user has completed it
            if ($previousLesson && !$request->user()->hasCompletedLesson($previousLesson->id)) {
                // Redirect if the user hasn't completed the previous lesson
                return redirect()->route('student.lessons.index')
                    ->with('error', 'You must complete the previous lesson before accessing this one.');
            }
        }

        // Retrieve the videos, documents, and quiz associated with the lesson
        $videos = $lesson->videos;
        $documents = $lesson->documents;
        $quiz = $lesson->quiz;

        // Pass the lesson details to the view
        return view('student.lessons.show', [
            'lesson' => $lesson,
            'course' => $course,
            'videos' => $videos,
            'documents' => $documents,
            'quiz' => $quiz,
            'previousLesson' => $previousLesson,
            'nextLesson' => $nextLesson
        ]);
    }

    /**
     * Mark a lesson as completed by the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The ID of the lesson to mark as completed.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeCurrentLesson(Request $request, $lessonId)
    {
        // Retrieve the authenticated user
        $user = $request->user();

        /// Mark the lesson as completed
        $user->completeLesson($lessonId);

        // Retrieve the current lesson
        $lesson = Lesson::find($lessonId);

        // If the lesson is not found, redirect with an error message
        if (!$lesson) {
            return redirect()->route('student.lessons.index')->with('error', 'Lesson not found.');
        }

        // Retrieve the associated course
        $course = $lesson->course;

        // Retrieve the lessons sorted by order
        $lessons = $course->lessons->sortBy('order');
        $lessonIndex = $lessons->search(fn($item) => $item->id === $lesson->id);

        // Determine the next lesson
        $nextLesson = $lessonIndex < $lessons->count() - 1 ? $lessons->slice($lessonIndex + 1, 1)->first() : null;

        // Unlock the next lesson if it exists
        if ($nextLesson) {
            $user->unlockLesson($nextLesson->id);
            return redirect()->route('student.lessons.show', $nextLesson->id);
        }

        // If no next lesson exists, redirect to the lessons index
        return redirect()->route('student.lessons.index')->with('success', 'Lesson completed, you have finished the course.');
    }
}
