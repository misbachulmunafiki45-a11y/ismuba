@extends('layouts.public')

@section('content')
    <div class="card">
        <h2>Materi - Kelas {{ $class }}, Semester {{ ucfirst($semester) }}, Mapel {{ $subject }}</h2>
        @if($materials->isEmpty())
            <p>Belum ada materi.</p>
        @else
            @foreach($materials as $m)
                <div class="item" style="margin-bottom:12px;">
                    <h3 style="margin-bottom:6px;">{{ $m->title }}</h3>
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
        @endif
        <div style="margin-top:16px; display:flex; gap:12px; flex-wrap:wrap;">
            <a class="btn btn-back" href="{{ route('materi.subject', ['class' => $class, 'semester' => $semester]) }}">Back Mapel</a>
            <a class="btn btn-back" href="{{ route('materi.semester', ['class' => $class]) }}">Back Semester</a>
            <a class="btn btn-back" href="{{ route('materi.index') }}">Back Kelas</a>
        </div>
    </div>
@endsection