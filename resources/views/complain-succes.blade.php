@extends('layout2')

@section('css')
    <style>
        .success-information {
            height: 400px;
        }
    </style>
@endsection
@section('content')
    <section id="success-complain">
        <div class="p-5">
            <div class="success-information d-flex justify-content-center align-items-center">
                <div class="text-center">
                    <img src="{{ asset('/assets/icons/success.png') }}" height="200">
                    <p class="mb-0">Selamat Saran / Pengaduan Anda Telah Berhasil Kami Kirimkan Ke Admin.</p>
                    <p>No. Ticket : {{ \Illuminate\Support\Facades\Session::get('ticket') }}</p>
                    <div class="w-100 text-right">
                        <a href="{{ route('home') }}" class="main-button"><i class="fa fa-arrow-left mr-2"></i>Kembali Ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

