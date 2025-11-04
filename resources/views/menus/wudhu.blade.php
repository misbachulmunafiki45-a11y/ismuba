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