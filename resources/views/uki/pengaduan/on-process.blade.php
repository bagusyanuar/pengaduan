@extends('admin.layout')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.uki') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Saran / Pengaduan Sedang Di Proses
                </li>
            </ol>
        </div>
    </div>
    <section>
        <div class="card card-outline card-warning">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0 f14 font-weight-bold">Data Saran / Pengaduan Sedang Di Proses</p>
                </div>
            </div>
            <div class="card-body">
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center f12 no-sort"></th>
                        <th width="5%" class="text-center f12">#</th>
                        <th class="f12" width="12%">Tanggal</th>
                        <th class="f12" width="25%">No. Ticket</th>
                        <th class="f12">Nama</th>
                        <th class="f12" width="12%">Legalitas</th>
                        <th class="f12" width="10%">Disposisi</th>
                        <th class="f12" width="8%">Status</th>
                        <th class="f12" width="12%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <style>
        .btn-detail-outline {
            border: 1px solid #0078AA;
            padding-top: 2px;
            border-radius: 5px;
            width: 30px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-answer-outline {
            border: 1px solid #EF5B0C;
            padding-top: 2px;
            border-radius: 5px;
            width: 30px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">
        var table;
        var prefix_url = '{{ env('PREFIX_URL') }}';
        var query = 'process';

        function reload() {
            table.ajax.reload();
            setExpand();
        }

        function detailElement(d) {
            let assignment = '';
            let ad_art = '';
            if (d['type'] === 1) {
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
            let ticket_id = d['ticket_id'].replaceAll('/', '-');
            let url = prefix_url + '/admin-uki/pengaduan/' + ticket_id + '/jawaban';
            let action = '<div class="row mb-2 mt-2">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">' +
                '<a href="' + url + '" class="main-button btn-process" data-ticket="' + d['ticket_id'] + '" data-id="' + d['id'] + '"><i class="fa fa-comments mr-2"></i>Lihat Jawaban</a>' +
                '</div>' +
                '</div>';

            return '<div class="f12">' +
                '<p class="font-weight-bold">Detail Saran / Pengaduan</p>' +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">No. Whatsapp</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['phone'] + '</div>' +
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
                '<div class="col-lg-9 col-md-8 col-sm-6"><div class="text-justify">: ' + d['complain'] + '</div></div>' +
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

        function sendProcess(id) {
            AjaxPost(prefix_url + '/admin-uki/pengaduan/' + id + '/process', function () {
                window.location.reload();
            })
        }

        function generateTable() {
            table = DataTableGenerator('#table-data', prefix_url + '/admin-uki/pengaduan/data', [
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
                {
                    data: null, render: function (data, type, row, meta) {
                        let legal = 'Individu';
                        if (data['type'] === 1) {
                            legal = 'Badan Hukum';
                        }
                        return legal;
                    }
                },
                {
                    data: null, render: function (data, type, row, meta) {
                        let target_disposition = '-';
                        if (data['target'] !== null) {
                            if (data['target'] === 1) {
                                target_disposition = data['ppk']['name'];
                            } else {
                                target_disposition = data['unit']['name'];
                            }
                        }
                        return target_disposition;
                    }
                },
                {
                    data: null, render: function (data, type, row, meta) {
                        let status = data['HasAnswer'];
                        let ticket_id = data['ticket_id'].replaceAll('/', '-');
                        let url = prefix_url + '/admin-uki/pengaduan/' + ticket_id + '/jawaban';
                        let el = '<i class="fa fa-check-circle" style="font-size: 18px; color: darkgray"></i>';
                        if (status) {
                            el = '<i class="fa fa-check-circle" style="font-size: 18px; color: #f55400"></i>';
                        }
                        return el;
                    }
                },
                {
                    data: null, render: function (data, type, row, meta) {
                        let ticket_id = data['ticket_id'].replaceAll('/', '-');
                        let url = prefix_url + '/admin-uki/pengaduan/' + ticket_id + '/info';
                        let urlAnswer = prefix_url + '/admin-uki/pengaduan/' + ticket_id + '/jawaban';
                        return '<a href="' + url + '" class="btn-detail-outline mr-1 mb-1 d-inline-block" data-id="' + data['id'] + '" data-toggle="tooltip" data-placement="bottom" title="Detail Saran / Pengaduan"><i class="fa fa-info" style="font-size: 12px; color: #0078AA"></i></a>' +
                            '<a href="' + urlAnswer + '" class="btn-answer-outline d-inline-block" data-id="' + data['id'] + '" data-toggle="tooltip" data-placement="bottom" title="Jawaban Saran / Pengaduan"><i class="fa fa-comments" style="font-size: 12px; color: #EF5B0C"></i></a>';
                    }
                },
            ], [
                {
                    targets: '_all',
                    className: 'f12'
                },
                {
                    targets: [0, 1, 2, 5, 6, 7, 8],
                    className: 'text-center'
                },
                {
                    targets: [6, 7, 8],
                    orderable: false
                }
            ], function (d) {
                d.q = query;
            }, {
                "scrollX": true,
                "fnDrawCallback": function (settings) {
                    setExpand();
                },
            });
        }


        $(document).ready(function () {
            generateTable();
            setExpand();
        });
    </script>
@endsection
