@extends('layouts.admin')

@section('title', 'Opsi Materi')
@section('page_title', 'Kelola Opsi Materi')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.materi.index') }}">Materi</a></li>
    <li class="breadcrumb-item active">Opsi</li>
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

        <div class="d-flex justify-content-end mt-3 mb-3">
            <a href="{{ route('admin.materi.options.create') }}" class="btn btn-purple">
                <i class="fas fa-plus mr-1"></i> Tambah
            </a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-secondary">
                    <div class="card-header d-flex justify-content-between align-items-center pr-0">
                        <h3 class="card-title mb-0">Kelas</h3>
                        
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 60px">No</th>
                                        <th>Nama</th>
                                        <th style="width: 120px" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classOptions as $i => $opt)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td class="font-weight-bold">{{ $opt->key }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.materi.options.edit', $opt) }}" class="btn btn-sm btn-primary mr-1" title="Edit"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('admin.materi.options.destroy', $opt) }}" method="POST" style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus opsi ini?')" title="Delete"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-muted py-4">Belum ada opsi.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-secondary">
                    <div class="card-header d-flex justify-content-between align-items-center pr-0">
                        <h3 class="card-title mb-0">Mapel</h3>
                        
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 60px">No</th>
                                        <th>Nama</th>
                                        <th style="width: 120px" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subjectOptions as $i => $opt)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td class="font-weight-bold">{{ $opt->key }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.materi.options.edit', $opt) }}" class="btn btn-sm btn-primary mr-1" title="Edit"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('admin.materi.options.destroy', $opt) }}" method="POST" style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus opsi ini?')" title="Delete"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-muted py-4">Belum ada opsi.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection