<?php

namespace App\Http\Controllers\Student;


use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProgressController extends Controller
{
    /**
     * Store the user's progress.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'completed' => 'required|boolean',
        ]);

        $user = Auth::user();
        $lessonId = $request->input('lesson_id');

        // Save or update progress
        $progress = Progress::updateOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $lessonId
            ],
            [
                'completed' => $request->completed,
                'completion_date' => now()
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Progress saved successfully',
            'progress' => $progress
        ]);
    }
}
