<div class="card prayer-time">
    <div class="digital-clock-wrapper">
        <div class="clock-label hover-title" aria-label="HOVER OVER ME!">
            <span>W</span><span>A</span><span>K</span><span>T</span><span>U</span><span>&nbsp;
            </span><span>S</span><span>A</span><span>A</span><span>T</span><span>&nbsp;
            </span><span>I</span><span>N</span><span>I</span>
        </div>
        <div class="digital-clock" id="currentTime">00:00:00</div>
    </div>
</div>
<div class="card">
    <h2>Jadwal Sholat</h2>
    <div class="prayer-grid">
        <div class="prayer-card">
            <div class="prayer-name">Date</div>
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
