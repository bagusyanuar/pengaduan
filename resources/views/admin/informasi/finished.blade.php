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
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Permintaan Informasi Selesai
                </li>
            </ol>
        </div>
    </div>
    <section>
        <div class="card card-outline card-warning">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0">Data Permintaan Informasi Selesai</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3 col-lg-3 col-sm-12">
                        <div class="form-group mb-2">
                            <label for="start_date" style="font-size: 12px;">Tanggal Awal</label>
                            <div class="input-group">
                                <input type="date" id="start_date" value="{{ date('Y-m-d') }}" class="form-control f12"
                                       aria-label="Recipient's username" aria-describedby="start_date_append">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="start_date_append"><i
                                            class="fa fa-calendar f12"></i></span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-12">
                        <div class="form-group">
                            <label for="end_date f12" style="font-size: 12px;">Tanggal Akhir</label>
                            <div class="input-group">
                                <input type="date" id="end_date" value="{{ date('Y-m-d') }}" class="form-control f12"
                                       aria-label="Recipient's username" aria-describedby="end_date_append">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="end_date_append"><i
                                            class="fa fa-calendar f12"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center f14 no-sort"></th>
                        <th width="5%" class="text-center f14">#</th>
                        <th class="f14" width="12%">Tanggal</th>
                        <th class="f14" width="25%">No. Ticket</th>
                        <th class="f14">Nama</th>
                        <th class="f14" width="15%">Legalitas</th>
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
        var query = 'complete';

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

            let targetDisposition = '-';
            if (d['unit'] !== null) {
                targetDisposition = d['unit']['name'];
            }
            if (d['ppk'] !== null) {
                targetDisposition = d['ppk']['name'];
            }


            let disposition = '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Disposisi</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + targetDisposition + '</div>' +
                '</div>';

            return '<div class="f12">' +
                '<p class="font-weight-bold">Detail Permintaan Informasi</p>' +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">No. Ktp</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['card_id'] + '</div>' +
                '</div>' +
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
                '<div class="col-lg-9 col-md-8 col-sm-6"><div class="text-justify">: ' + d['address'] + '</div></div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Pekerjaan</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['job'] + '</div>' +
                '</div>' +
                disposition +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Asal Informasi</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['information_source'] + '</div>' +
                '</div>' +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Salinan Informasi</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['source'] + '</div>' +
                '</div>' +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Tujuan</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6"><div class="text-justify">: ' + d['purpose'] + '</div></div>' +
                '</div>' +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Informasi</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6"><div class="text-justify">: ' + d['information'] + '</div></div>' +
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
                    // console.log(tr.closest('i'));

                }
            });


        }

        function generateTable() {
            table = DataTableGenerator('#table-data', prefix_url + '/admin/informasi/data', [
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
            ], [
                {
                    targets: '_all',
                    className: 'f12'
                },
                {
                    targets: [0, 1, 2, 3, 5],
                    className: 'text-center'
                },
                {
                    targets: [0],
                    orderable: false
                }
            ], function (d) {
                d.q = query;
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
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
            $('#start_date').on('change', function () {
                reload();
            });
            $('#end_date').on('change', function () {
                reload();
            });
        });
    </script>
@endsection