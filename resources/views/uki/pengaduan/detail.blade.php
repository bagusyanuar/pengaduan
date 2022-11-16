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
        <div class="row">
            <div class="col-sm-12 col-md-7 col-lg-7">
                <div class="card card-outline card-warning">
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
            <div class="col-sm-12 col-md-5 col-lg-5">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Persetujuan</p>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($data->satker_id == null)
                            {{--                            <form method="post" id="form-disposition"--}}
                            {{--                                  action="{{ route('complain.data.send.disposition', ['id' => $data->id]) }}">--}}
                            <form method="post" id="form-disposition">
                                @csrf
                                <div class="form-group w-100 mb-2">
                                    <label for="status" class="form-label f14">Status</label>
                                    <select class="form-control f14" id="status" name="status">
                                        <option class="f14" value="1">Setuju</option>
                                        <option class="f14" value="0">Tolak</option>
                                    </select>
                                </div>
                                <div class="d-block" id="accepted">
                                    <div class="form-group w-100 mb-2">
                                        <label for="target_satker" class="form-label f14 d-block">Disposisi</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="target"
                                                   id="target_satker"
                                                   value="0" checked>
                                            <label class="form-check-label" for="target_satker">Satuan Kerja</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="target" id="target_ppk"
                                                   value="1">
                                            <label class="form-check-label" for="target_ppk">PPK</label>
                                        </div>
                                    </div>
                                    <div class="form-group w-100 mb-2 d-block" id="panel-unit">
                                        <label for="unit" class="f14">Satuan Kerja</label>
                                        <select class="select2 f14" name="unit" id="unit" style="width: 100%;">
                                            @foreach($unit as $v)
                                                <option value="{{ $v->id }}"
                                                        class="f14">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group w-100 mb-2 d-none" id="panel-ppk">
                                        <label for="ppk" class="f14">PPK</label>
                                        <select class="select2 f14" name="ppk" id="ppk" style="width: 100%;">
                                            @foreach($ppk as $v)
                                                <option value="{{ $v->id }}"
                                                        class="f14">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="d-none" id="denied">
                                    <div class="w-100 mb-2">
                                        <label for="description" class="form-label f14">Deskripsi Penolakan</label>
                                        <textarea rows="3" class="form-control f14" id="description"
                                                  placeholder="Deskripsi Penolakan"
                                                  name="description"></textarea>
                                    </div>
                                </div>

                                <hr>
                                <div class="text-right">
                                    <button type="submit" class="main-button"><i class="fa fa-check mr-2"></i>Simpan
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="text-center">
                                <p class="font-weight-bold">
                                    Data Saran / Pengaduan Sudah Di Teruskan Kepada
                                    <br>
                                    @if($data->target == 1)
                                        <span class="font-weight-bold">{{ $data->ppk->name }}</span>
                                    @else
                                        <span class="font-weight-bold">{{ $data->unit->name }}</span>
                                    @endif
                                </p>
                            </div>
                            <hr>
                            <div class="text-right">
                                <a href="{{ route('complain.answers.uki.by.ticket', ['ticket' => str_replace('/', '-', $data->ticket_id)]) }}"
                                   class="main-button"><i class="fa fa-comments mr-2"></i>Lihat Jawaban</a>
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

        $(document).ready(function () {
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
        })
    </script>
@endsection
