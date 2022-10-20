@extends('admin.layout')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item active" aria-current="page">Dashboard
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>20</h3>
                    <p>Pengaduan Baru</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat lebih <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>15</h3>
                    <p>Permohonan Informasi Baru</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat lebih <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection
