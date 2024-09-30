<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order',
        'description',
        'course_id',
        'level',
    ];

    protected static function boot()
{
    parent::boot();

    static::deleting(function ($section) {
        // Delete all associated modules before deleting the section
        $section->modules()->delete();
    });
}

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
}
