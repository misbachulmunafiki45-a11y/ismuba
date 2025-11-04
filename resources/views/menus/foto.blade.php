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