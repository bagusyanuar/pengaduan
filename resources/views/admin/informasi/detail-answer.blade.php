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
    <div class="backdrop-loading" id="backdrop-loading">
        <div style="height: 100%; width: 100%" class="d-flex align-items-center justify-content-center">
            <div class="text-center">
                <img src="{{ asset('/assets/icons/loading.png') }}" height="200" class="mb-2">
                <p style="color: white">Sedang mengirim email ke pelapor...</p>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('information.index') }}">Permintaan Informasi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->ticket_id }}
                </li>
            </ol>
        </div>
    </div>
    <section>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                   aria-selected="true">Jawaban</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                   aria-controls="profile" aria-selected="false">Detail</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card mt-2 card-outline card-success">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Jawaban</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="w-100 mb-2">
                            <label for="target" class="form-label f14">Disposisi</label>
                            <input type="text" class="form-control f14" id="target" placeholder="Disposisi"
                                   name="target"
                                   value="{{ ($data->status === 6 ? '-' : ($data->target === 1 ? $data->ppk->name : $data->unit->name))   }}"
                                   readonly
                                   form="">
                        </div>
                        <hr>
                        @if($data->status === 6)
                            <div style="height: 200px" class="d-flex justify-content-center align-items-center">
                                <div>
                                    <p class="font-weight-bold">Permintaan Informasi ditolak
                                        dikarenakan {{ $data->description }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="text-right">
                                @if(!$data->is_finish)
                                    <form method="post" id="form-answer">
                                        @csrf
                                        <button type="submit" class="main-button f12"
                                                id="btn-response"><i
                                                class="fa fa-check mr-2"></i>Selesaikan
                                            Permohonan
                                        </button>
                                    </form>
                                @else
                                    <div class="d-flex f12 align-items-center font-weight-bold justify-content-end">
                                        <i class="fa fa-check mr-2"
                                           style="color: #54B435"></i><span>Permintaan Informasi Selesai</span>
                                    </div>
                                @endif
                            </div>
                        @else
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-answer-tab" data-toggle="pill"
                                       href="#pills-answer"
                                       role="tab" aria-controls="pills-answer" aria-selected="true">
                                        <i class="fa fa-file-pdf-o mr-2"></i>Lampiran Jawaban
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-history-tab" data-toggle="pill" href="#pills-history"
                                       role="tab" aria-controls="pills-history" aria-selected="false">
                                        <i class="fa fa-history mr-2"></i>History
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-answer" role="tabpanel"
                                     aria-labelledby="pills-answer-tab">
                                    @if($data->approved_answer != null)
                                        <object data="{{ asset($data->approved_answer->file) }}" width="100%"
                                                height="500"
                                                type="application/pdf" onerror="alert('pdf source not found!')">
                                        </object>
                                        <hr>
                                        <form method="post" id="form-answer" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row align-items-end">
                                                <div class="col-sm-12 col-md-6 col-lg-7">
                                                    <div class="d-flex align-items-center justify-content-start">
                                                        <a href="{{ route('information.attachment.by.ticket', ['ticket' => str_replace('/', '-', $data->ticket_id)]) }}"
                                                           target="_blank" class="f12"><i
                                                                class="fa fa-download mr-2"></i>Download Surat
                                                            Pengantar</a>
                                                        <span style="color: grey" class="ml-2 mr-2">|</span>
                                                        <a href="{{ env('PREFIX_URL'). $data->approved_answer->file }}"
                                                           target="_blank" class="ml-2 f12"><i
                                                                class="fa fa-download mr-2"></i>Download Jawaban</a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-5">
                                                    <div
                                                        class="d-flex align-items-center justify-content-end w-100">
                                                        @if(!$data->is_finish)
                                                            <button type="submit" class="main-button f12"
                                                                    id="btn-response"><i
                                                                    class="fa fa-check mr-2"></i>Selesaikan
                                                                Permohonan
                                                            </button>
                                                        @else
                                                            <div class="d-flex f12 align-items-center font-weight-bold">
                                                                <i class="fa fa-check mr-2"
                                                                   style="color: #54B435"></i><span>Permintaan Informasi Selesai</span>
                                                            </div>
                                                        @endif
                                                        <a href="#" class="main-button-outline f12 ml-2"
                                                           id="btn-send-email" data-ticket="{{ $data->ticket_id }}"><i
                                                                class="fa fa-envelope mr-2"></i>Kirim Email
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </form>
                                    @else
                                        <div class="d-flex justify-content-center align-items-center"
                                             style="height: 250px;">
                                            <p class="font-weight-bold">Belum Ada Lampiran Jawaban</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade show" id="pills-history" role="tabpanel"
                                     aria-labelledby="pills-history-tab">
                                    <table id="table-data" class="display w-100 table table-bordered">
                                        <thead>
                                        <tr>
                                            <th width="5%" class="text-center f12">#</th>
                                            <th class="f12 text-center" width="12%">Tanggal Upload</th>
                                            <th class="f12 text-center" width="12%">Tanggal Respon</th>
                                            <th scope="col" class="f12" width="15%">Di Upload Oleh</th>
                                            <th scope="col" class="f12">Respon</th>
                                            <th scope="col" class="f12 text-center" width="12%">File</th>
                                            <th scope="col" class="f12 text-center" width="8%">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card mt-2 card-outline card-warning">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Detail Saran / Pengaduan</p>
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
        </div>
    </section>
@endsection

@section('css')
    <style>
        .dataTables_length, .dataTables_length > label > select {
            font-size: 12px !important;
        }

        .dataTables_empty {
            font-size: 12px !important;
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
@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">
        var table;
        var prefix_url = '{{ env('PREFIX_URL') }}';

        function togglePanelStatus() {
            let cVal = $('#status').val();
            if (cVal === '1') {
                $('#denied').removeClass('d-block');
                $('#denied').addClass('d-none');
            } else {
                $('#denied').removeClass('d-none');
                $('#denied').addClass('d-block');
            }
        }

        function generateTable() {
            let ticket_id = '{{ $data->ticket_id }}'.replaceAll('/', '-');
            let url = prefix_url + '/admin/informasi/jawab/' + ticket_id + '/data';
            table = DataTableGenerator('#table-data', url, [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'date_upload'},
                {
                    data: 'date_answer', name: 'date_answer', render: function (data) {
                        let value = '-';
                        if (data !== null) {
                            value = data;
                        }
                        return value;
                    }
                },
                {data: 'upload_by.username'},
                {data: 'description'},
                {
                    data: 'file', name: 'file', render: function (data) {
                        let url = prefix_url + data;
                        return '<a href="' + url + '" target="_blank">Preview</a>';
                    }
                },
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
                    targets: [0, 1, 2, 5, 6],
                    className: 'text-center'
                },
                {
                    targets: [0, 5, 6],
                    orderable: false
                }
            ], function (d) {
                // d.q = query;
            }, {
                "scrollX": true,
                "fnDrawCallback": function (settings) {
                    // setExpand();
                },
            });
        }

        function eventSendMail(ticket) {
            AjaxPost(prefix_url + '/admin/informasi/jawab/' + ticket + '/email', function () {
                Swal.fire({
                    title: 'Success!',
                    text: 'Berhasil mengirimkan balasan ke pelapor...',
                    icon: 'success',
                }).then((result) => {
                    window.location.reload();
                });
            })
        }

        $(document).ready(function () {
            $('.custom-file-input').on('change', function () {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
            togglePanelStatus();
            $('#status').on('change', function () {
                togglePanelStatus();
            });
            generateTable();

            $(document).on('shown.bs.tab', function (e) {
                table.columns.adjust();
            });
            $('#btn-response').on('click', function (e) {
                e.preventDefault();
                let iconUrl = '{{ asset('/assets/icons/question.png') }}';
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: 'Ingin menyelesaikan permintaan informasi?',
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

            $('#btn-send-email').on('click', function (e) {
                e.preventDefault();
                let iconUrl = '{{ asset('/assets/icons/question.png') }}';
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: 'Ingin mengirim jawaban permohonan informasi ke pelapor?',
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
                        let ticket = this.dataset.ticket;
                        eventSendMail(ticket.replaceAll('/', '-'));
                        // $('#form-answer').submit();
                    }
                });
            });
        })
    </script>
@endsection
