<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'type','key',
    ];

    public function scopeType($query, string $type)
    {
        return $query->where('type', $type)->orderBy('key');
    }
}
