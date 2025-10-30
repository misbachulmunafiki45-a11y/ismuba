<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ISMUBA Digital</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>
@php use Illuminate\Support\Facades\Storage; @endphp

    <div class="container">
        <div class="header card">
            <div class="header-brand">
                <img src="{{ Storage::url('stm.png') }}" alt="" class="brand-logo">
                <div>
                    <h1>STEMDA ISMUBA</h1>
                    <p>Islam Agamaku Muhammadiyah Gerakanku</p>
                </div>
            </div>
        </div>

        <div class="desktop-nav">
            <div class="desktop-nav-grid">
                <div class="desktop-nav-item active" onclick="showSection('home', this)">
                    <div class="desktop-nav-icon">🏠</div>
                    <div class="desktop-nav-text">Home</div>
                </div>
                <div class="desktop-nav-item" onclick="showSection('wudhu', this)">
                    <div class="desktop-nav-icon">🚿</div>
                    <div class="desktop-nav-text">Wudhu</div>
                </div>
                <div class="desktop-nav-item" onclick="showSection('sholat', this)">
                    <div class="desktop-nav-icon">🕌</div>
                    <div class="desktop-nav-text">Sholat</div>
                </div>
                <div class="desktop-nav-item" onclick="showSection('doa', this)">
                    <div class="desktop-nav-icon">📿</div>
                    <div class="desktop-nav-text">Bacaan Doa</div>
                </div>
                <a href="https://quran.kemenag.go.id/" target="_blank" rel="noopener" class="desktop-nav-item">
                    <div class="desktop-nav-icon">📖</div>
                    <div class="desktop-nav-text">Alquran</div>
                </a>
                <div class="desktop-nav-item" onclick="showSection('kaifiyah', this)">
                    <div class="desktop-nav-icon">⚰️</div>
                    <div class="desktop-nav-text">Kaifiyah Jenazah</div>
                </div>
                <div class="desktop-nav-item" onclick="showSection('materi', this)">
                    <div class="desktop-nav-icon">🎓</div>
                    <div class="desktop-nav-text">Materi</div>
                </div>
                <div class="desktop-nav-item" onclick="showSection('foto', this)">
                    <div class="desktop-nav-icon">🖼️</div>
                    <div class="desktop-nav-text">Foto Kegiatan</div>
                </div>
            </div>
        </div>

        <div id="home" class="section">
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
        </div>

        <div id="wudhu" class="section hidden">
            <div class="card">
                <h2>Tata Cara Wudhu</h2>
                @forelse($wudhuReadings as $item)
                    <div class="item">
                        <h3>{{ $item->title }}</h3>
                        @if($item->image_path)
                            <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}" style="max-width: 100%; border-radius: 10px; margin: 10px 0;" />
                        @endif
                        @if($item->arabic)
                            <div class="arabic">{!! nl2br(e($item->arabic)) !!}</div>
                        @endif
                        @if($item->latin)
                            <div class="translation">{!! nl2br(e($item->latin)) !!}</div>
                        @endif
                        @if($item->description)
                            <p style="margin-top:8px;">{!! nl2br(e($item->description)) !!}</p>
                        @endif
                    </div>
                @empty
                    <p>Belum ada data wudhu.</p>
                @endforelse
            </div>
        </div>

        <div id="sholat" class="section hidden">
            <div class="card">
                <h2>Tata Cara Sholat</h2>
                @forelse($prayerReadings as $item)
                    <div class="item">
                        <h3>{{ $item->title }}</h3>
                        @if($item->image_path)
                            <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}" style="max-width: 100%; border-radius: 10px; margin: 10px 0;" />
                        @endif
                        @if($item->arabic)
                            <div class="arabic">{!! nl2br(e($item->arabic)) !!}</div>
                        @endif
                        @if($item->latin)
                            <div class="translation">{!! nl2br(e($item->latin)) !!}</div>
                        @endif
                        @if($item->description)
                            <p style="margin-top:8px;">{!! nl2br(e($item->description)) !!}</p>
                        @endif
                    </div>
                @empty
                    <p>Belum ada data sholat.</p>
                @endforelse
            </div>
        </div>

        <div id="doa" class="section hidden">
            <div class="card">
                <h2>Bacaan Doa Harian</h2>
                @forelse($dailyPrayers as $prayer)
                    <div class="item">
                        <h3>{{ $prayer->title }}</h3>
                        @if($prayer->arabic)
                            <div class="arabic">{!! nl2br(e($prayer->arabic)) !!}</div>
                        @endif
                        @if($prayer->latin)
                            <div class="translation">{!! nl2br(e($prayer->latin)) !!}</div>
                        @endif
                        @if($prayer->description)
                            <p style="margin-top:8px;">{!! nl2br(e($prayer->description)) !!}</p>
                        @endif
                    </div>
                @empty
                    <p>Belum ada doa harian.</p>
                @endforelse
            </div>

            <div class="card dhikr-counter">
                <h2>Dzikir Digital</h2>
                <div class="counter-display" id="dhikrCount">0</div>
                <button class="counter-btn" onclick="document.getElementById('dhikrCount').textContent = (+document.getElementById('dhikrCount').textContent + 1)">Tambah</button>
                <button class="counter-btn" onclick="document.getElementById('dhikrCount').textContent = 0">Reset</button>
            </div>
        </div>

        <div id="alquran" class="section hidden">
            <div class="card">
                <h2>Al-Qur'an Digital</h2>
                <p>Buka Al-Qur'an digital untuk membaca dan mendengarkan tilawah.</p>
                <a class="btn" href="https://quran.kemenag.go.id/" target="_blank" rel="noopener">Buka Qur'an Kemenag</a>
            </div>
        </div>

        <div id="kaifiyah" class="section hidden">
            <div class="card">
                <h2>Kaifiyah Jenazah</h2>
                @forelse($kaifiyahItems as $section => $items)
                    <div class="item" style="background: rgba(102, 126, 234, 0.2); color:#2c3e50;">
                        <h3 style="margin-bottom:6px;">Bagian: {{ $section }}</h3>
                        @foreach($items as $item)
                            <div style="background: white; color:#333; padding:12px; border-radius:8px; margin:8px 0;">
                                <h4 style="margin-bottom:6px;">{{ $item->title }}</h4>
                                @if($item->image_path)
                                    <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}" style="max-width: 100%; border-radius: 10px; margin: 6px 0;" />
                                @endif
                                @if($item->description)
                                    <p>{!! nl2br(e($item->description)) !!}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p>Belum ada data kaifiyah.</p>
                @endforelse
            </div>
        </div>

        <div id="materi" class="section hidden">
            <div class="card">
                <h2>Materi</h2>
                @forelse($materials as $m)
                    <div class="item">
                        <h3>{{ $m->title }}</h3>
                        <p style="opacity:0.9;">Kelas {{ $m->class_level }} • Semester {{ $m->semester }} • Mapel {{ $m->subject }}</p>
                        @if($m->description)
                            <p style="margin-top:6px;">{!! nl2br(e($m->description)) !!}</p>
                        @endif
                        <div style="margin-top:8px; display:flex; gap:10px; flex-wrap:wrap;">
                            @if($m->file_path)
                                <a class="btn" href="{{ Storage::url($m->file_path) }}" target="_blank" rel="noopener">Lihat File</a>
                            @endif
                            @if($m->video_url)
                                <a class="btn" href="{{ $m->video_url }}" target="_blank" rel="noopener">Tonton Video</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p>Belum ada materi.</p>
                @endforelse
            </div>
        </div>

        <div id="foto" class="section hidden">
            <div class="card">
                <h2>Foto Kegiatan</h2>
                <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px;">
                    @forelse($activityPhotos as $photo)
                        <div>
                            <img src="{{ Storage::url($photo->image_path) }}" alt="Foto Kegiatan" style="width:100%; height:160px; object-fit:cover; border-radius:12px;" />
                            @if($photo->description)
                                <p style="margin-top:6px; text-align:center; color:#2c3e50;">{{ $photo->description }}</p>
                            @endif
                        </div>
                    @empty
                        <p>Belum ada foto kegiatan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bottom-nav">
            <div class="nav-item active" onclick="showSection('home', this)">
                <div class="nav-icon">🏠</div>
                <div class="nav-text">Home</div>
            </div>
            <div class="nav-item" onclick="showSection('wudhu', this)">
                <div class="nav-icon">🚿</div>
                <div class="nav-text">Wudhu</div>
            </div>
            <div class="nav-item" onclick="showSection('sholat', this)">
                <div class="nav-icon">🕌</div>
                <div class="nav-text">Sholat</div>
            </div>
            <div class="nav-item" onclick="showSection('doa', this)">
                <div class="nav-icon">📿</div>
                <div class="nav-text">Doa</div>
            </div>
            <div class="nav-item" onclick="window.open('https://quran.kemenag.go.id/', '_blank')">
                <div class="nav-icon">📖</div>
                <div class="nav-text">Alquran</div>
            </div>
            <div class="nav-item" onclick="showSection('kaifiyah', this)">
                <div class="nav-icon">⚰️</div>
                <div class="nav-text">Kaifiyah</div>
            </div>
            <div class="nav-item" onclick="showSection('materi', this)">
                <div class="nav-icon">🎓</div>
                <div class="nav-text">Materi</div>
            </div>
            <div class="nav-item" onclick="showSection('foto', this)">
                <div class="nav-icon">🖼️</div>
                <div class="nav-text">Foto</div>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>