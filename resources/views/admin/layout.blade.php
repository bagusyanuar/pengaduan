<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/adminlte/css/adminlte.min.css')}}">
    <link href="{{ asset('/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js')}}"></script>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <title>Document</title>
    @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<nav class="main-header navbar navbar-expand elevation-1">
    <ul class="navbar-nav align-items-center">
        <li class="nav-item">
            <a class="nav-link navbar-link-item" data-widget="pushmenu" href="#" role="button"><i
                    class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item">
            <div>
                Sistem e-PPID
            </div>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link navbar-link-item" data-toggle="dropdown" href="#">
                <i class="fa fa-user mr-2"></i>
                <span>{{ auth()->user()->username }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                <a href="/logout" class="dropdown-item navbar-link-item">
                    <i class="fa fa-power-off mr-2"></i>Keluar</a>
            </div>
        </li>
    </ul>
</nav>
<aside class="main-sidebar sidebar-dark-primary elevation-1">
    <div class="sidebar">
        <a href="{{ route('dashboard') }}" class="brand-link" style="border-bottom: 1px solid #a0aec0">
            <img src="{{ asset('assets/icons/customer-service.png') }}" style="width: 34px !important;"
                 alt="AdminLTE Logo"
                 class="brand-image text-center"
            >
            <span class="brand-text font-weight-light">e-PPID</span>
        </a>
        <div class="my-sidebar-menu">
            <ul class="nav nav-sidebar nav-pills flex-column">
                <nav class="mt-2 nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                     data-accordion="false">
                    @if(auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                               class="nav-link {{ request()->is('admin') ? 'active' : ''}}">
                                <i class="fa fa-tachometer nav-icon" aria-hidden="true"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview {{ request()->is('admin/users*') ? 'menu-open' : ''}}">
                            <a href="#" class="nav-link {{ request()->is('admin/users*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Users
                                    <i class="right fa fa-angle-down"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}"
                                       class="nav-link {{ request()->is('admin/users') ? 'active' : ''}}">
                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                        <p>Admin</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users.uki.index') }}"
                                       class="nav-link {{ request()->is('admin/users/uki') ? 'active' : ''}}">
                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                        <p>UKI</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users.satker.index') }}"
                                       class="nav-link {{ request()->is('admin/users/satuan-kerja') ? 'active' : ''}}">
                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                        <p>Satuan Kerja</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users.ppk.index') }}"
                                       class="nav-link {{ request()->is('admin/users/ppk') ? 'active' : ''}}">
                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                        <p>PPK</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('unit.index') }}"
                               class="nav-link {{ request()->is('admin/satker*') ? 'active' : ''}}">
                                <i class="fa fa-bookmark nav-icon" aria-hidden="true"></i>
                                <p>Satuan Kerja</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('ppk.index') }}"
                               class="nav-link {{ request()->is('admin/ppk*') ? 'active' : '' }}">
                                <i class="fa fa-tag nav-icon" aria-hidden="true"></i>
                                <p>PPK</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview {{ request()->is('admin/pengaduan*') ? 'menu-open' : ''}}">
                            <a href="#" class="nav-link {{ request()->is('admin/pengaduan*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-exclamation"></i>
                                <p>
                                    Pengaduan
                                    <i class="right fa fa-angle-down"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('complain.index') }}"
                                       class="nav-link {{ request()->is('admin/pengaduan') ? 'active' : ''}}">
                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                        <p>Menunggu</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('complain.process') }}"
                                       class="nav-link {{ request()->is('admin/pengaduan/proses') ? 'active' : ''}}">
                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                        <p>Sedang Di Proses</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('complain.answered') }}"
                                       class="nav-link {{ request()->is('admin/pengaduan/jawab') ? 'active' : ''}}">
                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                        <p>Terjawab</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('complain.finished') }}"
                                       class="nav-link {{ request()->is('admin/pengaduan/selesai') ? 'active' : ''}}">
                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                        <p>Selesai</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview {{ request()->is('admin/informasi*') ? 'menu-open' : ''}}">
                            <a href="#" class="nav-link {{ request()->is('admin/informasi*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-list"></i>
                                <p>
                                    Informasi
                                    <i class="right fa fa-angle-down"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('information.index') }}"
                                       class="nav-link {{ request()->is('admin/informasi') ? 'active' : ''}}">
                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                        <p>Menunggu</p>
                                    </a>
                                </li>
{{--                                <li class="nav-item">--}}
{{--                                    <a href="{{ route('complain.process') }}"--}}
{{--                                       class="nav-link {{ request()->is('admin/pengaduan/proses') ? 'active' : ''}}">--}}
{{--                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>--}}
{{--                                        <p>Sedang Di Proses</p>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="{{ route('complain.answered') }}"--}}
{{--                                       class="nav-link {{ request()->is('admin/pengaduan/jawab') ? 'active' : ''}}">--}}
{{--                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>--}}
{{--                                        <p>Terjawab</p>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="{{ route('complain.finished') }}"--}}
{{--                                       class="nav-link {{ request()->is('admin/pengaduan/selesai') ? 'active' : ''}}">--}}
{{--                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>--}}
{{--                                        <p>Selesai</p>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
                            </ul>
                        </li>
                    @endif

                    @if(auth()->user()->role == 'uki')
                        <li class="nav-item">
                            <a href="{{ route('dashboard.uki') }}"
                               class="nav-link {{ request()->is('admin-uki') ? 'active' : ''}}">
                                <i class="fa fa-tachometer nav-icon" aria-hidden="true"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview {{ request()->is('admin-uki/pengaduan*') ? 'menu-open' : ''}}">
                            <a href="#" class="nav-link {{ request()->is('admin-uki/pengaduan*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-exclamation"></i>
                                <p>
                                    Pengaduan
                                    <i class="right fa fa-angle-down"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('complain.index.uki') }}"
                                       class="nav-link {{ request()->is('admin-uki/pengaduan') ? 'active' : ''}}">
                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                        <p>Menunggu</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('complain.process.uki') }}"
                                       class="nav-link {{ request()->is('admin-uki/pengaduan/proses') ? 'active' : ''}}">
                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                        <p>Sedang Di Proses</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if(auth()->user()->role == 'satker')
                        <li class="nav-item">
                            <a href="{{ route('dashboard.satker') }}"
                               class="nav-link {{ request()->is('admin-satker') ? 'active' : ''}}">
                                <i class="fa fa-tachometer nav-icon" aria-hidden="true"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview {{ request()->is('admin-satker/pengaduan*') ? 'menu-open' : ''}}">
                            <a href="#" class="nav-link {{ request()->is('admin-satker/pengaduan*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-exclamation"></i>
                                <p>
                                    Pengaduan
                                    <i class="right fa fa-angle-down"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('complain.index.satker') }}"
                                       class="nav-link {{ request()->is('admin-satker/pengaduan') ? 'active' : ''}}">
                                        <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                        <p>Data</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </nav>
            </ul>
        </div>
    </div>
</aside>

<div class="content-wrapper p-3">
    @yield('content-title')
    @yield('content')
</div>
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2022</strong> All rights reserved.
</footer>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="{{ asset ('/adminlte/js/adminlte.js') }}"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('/datatables/dataTables.bootstrap4.min.js') }}"></script>
@yield('js')
</body>
</html>
