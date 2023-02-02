<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <div class="user-details">
            <div class="text-center">
            </div>

            <?php

            use Illuminate\Support\Facades\Auth;

            $id = Auth::user()->id_pegawai;
            $user = Auth::user()->name;
            $role = Auth::user()->role;
            if ($role == 1) { ?>

            <div class="user-info">
                <div class="dropdown">
                    <br>
                    <a class="text-info panel-title">{{ $user }}</a>
                </div>
            </div>
        </div>
        <!--- Role HRD -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="/" class="waves-effect"><i class="ti-home"></i><span class="text-info panel-title"> Dashboard</span></a>
                </li>
                <li>
                    <a href="{{ route('karyawan.index') }}" class="waves-effect"><i
                            class="mdi mdi-account-multiple-plus"></i><span class="text-info panel-title"> Data Karyawan</span></a>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-circle"></i><span class="text-info panel-title">DATA HRD</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/absensi-karyawan"><i class="mdi mdi-account-check"></i><span>Absensi</span></a></li>
                            <li><a href="/history-absensi"><i class="mdi mdi-clipboard-check"></i><span>History Absensi</span></a></li> 
                            <li><a href="/alokasi-cuti"><i class="mdi mdi-walk"></i><span>Alokasi Cuti</span></a> </li>             
                            <li><a href="/cuti-karyawan"><i class="mdi mdi-walk"></i><span>Ajukan Cuti & Izin</span></a> </li>                          
                        </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book"></i><span class="text-info panel-title">Absensi</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/absensi"><i class="ion-compose"></i><span>Data Absensi</span></a></li>
        
                        </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-walk"></i><span class="text-info panel-title">Cuti & Izin</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/permintaan_cuti"><i class="fa fa-server"></i><span>Data Cuti & Izin</span></a></li>
                            <li><a href="/kategori_cuti"><i class="mdi mdi-calendar"></i><span>Kategori Cuti & Izin</span></a></li>
                            <li><a href="/settingalokasi"><i class="fa fa-gears"></i><span>Setting Alokasi</span></a></li>
                            <li><a href="/alokasicuti"><i class="mdi mdi-chart-arc mdi-2x"></i><span>Alokasi Cuti</span></a></li>
                        </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-briefcase-check"></i><span class="text-info panel-title">Rekruitmen</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/data_rekrutmen"><i class="fa fa-check-square"></i><span>Rekruitmen</span></a></li>
                            <li><a href="/metode_rekrutmen"><i class="fa fa-sitemap"></i><span>Tahapan Rekruitmen</span></a></li>
                            
                        </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-briefcase-check"></i><span class="text-info panel-title">Data Resign</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/resign_admin"><i class="fa fa-server"></i><span>Resign Karyawan</span></a></li>
                            {{-- <li><a href="/kategori_cuti"><i class="mdi mdi-calendar"></i><span>Proses Rekrutmen</span></a></li>
                            <li><a href="/settingalokasi"><i class="fa fa-gears"></i><span>Setting Alokasi</span></a></li>
                            <li><a href="/alokasicuti"><i class="mdi mdi-chart-arc mdi-2x"></i><span>Alokasi Cuti</span></a></li> --}}
                        </ul>
                </li>

            <?php } elseif ($role == 2) { ?>

            <div class="user-info">
                <div class="dropdown">
                    <br>
                    <a class="text-info panel-title">{{ $user }}</a>
                </div>
            </div>
        </div>


        <!--- Role Karyawan -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="karyawandashboard" class="waves-effect">
                        <i class="ti-home"></i><span> Dashboard Karyawan</span>
                    </a>
                </li>

                <li>
                    <a href="/absensi-karyawan" class="waves-effect"><i
                            class="mdi mdi-account-check"></i><span>Absensi</span></a>
                </li>
                <li>
                    <a href="/history-absensi" class="waves-effect"><i class="mdi mdi-clipboard-check"></i><span>History
                            Absensi</span></a>
                </li>
                <li>
                    <a href="/cuti-karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Ajukan Cuti &
                            Izin</span></a>
                </li>
                <li>
                    <a href="/resign-karyawan" class="waves-effect"><i class="mdi mdi-account-off"></i><span>Ajukan Resign</span></a>
                </li>

            </ul>

            <?php } elseif ($role == 3) { ?>

            <div class="user-info">
                <div class="dropdown">
                    <br>
                    <a class="text-info panel-title">{{ $user }}</a>
                </div>
            </div>
        </div>

        <!--- Role Manager  -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="karyawandashboard" class="waves-effect">
                        <i class="ti-home"></i><span> Dashboard Manager </span>
                    </a>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book-open-page-variant"></i><span class="text-info panel-title">DATA MANAGER</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                     <ul class="list-unstyled">
                        <li><a href="/absensi-karyawan" class="waves-effect"><i class="mdi mdi-account-check"></i><span>Absensi</span></a></li>
                        <li><a href="/history-absensi" class="waves-effect"><i class="mdi mdi-clipboard-check"></i><span>History Absensi</span></a></li>                           
                        <li><a href="/cuti-karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Ajukan Cuti & Izin</span></a></li>
                     </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book"></i><span class="text-info panel-title">DATA STAFF</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                     <ul class="list-unstyled">
                        <li> <a href="/data-staff" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span>Data
                            Staff</span></a></li>
                        <li><a href="/absensi-staff" class="waves-effect"><i class="ion-compose"></i><span>Absensi
                            Staff</span></a></li>
                        <li><a href="/cuti-staff" class="waves-effect"><i class="fa fa-server"></i><span>Data Cuti
                            Staff</span></a></li>
                            <li><a href="/resign_manager" class="waves-effect"><i class="mdi mdi-account-off"></i><span>Data Resign
                                Staff</span></a></li>    
                    </ul>
                </li>
                
            </ul>

            <?php } elseif ($role == 4) { ?>

                <div class="user-info">
                    <div class="dropdown">
                        <br>
                        <a class="text-info panel-title">{{ $user }}</a>
                    </div>
                </div>
            </div>
    
            <!--- Role Direktur  -->
            <div id="sidebar-menu">
                <ul>
                    <li>
                        <a href="karyawandashboard" class="waves-effect">
                            <i class="ti-home"></i><span> Dashboard Direktur </span>
                        </a>
                    </li>
    
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book-open-page-variant"></i><span class="text-info panel-title">DATA DIREKTUR</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                         <ul class="list-unstyled">
                            <li><a href="/absensi-karyawan" class="waves-effect"><i class="mdi mdi-account-check"></i><span>Absensi</span></a></li>
                            <li><a href="/history-absensi" class="waves-effect"><i class="mdi mdi-clipboard-check"></i><span>History Absensi</span></a></li>                           
                            {{-- <li><a href="/cuti-karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Ajukan Cuti & Izin</span></a></li> --}}
                         </ul>
                    </li>
    
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book"></i><span class="text-info panel-title">DATA STAFF</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                         <ul class="list-unstyled">
                            {{-- <li> <a href="/data-staff" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span>Data
                                Staff</span></a></li>
                            <li><a href="/absensi-staff" class="waves-effect"><i class="ion-compose"></i><span>Absensi
                                Staff</span></a></li> --}}
                            <li><a href="/data-cuti-staff" class="waves-effect"><i class="fa fa-server"></i><span>Data Cuti
                                Staff</span></a></li>
                        </ul>
                    </li>
                </ul>
    
    
            <?php } else { ?>

            <div class="user-info">
                <div class="dropdown">
                    <br>
                    <a class="text-info panel-title">{{ $user }}</a>
                </div>
            </div>
        </div>
        <!--- Role Manager Human Resources -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="karyawandashboard" class="waves-effect">
                        <i class="ti-home"></i><span> Dashboard Manager</span>
                    </a>
                </li>
                <li>
                <li>
                    <a><span class="text-info panel-title">DATA MANAGER</span></a>
                </li>
                <li>
                    <a href="/absensi-karyawan" class="waves-effect"><i
                            class="mdi mdi-account-check"></i><span>Absensi</span></a>
                </li>
                <li>
                    <a href="/history-absensi" class="waves-effect"><i class="mdi mdi-clipboard-check"></i><span>History
                            Absensi</span></a>
                </li>
                <li>
                    <a href="/cuti-karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Ajukan Cuti &
                            Izin</span></a>
                </li>
                </li>
                <li>
                <li>
                    <a><span class="text-info panel-title">DATA STAFF</span></a>
                </li>
                <li>
                    <a href="/data-staff" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span>Data
                            Staff</span></a>
                </li>
                <li>
                    <a href="/absensi-staff" class="waves-effect"><i class="ion-compose"></i><span>Absensi
                            Staff</span></a>
                </li>
                <li>
                    <a href="/cuti-staff" class="waves-effect"><i class="fa fa-server"></i><span>Data Cuti
                            Staff</span></a>
                </li>
                </li>
                <?php }
            ?>
            </ul>
        </div>

        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->
<!-- Start right Content here -->
<div class="content-page">
