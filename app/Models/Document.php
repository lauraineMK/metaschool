<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'description',
        'document_type',
        'entity_id',
    ];

    public function entity()
    {
        return $this->morphTo();
    }
}
