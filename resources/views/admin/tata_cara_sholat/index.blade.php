@extends('layouts.admin')

@section('title', 'Tata Cara Sholat')
@section('page_title', 'Tata Cara Sholat')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tata Cara Sholat</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Alerts -->
        @if(session('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-check-circle mr-2"></i> {{ session('status') }}
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

        <!-- Tabel Bacaan Sholat -->
        {{-- Hapus data statis, gunakan data dari controller --}}
        
        <div class="card card-outline card-secondary mt-3">
            <div class="card-header d-flex justify-content-between align-items-center pr-0">
                <h3 class="card-title mb-0">Daftar Bacaan Sholat</h3>
                <div class="card-tools pr-0">
                    <a href="{{ route('admin.prayer.readings.create') }}" class="btn btn-success mr-1">
                        <i class="fas fa-plus mr-1"></i> Tambah Bacaan Sholat
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="readingTable" class="table table-striped table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px">No</th>
                                <th class="text-left" style="min-width: 130px">Judul</th>
                                <th style="width: 90px">Gambar</th>
                                <th>Bacaan Sholat</th>
                                <th>Latin</th>
                                <th>Deskripsi</th>
                                <th style="width: 100px; text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="readingTbody">
                            @forelse($readings as $index => $reading)
                                <tr data-id="{{ $reading->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="align-middle font-weight-bold">{{ $reading->title }}</td>
                                    <td>
                                        @php $img = $reading->image_path ? asset('storage/'.$reading->image_path) : '/vendor/adminlte/dist/img/user2-160x160.jpg'; @endphp
                                        <img src="{{ $img }}" alt="Ilustrasi" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                                    </td>
                                    <td class="font-weight-normal" style="font-size: 1.05rem;">
                                        {{ $reading->arabic }}
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $reading->latin }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $reading->description }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="#" class="btn btn-sm btn-info mb-1 btn-detail" title="View" aria-label="View" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.prayer.readings.edit', $reading) }}" class="btn btn-sm btn-primary mb-1" title="Edit" aria-label="Edit" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" title="Delete" aria-label="Delete" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="empty-row">
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data bacaan sholat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal: Tambah Bacaan Sholat -->
        <div class="modal fade" id="modalAddReading" tabindex="-1" role="dialog" aria-labelledby="modalAddReadingLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddReadingLabel">Tambah Bacaan Sholat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formAddReading" method="POST" action="{{ route('admin.prayer.readings.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="inputTitle">Judul</label>
                                <input id="inputTitle" name="title" type="text" class="form-control" required placeholder="Masukkan judul bacaan">
                            </div>
                            <div class="form-group">
                                <label for="inputArabic">Bacaan (Arab)</label>
                                <textarea id="inputArabic" name="arabic" class="form-control" rows="2" required placeholder="Masukkan bacaan Arab"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputLatin">Latin</label>
                                <input id="inputLatin" name="latin" type="text" class="form-control" required placeholder="Masukkan transliterasi Latin">
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Deskripsi</label>
                                <textarea id="inputDescription" name="description" class="form-control" rows="3" placeholder="Masukkan deskripsi bacaan (opsional)"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputImage">Gambar (opsional)</label>
                                <input id="inputImage" name="image" type="file" accept="image/*" class="form-control-file">
                                <small class="form-text text-muted">Format gambar disarankan 1:1 (kotak).</small>
                                <div class="mt-2">
                                    <img id="previewImage" src="/vendor/adminlte/dist/img/user2-160x160.jpg" alt="Preview" style="width:64px;height:64px;border-radius:6px;object-fit:cover;display:none;" />
                                </div>
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

        <!-- Modal: Detail Bacaan Sholat -->
        <div class="modal fade" id="modalDetailReading" tabindex="-1" role="dialog" aria-labelledby="modalDetailReadingLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDetailReadingLabel">Detail Bacaan Sholat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img id="detailImage" src="" alt="Ilustrasi" style="width:84px;height:84px;border-radius:8px;object-fit:cover;" />
                        </div>
                        <div class="form-group mb-1">
                            <label class="mb-0">Bacaan (Arab)</label>
                            <div id="detailArabic" class="font-weight-normal" style="font-size: 1.05rem;"></div>
                        </div>
                        <div class="form-group mb-0">
                            <label class="mb-0">Latin</label>
                            <div id="detailLatin" class="text-muted"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal: Edit Bacaan Sholat -->
        <div class="modal fade" id="modalEditReading" tabindex="-1" role="dialog" aria-labelledby="modalEditReadingLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditReadingLabel">Edit Bacaan Sholat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formEditReading" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="editTitle">Judul</label>
                                <input id="editTitle" name="title" type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="editArabic">Bacaan (Arab)</label>
                                <textarea id="editArabic" name="arabic" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="editLatin">Latin</label>
                                <input id="editLatin" name="latin" type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="editDescription">Deskripsi</label>
                                <textarea id="editDescription" name="description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="editImage">Gambar (opsional)</label>
                                <input id="editImage" name="image" type="file" accept="image/*" class="form-control-file">
                                <div class="mt-2">
                                    <img id="editPreviewImage" src="" alt="Preview" style="width:64px;height:64px;border-radius:6px;object-fit:cover;display:none;" />
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

        <!-- Form hapus dinamis -->
        <form id="formDeleteReading" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    const placeholderImg = '/vendor/adminlte/dist/img/user2-160x160.jpg';

    function esc(text) { return $('<div>').text(text).html(); }

    $('#inputImage').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const url = URL.createObjectURL(file);
            $('#previewImage').attr('src', url).show();
        } else {
            $('#previewImage').attr('src', placeholderImg).hide();
        }
    });

    $('#editImage').on('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            $('#editPreviewImage').attr('src', ev.target.result).show();
        };
        reader.readAsDataURL(file);
    });

    // Detail: open modal dengan data row
    $(document).on('click', '.btn-detail', function(e) {
        e.preventDefault();
        const $row = $(this).closest('tr');
        const arabic = $row.find('td').eq(3).text().trim();
        const latin = $row.find('td').eq(4).text().trim();
        const $img = $row.find('td').eq(2).find('img');
        const imgSrc = $img.length ? $img.attr('src') : '';

        if (imgSrc) {
            $('#detailImage').attr('src', imgSrc).show();
        } else {
            $('#detailImage').hide();
        }
        $('#detailArabic').text(arabic);
        $('#detailLatin').text(latin);

        $('#modalDetailReading').modal('show');
    });

    // Edit: populate modal & set form action
    let $editingRow = null;
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        $editingRow = $(this).closest('tr');
        const id = $editingRow.data('id');
        const title = $editingRow.find('td').eq(1).text().trim();
        const arabic = $editingRow.find('td').eq(3).text().trim();
        const latin = $editingRow.find('td').eq(4).text().trim();
        const $img = $editingRow.find('td').eq(2).find('img');
        const imgSrc = $img.length ? $img.attr('src') : '';

        $('#formEditReading').attr('action', `{{ url('/admin/prayer-howto/readings') }}/${id}`);
        $('#editTitle').val(title);
        $('#editArabic').val(arabic);
        $('#editLatin').val(latin);
        if (imgSrc) {
            $('#editPreviewImage').attr('src', imgSrc).show();
        } else {
            $('#editPreviewImage').hide();
        }
        $('#editImage').val('');

        $('#modalEditReading').modal('show');
    });

    // Delete: konfirmasi lalu submit form delete dinamis
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const $row = $(this).closest('tr');
        const id = $row.data('id');
        const arabic = $row.find('td').eq(3).text().trim();
        const confirmed = confirm(`Hapus bacaan ini?\n\n${arabic}`);
        if (!confirmed) return;
        const $form = $('#formDeleteReading');
        $form.attr('action', `{{ url('/admin/prayer-howto/readings') }}/${id}`);
        $form.trigger('submit');
    });
});
</script>
@endpush
