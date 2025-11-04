@extends('layouts.public')

@section('content')
    <div class="card">
        <h2>Pilih Semester - Kelas {{ $class }}</h2>
        <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:8px;">
            @foreach($semesters as $s)
                <a class="btn" href="{{ route('materi.subject', ['class' => $class, 'semester' => $s['key']]) }}">Semester {{ $s['label'] }}</a>
            @endforeach
        </div>
        <div style="margin-top:16px;">
            <a class="btn btn-back" href="{{ route('materi.index') }}">Back Kelas</a>
        </div>
    </div>
@endsection