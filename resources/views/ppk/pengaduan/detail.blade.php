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
                    <a href="{{ route('dashboard.ppk') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('complain.index.ppk') }}">Saran / Pengaduan</a>
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
                                    <button type="submit" class="main-button"><i class="fa fa-check mr-2"></i>Simpan
                                    </button>
                                </div>
                            </form>
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
        })
    </script>
@endsection
