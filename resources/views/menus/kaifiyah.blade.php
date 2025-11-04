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