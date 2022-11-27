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
	<!-- Fontawesome -->
	<link type="text/css" href="{{ asset('/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
	<!-- Swipe CSS -->
    <link type="text/css" href="{{ asset('/css/swipe.css') }}" rel="stylesheet">
    <title>Pengaduan</title>
</head>
<body>
	<main>
		<section class="section section-header text-dark pb-md-2" id="home">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 text-center mb-5 mb-md-7">
                        <h1 class="display-2 font-weight-bolder mb-4">
                             <img src="{{ asset('img/logo.png') }}" height="200" alt="">
                        </h1>
                        <p class="lead mb-4 mb-lg-5">Layanan Permohonan Informasi dan Pengaduan Online <br> Balai Besar Pelaksanaan Jalan Nasional Jawa Timur - Bali</p>
                        <div>
                            <a href="/informasi" class="btn btn-dark btn-download-app mb-xl-0 mr-2 mr-md-3">
                                <span class="d-flex align-items-center">
                                    <span class="icon icon-brand mr-2 mr-md-3"><span class="fa fa-list"></span></span>
                                    <span class="d-inline-block text-left">
                                         Permohonan Informasi
                                    </span>
                                </span>
                            </a>
                            <a href="/pengaduan" class="btn btn-dark btn-download-app mb-xl-0 mr-2 mr-md-3">
                                <span class="d-flex align-items-center">
                                    <span class="icon icon-brand mr-2 mr-md-3"><span class="fa fa-paper-plane"></span></span>
                                    <span class="d-inline-block text-left">
                                        Pengaduan
                                    </span>
                                </span>
                            </a>
							<a href="{{ route('tracing.index') }}" class="btn btn-dark btn-download-app ">
                                <span class="d-flex align-items-center">
                                    <span class="icon icon-brand mr-2 mr-md-3"><span class="fa fa-search"></span></span>
                                    <span class="d-inline-block text-left">
                                        Tracing Laporan
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		{{-- @yield('content') --}}
	</main>
	{{-- <footer class="footer py-5 pt-lg-6">
	 <div class="sticky-right">
        <a href="#home" class="icon icon-primary icon-md btn btn-icon-only btn-white border border-soft shadow-soft animate-up-3">
            <span class="fas fa-chevron-up"></span>
        </a>
    </div>
	</footer> --}}
<script src="{{ asset ('/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset ('/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset ('/vendor/headroom.js/dist/headroom.min.js') }}"></script>

<!-- Vendor JS -->
<script src="{{ asset ('/vendor/onscreen/dist/on-screen.umd.min.js')}}"></script>
<script src="{{ asset ('/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js')}}"></script>

<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Swipe JS -->
<script src="{{ asset ('/js/swipe.js')}}"></script>

</body>
</html>
