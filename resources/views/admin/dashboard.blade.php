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
                    <h3>{{ $new_complain }}</h3>
                    <p>Pengaduan Baru</p>
                </div>
                <div class="icon">
                    <i class="fa fa-exclamation"></i>
                </div>
                <a href="{{ route('complain.index') }}" class="small-box-footer">Lihat lebih <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $new_information }}</h3>
                    <p>Permohonan Informasi Baru</p>
                </div>
                <div class="icon">
                    <i class="fa fa-info"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat lebih <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 col-md-12 col-sm-12">
            <div class="card card-outline card-warning mt-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0 font-weight-bold">Data Pengaduan</p>
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
                        <a href="{{ route('complain.answered') }}" class="main-button-outline f12">Lihat Lebih <i class="fa fa-arrow-circle-right ml-2"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col" width="10%" class="f14">#</th>
                            <th scope="col" width="75%" class="f14">No. Tiket</th>
                            <th scope="col" width="15%" class="text-center f14">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $v)
                            <tr>
                                <th scope="row" class="f14">{{ $loop->index + 1 }}</th>
                                <td class="f14 font-weight-bold">{{ $v->ticket_id }}</td>
                                <td class="text-center f14">
                                    <a href="#" data-ticket="{{ $v->ticket_id }}"
                                       data-contact="{{ $v->phone }}" class="wa-send"><i
                                            class="fa fa-whatsapp"></i></a>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">
        var table;
        var prefix_url = '{{ env('PREFIX_URL') }}';

        function detailElement(d) {
            let type = 'Individu';
            let assignment = '';
            let ad_art = '';
            if (d['type'] === 1) {
                type = 'Badan Hukum / Organisasi';
                let tmp_assignment = d['legal'] !== null ? d['legal']['assignment'] : '-';
                let tmp_ad_art = d['legal'] !== null ? d['legal']['ad_art'] : '-';
                assignment = '<div class="row mb-0">' +
                    '<div class="col-lg-3 col-md-4 col-sm-6">' +
                    '<p class="mb-0">Surat Tugas / Surat Kuasa </p>' +
                    '</div>' +
                    '<div class="col-lg-9 col-md-8 col-sm-6">: <a href="' + prefix_url + tmp_assignment + '" target="_blank">Preview</a></div>' +
                    '</div>';

                ad_art = '<div class="row mb-0">' +
                    '<div class="col-lg-3 col-md-4 col-sm-6">' +
                    '<p class="mb-0">AD ART</p>' +
                    '</div>' +
                    '<div class="col-lg-9 col-md-8 col-sm-6">: <a href="' + prefix_url + tmp_ad_art + '" target="_blank">Preview</a></div>' +
                    '</div>';
            }


            return '<div>' +
                '<p class="font-weight-bold f14">Informasi Saran / Pengaduan</p>' +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0 f14">Jenis Pengaduan</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6 f14">: ' + type + '</div>' +
                '</div>' +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0 f14">No. Whatsapp</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6 f14">: ' + d['phone'] + '</div>' +
                '</div>' +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Email</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['email'] + '</div>' +
                '</div>' +
                assignment +
                ad_art +
                '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Alamat</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['address'] + '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Pekerjaan</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['job'] + '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p>Isi Saran / Pengaduan</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['complain'] + '</div>' +
                '</div>' +
                '</div>';
        }

        function setExpand() {
            $('#table-data tbody').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var i = $(this).children();

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    i.removeClass('fa fa-minus-square-o');
                    i.addClass('fa fa-plus-square-o');
                } else {
                    // Open this row
                    console.log(row.data());
                    row.child(detailElement(row.data())).show();
                    tr.addClass('shown');
                    i.removeClass('fa fa-plus-square-o');
                    i.addClass('fa fa-minus-square-o');
                    console.log(row.data());
                    // console.log(tr.closest('i'));
                }
            });
        }

        $(document).ready(function () {
            table = DataTableGenerator('#table-data', prefix_url + '/admin/complain/dashboard', [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null, render: function () {
                        return '<i class="fa fa-plus-square-o main-text expand-icon"></i>';
                    }
                },
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'date'},
                {data: 'ticket_id'},
                {data: 'name'},
                // {data: 'phone'},
                {
                    data: null, render: function (data, type, row, meta) {
                        let status = '<div class="pills-grey text-center">Menunggu</div>';
                        switch (data['status']) {
                            case 1:
                                status = '<div class="pills-warning text-center">Proses</div>';
                                break;
                            case 6:
                                status = '<div class="pills-danger text-center">Di Tolak</div>';
                                break;
                            case 7:
                                status = '<div class="pills-info text-center">Terjawab</div>';
                                break;
                            case 9:
                                status = '<div class="pills-success text-center">Selesai</div>';
                                break;
                            default:
                                break;
                        }
                        return status;
                    }
                },
            ], [
                {
                    targets: '_all',
                    className: 'f14'
                }
            ], function (d) {
            }, {
                "scrollX": true,
                "fnDrawCallback": function (settings) {
                    setExpand();
                },
                dom: 't',
            });
            setExpand();

            $('.wa-send').on('click', function (e) {
                e.preventDefault();
                AjaxPost
                let phone = this.dataset.contact;
                let ticket = this.dataset.ticket;
                let text = 'https://api.whatsapp.com/send/?phone=' + phone + '&text=Cek Jawaban Ticket ' + ticket + ' klik link https://stackoverflow.com/';
                var win = window.open(text, '_blank');
                if (win) {
                    win.focus();
                }
            })
        });
    </script>
@endsection
