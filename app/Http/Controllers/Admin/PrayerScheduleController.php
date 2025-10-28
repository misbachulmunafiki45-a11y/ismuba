<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrayerScheduleController extends Controller
{
    /**
     * Tampilkan halaman jadwal sholat (read-only ringkas + tombol edit).
     */
    public function index(): View
    {
        try {
            $schedules = PrayerSchedule::orderBy('date', 'asc')->paginate(10);
            $current = PrayerSchedule::first();
        } catch (\Throwable $e) {
            $schedules = collect();
            $current = null;
        }

        $defaults = [
            'fajr' => '05:00',
            'dhuhr' => '12:00',
            'asr' => '15:30',
            'maghrib' => '18:00',
            'isha' => '19:00',
        ];

        return view('admin.prayer_schedule.index', [
            'schedules' => $schedules,
            'schedule' => $current,
            'defaults' => $defaults,
        ]);
    }

    /**
     * Tampilkan form edit jadwal sholat.
     */
    public function edit(): View
    {
        $schedule = null;
        try {
            $schedule = PrayerSchedule::first();
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

        return view('admin.prayer_schedule.edit', [
            'schedule' => $schedule,
            'defaults' => $defaults,
        ]);
    }

    /**
     * Simpan perubahan jadwal sholat.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => ['required','date'],
            'fajr' => ['required'],
            'dhuhr' => ['required'],
            'asr' => ['required'],
            'maghrib' => ['required'],
            'isha' => ['required'],
        ]);

        try {
            PrayerSchedule::query()->updateOrCreate(['id' => 1], $validated);
            return redirect()->route('admin.prayer.index')->with('success', 'Jadwal sholat berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan perubahan. Pastikan database dan migrasi sudah berjalan.');
        }
    }

    /**
     * Tampilkan form create jadwal sholat.
     */
    public function create(): View
    {
        $defaults = [
            'fajr' => '05:00',
            'dhuhr' => '12:00',
            'asr' => '15:30',
            'maghrib' => '18:00',
            'isha' => '19:00',
        ];

        return view('admin.prayer_schedule.create', [
            'defaults' => $defaults,
        ]);
    }

    /**
     * Simpan perubahan jadwal sholat.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => ['required','date'],
            'fajr' => ['required'],
            'dhuhr' => ['required'],
            'asr' => ['required'],
            'maghrib' => ['required'],
            'isha' => ['required'],
        ]);

        try {
            PrayerSchedule::create($validated);
            return redirect()->route('admin.prayer.index')->with('success', 'Jadwal sholat baru berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan jadwal. Pastikan database dan migrasi sudah berjalan.');
        }
    }

    /**
     * Hapus jadwal sholat.
     */
    public function destroy(PrayerSchedule $schedule): RedirectResponse
    {
        try {
            $schedule->delete();
            return redirect()->route('admin.prayer.index')->with('success', 'Jadwal sholat berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->route('admin.prayer.index')->with('error', 'Gagal menghapus jadwal.');
        }
    }
}