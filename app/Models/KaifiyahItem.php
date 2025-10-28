<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaifiyahItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'title',
        'description',
        'image_path',
    ];
}
