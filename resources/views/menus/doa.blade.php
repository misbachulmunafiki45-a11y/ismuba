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