@extends('layout')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    <section id="complain">
        <div class="p-5">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <img src="{{ asset('/assets/icons/complain-hero.png') }}" class="w-100">
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <div class="d-flex justify-content-center w-100">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                   role="tab" aria-controls="pills-home" aria-selected="true">Personal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                   role="tab" aria-controls="pills-profile" aria-selected="false">Badan Hukum /
                                    Organisasi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                             aria-labelledby="pills-home-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        @csrf
                                        <input type="hidden" name="type" value="0">
                                        <div class="form-group mb-1">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" id="name"
                                                   aria-describedby="emailHelp" placeholder="Nama" name="name">
                                            <small id="nameHelp" class="form-text text-muted">Contoh : Yanuar
                                                Ihsan</small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="address">Alamat</label>
                                            <textarea rows="3" class="form-control" id="address"
                                                      aria-describedby="addressHelp" placeholder="Alamat" name="address"></textarea>
                                            <small id="addressHelp" class="form-text text-muted">Contoh : Jl. Arjuna no.
                                                16, Kec. Serengan, Surakarta</small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="job">Pekerjaan</label>
                                            <input type="text" class="form-control" id="job" name="job" aria-describedby="jobHelp"
                                                   placeholder="Pekerjaan">
                                            <small id="jobHelp" class="form-text text-muted">Contoh : Wiraswasta</small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="phone">No. Whatsapp</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">+62</span>
                                                </div>
                                                <input type="number" class="form-control" id="phone"
                                                       aria-describedby="phoneHelp" placeholder="No. Whatsapp" name="phone">
                                            </div>
                                            <small id="phoneHelp" class="form-text text-muted">Contoh :
                                                895422630233</small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   aria-describedby="emailHelp"
                                                   placeholder="Email">
                                            <small id="emailHelp" class="form-text text-muted">Contoh :
                                                pelapor@gmail.com</small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="complain">Saran / Pengaduan</label>
                                            <textarea rows="3" class="form-control" id="complain" name="complain"
                                                      aria-describedby="complainHelp"
                                                      placeholder="Saran / Pengaduan"></textarea>
                                            <small id="complainHelp" class="form-text text-muted">Contoh : Jl. Arjuna
                                                no.
                                                16, Kec. Serengan, Surakarta</small>
                                        </div>
                                        <hr>
                                        <div class="text-right">
                                            <button type="submit" class="main-button">
                                                Kirim
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                             aria-labelledby="pills-profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        @csrf
                                        <input type="hidden" name="type" value="1">
                                        <div class="form-group mb-1">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" id="name"
                                                   aria-describedby="emailHelp" placeholder="Nama">
                                            <small id="nameHelp" class="form-text text-muted">Contoh : Yanuar
                                                Ihsan</small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="file" class="form-label">Surat Tugas / Surat Kuasa</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="assignment" name="assignment">
                                                <label class="custom-file-label f14" for="assignment">Pilih File Surat Tugas / Surat Kuasa</label>
                                            </div>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="file" class="form-label">AD ART</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="ad_art" name="ad_art">
                                                <label class="custom-file-label f14" for="ad_art">Pilih File AD ART</label>
                                            </div>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="address">Alamat</label>
                                            <textarea rows="3" class="form-control" id="address"
                                                      aria-describedby="addressHelp" placeholder="Alamat"></textarea>
                                            <small id="addressHelp" class="form-text text-muted">Contoh : Jl. Arjuna no.
                                                16, Kec. Serengan, Surakarta</small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="job">Pekerjaan</label>
                                            <input type="text" class="form-control" id="job" aria-describedby="jobHelp"
                                                   placeholder="Pekerjaan">
                                            <small id="jobHelp" class="form-text text-muted">Contoh : Wiraswasta</small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="phone">No. Whatsapp</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">+62</span>
                                                </div>
                                                <input type="number" class="form-control" id="phone"
                                                       aria-describedby="phoneHelp" placeholder="No. Whatsapp">
                                            </div>
                                            <small id="phoneHelp" class="form-text text-muted">Contoh :
                                                895422630233</small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="job"
                                                   aria-describedby="emailHelp"
                                                   placeholder="Email">
                                            <small id="emailHelp" class="form-text text-muted">Contoh :
                                                pelapor@gmail.com</small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="complain">Saran / Pengaduan</label>
                                            <textarea rows="3" class="form-control" id="complain"
                                                      aria-describedby="complainHelp"
                                                      placeholder="Saran / Pengaduan"></textarea>
                                            <small id="complainHelp" class="form-text text-muted">Contoh : Jl. Arjuna
                                                no.
                                                16, Kec. Serengan, Surakarta</small>
                                        </div>
                                        <hr>
                                        <div class="text-right">
                                            <button type="submit" class="main-button">
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
            })
        })
    </script>
@endsection
