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
                <li class="breadcrumb-item active" aria-current="page">PPK
                </li>
            </ol>
        </div>
    </div>
    <section>
        <div class="card card-outline card-warning">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0">Data PPK</p>
                    <a href="{{ route('ppk.add') }}" class="main-button f14">
                        <i class="fa fa-plus mr-1"></i>
                        <span>Tambah</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center f14">#</th>
                        <th width="20%" class="f14">Satuan Kerja</th>
                        <th class="f14">Nama</th>
                        <th width="10%" class="text-center f14"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                        <tr>
                            <td width="5%" class="text-center f14">{{ $loop->index + 1 }}</td>
                            <td class="f14">{{ $v->unit->name }}</td>
                            <td class="f14">{{ $v->name }}</td>
                            <td width="10%" class="text-center">
                                <div class="dropdown">
                                    <a href="#" class="main-button-outline" data-toggle="dropdown">
                                        <span style="font-size: 12px;">Kelola</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                                        <a href="{{ route('ppk.patch', ['id' => $v->id]) }}"
                                           class="dropdown-item f12">Edit</a>
                                        <a href="#" data-id="{{ $v->id }}"
                                           class="dropdown-item f12 btn-delete">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">
        var prefix_url = '{{ env('PREFIX_URL') }}';

        function destroy(id) {
            AjaxPost(prefix_url + '/admin/ppk/' + id + '/delete', function () {
                window.location.reload();
            })
        }

        function eventDelete() {
            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                AlertConfirm('Apakah anda yakin menghapus?', 'Data yang dihapus tidak dapat dikembalikan!', function () {
                    destroy(id);
                })
            });
        }

        $(document).ready(function () {
            $('#table-data').DataTable({
                "scrollX": true,
                "fnDrawCallback": function (setting) {
                    eventDelete();
                }
            });
            eventDelete();
        });
    </script>
@endsection
