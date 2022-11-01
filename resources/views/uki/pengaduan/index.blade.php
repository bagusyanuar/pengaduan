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
        <div class="w-100">
            <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-waiting-tab" data-toggle="pill" href="#pills-waiting"
                       role="tab" aria-controls="pills-waiting" aria-selected="true">Menunggu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-process-tab" data-toggle="pill" href="#pills-process"
                       role="tab" aria-controls="pills-process" aria-selected="false">Proses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-answered-tab" data-toggle="pill" href="#pills-answered"
                       role="tab" aria-controls="pills-answered" aria-selected="false">Terjawab</a>
                </li>
            </ul>
        </div>
        <div class="card card-outline card-warning">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0">Data Saran / Pengaduan</p>
                </div>
            </div>
            <div class="card-body">
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
        var query = 'waiting';

        function reload() {
            table.ajax.reload();
            setExpand();
        }

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

            let action = '';
            if (query === 'waiting') {
                let ticket_id = d['ticket_id'].replaceAll('/', '-');
                let url = prefix_url + '/admin-uki/pengaduan/' + ticket_id + '/info';
                action = '<div class="row mb-2 mt-2">' +
                    '<div class="col-lg-3 col-md-4 col-sm-6">' +
                    '</div>' +
                    '<div class="col-lg-9 col-md-8 col-sm-6">' +
                    '<a href="' + url + '" class="main-button btn-process" data-ticket="' + d['ticket_id'] + '" data-id="' + d['id'] + '"><i class="fa fa-info-circle mr-2"></i>Detail</a>' +
                    '</div>' +
                    '</div>';
            }

            let disposition = '';
            if (query !== 'waiting') {
                disposition = '<div class="row">' +
                    '<div class="col-lg-3 col-md-4 col-sm-6">' +
                    '<p class="mb-0">Disposisi</p>' +
                    '</div>' +
                    '<div class="col-lg-9 col-md-8 col-sm-6">: -</div>' +
                    '</div>';
            }


            return '<div>' +
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
                disposition +
                '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p>Isi Saran / Pengaduan</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6"><span>:</span><p class="text-justify mb-0 d-inline"> ' + d['complain'] + '</p></div>' +
                '</div>' +
                action +
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
            ], [], function (d) {
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
            $(document).on('shown.bs.tab', function (e) {
                let id = e.target.id;
                query = 'waiting';
                switch (id) {
                    case 'pills-process-tab':
                        query = 'process';
                        break;
                    case 'pills-answered-tab' :
                        query = 'answered';
                        break;
                    case 'pills-complete-tab' :
                        query = 'complete';
                        break;
                    default:
                        break;
                }
                reload();
                table.columns.adjust();
            });
            setExpand();
            // $('#table-data-waiting tbody').on('click', '.btn-process', function (e) {
            //     e.preventDefault();
            //     let id = this.dataset.id;
            //     sendProcess(id);
            //     console.log(id);
            // });
        });
    </script>
@endsection
