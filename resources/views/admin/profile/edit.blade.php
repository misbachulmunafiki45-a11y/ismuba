@extends('layouts.admin')

@section('title', 'Edit Profil')
@section('page_title', 'Edit Profil Admin')

@section('content')
<div class="row profile-edit-page">
    <div class="col-md-8">
        <div class="card" style="border-top: 3px solid #1e4b7c; box-shadow: 0 4px 12px rgba(30, 75, 124, 0.15);">
            <div class="card-header" style="background: linear-gradient(135deg, #1e4b7c 0%, #2c6aa7 100%); color: white;">
                <h3 class="card-title text-white font-weight-bold"><i class="fas fa-user-edit mr-2"></i>Edit Informasi Profil</h3>
            </div>
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body" style="background: linear-gradient(135deg, #1e4b7c 0%, #2c6aa7 100%); color: #ffffff;">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible" style="border-left: 4px solid #28a745;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-check-circle mr-2"></i> 
                            <strong>Sukses!</strong> {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible" style="border-left: 4px solid #dc3545;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-exclamation-circle mr-2"></i>
                            <strong>Perhatian!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name" style="color: #ffffff; font-weight: 700;">
                            <i class="fas fa-signature mr-1"></i>Nama Lengkap
                        </label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name', $user->name) }}" required
                               style="border: 1px solid #d1d9e6; border-radius: 8px; padding: 12px;
                                      box-shadow: 0 2px 4px rgba(30, 75, 124, 0.1);">
                    </div>

                    <div class="form-group">
                        <label for="email" style="color: #ffffff; font-weight: 700;">
                            <i class="fas fa-envelope mr-1"></i>Alamat Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $user->email) }}" required
                               style="border: 1px solid #d1d9e6; border-radius: 8px; padding: 12px;
                                      box-shadow: 0 2px 4px rgba(30, 75, 124, 0.1);">
                    </div>

                    <div class="form-group">
                        <label for="photo" style="color: #ffffff; font-weight: 700;">
                            <i class="fas fa-camera mr-1"></i>Foto Profil
                        </label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="photo" name="photo"
                                   style="border-radius: 8px;">
                            <label class="custom-file-label" for="photo" 
                                   style="border: 1px solid #d1d9e6; border-radius: 8px; padding: 10px;
                                          background-color: white; color: #495057;">
                                <i class="fas fa-upload mr-2"></i>Pilih foto...
                            </label>
                        </div>
                        <small class="form-text mt-2" style="color: #ffffff;">
                            <i class="fas fa-info-circle mr-1"></i>
                            Format: JPG, PNG, GIF | Maksimal: 2MB
                        </small>
                    </div>

                    
                </div>
                <div class="card-footer" style="background: linear-gradient(135deg, #f8fafc 0%, #e3f2fd 100%);
                                            border-top: 1px solid #e3f2fd;">
                    <button type="submit" class="btn btn-primary" 
                            style="background: linear-gradient(135deg, #1e4b7c 0%, #2c6aa7 100%);
                                   border: none; border-radius: 8px; padding: 12px 24px;
                                   box-shadow: 0 4px 8px rgba(30, 75, 124, 0.3);
                                   font-weight: 600;">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary ml-2"
                       style="border-radius: 8px; padding: 12px 24px; font-weight: 600;
                              border: 2px solid #6c757d; color: #6c757d;">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card" style="border-top: 3px solid #2c6aa7; box-shadow: 0 4px 12px rgba(44, 106, 167, 0.15);">
            <div class="card-header" style="background: linear-gradient(135deg, #2c6aa7 0%, #3a85d2 100%); color: white;">
                <h3 class="card-title text-white font-weight-bold"><i class="fas fa-user-circle mr-2"></i>Foto Profil</h3>
            </div>
            <div class="card-body text-center" style="background: linear-gradient(135deg, #1e4b7c 0%, #2c6aa7 100%); color: #ffffff;">
                @if($user->photo_path)
                    <img src="{{ Storage::url($user->photo_path) }}" 
                         alt="Foto Profil" 
                         class="img-circle elevation-2 shadow" 
                         style="width: 140px; height: 140px; object-fit: cover;
                                border: 4px solid #1e4b7c; box-shadow: 0 6px 12px rgba(30, 75, 124, 0.2);">
                @else
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                         style="width: 140px; height: 140px; background: linear-gradient(135deg, #1e4b7c 0%, #2c6aa7 100%);">
                        <i class="fas fa-user text-white" style="font-size: 3rem;"></i>
                    </div>
                @endif
                <h5 class="mt-4 mb-1" style="color: #ffffff; font-weight: 700;">{{ $user->name }}</h5>
                <p class="mb-3" style="color: #ffffff;">{{ $user->email }}</p>
                
                <div class="rounded p-3 mt-3" style="border-left: 4px solid #1e4b7c; background: rgba(255,255,255,0.08);">
                    <h6 style="color: #ffffff; font-weight: 700;">
                        <i class="fas fa-info-circle mr-2"></i>Informasi Akun
                    </h6>
                    <div class="text-left" style="color: #ffffff;">
                        <p class="mb-1"><strong>Terdaftar:</strong> {{ $user->created_at->format('d M Y') }}</p>
                        <p class="mb-0"><strong>Diperbarui:</strong> {{ $user->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3" style="border-top: 3px solid #28a745; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15);">
            <div class="card-header" style="background: linear-gradient(135deg, #28a745 0%, #34ce57 100%); color: white;">
                <h3 class="card-title"><i class="fas fa-shield-alt mr-2"></i>Keamanan</h3>
            </div>
            <div class="card-body text-center" style="background-color: #f8f9fa;">
                <div class="alert alert-info mb-0" style="border-left: 4px solid #17a2b8;">
                    <i class="fas fa-lock mr-2"></i>
                    <small>Data Anda dilindungi dengan enkripsi yang aman</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Menampilkan nama file yang dipilih pada input file
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById('photo').files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endsection