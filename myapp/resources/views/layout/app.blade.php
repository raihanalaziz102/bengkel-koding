<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* Main sidebar styling */
        .main-sidebar {
            background-color:rgb(216, 136, 149) !important; /* Hijau Muda */
            color: #000 !important;
            width: 300px !important;
        }

        /* Header styling */
        .main-header {
            background-color:rgb(230, 168, 217) !important;
            border-bottom: 1px solid #88d8b0;
            margin-left: 300px !important;
        }

        /* Content and footer adjustments */
        .content-wrapper,
        .main-footer {
            margin-left: 300px !important;
        }

        /* Brand logo area */
        .brand-link {
            padding: 15px !important;
            font-size: 18px !important;
        }

        .brand-link .brand-image {
            margin-right: 10px !important;
            margin-left: 5px !important;
        }

        /* User panel styling */
        .user-panel {
            padding: 15px 10px !important;
        }

        .user-panel .info {
            font-size: 16px !important;
            padding-left: 10px !important;
        }

        .user-panel .image img {
            width: 40px !important;
            height: 40px !important;
        }

        /* Sidebar search form */
        .sidebar .form-inline {
            padding: 10px !important;
        }

        .form-control-sidebar {
            height: 38px !important;
            font-size: 15px !important;
        }

        .btn-sidebar {
            width: 40px !important;
            height: 38px !important;
        }

        /* Navigation links */
        .sidebar .nav-pills .nav-link {
            padding: 12px 15px !important;
            font-size: 16px !important;
            border-radius: 5px !important;
            margin: 4px 8px !important;
        }

        /* Icons in navigation */
        .sidebar .nav-icon {
            font-size: 18px !important;
            margin-right: 10px !important;
        }

        /* Add more spacing between navigation items */
        .sidebar .nav-item {
            margin-bottom: 5px !important;
        }

        /* Highlight active menu item */
        .sidebar .nav-pills .nav-link.active {
            background-color: #4caf50 !important;
            color: #fff !important;
            font-weight: 500 !important;
        }

        /* Hover effect for menu items */
        .sidebar .nav-pills .nav-link:hover {
            background-color: rgba(76, 175, 80, 0.2) !important;
            color: #000 !important;
        }

        /* Dropdown menu inside sidebar */
        .sidebar .nav-treeview > .nav-item > .nav-link {
            padding-left: 30px !important;
            font-size: 15px !important;
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .content-wrapper,
            .main-header,
            .main-footer {
                margin-left: 0 !important;
            }
        }

        /* When sidebar is collapsed */
        body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper.sidebar-closed,
        body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header.sidebar-closed,
        body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer.sidebar-closed {
            margin-left: 0 !important;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('lte/dist/img/AdminLTELogo.png') }}" alt="Logo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ auth()->user()->role === 'dokter' ? route('dokter.dashboard') : route('pasien.dashboard') }}" class="nav-link">Dashboard</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" role="button">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-success elevation-4">
        <!-- Brand Logo -->
        <a href="{{ auth()->user()->role === 'dokter' ? route('dokter.dashboard') : route('pasien.dashboard') }}" class="brand-link">
            <img src="{{ asset('lte/dist/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Klinik App</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('lte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->nama }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ auth()->user()->role === 'dokter' ? route('dokter.dashboard') : route('pasien.dashboard') }}" class="nav-link {{ Route::is('dokter.dashboard', 'pasien.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    @if (auth()->user()->role === 'dokter')
                        <li class="nav-item">
                            <a href="{{ route('dokter.memeriksa') }}" class="nav-link {{ Route::is('dokter.memeriksa') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-stethoscope"></i>
                                <p>Memeriksa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('obat.index') }}" class="nav-link {{ Route::is('obat.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-capsules"></i>
                                <p>Obat</p>
                            </a>
                        </li>
                    @elseif (auth()->user()->role === 'pasien')
                        <li class="nav-item">
                            <a href="{{ route('pasien.periksa.create') }}" class="nav-link {{ Route::is('pasien.periksa.create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>Buat Janji</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} <a href="#">Klinik App</a>.</strong> All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
</div>

<!-- jQuery -->
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>
@stack('scripts')
</body>
</html>