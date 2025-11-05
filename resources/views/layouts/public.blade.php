<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ISMUBA Digital</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>
@php use Illuminate\Support\Facades\Storage; @endphp

    <div class="container">
        <!-- Header brand sama seperti halaman Kaifiyah/Home -->
        <div class="header card">
            <div class="header-brand">
                <img src="{{ Storage::url('stm.png') }}" alt="" class="brand-logo">
                <div>
                    <h1>STEMDA ISMUBA</h1>
                    <p>Islam Agamaku Muhammadiyah Gerakanku</p>
                </div>
            </div>
        </div>

        <!-- Desktop navigation, Materi aktif -->
        <div class="desktop-nav">
            <div class="desktop-nav-grid">
                <a class="desktop-nav-item" href="{{ url('/') }}" data-section="home">
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
                <a class="desktop-nav-item active" href="{{ url('/materi') }}" data-section="materi">
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

        <main>
            @yield('content')
        </main>

        <!-- Bottom navigation, Materi aktif -->
        <div class="bottom-nav">
            <a class="nav-item" href="{{ url('/') }}" data-section="home">
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
            <a class="nav-item active" href="{{ url('/materi') }}" data-section="materi">
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
