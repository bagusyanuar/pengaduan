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
                    <i class="fa fa-bell"></i>
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
                    <i class="fa fa-info"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat lebih <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="card card-outline card-warning mt-3">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0">Data Pengaduan</p>
            </div>
        </div>
        <div class="card-body">
            <table id="table-data" class="display w-100 table table-bordered">
                <thead>
                <tr>
                    <th width="5%" class="text-center f14 no-sort"></th>
                    <th width="5%" class="text-center f14">#</th>
                    <th width="20%" class="f14">Tanggal</th>
                    <th width="15%" class="f14">No. Tiket</th>
                    <th width="20%" class="f14">Nama</th>
                    <th width="20%" class="f14">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td width="5%" class="text-center f14 dt-control">
                            <i class="fa fa-plus-square-o main-text expand-icon"></i>
                        </td>
                        <td width="5%" class="text-center f14">{{ $loop->index + 1 }}</td>
                        <td class="f14">{{ $v->date }}</td>
                        <td class="f14">{{ $v->ticket_id }}</td>
                        <td class="f14">{{ $v->name }}</td>
                        <td class="f14">{{ $v->status }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table-data').DataTable();
        });
    </script>
@endsection
