<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Rynest Employee Management System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="assets/images/remss.png" width="38px" height="20px">

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    </head>


    <body>

        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">

                <div class="panel-body">
                    <h3 class="text-center m-t-0 m-b-30">
                        {{-- <span class=""><img src="assets/images/logo_dark2.png" alt="logo" height="130" width="130"></span> --}}
                        <span class=""><img src="assets/images/remss.png" alt="logo" height="80" width="200"></span>
                    </h3>
                    <h4 class="text-muted text-center m-t-0"><b>Log In</b></h4>

                    <form method="POST" class="form-horizontal m-t-20" action="{{ route('login') }}">
                    @csrf
                    
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <input class="form-control" type="text" required="" id="email" name="email" placeholder="Username">
                                    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <a class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <input class="form-control" type="password" required="" id="password" name="password" placeholder="Password">
                                   
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror   
                                    <a class="input-group-addon" id="toggle-password3"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" name="remember" id="remember" type="checkbox">
                                    <label for="checkbox-signup">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
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

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <script src="assets/js/app.js"></script>
        <style>
            #toggle-password3 i {
                cursor: pointer;
            }
        </style>
        <script type="text/javascript">
            document.getElementById("toggle-password3").addEventListener("click", function() {
                var x = document.getElementById("password");
                var toggle = document.getElementById("toggle-password3").firstChild;
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
        </script>

    </body>
</html>


