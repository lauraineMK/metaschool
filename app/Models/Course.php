<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cover_image',
        'creation_date',
        'author_id',
        'level',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function literature()
    {
        return $this->hasMany(Document::class)->where('type', 'literature');
    }

    public function quizzes()
    {
        return $this->hasMany(\App\Models\Quiz::class);
    }

    /**
     * Get all progresses for this course (via lessons).
     */
    public function progresses()
    {
        return $this->hasManyThrough(\App\Models\Progress::class, \App\Models\Lesson::class, 'course_id', 'lesson_id', 'id', 'id');
    }
}
