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
                <li class="breadcrumb-item active" aria-current="page">Saran / Pengaduan
                </li>
            </ol>
        </div>
    </div>
    <section>
        <div class="card card-outline card-warning">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0 f4 font-weight-bold">Data Saran / Pengaduan</p>
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
                        <th class="f12" width="13%">Legalitas</th>
                        <th class="f12" width="10%">Disposisi</th>
                        <th class="f12 text-center" width="5%">Status</th>
                        <th class="f12" width="8%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">
        var table;
        var prefix_url = '{{ env('PREFIX_URL') }}';
        var query = 'answered';

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
                    row.child(detailElement(row.data())).show();
                    tr.addClass('shown');
                    i.removeClass('fa fa-plus-square-o');
                    i.addClass('fa fa-minus-square-o');

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
                        let status = data['status'];
                        let el = '-';
                        switch (status) {
                            case 6:
                                el = '<i class="fa fa-window-close" style="color: #EB1D36; font-size: 16px;"></i>';
                                break;
                            case 9:
                                el = '<i class="fa fa-check-square" style="color: #54B435; font-size: 16px;"></i>';
                                break;
                            default:
                                break
                        }
                        return el;
                    }
                },
                {
                    data: null, render: function (data, type, row, meta) {
                        let ticket_id = data['ticket_id'].replaceAll('/', '-');
                        let url = prefix_url + '/admin-uki/pengaduan/' + ticket_id + '/jawaban';
                        return '<a href="' + url + '" class="btn-detail" data-id="' + data['id'] + '">Detail</a>'
                    }
                },
            ], [
                {
                    targets: '_all',
                    className: 'f12'
                },
                {
                    targets: [0, 1, 2, 5, 6, 7],
                    className: 'text-center'
                },
                {
                    targets: [0, 6, 7],
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
