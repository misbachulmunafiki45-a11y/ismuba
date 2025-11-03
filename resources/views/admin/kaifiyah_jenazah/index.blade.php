@extends('layouts.admin')

@section('title', 'Kaifiyah Jenazah')
@section('page_title', 'Kaifiyah Jenazah')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Kaifiyah Jenazah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-check-circle mr-2"></i> {{ session('status') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
            </div>
        @endif
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

        <!-- Tombol Tambah Item Global -->
        <div class="d-flex justify-content-end my-3">
            <a href="{{ route('admin.funeral.items.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Tambah Item
            </a>
        </div>
        <style>
          /* Sembunyikan tombol tambah per tabel agar hanya satu tombol global yang terlihat */
          .card-header .card-tools .btn.btn-success { display: none !important; }
        </style>

        @php
            $sections = [
                ['key' => 'bathing', 'title' => 'Memandikan Jenazah'],
                ['key' => 'shrouding', 'title' => 'Mengkafani Jenazah'],
                ['key' => 'prayer', 'title' => 'Mensholatkan'],
                ['key' => 'burial', 'title' => 'Mengkubur'],
            ];
        @endphp

        @foreach($sections as $section)
        <div id="{{ $section['key'] }}" class="card card-outline card-secondary mt-3">
            <div class="card-header d-flex justify-content-between align-items-center pr-0">
                <h3 class="card-title mb-0">{{ $section['title'] }}</h3>
                <div class="card-tools pr-0">
                    <a href="{{ route('admin.funeral.items.create', ['section' => $section['key']]) }}" class="btn btn-success mr-1">
                        <i class="fas fa-plus mr-1"></i> Tambah {{ $section['title'] }}
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0" style="table-layout: auto; width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px">No</th>
                                <th style="min-width: 140px">Judul</th>
                                <th style="width: 110px; text-align:left;">Gambar</th>
                                <th style="width: 55%; text-align:left;">Deskripsi</th>
                                <th style="width: 100px; text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $items = ($itemsBySection[$section['key']] ?? collect()); @endphp
                            @forelse($items as $idx => $item)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td class="font-weight-bold">{{ $item->title }}</td>
                                    <td>
                                        @php $img = $item->image_path ? asset('storage/'.$item->image_path) : '/vendor/adminlte/dist/img/user2-160x160.jpg'; @endphp
                                        <img src="{{ $img }}" alt="Ilustrasi" style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
                                    </td>
                                    <td class="text-muted" style="white-space: normal; word-break: break-word; text-align: left;">{{ $item->description }}</td>
                                    <td>
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="#" class="btn btn-sm btn-info mb-1 action-btn" title="View" aria-label="View" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.funeral.items.edit', $item) }}" class="btn btn-sm btn-primary mb-1 action-btn" title="Edit" aria-label="Edit" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;"><i class="fas fa-edit"></i></a>
                                            <form method="POST" action="{{ route('admin.funeral.items.destroy', $item) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger action-btn" title="Delete" aria-label="Delete" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;" onclick="return confirm('Hapus item ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada item untuk bagian ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalAdd_{{ $section['key'] }}" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel_{{ $section['key'] }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel_{{ $section['key'] }}">Tambah {{ $section['title'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('admin.funeral.items.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="section" value="{{ $section['key'] }}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Gambar (opsional)</label>
                                <input type="file" name="image" accept="image/*" class="form-control-file">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit untuk setiap item -->
        @foreach(($itemsBySection[$section['key']] ?? collect()) as $item)
            <div class="modal fade" id="modalEdit_{{ $section['key'] }}_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel_{{ $section['key'] }}_{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel_{{ $section['key'] }}_{{ $item->id }}">Edit {{ $section['title'] }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('admin.funeral.items.update', $item) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input type="text" name="title" class="form-control" value="{{ $item->title }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3" required>{{ $item->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Gambar (opsional)</label>
                                    <input type="file" name="image" accept="image/*" class="form-control-file">
                                    @if($item->image_path)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/'.$item->image_path) }}" alt="Ilustrasi" style="width:64px;height:64px;border-radius:6px;object-fit:cover;" />
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        @endforeach
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailLabel">Detail Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6 id="detailTitle" class="font-weight-bold mb-2"></h6>
        <div class="mt-2">
          <img id="detailImg" src="" alt="Image" style="width:120px;height:120px;object-fit:cover;border-radius:6px;display:none;">
        </div>
        <p id="detailDesc" class="text-muted mt-2"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLabel">Edit Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formEdit" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label for="editTitle">Judul</label>
            <input id="editTitle" name="title" type="text" class="form-control" required />
          </div>
          <div class="form-group">
            <label for="editDesc">Diskripsi</label>
            <textarea id="editDesc" name="description" class="form-control" rows="3" required></textarea>
          </div>
          <div class="form-group">
            <label for="editImage">Image (opsional)</label>
            <input id="editImage" name="image" type="file" accept="image/*" class="form-control-file">
            <small class="form-text text-muted">Biarkan kosong untuk mempertahankan gambar.</small>
            <div class="mt-2">
              <img id="editPreview" src="" alt="Preview" style="width:64px;height:64px;border-radius:6px;object-fit:cover;display:none;" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
$(function() {
    const placeholderImg = '/vendor/adminlte/dist/img/user2-160x160.jpg';

    function sanitize(text) {
        return $('<div>').text(text).html();
    }

    function bindSection(key) {
        const tbody = $('#tbody_' + key);

        // Preview image saat tambah
        $('#image_' + key).on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                $('#preview_' + key).attr('src', url).show();
            } else {
                $('#preview_' + key).hide();
            }
        });

        // Form tambah kini disubmit ke server (tidak ada preventDefault)
        $('#formAdd_' + key).on('submit', function(e) {
            // Persistence handled by backend
        });

        // Aksi: Detail
        $(document).on('click', '.btn-info.action-btn', function(e) {
            e.preventDefault();
            const row = $(this).closest('tr');
            const title = row.find('td').eq(1).text().trim();
            const desc = row.find('td').eq(3).text().trim();
            const img = row.find('td').eq(2).find('img');
            $('#detailTitle').text(title || '(Tanpa Judul)');
            $('#detailDesc').text(desc || '');
            if (img.length) {
                $('#detailImg').attr('src', img.attr('src')).show();
            } else {
                $('#detailImg').hide();
            }
            $('#detailModal').modal('show');
        });

        // Aksi: Edit (set form action + isi field)
        tbody.on('click', 'button.btn-primary', function(e) {
            e.preventDefault();
            const row = $(this).closest('tr')[0];
            const id = $(row).data('id');
            const title = $(row).find('td').eq(1).text().trim();
            const desc = $(row).find('td').eq(3).find('span.text-muted').text().trim();
            const img = $(row).find('td').eq(2).find('img');
            $('#formEdit').attr('action', '/admin/funeral-howto/items/' + id);
            $('#editTitle').val(title);
            $('#editDesc').val(desc);
            if (img.length) {
                $('#editPreview').attr('src', img.attr('src')).show();
            } else {
                $('#editPreview').hide();
            }
            $('#editImage').val('');
            $('#editModal').data('row', row).modal('show');
        });

        // Delete kini ditangani oleh form server-side
        tbody.on('click', '.btn-danger', function(e) {
            // No-op: submit form will handle deletion
        });
    }

    // Edit modal: preview image
    $('#editImage').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const url = URL.createObjectURL(file);
            $('#editPreview').attr('src', url).show();
        } else {
            $('#editPreview').hide();
        }
    });

    // Edit modal: form submit kini ke server (hapus handler preventDefault)
    $('#formEdit').on('submit', function(e) {
        // Persistence handled by backend
    });

    ['bathing','shrouding','prayer','burial'].forEach(bindSection);
});
</script>
@endpush