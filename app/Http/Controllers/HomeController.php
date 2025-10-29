<?php

namespace App\Http\Controllers;

use App\Models\WudhuReading;
use App\Models\PrayerReading;
use App\Models\DailyPrayer;
use App\Models\KaifiyahItem;
use App\Models\Material;
use App\Models\ActivityPhoto;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama dengan menu dan data konten.
     */
    public function index(): View
    {
        $wudhuReadings = WudhuReading::orderBy('id', 'asc')->get();
        $prayerReadings = PrayerReading::orderBy('id', 'asc')->get();
        $dailyPrayers = DailyPrayer::orderBy('id', 'asc')->get();
        $kaifiyahItems = KaifiyahItem::orderBy('created_at', 'asc')->get()->groupBy('section');
        $materials = Material::orderBy('created_at', 'desc')->get();
        $activityPhotos = ActivityPhoto::orderBy('created_at', 'desc')->get();

        return view('home', compact(
            'wudhuReadings',
            'prayerReadings',
            'dailyPrayers',
            'kaifiyahItems',
            'materials',
            'activityPhotos'
        ));
    }
}