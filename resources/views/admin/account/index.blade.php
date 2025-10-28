@extends('layouts.admin')

@section('title', 'Manajemen Akun')
@section('page_title', 'Manajemen Akun')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Manajemen Akun</li>
@endsection

@section('content')
    <div class="mt-3 mb-4 d-flex flex-wrap">
        <a href="{{ route('admin.users.create') }}" class="btn btn-success mb-2">
            <i class="fas fa-user-plus mr-1"></i> Tambah Pengguna
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Akun</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="width: 180px;">Dibuat</th>
                        <th style="width: 220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at?->format('d M Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    @php $isSelf = Auth::check() && (Auth::id() === $user->id); @endphp
                                    @if($isSelf)
                                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-purple mr-1" title="Edit Profil Admin">
                                            <i class="fas fa-id-card"></i>
                                        </a>
                                        <a href="{{ route('admin.security.password') }}" class="btn btn-warning mr-1" title="Ubah Password">
                                            <i class="fas fa-key"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" disabled title="Tidak dapat menghapus akun sendiri">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <a href="#" class="btn btn-purple disabled mr-1" tabindex="-1" aria-disabled="true" title="Edit Profil (segera)">
                                            <i class="fas fa-id-card"></i>
                                        </a>
                                        <a href="#" class="btn btn-warning disabled mr-1" tabindex="-1" aria-disabled="true" title="Ubah Password (segera)">
                                            <i class="fas fa-key"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Hapus Akun">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($users) && method_exists($users, 'links'))
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
