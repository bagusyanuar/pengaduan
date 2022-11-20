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
                <li class="breadcrumb-item active" aria-current="page">Saran / Pengaduan Menunggu
                </li>
            </ol>
        </div>
    </div>
    <section>
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
                        <th class="f14" width="20%">No. Ticket</th>
                        <th class="f14">Nama</th>
                        <th class="f14 text-center" width="13%">Legalitas</th>
                        <th class="f14" width="12%"></th>
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
                action = '<div class="row mb-2">' +
                    '<div class="col-lg-3 col-md-4 col-sm-6">' +
                    '</div>' +
                    '<div class="col-lg-9 col-md-8 col-sm-6">' +
                    '<a href="#" class="main-button btn-process" data-id="' + d['id'] + '"><i class="fa fa-paper-plane mr-2"></i>Proses</a>' +
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
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['complain'] + '</div>' +
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

        function sendProcess(id) {
            AjaxPost(prefix_url + '/admin/pengaduan/' + id + '/process', function () {
                window.location.reload();
            })
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
                        return '<a href="#" class="main-button-outline f14 btn-process" data-id="' + data['id'] + '"><i class="fa fa-paper-plane mr-2"></i>Proses</a>';
                    }
                },
            ], [
                {
                    targets: '_all',
                    className: 'f14'
                },
                {
                    targets: [5],
                    className: 'text-center'
                }
            ], function (d) {
                d.q = 'waiting';
            }, {
                "scrollX": true,
                "fnDrawCallback": function (settings) {
                    setExpand();
                    eventProcess();
                },
            });
        }

        function eventProcess() {
            $('.btn-process').on('click',  function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: 'Yakin ingin memproses data pengaduan?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.value) {
                        sendProcess(id);
                    }
                });
            });
        }

        $(document).ready(function () {
            generateTable();
            setExpand();
            eventProcess();
            // $('#table-data tbody').on('click', '.btn-process', function (e) {
            //     e.preventDefault();
            //     let id = this.dataset.id;
            //     Swal.fire({
            //         title: 'Konfirmasi!',
            //         text: 'Yakin ingin memproses data pengaduan?',
            //         icon: 'info',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Ya'
            //     }).then((result) => {
            //         if (result.value) {
            //             sendProcess(id);
            //         }
            //     });
            // });
        });
    </script>
@endsection
