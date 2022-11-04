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
                                @if($waiting_answer != null)
                                    <object data="{{ asset('/assets/answers/abc.pdf') }}" width="100%" height="500" type="application/pdf" onerror="alert('pdf source not found!')">
                                    </object>

                                    {{--                                    <embed src="{{ asset('/assets/answers/abc.pdf') }}" type="application/pdf"   height="500" width="100%" class="responsive">--}}
                                    <form method="post">
                                        @csrf
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
                                            <button type="submit" class="main-button"><i class="fa fa-check mr-2"></i>Simpan
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                            <div class="tab-pane fade show" id="pills-history" role="tabpanel"
                                 aria-labelledby="pills-history-tab">
                                <table id="table-data" class="display w-100 table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tanggal Upload</th>
                                        <th scope="col">File</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($data->answers as $answer)
                                        <tr>
                                            <td width="5%" class="text-center f14">{{ $loop->index + 1 }}</td>
                                            <td class="f14">{{ $answer->date_upload }}</td>
                                            <td width="10%" class="text-center">
                                            </td>
                                            <td width="10%" class="text-center">
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

        $(document).ready(function () {
            togglePanelStatus();
            $('#status').on('change', function () {
                togglePanelStatus();
            });
            var table = $('#table-data').DataTable({
                "scrollX": true,
                "fnDrawCallback": function (setting) {
                }
            });

            $(document).on('shown.bs.tab', function (e) {
                table.columns.adjust();
            });
        })
    </script>
@endsection
