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
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.uki.index') }}">User UKI</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah
                </li>
            </ol>
        </div>
        <section>
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <p class="mb-0">Form Data User UKI</p>
                </div>
                <div class="card-body">
                    <form method="post">
                        @csrf
                        <div class="w-100 mb-4">
                            <label for="email" class="form-label f14">Email</label>
                            <input type="email" class="form-control f14" id="email" placeholder="Email"
                                   name="email" required>
                        </div>
                        <div class="w-100 mb-4">
                            <label for="username" class="form-label f14">Username</label>
                            <input type="text" class="form-control f14" id="username" placeholder="Username"
                                   name="username" required>
                        </div>
                        <div class="w-100 mb-4">
                            <label for="password" class="form-label f14">Password</label>
                            <input type="password" class="form-control f14" id="password" placeholder="Password"
                                   name="password" required>
                        </div>
                        <div class="w-100 mb-4">
                            <label for="name" class="form-label f14">Name</label>
                            <input type="text" class="form-control f14" id="name" placeholder="Name"
                                   name="name" required>
                        </div>
                        <div class="w-100 mb-4">
                            <label for="phone" class="form-label f14">No. Hp</label>
                            <input type="number" class="form-control f14" id="phone" placeholder="No. Hp"
                                   name="phone" required>
                        </div>
                        <hr>
                        <div class="w-100 text-right">
                            <button type="submit" class="main-button f14">
                                <i class="fa fa-check mr-2"></i>
                                <span>Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </div>
@endsection
