@extends('layouts.admin')
@php /** @var array<string,string> $classes */ /** @var array<string,string> $semesters */ /** @var array<string,string> $subjects */ /** @var \App\Models\Material $material */ @endphp

@section('title', 'Edit Materi')
@section('page_title', 'Edit Materi')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.materi.index') }}">Materi</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title mb-0"><i class="fas fa-edit mr-2"></i> Form Edit Materi</h3>
            </div>
            <form action="{{ route('admin.materi.update', $material) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                                <option value="{{ $key }}" {{ $material->class_level === $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select id="semester" name="semester" class="form-control" required>
                            @foreach($semesters as $key => $name)
                                <option value="{{ $key }}" {{ $material->semester === $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subject">Mapel</label>
                        <select id="subject" name="subject" class="form-control" required>
                            @foreach($subjects as $key => $name)
                                <option value="{{ $key }}" {{ $material->subject === $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input id="title" name="title" type="text" class="form-control" value="{{ $material->title }}" required />
                    </div>
                    <div class="form-group">
                        <label for="description">Diskripsi</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{ $material->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">File (opsional)</label>
                        <input id="file" name="file" type="file" class="form-control-file" />
                        @if($material->file_path)
                            <div class="mt-2"><a href="{{ asset('storage/'.$material->file_path) }}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file mr-1"></i> Lihat File</a></div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="video_url">Link Video (opsional)</label>
                        <input id="video_url" name="video_url" type="url" class="form-control" value="{{ $material->video_url }}" />
                    </div>
                    <div class="form-group">
                        <label for="published_at">Tanggal Publikasi (opsional)</label>
                        <input id="published_at" name="published_at" type="date" class="form-control" value="{{ $material->published_at }}" />
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.materi.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection