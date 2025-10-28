@extends('layouts.admin')

@section('title', 'Tambah Foto Kegiatan')
@section('page_title', 'Tambah Foto Kegiatan')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.activity.photos.index') }}">Foto Kegiatan</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-secondary">
            <div class="card-header d-flex justify-content-between align-items-center pr-0">
                <h3 class="card-title mb-0">Form Tambah Foto Kegiatan</h3>
                <div class="card-tools pr-0">
                    <a href="{{ route('admin.activity.photos.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.activity.photos.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="image" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">Diskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Tulis deskripsi (opsional)"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection