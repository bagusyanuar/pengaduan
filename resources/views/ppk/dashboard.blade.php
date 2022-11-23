@extends('admin.layout')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item active" aria-current="page">Dashboard
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-7 col-md-12 col-sm-12">
            <div class="card card-outline card-warning mt-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0">Data Pengaduan</p>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table-data" class="display w-100 table table-bordered nowarp">
                        <thead>
                        <tr>
                            <th width="5%" class="text-center f14 no-sort"></th>
                            <th width="5%" class="text-center f14">#</th>
                            <th width="10%" class="f14">Tanggal</th>
                            <th width="30%" class="f14">No. Tiket</th>
                            <th width="20%" class="f14">Nama</th>
                            <th width="15%" class="f14">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="card card-outline card-success mt-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0">Pengaduan Di Jawab</p>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col" width="10%">#</th>
                            <th scope="col" width="75%">No. Tiket</th>
                            <th scope="col" width="15%" class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
@endsection
