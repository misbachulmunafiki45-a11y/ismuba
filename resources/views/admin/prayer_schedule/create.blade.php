@extends('layouts.admin')

@section('title', 'Tambah Jadwal Sholat')
@section('page_title', 'Tambah Jadwal Sholat')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.prayer.index') }}">Jadwal Sholat</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus mr-2"></i> Tambah Jadwal Baru</h3>
            </div>
            <form action="{{ route('admin.prayer.store') }}" method="POST">
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
                            'fajr' => $defaults['fajr'],
                            'dhuhr' => $defaults['dhuhr'],
                            'asr' => $defaults['asr'],
                            'maghrib' => $defaults['maghrib'],
                            'isha' => $defaults['isha'],
                        ];
                    @endphp

                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ old('date', now()->toDateString()) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="fajr">Subuh</label>
                        <input type="time" class="form-control" id="fajr" name="fajr" value="{{ old('fajr', substr($current['fajr'],0,5)) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="dhuhr">Zuhur</label>
                        <input type="time" class="form-control" id="dhuhr" name="dhuhr" value="{{ old('dhuhr', substr($current['dhuhr'],0,5)) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="asr">Ashar</label>
                        <input type="time" class="form-control" id="asr" name="asr" value="{{ old('asr', substr($current['asr'],0,5)) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="maghrib">Magrib</label>
                        <input type="time" class="form-control" id="maghrib" name="maghrib" value="{{ old('maghrib', substr($current['maghrib'],0,5)) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="isha">Isya</label>
                        <input type="time" class="form-control" id="isha" name="isha" value="{{ old('isha', substr($current['isha'],0,5)) }}" required>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.prayer.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection