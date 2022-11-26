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
                <a href="{{ route('complain.index') }}" class="small-box-footer">Lihat lebih <i
                        class="fa fa-arrow-circle-right"></i></a>
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
                        <p class="mb-0 font-weight-bold">Data Pengaduan Baru</p>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table-data" class="display w-100 table table-bordered nowarp">
                        <thead>
                        {{--                        <tr>--}}
                        {{--                            <th width="5%" class="text-center f14 no-sort"></th>--}}
                        {{--                            <th width="5%" class="text-center f14">#</th>--}}
                        {{--                            <th width="10%" class="f14">Tanggal</th>--}}
                        {{--                            <th width="30%" class="f14">No. Tiket</th>--}}
                        {{--                            <th width="20%" class="f14">Nama</th>--}}
                        {{--                            <th width="15%" class="f14">Status</th>--}}
                        {{--                        </tr>--}}
                        <tr>
                            <th width="5%" class="text-center f12 no-sort"></th>
                            <th width="5%" class="text-center f12">#</th>
                            <th class="f12 text-center" width="12%">Tanggal</th>
                            <th class="f12">No. Ticket</th>
                            <th class="f12 text-center" width="8%">Aksi</th>
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
                        <a href="{{ route('complain.answered') }}" class="main-button-outline f12">Lihat Lebih <i
                                class="fa fa-arrow-circle-right ml-2"></i></a>
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
        var query = 'waiting';

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

            let action = '<div class="row mb-2 mt-2">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">' +
                '<a href="#" class="main-button btn-process" data-id="' + d['id'] + '"><i class="fa fa-paper-plane mr-2"></i>Kirim saran / pengaduan ke UKI</a>' +
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
                // disposition +
                '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p>Isi Saran / Pengaduan</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6"><div class="text-justify">: ' + d['complain'] + '</div></div>' +
                '</div>' +
                // action +
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

        function generateTable() {
            table = DataTableGenerator('#table-data', prefix_url + '/admin/pengaduan/data', [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null, render: function () {
                        return '<i class="fa fa-plus-square-o main-text expand-icon"></i>';
                    }
                },
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {
                    data: 'date', name: 'date', render: function (data, type, row, meta) {
                        let date = new Date(data);
                        return date.toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});
                    }
                },
                {data: 'ticket_id'},
                {
                    data: null, render: function (data, type, row, meta) {
                        let ticket_id = data['ticket_id'].replaceAll('/', '-');
                        let url = prefix_url + '/admin/pengaduan/' + ticket_id + '/info';
                        return '<a href="' + url + '" class="btn-send" data-id="' + data['id'] + '">Detail</a>';
                    }
                },
            ], [
                {
                    targets: '_all',
                    className: 'f12'
                },
                {
                    targets: [0, 1, 3],
                    className: 'text-center'
                },
                {
                    targets: [0, 3],
                    orderable: false
                }
            ], function (d) {
                d.q = 'waiting';
                d.limit = 5;
            }, {
                "scrollX": true,
                responsive: true,
                "fnDrawCallback": function (settings) {
                    setExpand();
                },
            });
        }

        $(document).ready(function () {
            generateTable();
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
