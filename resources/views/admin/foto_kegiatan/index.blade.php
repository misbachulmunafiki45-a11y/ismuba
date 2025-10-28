@extends('layouts.admin')

@section('title', 'Foto Kegiatan')
@section('page_title', 'Foto Kegiatan')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Foto Kegiatan</li>
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

        <div class="card card-outline card-secondary">
            <div class="card-header d-flex justify-content-between align-items-center pr-0">
                <h3 class="card-title mb-0">Daftar Foto Kegiatan</h3>
                <div class="card-tools pr-0">
                    <a href="{{ route('admin.activity.photos.create') }}" class="btn btn-success"><i class="fas fa-plus mr-1"></i> Tambah</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px">No</th>
                                <th style="width: 110px; text-align:left;">Image</th>
                                <th style="width: 50%; text-align:left;">Diskripsi</th>
                                <th style="width: 120px; text-align:left;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $start = method_exists($photos, 'firstItem') ? $photos->firstItem() : 1; @endphp
                            @forelse($photos as $index => $photo)
                                <tr>
                                    <td class="align-middle">{{ $start + $index }}</td>
                                    <td class="align-middle">
                                        @if($photo->image_path)
                                            <img src="{{ asset('storage/'.$photo->image_path) }}" alt="Foto" style="width:70px;height:70px;object-fit:cover;border-radius:6px;">
                                        @else
                                            <span class="text-muted">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td class="text-muted align-middle" style="white-space: normal; word-break: break-word; text-align: left; max-width: 600px;">{{ $photo->description }}</td>
                                    <td class="text-left align-middle">
                                        <div class="d-flex flex-row justify-content-start">
                                            <a href="{{ route('admin.activity.photos.edit', $photo) }}" class="btn btn-sm btn-primary" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;" title="Edit"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.activity.photos.destroy', $photo) }}" method="POST" class="d-inline-block ml-1" onsubmit="return confirm('Yakin ingin menghapus foto ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada foto kegiatan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if(method_exists($photos, 'links'))
                <div class="card-footer">{{ $photos->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection