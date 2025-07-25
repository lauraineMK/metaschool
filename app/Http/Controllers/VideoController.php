<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Lesson;

class VideoController extends Controller
{
    // Upload vidéo (enseignant)
    public function upload(Request $request, $lessonId)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,webm,ogg,mov,avi|max:512000', // 500MB max
        ]);
        $lesson = Lesson::findOrFail($lessonId);
        // Vérifier que l'utilisateur est bien l'auteur du cours ou a le droit
        // (à adapter selon ta logique d'autorisation)
        $path = $request->file('video')->store('videos');
        $lesson->video_path = $path;
        $lesson->save();
        return back()->with('success', 'Vidéo uploadée avec succès.');
    }

    // Streaming sécurisé (étudiant inscrit ou enseignant)
    public function stream($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        // Vérifier que l'utilisateur a accès à la leçon (étudiant inscrit ou enseignant)
        // (à adapter selon ta logique d'accès)
        if (!$lesson->video_path || !Storage::exists($lesson->video_path)) {
            abort(404);
        }
        $file = Storage::path($lesson->video_path);
        $mime = Storage::mimeType($lesson->video_path);
        return response()->file($file, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="video.mp4"',
        ]);
    }
}
