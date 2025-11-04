@extends('layouts.public')

@section('content')
    <div class="card">
        <h2>Pilih Mapel - Kelas {{ $class }}, Semester {{ ucfirst($semester) }}</h2>
        <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:8px;">
            @foreach($subjects as $s)
                <a class="btn" href="{{ route('materi.list', ['class' => $class, 'semester' => $semester, 'subject' => $s['key']]) }}">{{ $s['label'] }}</a>
            @endforeach
        </div>
        <div style="margin-top:16px; display:flex; gap:12px; flex-wrap:wrap;">
            <a class="btn btn-back" href="{{ route('materi.semester', ['class' => $class]) }}">Back Semester</a>
            <a class="btn btn-back" href="{{ route('materi.index') }}">Back Kelas</a>
        </div>
    </div>
@endsection