<?php

namespace App\Http\Controllers\Student;

use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Affiche la liste des leçons de l'étudiant
     */
    public function index()
    {
        // Récupère toutes les leçons (à adapter selon la logique d'inscription)
        $lessons = Lesson::orderBy('order')->get();
        return view('student.lessons.index', compact('lessons'));
    }
    /**
     * Display the lesson list
    /**
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    /** //? previous/next module buttons to be added! and content drip to handle
     * Show details of a specific lesson by its id
     *
     * @param \Illuminate\Http\Request $request
     * @param [type] $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // Retrieve the lesson
        $lesson = Lesson::find($id);

        // If the lesson is not found, redirect to the lesson index with an error message
        if (!$lesson) {
            return redirect()->route('student.lessons.index')
                ->with('error', __('messages.lesson_not_found'));
        }

        // Retrieve the course associated with the lesson
        $course = $lesson->course;

        // Initialize variables for the next and previous lessons
        $previousLesson = null;
        $nextLesson = null;

        // Determine the next and previous lessons
        if ($course) {
            // Récupère toutes les leçons du cours, triées
            $lessons = $course->lessons->sortBy('order')->values();
            // Trouve l'index de la leçon courante
            $lessonIndex = $lessons->search(function($item) use ($lesson) {
                return $item->id == $lesson->id;
            });
            // Détermine la leçon précédente
            $previousLesson = $lessonIndex > 0 ? $lessons[$lessonIndex - 1] : null;
            $nextLesson = $lessonIndex < $lessons->count() - 1 ? $lessons[$lessonIndex + 1] : null;
            // Blocage strict si la leçon précédente n'est pas terminée
            if ($previousLesson && !Auth::user()->hasCompletedLesson($previousLesson->id)) {
                return redirect()->route('student.lessons.index')
                    ->with('error', "Vous devez terminer la leçon précédente avant d'accéder à celle-ci.");
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
    public function complete(Request $request, $id)
    {
        $user = $request->user();
        $user->completeLesson($id);
        return redirect()->route('student.lessons.show', $id)->with('success', 'Leçon marquée comme terminée.');
    }
}
