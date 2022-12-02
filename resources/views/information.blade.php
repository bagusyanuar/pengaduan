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
    </style>
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif

    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Gagal!", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <section id="information">
        <div class="p-5">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <img src="{{ asset('/assets/icons/complain-hero.png') }}" class="w-100">
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <div class="d-flex justify-content-center w-100">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ \Illuminate\Support\Facades\Session::has('legal') === true ? '' : 'active' }}"
                                   id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                   role="tab" aria-controls="pills-home" aria-selected="true">Personal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ \Illuminate\Support\Facades\Session::has('legal') === true ? 'active' : '' }}"
                                   id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                   role="tab" aria-controls="pills-profile" aria-selected="false">Badan Hukum /
                                    Organisasi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div
                            class="tab-pane fade {{ \Illuminate\Support\Facades\Session::has('legal') === true ? '' : 'show' }} {{ \Illuminate\Support\Facades\Session::has('legal') === true ? '' : 'active' }}"
                            id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" id="form-information">
                                        @csrf
                                        <input type="hidden" name="type" value="0">
                                        <div class="form-group mb-1">
                                            <label for="name">Nama <span style="color: red">*</span></label>
                                            <input type="text"
                                                   class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                   id="name"
                                                   aria-describedby="emailHelp" placeholder="Nama" name="name"
                                                   value="{{ old('name') }}">
                                            @if ($errors->has('name'))
                                                <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                                    {{ $errors->first('name') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="email">Email <span style="color: red">*</span></label>
                                            <input type="email"
                                                   class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                   id="email" name="email"
                                                   aria-describedby="emailHelp"
                                                   placeholder="Email" value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                                <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                                    {{ $errors->first('email') }}
                                                </p>
                                            @endif
                                            <small id="emailHelp" class="form-text text-muted">Contoh :
                                                pelapor@gmail.com</small>

                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="card_id">No. KTP <span style="color: red">*</span></label>
                                            <input type="number"
                                                   class="form-control {{ $errors->has('card_id') ? 'is-invalid' : '' }}"
                                                   id="card_id" name="card_id"
                                                   aria-describedby="cardIdHelp"
                                                   placeholder="No. KTP" value="{{ old('card_id') }}">
                                            @if ($errors->has('card_id'))
                                                <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                                    {{ $errors->first('card_id') }}
                                                </p>
                                            @endif
                                            <small id="cardIdHelp" class="form-text text-muted">Contoh :
                                                337201******</small>

                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="phone">No. Whatsapp <span style="color: red">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">+62</span>
                                                </div>
                                                <input type="number"
                                                       class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                                       id="phone"
                                                       aria-describedby="phoneHelp" placeholder="No. Whatsapp"
                                                       name="phone" value="{{ old('phone') }}">
                                                @if ($errors->has('phone'))
                                                    <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                                        {{ $errors->first('phone') }}
                                                    </p>
                                                @endif
                                            </div>
                                            <small id="phoneHelp" class="form-text text-muted">Contoh :
                                                89545******</small>
                                        </div>

                                        <div class="form-group mb-1">
                                            <label for="address">Alamat <span style="color: red">*</span></label>
                                            <textarea rows="3"
                                                      class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                                      id="address"
                                                      aria-describedby="addressHelp" placeholder="Alamat"
                                                      name="address">{{ old('address') }}</textarea>
                                            @if ($errors->has('address'))
                                                <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                                    {{ $errors->first('address') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="job">Pekerjaan</label>
                                            <input type="text" class="form-control" id="job" name="job"
                                                   aria-describedby="jobHelp"
                                                   placeholder="Pekerjaan">
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="information">Rincian Informasi <span style="color: red">*</span></label>
                                            <textarea rows="3" class="form-control" id="information" name="information"
                                                      aria-describedby="informationHelp"
                                                      placeholder="Rincian Informasi yang Dibutuhkan"></textarea>

                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="purpose">Tujuan Penggunaan Informasi <span
                                                    style="color: red">*</span></label>
                                            <textarea rows="3" class="form-control" id="purpose" name="purpose"
                                                      aria-describedby="purposeHelp"
                                                      placeholder="Tujuan Penggunaan Informasi (Mohon Diperinci)"></textarea>
                                        </div>

                                        <div class="mb-2">
                                            <label for="">Cara Memperoleh Informasi <span
                                                    style="color: red">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="information_source"
                                                       id="information_source-1" value="Melihat/membaca/mendengarkan/mencatat" checked>
                                                <label class="form-check-label" for="information_source-1">
                                                    Melihat/membaca/mendengarkan/mencatat
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="information_source"
                                                       id="information_source-2"
                                                       value="Mendapatkan salinan informasi (hard/softcopy)">
                                                <label class="form-check-label" for="information_source-2">
                                                    Mendapatkan salinan informasi (hard/softcopy)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <label for="">Cara mendapatkan salinan informasi <span
                                                    style="color: red">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="source"
                                                       id="source-1" value="Diambil langsung" checked>
                                                <label class="form-check-label" for="source-1">
                                                    Diambil langsung
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="source"
                                                       id="source-2" value="Email">
                                                <label class="form-check-label" for="source-2">
                                                    Email
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="source"
                                                       id="source-3" value="Tidak dapat disalin">
                                                <label class="form-check-label" for="source-2">
                                                    Tidak dapat disalin
                                                </label>
                                            </div>
                                        </div>


                                        <hr>
                                        <div class="text-right">
                                            <button type="submit" class="main-button"  id="btn-submit-information">
                                                Kirim
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div
                            class="tab-pane fade {{ \Illuminate\Support\Facades\Session::has('legal') === true ? 'show' : '' }} {{ \Illuminate\Support\Facades\Session::has('legal') === true ? 'active' : '' }}"
                            id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data" id="form-legal-information">
                                        @csrf
                                        <input type="hidden" name="type" value="1">
                                        <div class="form-group mb-1">
                                            <label for="legal_name">Nama <span style="color: red">*</span></label>
                                            <input type="text"
                                                   class="form-control {{ $errors->has('legal_name') ? 'is-invalid' : '' }}"
                                                   id="legal_name"
                                                   aria-describedby="emailHelp" placeholder="Nama" name="legal_name"
                                                   value="{{ old('legal_name') }}">
                                            @if ($errors->has('legal_name'))
                                                <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                                    {{ $errors->first('legal_name') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="legal_email">Email <span style="color: red">*</span></label>
                                            <input type="email"
                                                   class="form-control {{ $errors->has('legal_email') ? 'is-invalid' : '' }}"
                                                   id="legal_email" name="legal_email"
                                                   aria-describedby="emailHelp"
                                                   placeholder="Email" value="{{ old('legal_email') }}">
                                            @if ($errors->has('legal_email'))
                                                <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                                    {{ $errors->first('legal_email') }}
                                                </p>
                                            @endif
                                            <small id="emailHelp" class="form-text text-muted">Contoh :
                                                pelapor@gmail.com</small>

                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="legal_card_id">No. KTP <span style="color: red">*</span></label>
                                            <input type="number"
                                                   class="form-control {{ $errors->has('legal_card_id') ? 'is-invalid' : '' }}"
                                                   id="legal_card_id" name="legal_card_id"
                                                   aria-describedby="cardIdHelp"
                                                   placeholder="No. KTP" value="{{ old('legal_card_id') }}">
                                            @if ($errors->has('legal_card_id'))
                                                <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                                    {{ $errors->first('legal_card_id') }}
                                                </p>
                                            @endif
                                            <small id="cardIdHelp" class="form-text text-muted">Contoh :
                                                337201******</small>

                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="legal_phone">No. Whatsapp <span style="color: red">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">+62</span>
                                                </div>
                                                <input type="number"
                                                       class="form-control {{ $errors->has('legal_phone') ? 'is-invalid' : '' }}"
                                                       id="legal_phone"
                                                       aria-describedby="phoneHelp" placeholder="No. Whatsapp"
                                                       name="legal_phone" value="{{ old('legal_phone') }}">
                                                @if ($errors->has('legal_phone'))
                                                    <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                                        {{ $errors->first('legal_phone') }}
                                                    </p>
                                                @endif
                                            </div>
                                            <small id="phoneHelp" class="form-text text-muted">Contoh :
                                                89545******</small>
                                        </div>

                                        <div class="form-group mb-1">
                                            <label for="legal_address">Alamat <span style="color: red">*</span></label>
                                            <textarea rows="3"
                                                      class="form-control {{ $errors->has('legal_address') ? 'is-invalid' : '' }}"
                                                      id="legal_address"
                                                      aria-describedby="addressHelp" placeholder="Alamat"
                                                      name="legal_address">{{ old('legal_address') }}</textarea>
                                            @if ($errors->has('legal_address'))
                                                <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                                    {{ $errors->first('legal_address') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="legal_job">Pekerjaan</label>
                                            <input type="text" class="form-control" id="legal_job" name="legal_job"
                                                   aria-describedby="jobHelp"
                                                   placeholder="Pekerjaan" value="{{ old('legal_job') }}">
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="legal_information">Rincian Informasi <span style="color: red">*</span></label>
                                            <textarea rows="3" class="form-control" id="legal_information" name="legal_information"
                                                      aria-describedby="informationHelp"
                                                      placeholder="Rincian Informasi yang Dibutuhkan">{{ old('legal_information') }}</textarea>

                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="legal_purpose">Tujuan Penggunaan Informasi <span
                                                    style="color: red">*</span></label>
                                            <textarea rows="3" class="form-control" id="legal_purpose" name="legal_purpose"
                                                      aria-describedby="purposeHelp"
                                                      placeholder="Tujuan Penggunaan Informasi (Mohon Diperinci)">{{ old('legal_purpose') }}</textarea>
                                        </div>

                                        <div class="mb-2">
                                            <label for="">Cara Memperoleh Informasi <span
                                                    style="color: red">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="legal_information_source"
                                                       id="legal_information_source-1" value="Melihat/membaca/mendengarkan/mencatat"
                                                       checked>
                                                <label class="form-check-label" for="legal_information_source-1">
                                                    Melihat/membaca/mendengarkan/mencatat
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="legal_information_source"
                                                       id="legal_information_source-2"
                                                       value="Mendapatkan salinan informasi (hard/softcopy)">
                                                <label class="form-check-label" for="legal_information_source-2">
                                                    Mendapatkan salinan informasi (hard/softcopy)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="">Cara mendapatkan salinan informasi <span
                                                    style="color: red">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="legal_source"
                                                       id="legal_source-1" value="Diambil langsung" checked>
                                                <label class="form-check-label" for="legal_source-1">
                                                    Diambil langsung
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="legal_source"
                                                       id="legal_source-2" value="Email">
                                                <label class="form-check-label" for="legal_source-2">
                                                    Email
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="legal_source"
                                                       id="legal_source-3" value="Tidak dapat disalin">
                                                <label class="form-check-label" for="legal_source-2">
                                                    Tidak dapat disalin
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="legal_assignment" class="form-label">Surat Tugas / Surat Kuasa <span style="color: red">*</span></label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input {{ $errors->has('legal_assignment') ? 'is-invalid' : '' }}" id="legal_assignment"
                                                       name="legal_assignment" accept="application/pdf">
                                                <label class="custom-file-label f14" for="legal_assignment">Pilih File Surat
                                                    Tugas / Surat Kuasa</label>
                                                @if ($errors->has('legal_assignment'))
                                                    <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                                        {{ $errors->first('legal_assignment') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="legal_ad_art" class="form-label">AD ART <span style="color: red">*</span></label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input {{ $errors->has('legal_ad_art') ? 'is-invalid' : '' }}" id="legal_ad_art" name="legal_ad_art" accept="application/pdf">
                                                <label class="custom-file-label f14" for="legal_ad_art">Pilih File AD
                                                    ART</label>
                                                @if ($errors->has('legal_ad_art'))
                                                    <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                                        {{ $errors->first('legal_ad_art') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="text-right">
                                            <button type="submit" class="main-button" id="btn-submit-legal-information">
                                                Kirim
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.custom-file-input').on('change', function () {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            $('#btn-submit-information').on('click', function (e) {
                e.preventDefault();
                let iconUrl = '{{ asset('/assets/icons/question.png') }}';
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: 'Ingin mengirimkan permintaan informasi?',
                    iconHtml: '<img src="' + iconUrl + '" height="100">',
                    customClass: {
                        icon: 'no-border'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.value) {
                        $('#form-information').submit();
                    }
                });
            });
            $('#btn-submit-legal-information').on('click', function (e) {
                e.preventDefault();
                let iconUrl = '{{ asset('/assets/icons/question.png') }}';
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: 'Ingin mengirimkan permintaan informasi?',
                    iconHtml: '<img src="' + iconUrl + '" height="100">',
                    customClass: {
                        icon: 'no-border'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.value) {
                        $('#form-legal-information').submit();
                    }
                });
            });
        })
    </script>
@endsection
