<div class="card prayer-time">
    <div class="time-header">
        <span class="time-icon" aria-hidden="true">🕒</span>
        <h3>Waktu Saat Ini</h3>
    </div>
    <div id="currentTime" class="time-display">--:--:--</div>
</div>
<div class="card">
    <h2>Jadwal Sholat Hari Ini</h2>
    <div class="prayer-grid">
        <div class="prayer-card">
            <div class="prayer-name">Hari / Tanggal</div>
            <div class="prayer-time-value">{{ $prayerDate['day'] ?? '-' }}</div>
            <div style="margin-top:2px; font-size:0.95rem; opacity:0.9;">{{ $prayerDate['date'] ?? '-' }}</div>
        </div>
        <div class="prayer-card" data-time="{{ isset($prayerTimes['fajr']) ? substr($prayerTimes['fajr'],0,5) : '' }}">
            <div class="prayer-name">Subuh</div>
            <div class="prayer-time-value">{{ isset($prayerTimes['fajr']) ? substr($prayerTimes['fajr'],0,5) : '--:--' }}</div>
        </div>
        <div class="prayer-card" data-time="{{ isset($prayerTimes['dhuhr']) ? substr($prayerTimes['dhuhr'],0,5) : '' }}">
            <div class="prayer-name">Dzuhur</div>
            <div class="prayer-time-value">{{ isset($prayerTimes['dhuhr']) ? substr($prayerTimes['dhuhr'],0,5) : '--:--' }}</div>
        </div>
        <div class="prayer-card" data-time="{{ isset($prayerTimes['asr']) ? substr($prayerTimes['asr'],0,5) : '' }}">
            <div class="prayer-name">Ashar</div>
            <div class="prayer-time-value">{{ isset($prayerTimes['asr']) ? substr($prayerTimes['asr'],0,5) : '--:--' }}</div>
        </div>
        <div class="prayer-card" data-time="{{ isset($prayerTimes['maghrib']) ? substr($prayerTimes['maghrib'],0,5) : '' }}">
            <div class="prayer-name">Maghrib</div>
            <div class="prayer-time-value">{{ isset($prayerTimes['maghrib']) ? substr($prayerTimes['maghrib'],0,5) : '--:--' }}</div>
        </div>
        <div class="prayer-card" data-time="{{ isset($prayerTimes['isha']) ? substr($prayerTimes['isha'],0,5) : '' }}">
            <div class="prayer-name">Isya</div>
            <div class="prayer-time-value">{{ isset($prayerTimes['isha']) ? substr($prayerTimes['isha'],0,5) : '--:--' }}</div>
        </div>
    </div>
</div>