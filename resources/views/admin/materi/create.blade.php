@extends('layouts.admin')
@php /** @var array<string,string> $classes */ /** @var array<string,string> $semesters */ /** @var array<string,string> $subjects */ /** @var string $defaultClass */ /** @var string $defaultSemester */ /** @var string $defaultSubject */ @endphp

@section('title', 'Tambah Materi')
@section('page_title', 'Tambah Materi')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.materi.index') }}">Materi</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title mb-0"><i class="fas fa-plus mr-2"></i> Form Tambah Materi</h3>
            </div>
            <form action="{{ route('admin.materi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-exclamation-triangle mr-2"></i> Terjadi kesalahan:
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="class_level">Kelas</label>
                        <select id="class_level" name="class_level" class="form-control" required>
                            @foreach($classes as $key => $name)
                                <option value="{{ $key }}" {{ $defaultClass === $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select id="semester" name="semester" class="form-control" required>
                            @foreach($semesters as $key => $name)
                                <option value="{{ $key }}" {{ $defaultSemester === $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subject">Mapel</label>
                        <select id="subject" name="subject" class="form-control" required>
                            @foreach($subjects as $key => $name)
                                <option value="{{ $key }}" {{ $defaultSubject === $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input id="title" name="title" type="text" class="form-control" required placeholder="Judul materi" />
                    </div>
                    <div class="form-group">
                        <label for="description">Diskripsi</label>
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Ringkasan materi"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">File (opsional)</label>
                        <input id="file" name="file" type="file" class="form-control-file" />
                        <small class="form-text text-muted">PDF/DOC/ZIP, maks 5MB.</small>
                    </div>
                    <div class="form-group">
                        <label for="video_url">Link Video (opsional)</label>
                        <input id="video_url" name="video_url" type="url" class="form-control" placeholder="https://..." />
                    </div>
                    <div class="form-group">
                        <label for="published_at">Tanggal Publikasi (opsional)</label>
                        <input id="published_at" name="published_at" type="date" class="form-control" />
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.materi.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection