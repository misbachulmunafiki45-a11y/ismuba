@extends('layouts.admin')

@section('title', 'Manajemen Akun')
@section('page_title', 'Manajemen Akun')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Manajemen Akun</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-white font-weight-bold">
                        <i class="fas fa-id-card mr-2"></i> Edit Profil Admin
                    </h3>
                </div>
                <div class="card-body">
                    <p>Ubah nama, email, dan foto profil admin.</p>
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-cog mr-1"></i> Buka Halaman
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-white font-weight-bold">
                        <i class="fas fa-key mr-2"></i> Ubah Password
                    </h3>
                </div>
                <div class="card-body">
                    <p>Perbarui password akun Anda untuk keamanan.</p>
                    <a href="{{ route('admin.security.password') }}" class="btn btn-primary">
                        <i class="fas fa-key mr-1"></i> Buka Halaman
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-white font-weight-bold">
                        <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna
                    </h3>
                </div>
                <div class="card-body">
                    <p>Buat akun pengguna baru untuk akses sistem.</p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus mr-1"></i> Buka Halaman
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection