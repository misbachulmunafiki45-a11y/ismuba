<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerSchedule;
use App\Models\WudhuReading;
use App\Models\PrayerReading;
use App\Models\KaifiyahItem;
use App\Models\DailyPrayer;
use App\Models\Material;
use App\Models\ActivityPhoto;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(Request $request)
    {
        $months = collect(range(1, 12))->map(function ($m) {
            return Carbon::create(null, $m, 1)->locale('id')->translatedFormat('M');
        })->toArray();

        $data = [
            'prayerSchedules' => $this->monthlyCounts(PrayerSchedule::class),
            'wudhuReadings'   => $this->monthlyCounts(WudhuReading::class),
            'prayerReadings'  => $this->monthlyCounts(PrayerReading::class),
            'kaifiyahItems'   => $this->monthlyCounts(KaifiyahItem::class),
            'dailyPrayers'    => $this->monthlyCounts(DailyPrayer::class),
            'materials'       => $this->monthlyCounts(Material::class),
            'activityPhotos'  => $this->monthlyCounts(ActivityPhoto::class),
            'months'          => $months,
            // total counts (jumlah data yang sudah diinput)
            'countPrayerSchedules' => $this->totalCount(PrayerSchedule::class),
            'countWudhuReadings'   => $this->totalCount(WudhuReading::class),
            'countPrayerReadings'  => $this->totalCount(PrayerReading::class),
            'countKaifiyahItems'   => $this->totalCount(KaifiyahItem::class),
            'countDailyPrayers'    => $this->totalCount(DailyPrayer::class),
            'countMaterials'       => $this->totalCount(Material::class),
            'countActivityPhotos'  => $this->totalCount(ActivityPhoto::class),
            // group counts for materials
            'materialBySubject'    => $this->groupCounts(Material::class, 'subject'),
            'materialBySemester'   => $this->groupCounts(Material::class, 'semester'),
            'materialByClassLevel' => $this->groupCounts(Material::class, 'class_level'),
            // group counts for kaifiyah (empat bagian/tabel) - fixed order & localized labels
            'kaifiyahBySection'    => $this->groupCounts(KaifiyahItem::class, 'section'),
            'kaifiyahBySectionFixed' => $this->kaifiyahGroupFixed(),
            // calendar events (map tanggal => jumlah), gunakan foto kegiatan sebagai contoh
            'calendarEvents' => $this->calendarEvents(),
        ];

        return view('admin.dashboard', $data);
    }

    /**
     * Get monthly counts for current year for a model.
     * Returns array of 12 integers representing Jan-Dec counts.
     */
    private function monthlyCounts(string $modelClass): array
    {
        // If model/table doesn't have timestamps, gracefully return zeros
        try {
            $raw = $modelClass::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('month')
                ->pluck('count', 'month');
        } catch (\Throwable $e) {
            $raw = collect();
        }

        $counts = [];
        for ($m = 1; $m <= 12; $m++) {
            $counts[] = (int) ($raw[$m] ?? 0);
        }
        return $counts;
    }

    /** Get total count for a model */
    private function totalCount(string $modelClass): int
    {
        try {
            return (int) $modelClass::count();
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /** Get grouped counts [labels, data] for a column */
    private function groupCounts(string $modelClass, string $column): array
    {
        try {
            $rows = $modelClass::selectRaw($column.' as label, COUNT(*) as count')
                ->groupBy($column)
                ->orderBy($column)
                ->get();
            return [
                'labels' => $rows->pluck('label')->map(fn($v) => (string) $v)->toArray(),
                'data'   => $rows->pluck('count')->map(fn($v) => (int) $v)->toArray(),
            ];
        } catch (\Throwable $e) {
            return ['labels' => [], 'data' => []];
        }
    }

    /**
     * Kaifiyah grouped counts with fixed order and Indonesian labels.
     * Ensures slices for [bathing, shrouding, prayer, burial] exist even if zero.
     */
    private function kaifiyahGroupFixed(): array
    {
        $keys = ['bathing','shrouding','prayer','burial'];
        $labels = [
            'bathing' => 'Memandikan',
            'shrouding' => 'Mengkafani',
            'prayer' => 'Mensholatkan',
            'burial' => 'Mengkubur',
        ];
        $data = [];
        foreach ($keys as $k) {
            try {
                $data[] = (int) KaifiyahItem::where('section', $k)->count();
            } catch (\Throwable $e) {
                $data[] = 0;
            }
        }
        return [
            'labels' => array_map(fn($k) => $labels[$k], $keys),
            'data' => $data,
        ];
    }

    /**
     * Ambil event kalender per tanggal untuk bulan berjalan dari Jadwal Sholat.
     * Menandai tanggal yang memiliki jadwal (count=1) agar muncul di kalender.
     * Format: ['YYYY-MM-DD' => count]
     */
    private function calendarEvents(): array
    {
        try {
            $start = Carbon::now()->startOfMonth()->toDateString();
            $end = Carbon::now()->endOfMonth()->toDateString();
            // Ambil tanggal yang terisi pada tabel prayer_schedules
            $rows = PrayerSchedule::query()
                ->select(DB::raw('date as d'), DB::raw('COUNT(*) as c'))
                ->whereNotNull('date')
                ->whereBetween('date', [$start, $end])
                ->groupBy(DB::raw('date'))
                ->orderBy(DB::raw('date'))
                ->get();
            // Gunakan count untuk kemungkinan lebih dari satu entri di satu tanggal,
            // namun minimal akan bernilai 1 sehingga kalender menandai tanggal tsb.
            return $rows->mapWithKeys(fn($r) => [Carbon::parse($r->d)->toDateString() => (int) $r->c])->toArray();
        } catch (\Throwable $e) {
            return [];
        }
    }
}