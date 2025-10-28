@extends('layouts.admin')

@section('title', 'Bacaan Doa Harian')
@section('page_title', 'Bacaan Doa Harian')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Bacaan Doa Harian</li>
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
            <a href="{{ route('admin.daily.prayers.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Tambah Item
            </a>
        </div>

        <div class="card card-outline card-secondary mt-2">
            <div class="card-header d-flex justify-content-between align-items-center pr-0">
                <h3 class="card-title mb-0">Daftar Bacaan Doa Harian</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0" style="table-layout: auto; width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px">No</th>
                                <th style="min-width: 140px">Judul</th>
                                <th style="min-width: 160px">Bacaan</th>
                                <th style="min-width: 160px">Latin</th>
                                <th class="text-left">Diskripsi</th>
                                <th style="width: 100px; text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $i => $item)
                                <tr>
                                    <td>{{ ($items->firstItem() ?? 1) + $i }}</td>
                                    <td class="font-weight-bold">{{ $item->title }}</td>
                                    <td>{{ $item->arabic }}</td>
                                    <td><span class="text-muted">{{ $item->latin }}</span></td>
                                    <td class="text-muted" style="white-space: normal; word-break: break-word;">{{ $item->description }}</td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <a href="#" class="btn btn-sm btn-info mb-1" title="View" aria-label="View" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.daily.prayers.edit', $item) }}" class="btn btn-sm btn-primary mb-1" title="Edit" aria-label="Edit" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.daily.prayers.destroy', $item) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete" aria-label="Delete" style="width: 36px; display:inline-flex; align-items:center; justify-content:center;" onclick="return confirm('Hapus item ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data doa harian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Doa Harian -->
<div class="modal fade" id="modalDetailPrayer" tabindex="-1" role="dialog" aria-labelledby="modalDetailPrayerLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailPrayerLabel">Detail Doa Harian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6 id="detailPrayerTitle" class="font-weight-bold mb-2"></h6>
        <div class="form-group mb-1">
          <label class="mb-0">Bacaan (Arab)</label>
          <div id="detailPrayerArabic" class="font-weight-normal" style="font-size: 1.05rem;"></div>
        </div>
        <div class="form-group mb-1">
          <label class="mb-0">Latin</label>
          <div id="detailPrayerLatin" class="text-muted"></div>
        </div>
        <div class="form-group mb-0">
          <label class="mb-0">Diskripsi</label>
          <div id="detailPrayerDesc" class="text-muted"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
$(function() {
  $(document).on('click', 'a.btn-info[title="View"]', function(e) {
    e.preventDefault();
    const $row = $(this).closest('tr');
    const title = $row.find('td').eq(1).text().trim();
    const arabic = $row.find('td').eq(2).text().trim();
    const latin = $row.find('td').eq(3).text().trim();
    const desc = $row.find('td').eq(4).text().trim();

    $('#detailPrayerTitle').text(title || '(Tanpa Judul)');
    $('#detailPrayerArabic').text(arabic || '');
    $('#detailPrayerLatin').text(latin || '');
    $('#detailPrayerDesc').text(desc || '');

    $('#modalDetailPrayer').modal('show');
  });
});
</script>
@endpush