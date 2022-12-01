@extends('admin.layout')

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
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.satker') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('information.index.satker') }}">Permintaan Informasi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->ticket_id }}
                </li>
            </ol>
        </div>
    </div>
    <section>
        <div class="row">
            <div class="col-sm-12 col-md-5 col-lg-5">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Detail Permintaan Informasi</p>
                        </div>
                    </div>
                    <div class="card-body">


                        <div class="w-100 mb-2">
                            <label for="ticket_id" class="form-label f14">No. Ticket</label>
                            <input type="text" class="form-control f14" id="ticket_id" placeholder="No. Ticket"
                                   name="ticket_id" value="{{ $data->ticket_id }}" readonly form="">
                        </div>
                        <div class="w-100 mb-2">
                            <label for="date" class="form-label f14">Tanggal Pengajuan</label>
                            <input type="text" class="form-control f14" id="date" placeholder="Tanggal Pengajuan"
                                   name="date" value="{{ \Carbon\Carbon::parse($data->date)->format('d M Y') }}"
                                   readonly>
                        </div>
                        <div class="w-100 mb-2">
                            <label for="name" class="form-label f14">Nama Pelapor</label>
                            <input type="text" class="form-control f14" id="name" placeholder="No. Ticket"
                                   name="name" value="{{ $data->name }}" readonly>
                        </div>
                        <div class="w-100 mb-2">
                            <label for="address" class="form-label f14">Alamat</label>
                            <textarea rows="3" class="form-control f14" id="address" placeholder="Alamat"
                                      name="address" readonly>{{ $data->address }}</textarea>
                        </div>
                        <div class="w-100 mb-2">
                            <label for="phone" class="form-label f14">No. Whatsapp</label>
                            <input type="text" class="form-control f14" id="phone" placeholder="No. Whatsapp"
                                   name="phone" value="{{ $data->phone }}" readonly>
                        </div>
                        <div class="w-100 mb-2">
                            <label for="email" class="form-label f14">Email</label>
                            <input type="text" class="form-control f14" id="email" placeholder="Email"
                                   name="email" value="{{ $data->email }}" readonly>
                        </div>
                        <div class="w-100 mb-2">
                            <label for="information_source" class="form-label f14">Asal Informasi</label>
                            <input type="text" class="form-control f14" id="information_source"
                                   name="information_source" value="{{ $data->information_source }}" readonly>
                        </div>
                        <div class="w-100 mb-2">
                            <label for="source" class="form-label f14">Salinan Informasi</label>
                            <input type="text" class="form-control f14" id="source"
                                   name="source" value="{{ $data->source }}" readonly>
                        </div>
                        <div class="w-100 mb-2">
                            <label for="purpose" class="form-label f14">Tujuan</label>
                            <textarea rows="4" class="form-control f14" id="purpose"
                                      name="purpose" readonly>{{ $data->purpose }}</textarea>
                        </div>
                        <div class="w-100 mb-2">
                            <label for="information" class="form-label f14">Informasi</label>
                            <textarea rows="4" class="form-control f14" id="information"
                                      name="information" readonly>{{ $data->information }}</textarea>
                        </div>
                        <div class="w-100 mb-2">
                            <label for="type" class="form-label f14">Legalitas</label>
                            <input type="text" class="form-control f14" id="type" placeholder="Legalitas"
                                   name="type"
                                   value="{{ $data->type === 0 ? 'Personal / Individu' : 'Badan Hukum / Organisasi' }}"
                                   readonly>
                        </div>
                        @if($data->type === 1)
                            <div class="w-100 mb-2">
                                <label for="assignment" class="form-label f14 d-block">Surat Kuasa</label>
                                <a href="#">Preview</a>
                            </div>
                            <div class="w-100 mb-2">
                                <label for="ad_art" class="form-label f14 d-block">AD ART</label>
                                <a href="#">Preview</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-7 col-lg-7">
                @if($data->target === 0)
                    <div class="card card-outline card-success mb-2">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0">Jawaban</p>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($data->HasAnswer && !$data->HasApprovedAnswer)
                                <div class="d-flex justify-content-center align-items-center" style="height: 150px">
                                    <p class="font-weight-bold">Menunggu Persetujuan Dari Admin UKI</p>
                                </div>
                            @elseif($data->HasApprovedAnswer)
                                <div class="d-flex justify-content-center align-items-center" style="height: 150px">
                                    <p class="font-weight-bold">Jawaban Disetujui</p>
                                </div>
                            @else
                                <form method="post" id="form-answer" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-1">
                                        <label for="answer" class="form-label">Lampiran Jawaban</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="answer" name="answer"
                                                   accept="application/pdf">
                                            <label class="custom-file-label f14" for="ad_art">Pilih File Lampiran
                                                Jawaban</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="text-right">
                                        <button type="submit" class="main-button" id="btn-answer"><i
                                                class="fa fa-check mr-2"></i>Simpan
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Riwayat Jawaban</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="display w-100 table table-bordered" id="table-data">
                            <thead>
                            <tr>
                                <th width="5%" class="text-center f14 no-sort"></th>
                                <th width="5%" class="text-center f14">#</th>
                                <th class="f14" width="17%">Tanggal</th>
                                <th class="f14">Respon UKI</th>
                                <th class="f14" width="8%">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('css')
    <link href="{{ asset('/adminlte/plugins/select2/select2.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script src="{{ asset('/adminlte/plugins/select2/select2.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.full.js') }}"></script>
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">
        let table;
        var prefix_url = '{{ env('PREFIX_URL') }}';

        function togglePanelStatus() {
            let cVal = $('#status').val();
            if (cVal === '1') {
                $('#accepted').removeClass('d-none');
                $('#accepted').addClass('d-block');
                $('#denied').removeClass('d-block');
                $('#denied').addClass('d-none');
            } else {
                $('#accepted').removeClass('d-block');
                $('#accepted').addClass('d-none');
                $('#denied').removeClass('d-none');
                $('#denied').addClass('d-block');
            }
        }

        function togglePanelTarget() {
            let rVal = $('input:radio[name=target]:checked').val();
            console.log(rVal)
            if (rVal === '1') {
                $('#panel-ppk').removeClass('d-none');
                $('#panel-ppk').addClass('d-block');
                $('#panel-unit').removeClass('d-block');
                $('#panel-unit').addClass('d-none');
            } else {
                $('#panel-ppk').removeClass('d-block');
                $('#panel-ppk').addClass('d-none');
                $('#panel-unit').removeClass('d-none');
                $('#panel-unit').addClass('d-block');
            }
        }

        function detailElement(d) {
            let asset_file = prefix_url + d['file'];
            let author_answer = '-';
            let response_date = '-';
            if (d['status'] !== 0) {
                author_answer = d['author_answer']['username'];
                response_date = d['date_answer'];
            }
            return '<div class="f14">' +
                '<p class="font-weight-bold">Detail Respon Jawaban UKI</p>' +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Tanggal Respon</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + response_date + '</div>' +
                '</div>' +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Di Jawab Oleh</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + author_answer + '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">File Lampiran</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6"><div class="text-justify">: <a href="' + asset_file + '" target="_blank">Lampiran</a></div></div>' +
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
                }
            });
        }

        function generateTable() {
            let ticket_id = '{{ $data->ticket_id }}'.replaceAll('/', '-');
            let url = prefix_url + '/admin-satker/informasi/' + ticket_id + '/jawaban/riwayat';
            table = DataTableGenerator('#table-data', prefix_url + url, [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null, render: function () {
                        return '<i class="fa fa-plus-square-o main-text expand-icon"></i>';
                    }
                },
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {
                    data: 'date_upload', name: 'date_upload', render: function (data) {
                        let date = new Date(data);
                        return date.toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});
                    }
                },
                {data: 'description'},
                {
                    data: null, render: function (data, type, row, meta) {
                        let status = data['status'];
                        let el = '<i class="fa fa-minus" style="font-size: 16px; color: gray"></i>';
                        switch (status) {
                            case 0:
                                el = '<i class="fa fa-check-circle" style="font-size: 16px; color: #f55400"></i>';
                                break;
                            case 6:
                                el = '<i class="fa fa-check-circle" style="font-size: 16px; color: #EB1D36"></i>';
                                break;
                            case 9:
                                el = '<i class="fa fa-check-circle" style="font-size: 16px; color: #54B435"></i>';
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
                    targets: [0, 1, 4],
                    className: 'text-center'
                },
                {
                    targets: [0, 4],
                    orderable: false
                }
            ], function (d) {

            }, {
                "scrollX": true,
                "fnDrawCallback": function (settings) {
                    setExpand();
                },
            });
        }

        $(document).ready(function () {
            $('.custom-file-input').on('change', function () {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
            $('.select2').select2({
                width: 'resolve'
            });
            togglePanelStatus();
            togglePanelTarget();
            $('#status').on('change', function () {
                togglePanelStatus();
            });

            $('input:radio[name=target]').on('change', function () {
                togglePanelTarget();
            })
            generateTable();
            setExpand();

            $('#btn-answer').on('click', function (e) {
                e.preventDefault();
                let iconUrl = '{{ asset('/assets/icons/question.png') }}';
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: 'Ingin mengirimkan lampiran jawaban ke UKI?',
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
                        $('#form-answer').submit();
                    }
                });
            });
        })
    </script>
@endsection
