@extends('layouts.admin')

@section('title', 'Tata Cara Berwudhu')
@section('page_title', 'Tata Cara Berwudhu')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tata Cara Berwudhu</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-check-circle mr-2"></i> {{ session('status') }}
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

        <div class="card card-outline card-secondary mt-3">
            <div class="card-header d-flex justify-content-between align-items-center pr-0">
                <h3 class="card-title mb-0">Daftar Bacaan Wudhu</h3>
                <div class="card-tools pr-0">
                    <a href="{{ route('admin.wudhu.readings.create') }}" class="btn btn-success mr-1">
                        <i class="fas fa-plus mr-1"></i> Tambah
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="readingTable" class="table table-striped table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px">No</th>
                                <th class="text-left" style="min-width: 130px">Judul</th>
                                <th style="width: 90px">Gambar</th>
                                <th>Bacaan (Arab)</th>
                                <th>Latin</th>
                                <th>Deskripsi</th>
                                <th style="width: 100px; text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="readingTbody">
                            @forelse($readings as $index => $reading)
                                <tr data-id="{{ $reading->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="align-middle font-weight-bold">{{ $reading->title }}</td>
                                    <td>
                                        @if($reading->image_path)
                                            <img src="{{ Storage::disk('public')->url($reading->image_path) }}" alt="Gambar" style="width: 70px; height: auto; border-radius: 4px;" />
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td style="white-space: pre-line">{{ $reading->arabic }}</td>
                                    <td style="white-space: pre-line">{{ $reading->latin }}</td>
                                    <td style="white-space: pre-line">{{ $reading->description }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Aksi">
                                            <a href="{{ route('admin.wudhu.readings.edit', $reading) }}" class="btn btn-sm btn-primary" title="Edit" aria-label="Edit" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.wudhu.readings.destroy', $reading) }}" method="POST" style="display:inline-block; margin-left:6px;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete" aria-label="Delete" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;" onclick="return confirm('Hapus bacaan ini?')"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="empty-row">
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data bacaan wudhu.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection