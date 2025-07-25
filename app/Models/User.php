<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the courses for the user.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'author_id');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'progress')
            ->withPivot('completed', 'completion_date')
            ->withTimestamps();
    }

    public function hasCompletedLesson($lessonId)
    {
        return $this->lessons()
            ->where('lesson_id', $lessonId)
            ->wherePivot('completed', true)
            ->exists();
    }

    // // Mark a lesson as completed
    public function completeLesson($lessonId)
    {
        if (!$this->hasCompletedLesson($lessonId)) {
            $this->lessons()->attach($lessonId, ['completed' => true, 'completion_date' => now()]);
        }
    }

    // // AUnlock the next lesson
    // public function unlockLesson($lessonId)
    // {
    //     // Make sure the lesson is not already completed
    //     if (!$this->hasCompletedLesson($lessonId)) {
    //         // Check if the lesson already exists in the progress table
    //         $this->lessons()->firstOrCreate(
    //             ['lesson_id' => $lessonId],
    //             ['completed' => false]
    //         );
    //     }
    // }

    // public function completedLessons()
    // {
    //     return $this->lessons()->wherePivot('completed', true)->get();
    // }

    // public function incompleteLessons()
    // {
    //     return $this->lessons()->wherePivot('completed', false)->get();
    // }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function enrolledCourses()
    {
        // Pour supporter plusieurs cours inscrits à l'avenir, on suppose une table d'inscription (pivot)
        // Ici, on retourne le current_course_id comme unique cours inscrit
        return $this->current_course_id
            ? Course::where('id', $this->current_course_id)->get()
            : collect();
    }
    public function completedCourses()
    {
        // Un cours est terminé si toutes ses leçons sont marquées completed
        $courses = $this->enrolledCourses();
        return $courses->filter(function($course) {
            $total = $course->sections->flatMap(fn($section) => $section->modules->flatMap(fn($module) => $module->lessons))->count();
            $completed = $this->lessons()->wherePivot('completed', true)
                ->whereHas('module', function($q) use ($course) {
                    $q->whereHas('section', function($q2) use ($course) {
                        $q2->where('course_id', $course->id);
                    });
                })->count();
            return $total > 0 && $completed >= $total;
        });
    }
    public function inProgressCourses()
    {
        $courses = $this->enrolledCourses();
        return $courses->filter(function($course) {
            $total = $course->sections->flatMap(fn($section) => $section->modules->flatMap(fn($module) => $module->lessons))->count();
            $completed = $this->lessons()->wherePivot('completed', true)
                ->whereHas('module', function($q) use ($course) {
                    $q->whereHas('section', function($q2) use ($course) {
                        $q2->where('course_id', $course->id);
                    });
                })->count();
            return $total > 0 && $completed < $total;
        });
    }
}
