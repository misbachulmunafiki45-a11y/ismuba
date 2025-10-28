<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerSchedule extends Model
{
    protected $fillable = [
        'date',
        'fajr',
        'dhuhr',
        'asr',
        'maghrib',
        'isha',
    ];
}
