<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaifiyah Jenazah - {{ $sectionLabel }}</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>
    <div class="container" style="max-width: 960px; margin: 20px auto; padding: 0 12px;">
        <div class="card" style="margin-bottom: 16px;">
            <h2 style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                <span>Kaifiyah Jenazah — {{ $sectionLabel }}</span>
                <a class="btn" href="{{ route('home.section', 'kaifiyah') }}#kaifiyah-{{ $section }}">Back</a>
            </h2>
        </div>

        @forelse($items as $item)
            <div class="card" style="margin-bottom: 12px;">
                <h3 style="margin-bottom:6px;">{{ $item->title }}</h3>
                @if($item->image_path)
                    <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}" style="max-width:100%; border-radius:10px; margin:6px 0;" />
                @endif
                @if($item->description)
                    <p style="margin-top:6px;">{!! nl2br(e($item->description)) !!}</p>
                @endif
            </div>
        @empty
            <div class="card">
                <p>Belum ada data untuk bagian {{ $sectionLabel }}.</p>
            </div>
        @endforelse
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
