<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_level', 'semester', 'subject', 'title', 'description', 'file_path', 'video_url', 'published_at',
    ];
}
