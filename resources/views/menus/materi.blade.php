@php use Illuminate\Support\Str; @endphp
<div class="card">
    <h2>Materi</h2>
    <div style="display:flex; gap:12px; flex-wrap:wrap; margin:8px 0 16px;">
        <a class="btn" href="{{ route('materi.semester', ['class' => 'X']) }}">Kelas X</a>
        <a class="btn" href="{{ route('materi.semester', ['class' => 'XI']) }}">Kelas XI</a>
        <a class="btn" href="{{ route('materi.semester', ['class' => 'XII']) }}">Kelas XII</a>
    </div>
    @php
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