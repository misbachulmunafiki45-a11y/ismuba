@extends('layouts.admin')

@section('title', 'Edit Bacaan Wudhu')
@section('page_title', 'Edit Bacaan Wudhu')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.wudhu.howto.index') }}">Tata Cara Berwudhu</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title mb-0"><i class="fas fa-edit mr-2"></i> Form Edit Bacaan</h3>
            </div>
            <form action="{{ route('admin.wudhu.readings.update', $reading) }}" method="POST" enctype="multipart/form-data">
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
                        <input id="title" name="title" type="text" class="form-control" required value="{{ old('title', $reading->title) }}" />
                    </div>
                    <div class="form-group">
                        <label for="arabic">Bacaan (Arab)</label>
                        <textarea id="arabic" name="arabic" class="form-control" rows="2" required>{{ old('arabic', $reading->arabic) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="latin">Latin</label>
                        <input id="latin" name="latin" type="text" class="form-control" required value="{{ old('latin', $reading->latin) }}" />
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $reading->description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar (opsional)</label>
                        @if($reading->image_path)
                            <div class="mb-2">
                                <img src="{{ Storage::disk('public')->url($reading->image_path) }}" alt="Gambar" style="max-height: 120px; border-radius: 4px;" />
                            </div>
                        @endif
                        <input id="image" name="image" type="file" accept="image/*" class="form-control-file" />
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.wudhu.howto.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection