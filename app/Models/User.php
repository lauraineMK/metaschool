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

    // public function hasCompletedLesson($lessonId)
    // {
    //     return $this->lessons()
    //         ->where('lesson_id', $lessonId)
    //         ->wherePivot('completed', true)
    //         ->exists();
    // }

    // // Mark a lesson as completed
    // public function completeLesson($lessonId)
    // {
    //     // Check if the lesson is already completed
    //     if (!$this->hasCompletedLesson($lessonId)) {
    //         $this->lessons()->attach($lessonId, ['completed' => true, 'completion_date' => now()]);
    //     }
    // }

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
}
