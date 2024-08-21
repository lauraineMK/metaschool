<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'section_id',
        'module_id',
        'course_id',
        'level',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
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
