@extends('layout2')

@section('css')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .bs-stepper-circle {
            display: -ms-inline-flexbox;
            display: inline-flex;
            -ms-flex-line-pack: center;
            align-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 1.6em !important;
            height: 1.6em !important;
            padding: .4em .2em !important;
            margin: .25rem !important;
            line-height: 0.5em !important;
            color: #fff;
            background-color: #6c757d;
            border-radius: 1em;
        }
    </style>
    <link rel="stylesheet" href="{{ env('PREFIX_URL').asset('/css/bs-stepper.min.css') }}">
@endsection

@section('content')
    <section id="tracing">
        <div class="p-5">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-10 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="bs-stepper">
                                <div class="bs-stepper-header" role="tablist">
                                    <!-- your steps here -->
                                    <div class="step {{ 1 <= $step ? 'active' : '' }}" data-target="#logins-part">
                                        <button type="button" class="step-trigger" role="tab"
                                                aria-controls="logins-part"
                                                id="logins-part-trigger">
                                            <span class="bs-stepper-circle"><i
                                                    class="fa fa-check-circle f12"></i></span>
                                            <span class="bs-stepper-label">Admin</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step {{ 2 <= $step ? 'active' : '' }}" data-target="#information-part">
                                        <button type="button" class="step-trigger" role="tab"
                                                aria-controls="information-part"
                                                id="information-part-trigger">
                                            <span class="bs-stepper-circle"><i
                                                    class="fa fa-check-circle f12"></i></span>
                                            <span class="bs-stepper-label">UKI</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step {{ 3 <= $step ? 'active' : '' }}" data-target="#information-part">
                                        <button type="button" class="step-trigger" role="tab"
                                                aria-controls="information-part"
                                                id="information-part-trigger">
                                            <span class="bs-stepper-circle"><i
                                                    class="fa fa-check-circle f12"></i></span>
                                            <span class="bs-stepper-label">Satker / PPK</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step {{ 4 <= $step ? 'active' : '' }}" data-target="#information-part">
                                        <button type="button" class="step-trigger" role="tab"
                                                aria-controls="information-part"
                                                id="information-part-trigger">
                                            <span class="bs-stepper-circle"><i
                                                    class="fa fa-check-circle f12"></i></span>
                                            <span class="bs-stepper-label">Selesai</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="bs-stepper-content">
                                    <!-- your steps content here -->
                                    <div id="logins-part" class="content" role="tabpanel"
                                         aria-labelledby="logins-part-trigger"></div>
                                    <div id="information-part" class="content" role="tabpanel"
                                         aria-labelledby="information-part-trigger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                @if($step === 4)
                                    <img class="text-center"
                                         src="{{ env('PREFIX_URL').asset('/assets/icons/complete-step.svg') }}"
                                         style="width: 60%">
                                @else
                                    <img class="text-center"
                                         src="{{ env('PREFIX_URL').asset('/assets/icons/waiting.svg') }}"
                                         style="width: 60%">
                                @endif
                            </div>
                            <p class="text-center mt-3">Status {{ $type === 'complain' ? 'saran / pengaduan' : 'permintaan informasi' }}
                                anda
                                @if($step === 1)
                                    sedang di proses oleh <span class="font-weight-bold">Admin</span>
                                @elseif($step === 2)
                                    sedang di proses oleh <span class="font-weight-bold">UKI</span>
                                @elseif($step === 3)
                                    sedang di proses oleh <span class="font-weight-bold">Satker / PPK</span>
                                @elseif($step === 4)
                                    telah selesai di proses mohon cek email anda untuk melihat respon jawaban dari pihak
                                    terkait.
                                @else
                                    sedang di proses oleh -
                                @endif
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="{{ route('home') }}" class="main-button" id="btn-tracing">
                                    <i class="fa fa-arrow-left mr-2"></i><span>Kembali Ke Beranda</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('js')
    <script src="{{ env('PREFIX_URL').asset('/js/bs-stepper.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var stepper = new Stepper($('.bs-stepper')[0])
        });
    </script>
@endsection
