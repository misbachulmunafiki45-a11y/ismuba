@extends('layouts.admin')
@php /** @var array<string,string> $classes */ /** @var array<string,string> $semesters */ /** @var array<string,string> $subjects */ /** @var string $selectedClass */ /** @var string $selectedSemester */ /** @var string $selectedSubject */ @endphp

@section('title', 'Materi')
@section('page_title', 'Materi - Manajemen Data')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Materi</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif
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

        <div class="card card-outline card-secondary">
            <div class="card-header d-flex justify-content-between align-items-center pr-0">
                <h3 class="card-title mb-0">Daftar Materi</h3>
                <div class="card-tools pr-0">
                    <a href="{{ route('admin.materi.options.index') }}" class="btn btn-info mr-1"><i class="fas fa-cog mr-1"></i> Kelola Opsi</a>
                    <a href="{{ route('admin.materi.create', $filters) }}" class="btn btn-purple"><i class="fas fa-plus mr-1"></i> Tambah Materi</a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.materi.index') }}" class="form-inline mb-3">
                    <div class="form-group mr-2">
                        <label class="mr-2">Kelas</label>
                        <select name="class_level" class="form-control">
                            <option value="">Semua</option>
                            @foreach($classes as $key => $name)
                                <option value="{{ $key }}" {{ $selectedClass === $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mr-2">
                        <label class="mr-2">Semester</label>
                        <select name="semester" class="form-control">
                            <option value="">Semua</option>
                            @foreach($semesters as $key => $name)
                                <option value="{{ $key }}" {{ $selectedSemester === $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mr-2">
                        <label class="mr-2">Mapel</label>
                        <select name="subject" class="form-control">
                            <option value="">Semua</option>
                            @foreach($subjects as $key => $name)
                                <option value="{{ $key }}" {{ $selectedSubject === $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter mr-1"></i> Terapkan</button>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0" style="table-layout: auto; width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px">No</th>
                                <th style="min-width: 120px">Kelas</th>
                                <th style="min-width: 120px">Semester</th>
                                <th style="min-width: 120px">Mapel</th>
                                <th style="min-width: 140px">Judul</th>
                                <th style="width: 90px; text-align:center;">File</th>
                                <th>Diskripsi</th>
                                <th style="width: 100px; text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materials as $i => $m)
                                <tr>
                                    <td>{{ ($materials->firstItem() ?? 1) + $i }}</td>
                                    <td>{{ $m->class_level }}</td>
                                    <td>{{ ucfirst($m->semester) }}</td>
                                    <td>{{ $m->subject }}</td>
                                    <td class="font-weight-bold">{{ $m->title }}</td>
                                    <td class="text-center">
                                        @if($m->file_path)
                                            <a href="{{ asset('storage/'.$m->file_path) }}" target="_blank" class="btn btn-sm btn-info" title="Lihat File" aria-label="Lihat File" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;"><i class="fas fa-file-pdf"></i></a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-muted" style="white-space: normal; word-break: break-word;">{{ $m->description }}</td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            @if($m->video_url)
                                                <a href="{{ $m->video_url }}" target="_blank" class="btn btn-sm btn-success mb-1" title="Video" aria-label="Video" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;"><i class="fas fa-video"></i></a>
                                            @endif
                                            <a href="{{ route('admin.materi.edit', $m) }}" class="btn btn-sm btn-primary mb-1" title="Edit" aria-label="Edit" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.materi.destroy', $m) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete" aria-label="Delete" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;" onclick="return confirm('Hapus materi ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data materi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">{{ $materials->links() }}</div>
        </div>
    </div>
</div>
@endsection