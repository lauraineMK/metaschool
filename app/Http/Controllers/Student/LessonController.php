<?php

namespace App\Http\Controllers\Student;

use App\Models\Lesson;
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

    /** //? previous/next module buttons to be added
     * Show details of a specific lesson by its id
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
            return redirect()->route('student.lessons.index')
                ->with('error', 'Lesson not found');
        }

        // $user = Auth::user();

        // // Check the user's progress
        // $previousLesson = $lesson->previousLesson(); // Assume you have logic to get the previous lesson

        // if ($previousLesson) {
        //     $progress = $user->lessons()->where('lesson_id', $previousLesson->id)->first();
        //     if (!$progress || !$progress->pivot->completed) {
        //         return redirect()->route('student.courses.index')->with('error', 'You must complete the previous lesson first.');
        //     }
        // }

        // // Optionally mark the lesson as viewed by the student
        // $user->lessons()->syncWithoutDetaching([$lesson->id => ['completed' => false]]);

        // Retrieve the course associated with the lesson
        $course = $lesson->course;

        // Determine the next and previous lessons
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
        return view('student.lessons.show', [
            'lesson' => $lesson,
            'course' => $course,
            'previousLesson' => $previousLesson,
            'nextLesson' => $nextLesson
        ]);
    }

    /**
     * Mark a lesson as completed by the authenticated user.
     *
     * @param int $id The ID of the lesson to mark as completed.
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function complete($id)
    // {
    //     $lesson = Lesson::find($id);

    //     if (!$lesson) {
    //         return redirect()->route('student.courses.index')->with('error', 'Lesson not found');
    //     }

    //     $user = Auth::user();

    //     // Update the progress table
    //     $user->lessons()->updateExistingPivot($lesson->id, ['completed' => true, 'completion_date' => now()]);

    //     return redirect()->route('student.lessons.show', $lesson->id)->with('success', 'Lesson marked as completed!');
    // }
}
