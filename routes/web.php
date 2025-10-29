<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PrayerScheduleController;
use App\Http\Controllers\Admin\TataCaraSholatController;
use App\Http\Controllers\Admin\TataCaraWudhuController;
use App\Http\Controllers\Admin\KaifiyahJenazahController;
use App\Http\Controllers\Admin\ActivityPhotoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Halaman utama kustom
Route::get('/', [HomeController::class, 'index'])->name('home');

// ... routes lainnya

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Non-admin profile routes removed to avoid redirecting to /profile after login

require __DIR__.'/auth.php';

// Admin area
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // Account security (password change) view within admin layout
    Route::get('/security/password', function () {
        return view('admin.security.password');
    })->name('security.password');

    // Admin user management: create new user
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    // Jadwal Sholat
    Route::get('/prayer-schedule', [PrayerScheduleController::class, 'index'])->name('prayer.index');
    Route::get('/prayer-schedule/create', [PrayerScheduleController::class, 'create'])->name('prayer.create');
    Route::post('/prayer-schedule/store', [PrayerScheduleController::class, 'store'])->name('prayer.store');
    Route::get('/prayer-schedule/edit', [PrayerScheduleController::class, 'edit'])->name('prayer.edit');
    Route::post('/prayer-schedule', [PrayerScheduleController::class, 'update'])->name('prayer.update');
    Route::delete('/prayer-schedule/{schedule}', [PrayerScheduleController::class, 'destroy'])->name('prayer.destroy');

    // Tata Cara Berwudhu (view + CRUD)
    Route::get('/wudhu-howto', [TataCaraWudhuController::class, 'index'])->name('wudhu.howto.index');
    Route::get('/wudhu-howto/readings/create', [TataCaraWudhuController::class, 'create'])->name('wudhu.readings.create');
    Route::get('/wudhu-howto/readings/{reading}/edit', [TataCaraWudhuController::class, 'edit'])->name('wudhu.readings.edit');
    Route::post('/wudhu-howto/readings', [TataCaraWudhuController::class, 'store'])->name('wudhu.readings.store');
    Route::put('/wudhu-howto/readings/{reading}', [TataCaraWudhuController::class, 'update'])->name('wudhu.readings.update');
    Route::delete('/wudhu-howto/readings/{reading}', [TataCaraWudhuController::class, 'destroy'])->name('wudhu.readings.destroy');

    // Tata Cara Sholat (view + CRUD)
    Route::get('/prayer-howto', [TataCaraSholatController::class, 'index'])->name('prayer.howto.index');
    // Halaman create/edit terpisah
    Route::get('/prayer-howto/readings/create', [TataCaraSholatController::class, 'create'])->name('prayer.readings.create');
    Route::get('/prayer-howto/readings/{reading}/edit', [TataCaraSholatController::class, 'edit'])->name('prayer.readings.edit');
    // Aksi store/update/destroy
    Route::post('/prayer-howto/readings', [TataCaraSholatController::class, 'store'])->name('prayer.readings.store');
    Route::put('/prayer-howto/readings/{reading}', [TataCaraSholatController::class, 'update'])->name('prayer.readings.update');
    Route::delete('/prayer-howto/readings/{reading}', [TataCaraSholatController::class, 'destroy'])->name('prayer.readings.destroy');

    // Kaifiyah Jenazah (view + CRUD)
    Route::get('/funeral-howto', [KaifiyahJenazahController::class, 'index'])->name('funeral.howto.index');
    // Halaman create/edit terpisah
    Route::get('/funeral-howto/items/create', [KaifiyahJenazahController::class, 'create'])->name('funeral.items.create');
    Route::get('/funeral-howto/items/{item}/edit', [KaifiyahJenazahController::class, 'edit'])->name('funeral.items.edit');
    // Aksi store/update/destroy
    Route::post('/funeral-howto/items', [KaifiyahJenazahController::class, 'store'])->name('funeral.items.store');
    Route::put('/funeral-howto/items/{item}', [KaifiyahJenazahController::class, 'update'])->name('funeral.items.update');
    Route::delete('/funeral-howto/items/{item}', [KaifiyahJenazahController::class, 'destroy'])->name('funeral.items.destroy');

    // Bacaan Doa Harian
    Route::get('/daily-prayers', [\App\Http\Controllers\Admin\DailyPrayerController::class, 'index'])->name('daily.prayers.index');
    Route::get('/daily-prayers/create', [\App\Http\Controllers\Admin\DailyPrayerController::class, 'create'])->name('daily.prayers.create');
    Route::post('/daily-prayers', [\App\Http\Controllers\Admin\DailyPrayerController::class, 'store'])->name('daily.prayers.store');
    Route::get('/daily-prayers/{prayer}/edit', [\App\Http\Controllers\Admin\DailyPrayerController::class, 'edit'])->name('daily.prayers.edit');
    Route::put('/daily-prayers/{prayer}', [\App\Http\Controllers\Admin\DailyPrayerController::class, 'update'])->name('daily.prayers.update');
    Route::delete('/daily-prayers/{prayer}', [\App\Http\Controllers\Admin\DailyPrayerController::class, 'destroy'])->name('daily.prayers.destroy');

    // Materi
    Route::get('/materi', [\App\Http\Controllers\Admin\MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi/create', [\App\Http\Controllers\Admin\MateriController::class, 'create'])->name('materi.create');
    Route::post('/materi', [\App\Http\Controllers\Admin\MateriController::class, 'store'])->name('materi.store');
    Route::get('/materi/{material}/edit', [\App\Http\Controllers\Admin\MateriController::class, 'edit'])->name('materi.edit');
    Route::put('/materi/{material}', [\App\Http\Controllers\Admin\MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/{material}', [\App\Http\Controllers\Admin\MateriController::class, 'destroy'])->name('materi.destroy');

    // Opsi Materi (Kelas/Semester/Mapel)
    Route::get('/materi/options', [\App\Http\Controllers\Admin\MaterialOptionController::class, 'index'])->name('materi.options.index');
    Route::get('/materi/options/create', [\App\Http\Controllers\Admin\MaterialOptionController::class, 'create'])->name('materi.options.create');
    Route::post('/materi/options', [\App\Http\Controllers\Admin\MaterialOptionController::class, 'store'])->name('materi.options.store');
    Route::get('/materi/options/{option}/edit', [\App\Http\Controllers\Admin\MaterialOptionController::class, 'edit'])->name('materi.options.edit');
    Route::put('/materi/options/{option}', [\App\Http\Controllers\Admin\MaterialOptionController::class, 'update'])->name('materi.options.update');
    Route::delete('/materi/options/{option}', [\App\Http\Controllers\Admin\MaterialOptionController::class, 'destroy'])->name('materi.options.destroy');

    // Foto Kegiatan
    Route::get('/foto-kegiatan', [ActivityPhotoController::class, 'index'])->name('activity.photos.index');
    Route::get('/foto-kegiatan/create', [ActivityPhotoController::class, 'create'])->name('activity.photos.create');
    Route::post('/foto-kegiatan', [ActivityPhotoController::class, 'store'])->name('activity.photos.store');
    // Edit/Update/Destroy
    Route::get('/foto-kegiatan/{photo}/edit', [ActivityPhotoController::class, 'edit'])->name('activity.photos.edit');
    Route::put('/foto-kegiatan/{photo}', [ActivityPhotoController::class, 'update'])->name('activity.photos.update');
    Route::delete('/foto-kegiatan/{photo}', [ActivityPhotoController::class, 'destroy'])->name('activity.photos.destroy');

    // Single consolidated Account Management page with users listing
    Route::get('/account', function () {
        $users = \App\Models\User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.account.index', compact('users'));
    })->name('account.index');
});

?>
