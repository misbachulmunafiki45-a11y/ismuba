@extends('layouts.admin')

@section('title', 'Edit Foto Kegiatan')
@section('page_title', 'Edit Foto Kegiatan')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.activity.photos.index') }}">Foto Kegiatan</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-secondary">
            <div class="card-header d-flex justify-content-between align-items-center pr-0">
                <h3 class="card-title mb-0">Form Edit Foto Kegiatan</h3>
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

                <form action="{{ route('admin.activity.photos.update', $photo) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label d-block">Gambar Saat Ini</label>
                        @if($photo->image_path)
                            <img src="{{ asset('storage/'.$photo->image_path) }}" alt="Foto" style="width:120px;height:120px;object-fit:cover;border-radius:8px;">
                        @else
                            <span class="text-muted">Tidak ada gambar</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="image" class="form-label">Ganti Gambar (opsional)</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="form-text text-muted">Format: jpg, jpeg, png, webp. Maks 2MB.</small>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Diskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Tulis deskripsi (opsional)">{{ old('description', $photo->description) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection