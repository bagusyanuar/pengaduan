@extends('layout2')

@section('css')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
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
    <section id="tracing">
        <div class="p-5">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="ticket">No. Ticket <span style="color: red">*</span></label>
                                <input type="text"
                                       class="form-control {{ $errors->has('ticket') ? 'is-invalid' : '' }}"
                                       id="ticket"
                                       aria-describedby="legalNameHelp" placeholder="No. Ticket" name="ticket"
                                       value="{{ old('ticket') }}">
                                @if ($errors->has('ticket'))
                                    <p class="invalid-feedback mb-0" style="font-size: 0.8em">
                                        {{ $errors->first('ticket') }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-right">
                                <a href="#" class="main-button" id="btn-tracing">
                                    <i class="fa fa-search mr-2"></i><span>Lacak Laporan</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('js')
    <script type="text/javascript">
        var prefix_url = '{{ env('PREFIX_URL') }}';
        $(document).ready(function () {
            $('#btn-tracing').on('click', function (e) {
                e.preventDefault();
                console.log('a');
                let ticket_id = $('#ticket').val().replaceAll('/', '-');
                if (ticket_id !== '') {
                    window.location.href = prefix_url + '/lacak-laporan/' + ticket_id;
                }

            });
        })
    </script>
@endsection
