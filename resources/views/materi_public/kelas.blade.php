@extends('layouts.public')

@section('content')
    <div class="card">
        <!-- Area gambar di atas judul, dengan shadow pada kontainer -->
        <div class="image-flexbox-card" style="display:flex; justify-content:center; align-items:center; flex-wrap:wrap; gap:12px; margin:12px 0 16px; background:#fff; border-radius:12px; padding:10px; box-shadow:0 8px 24px rgba(0,0,0,0.12);">
            <img src="{{ asset('img/masjid.jpg') }}" alt="Masjid" style="width:100%; max-width:720px; height:auto; border-radius:12px;">
        </div>

        <h2 style="text-align:center;">Pilih Kelas</h2>

        <!-- Tiga tombol kelas ditampilkan di tengah -->
        <div style="display:flex; justify-content:center; gap:12px; flex-wrap:wrap; margin-top:8px;">
            @foreach($classes as $c)
                <a class="btn" href="{{ route('materi.semester', ['class' => $c['key']]) }}">Kelas {{ $c['label'] }}</a>
            @endforeach
        </div>
    </div>
@endsection