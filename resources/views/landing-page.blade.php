@extends('layout')

@section('content')
    <section id="hero">
        <div class="pt-5 pr-5 pl-5">
            <div class="hero p-5 align-items-center d-flex">
                <div class="row flex-column-reverse flex-lg-row align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h1 class="font-weight-bold " style="font-size: 44px">Layanan Pengaduan
                            Online Masyarakat</h1>
                        <p style="font-size: 20px;">Sampaikan laporan Anda langsung kepada instansi pemerintah
                            berwenang</p>
                        <div class="d-flex">
                            <a href="/pengaduan" class="main-button mr-2">Buat Pengaduan</a>
                            <a href="#" class="main-button-outline">Permintaan Informasi</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <img src="{{ asset('/assets/icons/hero.png') }}" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="about-us" class="mt-5">
        <div class="pr-5 pl-5">
            <h2 class="font-weight-bold text-center">Tentang Kami</h2>
            <p style="font-size: 18px;" class="text-center mb-5">LPOM adalah Aplikasi Pengelolaan Pengaduan Masyarakat
                dan pelayanan terhadap semua aspirasi dan pengaduan masyarakat.</p>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <img src="{{ asset('/assets/icons/about-us-hero.png') }}" class="w-100">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <p class="f18 text-justify mb-5">
                        Pengelolaan pengaduan pelayanan publik disetiap organisasi penyelenggara di Indonesia belum
                        terkelola secara efektif dan teritegrasi. Oleh karena itu LPOM hadir untuk mengatasi masalah
                        tersebut. Dengan adanya LPOM masyarakat bisa melakukan pengaduan secara online.
                    </p>
                    <div class="d-flex mb-4">
                        <div class="mr-3">
                            <div class="circle-palette">
                                <i class="mdi mdi-shopping-outline" style="font-size: 40px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="font-weight-bold mb-1">Meningkatkan Mutu Pelayanan</p>
                            <p class="text-justify">Dengan adanya Aplikasi LPOM ini diharapkan dapat meningkatkan
                                pelayanan terhadap masyarakat.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="mr-3">
                            <div class="circle-palette">
                                <i class="mdi mdi-image-outline" style="font-size: 40px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="font-weight-bold mb-1">Praktis Dan Hemat Waktu</p>
                            <p class="text-justify">Dengan adanya LPOM ini masyarakat tidak perlu datang ke instansi
                                terkait untuk melakukan pengaduan.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="mr-3">
                            <div class="circle-palette">
                                <i class="mdi mdi-chart-bar" style="font-size: 40px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="font-weight-bold mb-1">Cepat, Tepat dan Tuntas</p>
                            <p class="text-justify">Pengaduan dapat terkoordinasi dengan baik, sehingga dapat
                                mempercepat proses tindak lanjut.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="procedure" class="mt-5">
        <div class="pr-5 pl-5">
            <h2 class="font-weight-bold text-center">Prosedur Pengaduan</h2>
            <p style="font-size: 18px;" class="text-center mb-5">Berikut adalah prosedur pengaduan</p>
            <div class="d-flex justify-content-center w-100">
                <div class="row w-75 justify-content-center">
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-5">
                        <div class="procedure-palette p-5 d-flex align-items-center">
                            <div>
                                <p class="font-weight-bold mb-0">1. Daftar / Masuk</p>
                                <p class="text-justify">Daftar terlebih dahulu sebelum melakukan pengaduan. Setelah
                                    mendaftar, login untuk menulis pengaduan anda.</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-5">
                        <div class="procedure-palette p-5 d-flex align-items-center">
                            <div>
                                <p class="font-weight-bold mb-0">2. Tulis Pengaduan</p>
                                <p class="text-justify">Tulis pengaduan yang sesuai dengan masalah yang anda alami atau
                                    yang anda temui.Sertakan surat atau foto sebelum melakukan pengaduan.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center w-100">
                <div class="row w-75 justify-content-center">
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-5">
                        <div class="procedure-palette p-5 d-flex align-items-center">
                            <div>
                                <p class="font-weight-bold mb-0">3. Verifikasi Pengaduan</p>
                                <p class="text-justify">Jika anda sudah mengirim pengaduan, maka pengaduan anda akan
                                    segera di proses dan diverifikasi oleh petugas kami.</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-5">
                        <div class="procedure-palette p-5 d-flex align-items-center">
                            <div>
                                <p class="font-weight-bold mb-0">4. Proses Tindak Lanjut</p>
                                <p class="text-justify">Setelah melalui proses verifikasi oleh petugas, selanjutnya kami
                                    akan menindak lanjuti terkait pengaduan anda.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center w-100">
                <div class="row w-75 justify-content-center">
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-5">
                        <div class="procedure-palette p-5 d-flex align-items-center">
                            <div>
                                <p class="font-weight-bold mb-0">5. Beri Tanggapan</p>
                                <p class="text-justify">Setelah melalui proses verifikasi oleh petugas, selanjutnya kami
                                    akan menindak lanjuti terkait pengaduan anda.</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-5">
                        <div class="procedure-palette p-5 d-flex align-items-center">
                            <div>
                                <p class="font-weight-bold mb-0">6. Selesai</p>
                                <p class="text-justify">Anda bisa melihat tanggapan atau status dari pengaduan anda di
                                    halaman dashboard anda.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
