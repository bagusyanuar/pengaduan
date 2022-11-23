@extends('admin.layout')

@section('css')
    <style>
        .swal2-container {
            display: grid;
            position: fixed;
            z-index: 9999;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            box-sizing: border-box;
            grid-template-areas: "top-start  top       top-end   " "center-start center    center-end" "bottom-start bottom-center bottom-end";
            grid-template-rows: minmax(-webkit-min-content, auto) minmax(-webkit-min-content, auto) minmax(-webkit-min-content, auto);
            grid-template-rows: minmax(min-content, auto) minmax(min-content, auto) minmax(min-content, auto);
            height: 100%;
            padding: 0.625em;
            overflow-x: hidden;
            transition: background-color 0.1s;
            -webkit-overflow-scrolling: touch;
        }

        .swal2-shown {
            overflow: unset !important;
            padding-right: 0px !important;
        }

        #backdrop-loading {
            pointer-events: all;
            display: none;
            z-index: 99999;
            border: none;
            margin: 0px;
            padding: 0px;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            cursor: wait;
            position: fixed;
            background-color: rgba(0, 0, 0, 0.6);
        }
    </style>
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Gagal!", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="backdrop-loading" id="backdrop-loading">
        <div style="height: 100%; width: 100%" class="d-flex align-items-center justify-content-center">
            <div class="text-center">
                <img src="{{ asset('/assets/icons/loading.png') }}" height="200" class="mb-2">
                <p style="color: white">Sedang mengirim data saran / pengaduan ke admin UKI...</p>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Saran / Pengaduan Terjawab
                </li>
            </ol>
        </div>
    </div>
    <section>
        <div class="card card-outline card-warning">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0">Data Saran / Pengaduan Terjawab</p>
                </div>
            </div>
            <div class="card-body">
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center f14"></th>
                        <th width="5%" class="text-center f14">#</th>
                        <th class="f14" width="12%">Tanggal</th>
                        <th class="f14" width="25%">No. Ticket</th>
                        <th class="f14">Nama</th>
                        <th class="f14" width="13%">Legalitas</th>
                        <th class="f14 text-center" width="8%">Status</th>
                        <th class="f14 text-center" width="8%">Aksi</th>
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

            let action = '<div class="row mt-2 mb-2">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">' +
                '<a href="#" class="main-button btn-process" data-id="' + d['id'] + '"><i class="fa fa-check mr-2"></i>Selesai & Kirim Pesan</a>' +
                '</div>' +
                '</div>';

            let targetDisposition = '-';

            if (d['unit'] !== null && d['target'] === 0) {
                targetDisposition = d['unit']['name'];
            }
            if (d['ppk'] !== null && d['target'] === 1) {
                targetDisposition = d['ppk']['name'];
            }


            let disposition = '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Disposisi</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + targetDisposition + '</div>' +
                '</div>';

            let description = '';
            if (d['status'] === 6) {
                description = '<div class="row mb-2">' +
                    '<div class="col-lg-3 col-md-4 col-sm-6">' +
                    '<p>Alasan Penolakan</p>' +
                    '</div>' +
                    '<div class="col-lg-9 col-md-8 col-sm-6"><div class="text-justify">: ' + d['description'] + '</div></div>' +
                    '</div>';
            }

            return '<div class="f14">' +
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
                '<div class="col-lg-9 col-md-8 col-sm-6"><div class="text-justify">: ' + d['complain'] + '</div></div>' +
                '</div>' +
                description +
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
                        let status = data['status'];
                        let el = '-';
                        switch (status) {
                            case 6:
                                // el = '<div class="pills-danger text-center">Di Tolak</div>';
                                el = '<i class="fa fa-window-close" style="color: #EB1D36; font-size: 16px;"></i>';
                                break;
                            case 7:
                                // el = '<div class="pills-success text-center">Di Setujui</div>';
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
                        return '<a href="#" class="btn-send" data-id="' + data['id'] + '"><i class="fa fa-envelope" style="font-size: 16px;"></i></a>'
                    }
                },
            ], [
                {
                    targets: '_all',
                    className: 'f14'
                },
                {
                    targets: [0, 1, 2, 5, 6, 7],
                    className: 'text-center'
                },
                {
                    targets: [0, 6, 7],
                    orderable: false,
                }
            ], function (d) {
                d.q = query;
            }, {
                "scrollX": true,
                "fnDrawCallback": function (settings) {
                    setExpand();
                    eventSend();
                },
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

        function eventSend() {
            $('.btn-send').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                console.log(id);
                let iconUrl = '{{ asset('/assets/icons/question.png') }}';
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: 'Ingin mengirimkan pesan ke pelapor?',
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

        $(document).ready(function () {
            generateTable();
            setExpand();
            eventSend();
        });
    </script>
@endsection
