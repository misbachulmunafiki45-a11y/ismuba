@extends('layouts.admin')

@section('title', 'Jadwal Sholat')
@section('page_title', 'Jadwal Sholat')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Jadwal Sholat</li>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">SMKS Muhammadiyah 2 Genteng</h3>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex gap-2">
                <a href="{{ route('admin.prayer.create') }}" class="btn btn-success">
                    <i class="fas fa-plus mr-1"></i> Tambah Jadwal
                </a>
            </div>

            @php
                $dateDisplay = optional($schedule)->date ?? now()->toDateString();
                $fajr = $schedule->fajr ?? $defaults['fajr'];
                $dhuhr = $schedule->dhuhr ?? $defaults['dhuhr'];
                $asr = $schedule->asr ?? $defaults['asr'];
                $maghrib = $schedule->maghrib ?? $defaults['maghrib'];
                $isha = $schedule->isha ?? $defaults['isha'];
            @endphp

            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Subuh</th>
                        <th class="text-center">Zuhur</th>
                        <th class="text-center">Ashar</th>
                        <th class="text-center">Magrib</th>
                        <th class="text-center">Isya</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $row)
                        <tr>
                            <td>
                                @php
                                    $formattedDate = $row->date
                                        ? \Carbon\Carbon::parse($row->date)->locale('id')->isoFormat('dddd, DD-MM-YYYY')
                                        : '-';
                                @endphp
                                {{ $formattedDate }}
                            </td>
                            <td>{{ \Illuminate\Support\Str::of($row->fajr)->substr(0,5) }}</td>
                            <td>{{ \Illuminate\Support\Str::of($row->dhuhr)->substr(0,5) }}</td>
                            <td>{{ \Illuminate\Support\Str::of($row->asr)->substr(0,5) }}</td>
                            <td>{{ \Illuminate\Support\Str::of($row->maghrib)->substr(0,5) }}</td>
                            <td>{{ \Illuminate\Support\Str::of($row->isha)->substr(0,5) }}</td>
                            <td class="d-flex align-items-center justify-content-center gap-2">
                                <a href="{{ route('admin.prayer.edit') }}" class="btn btn-sm btn-primary mr-2">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.prayer.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin menghapus jadwal tanggal {{ $row->date }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt mr-1"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                @php
                                    $formattedDate = $dateDisplay
                                        ? \Carbon\Carbon::parse($dateDisplay)->locale('id')->isoFormat('dddd, DD-MM-YYYY')
                                        : '-';
                                @endphp
                                {{ $formattedDate }}
                            </td>
                            <td>{{ \Illuminate\Support\Str::of($fajr)->substr(0,5) }}</td>
                            <td>{{ \Illuminate\Support\Str::of($dhuhr)->substr(0,5) }}</td>
                            <td>{{ \Illuminate\Support\Str::of($asr)->substr(0,5) }}</td>
                            <td>{{ \Illuminate\Support\Str::of($maghrib)->substr(0,5) }}</td>
                            <td>{{ \Illuminate\Support\Str::of($isha)->substr(0,5) }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.prayer.edit') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if(method_exists($schedules, 'links'))
                <div class="d-flex justify-content-center mt-3">
                    {{ $schedules->onEachSide(1)->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection
