@extends('layouts.admin')

@section('title', 'Tambah Doa Harian')
@section('page_title', 'Tambah Doa Harian')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.daily.prayers.index') }}">Bacaan Doa Harian</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title mb-0"><i class="fas fa-plus mr-2"></i> Form Tambah Doa</h3>
            </div>
            <form action="{{ route('admin.daily.prayers.store') }}" method="POST">
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
                        <label for="title">Judul</label>
                        <input id="title" name="title" type="text" class="form-control" required placeholder="Masukkan judul doa" />
                    </div>
                    <div class="form-group">
                        <label for="arabic">Bacaan (Arab)</label>
                        <textarea id="arabic" name="arabic" class="form-control" rows="3" required placeholder="Masukkan bacaan Arab"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="latin">Latin</label>
                        <textarea id="latin" name="latin" class="form-control" rows="3" required placeholder="Masukkan transliterasi Latin"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">Diskripsi</label>
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Tambahkan diskripsi bila perlu"></textarea>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.daily.prayers.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection