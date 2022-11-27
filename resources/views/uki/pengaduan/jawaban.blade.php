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
                <li class="breadcrumb-item">
                    <a href="{{ route('complain.index.uki') }}">Saran / Pengaduan</a>
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
                                   value="{{ $data->target === 1 ? $data->ppk->name : $data->unit->name  }}" readonly
                                   form="">
                        </div>
                        <hr>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-answer-tab" data-toggle="pill" href="#pills-answer"
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
                                @if($data->answer != null)
                                    <object data="{{ asset($data->answer->file) }}" width="100%" height="500"
                                            type="application/pdf" onerror="alert('pdf source not found!')">
                                    </object>
                                    <form method="post" id="form-answer">
                                        @csrf
                                        {{--                                        <input type="hidden" value="{{ $data->answer->id }}" name="id">--}}
                                        <div class="form-group w-100 mb-2">
                                            <label for="status" class="form-label f14">Status</label>
                                            <select class="form-control f14" id="status" name="status">
                                                <option class="f14" value="1">Setuju</option>
                                                <option class="f14" value="0">Tolak</option>
                                            </select>
                                        </div>
                                        <div class="d-none" id="denied">
                                            <div class="w-100 mb-2">
                                                <label for="description" class="form-label f14">Deskripsi
                                                    Penolakan</label>
                                                <textarea rows="3" class="form-control f14" id="description"
                                                          placeholder="Deskripsi Penolakan"
                                                          name="description"></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="text-right">
                                            <button type="submit" class="main-button" id="btn-response"><i class="fa fa-check mr-2"></i>Simpan
                                            </button>
                                        </div>
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
                            <label for="complain" class="form-label f14">Saran / Pengaduan</label>
                            <textarea rows="4" class="form-control f14" id="complain" placeholder="Saran / Pengaduan"
                                      name="complain" readonly>{{ $data->complain }}</textarea>
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
    <link href="{{ asset('/adminlte/plugins/select2/select2.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script src="{{ asset('/adminlte/plugins/select2/select2.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.full.js') }}"></script>
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
            console.log(ticket_id)
            let url = prefix_url + '/admin-uki/pengaduan/' + ticket_id + '/jawaban/data';
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

        $(document).ready(function () {
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
                    text: 'Ingin memproses jawaban saran / pengaduan?',
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
