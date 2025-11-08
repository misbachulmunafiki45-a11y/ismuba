<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | ISMUBA</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    @php
        $faCss = public_path('vendor/adminlte/plugins/fontawesome-free/css/all.min.css');
        $lteCss = public_path('vendor/adminlte/dist/css/adminlte.min.css');
    @endphp
    @if (file_exists($faCss))
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    @else
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-dym3BdK0g5C3v+5Jd1YoY2c1c7FQm2rjvY3tYFf7H+3dCkSsrYoXvJw9M3zJv4F1m9WvEwBvH8gJ0dV9YxZL0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endif
    @if (file_exists($lteCss))
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    @endif
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
</head>
<body class="hold-transition sidebar-mini admin-theme">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->


            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">


            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <!-- User Profile Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <span class="dropdown-item-text">
                        <small>Logged in as</small><br>
                        <strong>{{ Auth::user()->name ?? 'Administrator' }}</strong>
                    </span>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.profile.edit') }}" class="dropdown-item">
                        <i class="fas fa-cog mr-2"></i> Edit Profile
                    </a>
                    <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    @php
                        $user = Auth::user();
                        $photoUrl = ($user && $user->photo_path)
                            ? Storage::url($user->photo_path)
                            : asset('vendor/adminlte/dist/img/user2-160x160.jpg');
                    @endphp
                    <img src="{{ $photoUrl }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{ route('admin.dashboard') }}" class="d-block">{{ Auth::user()->name ?? 'Administrator' }}</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Managemen Menu
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <!-- Jadwal Sholat -->
                            <li class="nav-item">
                                <a href="{{ route('admin.prayer.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-calendar-alt"></i>
                                    <p>Jadwal Sholat</p>
                                </a>
                            </li>

                            <!-- Tata Cara Berwudhu (baru) -->
                            <li class="nav-item">
                                <a href="{{ route('admin.wudhu.howto.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-tint"></i>
                                    <p>Tata Cara Berwudhu</p>
                                </a>
                            </li>

                            <!-- Tata Cara Sholat-->
                            <li class="nav-item">
                                <a href="{{ route('admin.prayer.howto.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-praying-hands"></i>
                                    <p>Tata Cara Sholat</p>
                                </a>
                            </li>
                                                     <!-- Tata Cara Sholat-->
                            <li class="nav-item">
                                <a href="{{ route('admin.funeral.howto.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>Kaifiyah Jenazah</p>
                                </a>
                            </li>

                                                        <!-- Tata Cara Sholat-->
                            <li class="nav-item">
                                <a href="{{ route('admin.daily.prayers.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-book-reader"></i>
                                    <p>Bacaan Doa Harian</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.materi.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-graduation-cap"></i>
                                    <p>Materi</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.activity.photos.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-images"></i>
                                    <p>Foto Kegiatan</p>
                                </a>
                            </li>


                        </ul>
                    </li>
                    <!-- Manajemen Akun: satu tautan saja -->
                    <li class="nav-item">
                        <a href="{{ route('admin.account.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>Manajemen Akun</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page_title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumbs')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content pb-2">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <aside class="control-sidebar control-sidebar-dark"></aside>
    <footer class="main-footer mt-4">
        <div class="float-right d-none d-sm-inline">ISMUBA STEMDA</div>
        <strong>&copy; {{ date('Y') }} ISMUBA.</strong> SMKS Muhammadiyah 2 Genteng
    </footer>
</div>

@php
    $jqJs = public_path('vendor/adminlte/plugins/jquery/jquery.min.js');
    $bsJs = public_path('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js');
    $lteJs = public_path('vendor/adminlte/dist/js/adminlte.min.js');
@endphp
@if (file_exists($jqJs))
    <script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
@else
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
@endif
@if (file_exists($bsJs))
    <script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@else
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@endif
@if (file_exists($lteJs))
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
@else
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@endif
@stack('scripts')
</body>
</html>
