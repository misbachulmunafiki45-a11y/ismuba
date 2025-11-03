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
                <a class="desktop-nav-item active" href="{{ url('/') }}" data-section="home">
                    <div class="desktop-nav-icon">🏠</div>
                    <div class="desktop-nav-text">Home</div>
                </a>
                <a class="desktop-nav-item" href="{{ url('/wudhu') }}" data-section="wudhu">
                    <div class="desktop-nav-icon">
                        <img src="{{ asset('img/wudhu.png') }}" alt="Wudhu" class="nav-icon-img" onerror="this.style.display='none'; this.parentNode.querySelector('.nav-icon-fallback').style.display='inline-block';">
                        <span class="nav-icon-fallback" style="display:none;">🚿</span>
                    </div>
                    <div class="desktop-nav-text">Wudhu</div>
                </a>
                <a class="desktop-nav-item" href="{{ url('/sholat') }}" data-section="sholat">
                    <div class="desktop-nav-icon">
                        <img src="{{ asset('img/sholat.png') }}" alt="Sholat" class="nav-icon-img" onerror="this.style.display='none'; this.parentNode.querySelector('.nav-icon-fallback').style.display='inline-block';">
                        <span class="nav-icon-fallback" style="display:none;">🕌</span>
                    </div>
                    <div class="desktop-nav-text">Sholat</div>
                </a>
                <a class="desktop-nav-item" href="{{ url('/doa') }}" data-section="doa">
                    <div class="desktop-nav-icon">📿</div>
                    <div class="desktop-nav-text">Bacaan Doa</div>
                </a>
                <a class="desktop-nav-item" href="{{ url('/kaifiyah') }}" data-section="kaifiyah">
                    <div class="desktop-nav-icon">
                        <img src="{{ asset('img/jenazah.png') }}" alt="Kaifiyah" class="nav-icon-img nav-icon-img--lg" onerror="this.style.display='none'; this.parentNode.querySelector('.nav-icon-fallback').style.display='inline-block';">
                        <span class="nav-icon-fallback" style="display:none;">🕌</span>
                    </div>
                    <div class="desktop-nav-text">Kaifiyah Jenazah</div>
                </a>
                <a class="desktop-nav-item" href="{{ url('/materi') }}" data-section="materi">
                    <div class="desktop-nav-icon">🎓</div>
                    <div class="desktop-nav-text">Materi</div>
                </a>
                <a class="desktop-nav-item" href="{{ url('/foto') }}" data-section="foto">
                    <div class="desktop-nav-icon">🖼️</div>
                    <div class="desktop-nav-text">Foto Kegiatan</div>
                </a>
                <a href="https://quran.kemenag.go.id/" target="_blank" rel="noopener" class="desktop-nav-item">
                    <div class="desktop-nav-icon">
                        <img src="{{ asset('img/alquran.png') }}" alt="Alquran" class="nav-icon-img" onerror="this.style.display='none'; this.parentNode.querySelector('.nav-icon-fallback').style.display='inline-block';">
                        <span class="nav-icon-fallback" style="display:none;">📖</span>
                    </div>
                    <div class="desktop-nav-text">Alquran</div>
                </a>
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
                <div class="wudhu-grid">
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
        </div>

        <div id="sholat" class="section hidden">
            <div class="card">
                <h2>Tata Cara Sholat</h2>
                <div class="wudhu-grid sholat-grid">
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
                @php
                    $kaifiyahLabels = [
                        'bathing' => 'Memandikan',
                        'shrouding' => 'Mengkafani',
                        'prayer' => 'Mensholatkan',
                        'burial' => 'Mengkubur',
                    ];
                    $kaifiyahSections = ['bathing','shrouding','prayer','burial'];
                @endphp
                <div class="kaifiyah-menu">
                    @foreach($kaifiyahSections as $sec)
                        <div class="kaifiyah-tile" data-section="{{ $sec }}">
                            <a class="kaifiyah-menu-item" href="{{ route('funeral.howto.section', $sec) }}">{{ $kaifiyahLabels[$sec] }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="materi" class="section hidden">
            <div class="card">
                <h2>Materi</h2>
                <div style="display:flex; gap:12px; flex-wrap:wrap; margin:8px 0 16px;">
                    <a class="btn" href="{{ route('home.section', 'materi') }}#kelas-x">Kelas X</a>
                    <a class="btn" href="{{ route('home.section', 'materi') }}#kelas-xi">Kelas XI</a>
                    <a class="btn" href="{{ route('home.section', 'materi') }}#kelas-xii">Kelas XII</a>
                </div>
                @php
                    use Illuminate\Support\Str;
                    $groups = $materials->groupBy('subject');
                @endphp
                @if($groups->isEmpty())
                    <p>Belum ada materi.</p>
                @else
                    <div class="materi-menu" style="display:flex; gap:12px; flex-wrap:wrap;">
                        @foreach($groups as $subject => $items)
                            @php $slug = Str::slug($subject ?: 'umum'); @endphp
                            <div class="materi-tile" data-section="{{ $slug }}">
                                <a class="materi-menu-item" href="{{ route('home.section', 'materi') }}#materi-{{ $slug }}">{{ $subject ?: 'Umum' }}</a>
                            </div>
                        @endforeach
                    </div>

                    @foreach($groups as $subject => $items)
                        @php $slug = Str::slug($subject ?: 'umum'); @endphp
                        <div id="materi-content-{{ $slug }}" hidden class="card" style="margin-top:12px;">
                            <h3 style="margin-bottom:8px;">{{ $subject ?: 'Umum' }}</h3>
                            @foreach($items as $m)
                                <div class="item" style="margin-bottom:12px;">
                                    <h4 style="margin-bottom:4px;">{{ $m->title }}</h4>
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
                            @endforeach
                        </div>
                    @endforeach
                @endif
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
            <a class="nav-item active" href="{{ url('/') }}" data-section="home">
                <div class="nav-icon">🏠</div>
                <div class="nav-text">Home</div>
            </a>
            <a class="nav-item" href="{{ url('/wudhu') }}" data-section="wudhu">
                <div class="nav-icon">
                    <img src="{{ asset('img/wudhu.png') }}" alt="Wudhu" class="nav-icon-img" onerror="this.style.display='none'; this.parentNode.querySelector('.nav-icon-fallback').style.display='inline-block';">
                    <span class="nav-icon-fallback" style="display:none;">🚿</span>
                </div>
                <div class="nav-text">Wudhu</div>
            </a>
            <a class="nav-item" href="{{ url('/sholat') }}" data-section="sholat">
                <div class="nav-icon">
                    <img src="{{ asset('img/sholat.png') }}" alt="Sholat" class="nav-icon-img" onerror="this.style.display='none'; this.parentNode.querySelector('.nav-icon-fallback').style.display='inline-block';">
                    <span class="nav-icon-fallback" style="display:none;">🕌</span>
                </div>
                <div class="nav-text">Sholat</div>
            </a>
            <a class="nav-item" href="{{ url('/doa') }}" data-section="doa">
                <div class="nav-icon">📿</div>
                <div class="nav-text">Doa</div>
            </a>
            <a class="nav-item" href="{{ url('/kaifiyah') }}" data-section="kaifiyah">
                <div class="nav-icon">
                    <img src="{{ asset('img/jenazah.png') }}" alt="Kaifiyah" class="nav-icon-img nav-icon-img--lg" onerror="this.style.display='none'; this.parentNode.querySelector('.nav-icon-fallback').style.display='inline-block';">
                    <span class="nav-icon-fallback" style="display:none;">🕌</span>
                </div>
                <div class="nav-text">Kaifiyah</div>
            </a>
            <a class="nav-item" href="{{ url('/materi') }}" data-section="materi">
                <div class="nav-icon">🎓</div>
                <div class="nav-text">Materi</div>
            </a>
            <a class="nav-item" href="{{ url('/foto') }}" data-section="foto">
                <div class="nav-icon">🖼️</div>
                <div class="nav-text">Foto</div>
            </a>
            <a class="nav-item" href="https://quran.kemenag.go.id/" target="_blank" rel="noopener">
                <div class="nav-icon">
                    <img src="{{ asset('img/alquran.png') }}" alt="Alquran" class="nav-icon-img" onerror="this.style.display='none'; this.parentNode.querySelector('.nav-icon-fallback').style.display='inline-block';">
                    <span class="nav-icon-fallback" style="display:none;">📖</span>
                </div>
                <div class="nav-text">Alquran</div>
            </a>
        </div>

    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>