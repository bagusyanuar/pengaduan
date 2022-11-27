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
                        <p class="mb-0 font-weight-bold f14 main-text">Data Pengaduan Baru</p>
                        <a href="{{ route('complain.index') }}" class="main-button-outline f12">Lihat Lebih <i
                                class="fa fa-arrow-circle-right ml-2"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table-data" class="display w-100 table table-bordered nowarp">
                        <thead>
                        <tr>
                            <th width="5%" class="text-center f12 no-sort"></th>
                            <th width="5%" class="text-center f12">#</th>
                            <th class="f12 text-center" width="20%">Tanggal</th>
                            <th class="f12">No. Ticket</th>
                            <th class="f12 text-center" width="8%">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0 font-weight-bold f14 main-text">Data Permintaan Informasi Baru</p>
                        <a href="{{ route('information.index') }}" class="main-button-outline f12">Lihat Lebih <i
                                class="fa fa-arrow-circle-right ml-2"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table-data-information" class="display w-100 table table-bordered nowarp">
                        <thead>
                        <tr>
                            <th width="5%" class="text-center f12 no-sort"></th>
                            <th width="5%" class="text-center f12">#</th>
                            <th class="f12 text-center" width="20%">Tanggal</th>
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
                    <table class="display w-100 table table-bordered nowarp" id="table-data-complain-answered">
                        <thead>
                        <tr>
                            <th scope="col" width="5%" class="f12">#</th>
                            <th scope="col" class="f12">No. Tiket</th>
                            <th scope="col" width="8%" class="text-center f12">Aksi</th>
                            <th scope="col" width="5%" class="text-center f12"></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card card-outline card-success">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0">Permintaan Informasi Dijawab</p>
                        <a href="{{ route('information.index') }}" class="main-button-outline f12">Lihat Lebih <i
                                class="fa fa-arrow-circle-right ml-2"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="display w-100 table table-bordered nowarp" id="table-data-information-answered">
                        <thead>
                        <tr>
                            <th scope="col" width="5%" class="f12">#</th>
                            <th scope="col" class="f12">No. Tiket</th>
                            <th scope="col" width="8%" class="text-center f12">Aksi</th>
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

@section('css')
    <style>
        .dataTables_length, .dataTables_length > label > select {
            font-size: 12px !important;
        }

        .dataTables_empty {
            font-size: 12px !important;
        }
    </style>
@endsection
@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">
        var table, tableAnswer, tableInformation, tableInformationAnswer;
        var prefix_url = '{{ env('PREFIX_URL') }}';
        var query = 'waiting';

        function setExpandTableRowComplain() {
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
                '<div class="col-lg-9 col-md-8 col-sm-6"><div class="text-justify">: ' + d['address'] + '</div></div>' +
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
                // action +
                '</div>';
        }

        function generateTableNewComplain() {
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
                        return '<a href="#" class="btn-send-complain" data-id="' + data['id'] + '"><i class="fa fa-envelope"></i></a>'
                    }
                },
            ], [
                {
                    targets: '_all',
                    className: 'f12'
                },
                {
                    targets: [0, 1, 2, 4],
                    className: 'text-center'
                },
                {
                    targets: [0, 4],
                    orderable: false
                }
            ], function (d) {
                d.q = 'waiting';
                d.limit = 5;
            }, {
                "dom": 't',
                "scrollX": true,
                responsive: true,
                "fnDrawCallback": function (settings) {
                    setExpandTableRowComplain();
                    eventProcessComplain();
                },
            });
        }

        function eventProcessComplain() {
            $('.btn-send-complain').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                let iconUrl = '{{ asset('/assets/icons/question.png') }}';
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: 'Ingin memproses data pengaduan?',
                    iconHtml: '<img src="' + iconUrl + '" height="100">',
                    customClass: {
                        icon: 'no-border'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.value) {
                        sendProcessComplain(id);
                    }
                });
            });
        }

        function sendProcessComplain(id) {
            AjaxPost(prefix_url + '/admin/pengaduan/' + id + '/process', function () {
                Swal.fire({
                    title: 'Success!',
                    text: 'Berhasil mengirimkan data ke admin UKI...',
                    icon: 'success',
                }).then((result) => {
                    window.location.reload();
                });
            })
        }

        function generateTableAnsweredComplain() {
            tableAnswer = DataTableGenerator('#table-data-complain-answered', prefix_url + '/admin/pengaduan/data', [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'ticket_id'},
                {
                    data: null, render: function (data, type, row, meta) {
                        return '<a href="#" class="btn-reply-complain" data-id="' + data['id'] + '"><i class="fa fa-envelope"></i></a>';
                    }
                },
                {
                    data: null, render: function (data, type, row, meta) {
                        let status = data['status'];
                        let el = '-';
                        switch (status) {
                            case 6:
                                // el = '<div class="pills-danger text-center">Di Tolak</div>';
                                el = '<i class="fa fa-window-close" style="color: #EB1D36; font-size: 14px;"></i>';
                                break;
                            case 9:
                                // el = '<div class="pills-success text-center">Di Setujui</div>';
                                el = '<i class="fa fa-check-square" style="color: #54B435; font-size: 14px;"></i>';
                                break;
                            default:
                                break
                        }
                        return el;
                    }
                },
            ], [
                {
                    targets: '_all',
                    className: 'f12'
                },
                {
                    targets: [0, 2, 3],
                    className: 'text-center'
                },
                {
                    targets: [0, 2, 3],
                    orderable: false
                }
            ], function (d) {
                d.q = 'answered';
                d.limit = 5;
            }, {
                "dom": 't',
                "scrollX": true,
                responsive: true,
                "fnDrawCallback": function (settings) {
                    eventSendReplyComplain();
                },
            });
        }

        function eventSendReplyComplain() {
            $('.btn-reply-complain').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                let iconUrl = '{{ asset('/assets/icons/question.png') }}';
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: 'Selesaikan saran / pengaduan dan kirim pesan ke pelapor?',
                    iconHtml: '<img src="' + iconUrl + '" height="100">',
                    customClass: {
                        icon: 'no-border'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.value) {
                        sendReply(id);
                    }
                });
            });
        }

        function sendReply(id) {
            AjaxPost(prefix_url + '/admin/pengaduan/' + id + '/reply', function () {
                Swal.fire({
                    title: 'Success!',
                    text: 'Berhasil mengirimkan balasan ke pelapor...',
                    icon: 'success',
                }).then((result) => {
                    window.location.reload();
                });
            })
        }

        function generateTableNewInformation() {
            tableInformation = DataTableGenerator('#table-data-information', prefix_url + '/admin/informasi/data', [
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
                        return '<a href="#" class="btn-send-information" data-id="' + data['id'] + '"><i class="fa fa-envelope"></i></a>'
                    }
                },
            ], [
                {
                    targets: '_all',
                    className: 'f12'
                },
                {
                    targets: [0, 1, 2, 4],
                    className: 'text-center'
                },
                {
                    targets: [0, 4],
                    orderable: false
                }
            ], function (d) {
                d.q = 'waiting';
                d.limit = 5;
            }, {
                "dom": 't',
                "scrollX": true,
                responsive: true,
                "fnDrawCallback": function (settings) {
                    setExpandTableRowInformation();
                    eventProcessInformation();
                },
            });
        }

        function detailElementInformation(d) {
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

        function setExpandTableRowInformation() {
            $('#table-data-information tbody').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var row = tableInformation.row(tr);
                var i = $(this).children();

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    i.removeClass('fa fa-minus-square-o');
                    i.addClass('fa fa-plus-square-o');
                } else {
                    // Open this row
                    row.child(detailElementInformation(row.data())).show();
                    tr.addClass('shown');
                    i.removeClass('fa fa-plus-square-o');
                    i.addClass('fa fa-minus-square-o');
                }
            });
        }

        function eventProcessInformation() {
            $('.btn-send-information').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                let iconUrl = '{{ asset('/assets/icons/question.png') }}';
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: 'Ingin memproses data permintaan informasi?',
                    iconHtml: '<img src="' + iconUrl + '" height="100">',
                    customClass: {
                        icon: 'no-border'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.value) {
                        sendProcessInformation(id);
                    }
                });
            });
        }

        function sendProcessInformation(id) {
            AjaxPost(prefix_url + '/admin/informasi/' + id + '/process', function () {
                Swal.fire({
                    title: 'Success!',
                    text: 'Berhasil mengirimkan permintaan informasi data ke admin UKI...',
                    icon: 'success',
                }).then((result) => {
                    window.location.reload();
                });
            })
        }

        $(document).ready(function () {
            generateTableNewComplain();
            setExpandTableRowComplain();
            eventProcessComplain();
            generateTableAnsweredComplain();
            eventSendReplyComplain();

            generateTableNewInformation();
            setExpandTableRowInformation();
            eventProcessInformation();
        });
    </script>
@endsection
