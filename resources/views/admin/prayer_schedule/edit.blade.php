@extends('layouts.admin')

@section('title', 'Edit Jadwal Sholat')
@section('page_title', 'Pengaturan Jadwal Sholat')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.prayer.index') }}">Jadwal Sholat</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-clock mr-2"></i> Atur Waktu Sholat</h3>
            </div>
            <form action="{{ route('admin.prayer.update') }}" method="POST">
                @csrf
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @php
                        $current = [
                            'fajr' => $schedule->fajr ?? $defaults['fajr'],
                            'dhuhr' => $schedule->dhuhr ?? $defaults['dhuhr'],
                            'asr' => $schedule->asr ?? $defaults['asr'],
                            'maghrib' => $schedule->maghrib ?? $defaults['maghrib'],
                            'isha' => $schedule->isha ?? $defaults['isha'],
                        ];
                    @endphp

                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ old('date', optional($schedule)->date ?? now()->toDateString()) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="fajr">Subuh</label>
                        <input type="time" class="form-control" id="fajr" name="fajr" value="{{ old('fajr', substr($current['fajr'],0,5)) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="dhuhr">Dzuhur</label>
                        <input type="time" class="form-control" id="dhuhr" name="dhuhr" value="{{ old('dhuhr', substr($current['dhuhr'],0,5)) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="asr">Ashar</label>
                        <input type="time" class="form-control" id="asr" name="asr" value="{{ old('asr', substr($current['asr'],0,5)) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="maghrib">Maghrib</label>
                        <input type="time" class="form-control" id="maghrib" name="maghrib" value="{{ old('maghrib', substr($current['maghrib'],0,5)) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="isha">Isya</label>
                        <input type="time" class="form-control" id="isha" name="isha" value="{{ old('isha', substr($current['isha'],0,5)) }}" required>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.prayer.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection