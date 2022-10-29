<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
	<!-- Fontawesome -->
	<link type="text/css" href="{{ asset('/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
	<!-- Swipe CSS -->
    <link type="text/css" href="{{ asset('/css/swipe.css') }}" rel="stylesheet">
    <title>Pengaduan</title>
</head>
<body>
	<main>
		<section class="section section-header text-dark pb-md-8" id="home">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 text-center mb-5 mb-md-7">
                        <h1 class="display-2 font-weight-bolder mb-4">
                             <img src="{{ asset('img/logo.png') }}" height="200" alt="">
                        </h1>
                        <p class="lead mb-4 mb-lg-5">Layanan Permohonan Informasi dan Pengaduan Online <br> Balai Besar Pelaksanaan Jalan Nasional Jawa Timur - Bali</p>
                        <div>
                            <a href="#permohonan" class="btn btn-dark btn-download-app mb-xl-0 mr-2 mr-md-3">
                                <span class="d-flex align-items-center">
                                    <span class="icon icon-brand mr-2 mr-md-3"><span class="fa fa-list"></span></span>
                                    <span class="d-inline-block text-left">
                                         Permohonan Informasi
                                    </span> 
                                </span>
                            </a>
                            <a href="#pengaduan" class="btn btn-dark btn-download-app mb-xl-0 mr-2 mr-md-3">
                                <span class="d-flex align-items-center">
                                    <span class="icon icon-brand mr-2 mr-md-3"><span class="fa fa-paper-plane"></span></span>
                                    <span class="d-inline-block text-left">
                                        Pengaduan
                                    </span> 
                                </span>
                            </a>
							<a href="#lacak" class="btn btn-dark btn-download-app ">
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
		@yield('content')
	</main>
	<footer class="footer py-5 pt-lg-6">
	 <div class="sticky-right">
        <a href="#home" class="icon icon-primary icon-md btn btn-icon-only btn-white border border-soft shadow-soft animate-up-3">
            <span class="fas fa-chevron-up"></span>
        </a>
    </div>
	</footer>
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
