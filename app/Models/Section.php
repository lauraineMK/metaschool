<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'course_id',
        'level',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
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
