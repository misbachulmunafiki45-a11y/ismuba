<?php

namespace App\Http\Controllers;

use App\Models\PrayerSchedule;
use App\Models\WudhuReading;
use App\Models\PrayerReading;
use App\Models\DailyPrayer;
use App\Models\KaifiyahItem;
use App\Models\Material;
use App\Models\ActivityPhoto;
use Carbon\Carbon;
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

        // Ambil jadwal sholat terbaru atau gunakan default jika belum ada
        $schedule = null;
        try {
            $schedule = PrayerSchedule::orderBy('date', 'desc')->first();
        } catch (\Throwable $e) {
            $schedule = null;
        }
        $defaults = [
            'fajr' => '05:00',
            'dhuhr' => '12:00',
            'asr' => '15:30',
            'maghrib' => '18:00',
            'isha' => '19:00',
        ];
        $prayerTimes = [
            'fajr' => $schedule->fajr ?? $defaults['fajr'],
            'dhuhr' => $schedule->dhuhr ?? $defaults['dhuhr'],
            'asr' => $schedule->asr ?? $defaults['asr'],
            'maghrib' => $schedule->maghrib ?? $defaults['maghrib'],
            'isha' => $schedule->isha ?? $defaults['isha'],
        ];

        // Siapkan hari/tanggal untuk ditampilkan di HOME
        $dateString = $schedule->date ?? Carbon::today()->toDateString();
        $dayEnglish = Carbon::parse($dateString)->format('l');
        $dayMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $prayerDate = [
            'day' => $dayMap[$dayEnglish] ?? $dayEnglish,
            'date' => Carbon::parse($dateString)->format('d/m/Y'),
        ];

        return view('home', compact(
            'wudhuReadings',
            'prayerReadings',
            'dailyPrayers',
            'kaifiyahItems',
            'materials',
            'activityPhotos',
            'prayerTimes',
            'prayerDate'
        ));
    }

    /**
     * Halaman utama dengan section awal berdasarkan URL (/wudhu, /sholat, dll).
     */
    public function indexSection(string $section): View
    {
        // Reuse data loading from index()
        $wudhuReadings = WudhuReading::orderBy('id', 'asc')->get();
        $prayerReadings = PrayerReading::orderBy('id', 'asc')->get();
        $dailyPrayers = DailyPrayer::orderBy('id', 'asc')->get();
        $kaifiyahItems = KaifiyahItem::orderBy('created_at', 'asc')->get()->groupBy('section');
        $materials = Material::orderBy('created_at', 'desc')->get();
        $activityPhotos = ActivityPhoto::orderBy('created_at', 'desc')->get();

        $schedule = null;
        try { $schedule = PrayerSchedule::orderBy('date', 'desc')->first(); } catch (\Throwable $e) { $schedule = null; }
        $defaults = [ 'fajr' => '05:00','dhuhr' => '12:00','asr' => '15:30','maghrib' => '18:00','isha' => '19:00' ];
        $prayerTimes = [
            'fajr' => $schedule->fajr ?? $defaults['fajr'],
            'dhuhr' => $schedule->dhuhr ?? $defaults['dhuhr'],
            'asr' => $schedule->asr ?? $defaults['asr'],
            'maghrib' => $schedule->maghrib ?? $defaults['maghrib'],
            'isha' => $schedule->isha ?? $defaults['isha'],
        ];

        $dateString = $schedule->date ?? Carbon::today()->toDateString();
        $dayEnglish = Carbon::parse($dateString)->format('l');
        $dayMap = [ 'Monday' => 'Senin','Tuesday' => 'Selasa','Wednesday' => 'Rabu','Thursday' => 'Kamis','Friday' => 'Jumat','Saturday' => 'Sabtu','Sunday' => 'Minggu' ];
        $prayerDate = [ 'day' => $dayMap[$dayEnglish] ?? $dayEnglish, 'date' => Carbon::parse($dateString)->format('d/m/Y') ];

        return view('home', compact(
            'wudhuReadings','prayerReadings','dailyPrayers','kaifiyahItems','materials','activityPhotos','prayerTimes','prayerDate'
        ));
    }

    /**
     * Halaman detail Kaifiyah Jenazah per bagian.
     */
    public function kaifiyahSection(string $section): View
    {
        $allowed = ['bathing','shrouding','prayer','burial'];
        if (!in_array($section, $allowed, true)) {
            abort(404);
        }

        $labelMap = [
            'bathing' => 'Memandikan',
            'shrouding' => 'Mengkafani',
            'prayer' => 'Mensholatkan',
            'burial' => 'Mengkubur',
        ];

        $items = KaifiyahItem::query()
            ->where('section', $section)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('kaifiyah.section', [
            'section' => $section,
            'sectionLabel' => $labelMap[$section] ?? ucfirst($section),
            'items' => $items,
        ]);
    }
}