<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WudhuReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'arabic',
        'latin',
        'description',
        'image_path',
    ];
}