<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'order',
        'content',
        'course_id',
        'section_id',
        'module_id',
        'level',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function quizzes()
    {
        return $this->hasOne(Quiz::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // public function getDocumentsWithUrlsAttribute()
    // {
    //     return $this->documents->map(function ($document) {
    //         return [
    //             'title' => $document->title,
    //             'url' => $document->file_url,
    //         ];
    //     });
    // }

    public function users()
    {
        return $this->belongsToMany(User::class, 'progress')
            ->withPivot('completed', 'completion_date')
            ->withTimestamps();
    }
}
