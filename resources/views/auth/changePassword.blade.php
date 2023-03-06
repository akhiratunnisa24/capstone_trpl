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
                    <h4 class="text-muted text-center m-t-0 m-b-30"><b>Ganti Password</b></h4>

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
                            <div class="form-group">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput" placeholder="Masukkan Password Lama">
                                        @error('old_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <a class="input-group-addon" id="toggle-password"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                        placeholder="Masukkan Password Baru">
                                        @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <a class="input-group-addon" id="toggle-password1"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput"
                                        placeholder="Konfirmasi Password Baru">
                                        <a class="input-group-addon" id="toggle-password2"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Simpan</button>
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
        <style>
            #toggle-password i {
                cursor: pointer;
            }
            #toggle-password1 i {
                cursor: pointer;
            }
            #toggle-password2 i {
                cursor: pointer;
            }
        </style>
        <script type="text/javascript">
            document.getElementById("toggle-password").addEventListener("click", function() {
                var x = document.getElementById("oldPasswordInput");
                var toggle = document.getElementById("toggle-password").firstChild;
                if (x.type === "password") {
                    x.type = "text";
                    toggle.classList.remove("fa-eye");
                    toggle.classList.add("fa-eye-slash");
                } else {
                    x.type = "password";
                    toggle.classList.remove("fa-eye-slash");
                    toggle.classList.add("fa-eye");
                }
            });
            document.getElementById("toggle-password1").addEventListener("click", function() {
                var y = document.getElementById("newPasswordInput");
                var toggle = document.getElementById("toggle-password1").firstChild;
                if (y.type === "password") {
                    y.type = "text";
                    toggle.classList.remove("fa-eye");
                    toggle.classList.add("fa-eye-slash");
                } else {
                    y.type = "password";
                    toggle.classList.remove("fa-eye-slash");
                    toggle.classList.add("fa-eye");
                }
            });
            document.getElementById("toggle-password2").addEventListener("click", function() {
                var z = document.getElementById("confirmNewPasswordInput");
                var toggle = document.getElementById("toggle-password2").firstChild;
                if (z.type === "password") {
                    z.type = "text";
                    toggle.classList.remove("fa-eye");
                    toggle.classList.add("fa-eye-slash");
                } else {
                    z.type = "password";
                    toggle.classList.remove("fa-eye-slash");
                    toggle.classList.add("fa-eye");
                }
            });
        </script>

@endsection