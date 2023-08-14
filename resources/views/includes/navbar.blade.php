<body class="fixed-left">
    <!-- Begin page -->
        <div id="wrapper">
            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="/" class="logo"><img src="assets/images/remss.png" height="40" width="100"></a>
                        {{-- <img src="{{ asset('images/' . SettingHelper::getSetting()->logo) }}" alt="Logo"> --}}
                        {{-- <img src="{{ asset('images/' . SettingOrganisasiLogo()) }}" alt="Logo" width="100%">
                        <img src="{{ asset('images/' . SettingOrganisasiLogo()) }}" alt="Logo"> --}}

                        <a href="/" class="logo-sm"><img src="assets/images/remss.png" height="20"  width="50"></a>
                    </div>
                </div>
                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button type="button" class="button-menu-mobile open-left  waves-light">
                                    <i class="ion-navicon"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>
                            {{-- <form class="navbar-form pull-left" role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control search-bar" placeholder="Search...">
                                </div>
                                <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                            </form> --}}

                            <ul class="nav navbar-nav navbar-right pull-right">
                                <li class="dropdown hidden-xs">
                                    {{-- <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-bell"></i> <span class="badge badge-xs badge-danger">3</span>
                                    </a> --}}
                                    <ul class="dropdown-menu dropdown-menu-lg">
                                        <li class="text-center notifi-title">Pemberitahuan <span class="badge badge-xs badge-success">3</span></li>
                                        <li class="list-group">
                                           <!-- list item-->
                                            <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="media-heading">Your order is placed</div>
                                                 <p class="m-0">
                                                   <small>Dummy text of the printing and typesetting industry.</small>
                                                 </p>
                                              </div>
                                            </a>
                                            <!-- list item-->
                                            <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="media-body clearfix">
                                                    <div class="media-heading">New Message received</div>
                                                    <p class="m-0">
                                                       <small>You have 87 unread messages</small>
                                                    </p>
                                                 </div>
                                              </div>
                                            </a>
                                            <!-- list item-->
                                            <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="media-body clearfix">
                                                    <div class="media-heading">Your item is shipped.</div>
                                                    <p class="m-0">
                                                       <small>It is a long established fact that a reader will</small>
                                                    </p>
                                                 </div>
                                              </div>
                                            </a>
                                            <!-- last list item -->
                                            <a href="javascript:void(0);" class="list-group-item">
                                              <small class="text-primary">See all notifications</small>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <?php
            
                                use Illuminate\Support\Facades\Auth;
                                $id = Auth::user()->id_pegawai;
                                { ?>

                                <li class="dropdown">
                                    <a href="" class="dropdown-toggle profile waves-effect waves-light " data-toggle="dropdown" aria-expanded="true"><img src="{{ !empty($row->foto) ? asset('Foto_Profile/' . $row->foto) : asset('assets/images/users/avatar-1.jpg') }}" alt="user-img" class="img-circle"> </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="showkaryawan{{$id}}"><i class="fa fa-user pull-right"></i>Profile</a></li>
                                        <li><a href="editPassword{{$id}}"><i class="fa fa-cog pull-right"></i> Ganti Password </a></li>
                                        {{-- <li><a href="javascript:void(0)"> Lock screen</a></li> --}}
                                        <li class="divider"></li>
                                    
                                        <li><a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Keluar </a></li>
                                        
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                                            @csrf
                                        </form>
                                    </ul>
                                </li>
                                <?php  } ?>
                            </ul>
                        </div>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        {{-- </div> --}}
    <!-- Top Bar End -->
            