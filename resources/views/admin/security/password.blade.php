@extends('layouts.admin')

@section('title', 'Ubah Password')
@section('page_title', 'Ubah Password')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Ubah Password</li>
@endsection

@section('content')
    @if(session('status') === 'password-updated')
        <div class="alert alert-success">Password berhasil diperbarui.</div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-white font-weight-bold">
                        <i class="fas fa-key mr-2"></i> Ubah Password Akun
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="current_password">Password Saat Ini</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" required>
                            @error('current_password', 'updatePassword')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            @error('password', 'updatePassword')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection