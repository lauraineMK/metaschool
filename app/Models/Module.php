<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order',
        'description',
        'course_id',
        'section_id',
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

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function videos()
    {
        return $this->morphMany(Video::class, 'entity');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'entity');
    }
}
