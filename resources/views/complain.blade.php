@extends('layout')

@section('content')
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
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Personal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Badan Hukum / Organisasi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Nama">
                                            <small id="nameHelp" class="form-text text-muted">Contoh : Yanuar Ihsan</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Alamat</label>
                                            <textarea rows="3" class="form-control" id="address" aria-describedby="addressHelp" placeholder="Alamat"></textarea>
                                            <small id="addressHelp" class="form-text text-muted">Contoh : Jl. Arjuna no. 16, Kec. Serengan, Surakarta</small>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
