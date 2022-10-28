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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js')}}"></script>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <title>Pengaduan</title>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light custom-nav shadow-sm">
    <a class="navbar-brand" href="#">
        <div class="d-flex align-items-center">
            <img src="{{ asset('assets/icons/headset.png') }}" height="50" class="mr-2">
            <span class="f14"
                  style="color: var(--primaryColor); font-weight: bold; letter-spacing: 1.5px">PENGADUAN</span>
        </div>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Beranda <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Tentang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Statistik</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Prosedur</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Kontak</a>
            </li>
        </ul>
    </div>
</nav>
<div style="min-height: 400px">
    @yield('content')
</div>
<section id="footer">
    <div class="footer">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <p class="font-weight-bold" style="font-size: 36px">e-PPID</p>
                <p>e-PPID adalah Aplikasi Pengelolaan Pengaduan Masyarakat dan pelayanan terhadap semua aspirasi dan
                    pengaduan masyarakat.</p>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <p class="font-weight-bold" style="font-size: 24px;">USEFUL LINKS</p>
                <a href="#" class="d-block">Beranda</a>
                <a href="#" class="d-block">Bantuan</a>
                <a href="#" class="d-block">Link 1</a>
                <a href="#" class="d-block">Link 2</a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <p class="font-weight-bold" style="font-size: 24px;">USEFUL LINKS</p>
                <a href="#" class="d-block">Surabaya</a>
                <a href="#" class="d-block">Indonesia</a>
                <a href="#" class="d-block">Phone : +629xxxxxxxx</a>
                <a href="#" class="d-block">Email : e-PPID@gmail.com</a>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
@yield('js')
</body>
</html>
