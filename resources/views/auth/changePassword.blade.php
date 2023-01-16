@extends('layouts.default')

@section('content')


        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">

                <div class="panel-body">
                    <h3 class="text-center m-t-0 m-b-20">
                        {{-- <span class=""><img src="assets/images/logo_dark2.png" alt="logo" height="130" width="130"></span> --}}
                        <span class="btn btn-lg"><i class="fa fa-key fa-4x fa-rotate-270"></i></span>
                    </h3>
                    <h4 class="text-muted text-center m-t-0"><b>Ganti Password</b></h4>

                    <form action="updatePassword{id}" method="POST">
                        @csrf
                        @method('put')

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="oldPasswordInput" class="form-label">Password Lama</label>
                                    <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                                        placeholder="Masukkan Password Lama">
                                        @error('old_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="newPasswordInput" class="form-label">Password Baru</label>
                                    <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                        placeholder="Masukkan Password Baru">
                                    @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="confirmNewPasswordInput" class="form-label">Konfirmasi Password Baru</label>
                                    <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput"
                                        placeholder="Konfirmasi Password Baru">
                                </div>
                            </div>


                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Change</button>
                            </div>
                        </div>

                        <div class="form-group m-t-30 m-b-0">
                            <div class="col-sm-7">
                                <a href="{{ route('password.request') }}" class="text-muted"> </a>
                            </div>
                            <div class="col-sm-5 text-right">
                                <!-- <a href="{{ route('register') }}" class="nav-link">Create an account</a>                                -->
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

@endsection