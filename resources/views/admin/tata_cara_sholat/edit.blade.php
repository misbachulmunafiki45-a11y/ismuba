@extends('layouts.admin')

@section('title', 'Edit Bacaan Sholat')
@section('page_title', 'Edit Bacaan Sholat')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.prayer.howto.index') }}">Tata Cara Sholat</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title mb-0"><i class="fas fa-edit mr-2"></i> Form Edit Bacaan</h3>
            </div>
            <form action="{{ route('admin.prayer.readings.update', $reading) }}" method="POST" enctype="multipart/form-data">
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
                        <label for="title">Judul</label>
                        <input id="title" name="title" type="text" class="form-control" value="{{ $reading->title }}" required />
                    </div>
                    <div class="form-group">
                        <label for="arabic">Bacaan (Arab)</label>
                        <textarea id="arabic" name="arabic" class="form-control" rows="2" required>{{ $reading->arabic }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="latin">Latin</label>
                        <input id="latin" name="latin" type="text" class="form-control" value="{{ $reading->latin }}" required />
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar (opsional)</label>
                        <input id="image" name="image" type="file" accept="image/*" class="form-control-file" />
                        @if($reading->image_path)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$reading->image_path) }}" alt="Ilustrasi" style="width:64px;height:64px;border-radius:6px;object-fit:cover;" />
                            </div>
                        @endif
                        <small class="form-text text-muted">Biarkan kosong untuk mempertahankan gambar lama.</small>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.prayer.howto.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection