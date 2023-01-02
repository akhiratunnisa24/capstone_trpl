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
                    <a href="/" class="waves-effect"><i class="ti-home"></i><span> Dashboard</span></a>
                </li>
                <li>
                    <a href="/absensi-karyawan" class="waves-effect">
                        <i class="mdi mdi-account-check"></i><span>Absensi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('karyawan.index') }}" class="waves-effect">
                        <i class="mdi mdi-account-multiple-plus"></i><span> Data Karyawan</span>
                    </a>
                </li>

                {{-- <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><span>ABSENSI</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="/absensi"><i class="ion-compose"></i><span>Data Absensi</span></a></li>
                        <li><a href="/rekapabsensi"><i class="mdi mdi-account-card-details"></i><span>Rekap Absensi</span></a></li>
                    </ul>
                </li> --}}

                {{-- <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><span>CUTI & IZIN</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="/permintaan_cuti"><i class="fa fa-server"></i><span>Data Cuti & Izin</span></a></li>
                        <li><a href="/kategori_cuti"><i class="mdi mdi-calendar"></i><span>Kategori Cuti & Izin</span></a></li>
                        <li><a href="/settingalokasi"><i class="fa fa-gears"></i><span>Setting Alokasi</span></a></li>
            
                        <li><a href="/alokasicuti"><i class="mdi mdi-chart-arc mdi-2x"></i><span>Alokasi Cuti</span></a></li>
                    </ul>
                </li> --}}

                <li>
                    <li><a><span class="text-info panel-title">ABSENSI</span></a></li>
                    <li><a href="/absensi"><i class="ion-compose"></i><span>Data Absensi</span></a></li>
                    <li><a href="/rekapabsensi"><i class="mdi mdi-account-card-details"></i><span>Rekap Absensi</span></a>
                </li>
                </li>
                <li>
                    <li><a><span class="text-info panel-title">CUTI & IZIN</span></a></li>
                    <li><a href="/permintaan_cuti"><i class="fa fa-server"></i><span>Data Cuti & Izin</span></a></li>
                    <li><a href="/kategori_cuti"><i class="mdi mdi-calendar"></i><span>Kategori Cuti & Izin</span></a></li>
                    <li><a href="/settingalokasi"><i class="fa fa-gears"></i><span>Setting Alokasi</span></a></li>
                    <li><a href="/alokasicuti"><i class="mdi mdi-chart-arc mdi-2x"></i><span>Alokasi Cuti</span></a></li>
                </li>
            </ul>
        </div>

    <?php } elseif ($role == 2) { ?>

        <div class="user-info">
            <div class="dropdown">
                <br>
                <a class="text-info panel-title">{{ $user }}</a>
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
                    <li><a><span class="text-info panel-title">DATA MANAGER</span></a></li>
                    <li><a href="/absensi-karyawan" class="waves-effect"><i class="mdi mdi-account-check"></i><span>Absensi</span></a></li>
                    <li><a href="/history-absensi" class="waves-effect"><i class="mdi mdi-clipboard-check"></i><span>History Absensi</span></a></li>
                    <li><a href="/cuti-karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Ajukan Cuti & Izin</span></a></li>
                </li>
                <li>
                    <li><a><span class="text-info panel-title">DATA STAFF</span></a></li>
                    <li><a href="/data-staff" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span>Data Staff</span></a></li>     
                    <li><a href="/absensi-staff" class="waves-effect"><i class="ion-compose"></i><span>Absensi Staff</span></a></li>                         
                    <li><a href="#" class="waves-effect"><i class="fa fa-server"></i><span>Data Cuti Staff</span></a></li>               
                </li>
            </ul>
        </div>

    <?php } elseif ($role == 3) { ?>

        <div class="user-info">
            <div class="dropdown">
                <br>
                <a class="text-info panel-title">{{ $user }}</a>
            </div>
        </div>

        <!--- Role Manager Konvensional -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="karyawandashboard" class="waves-effect">
                        <i class="ti-home"></i><span> Dashboard Manager Konvensional</span>
                    </a>
                </li>
                <li>
                    <li><a><span class="text-info panel-title">DATA MANAGER</span></a></li>
                    <li><a href="/absensi-karyawan" class="waves-effect"><i class="mdi mdi-account-check"></i><span>Absensi</span></a></li>
                    <li><a href="/history-absensi" class="waves-effect"><i class="mdi mdi-clipboard-check"></i><span>History Absensi</span></a></li>
                    <li><a href="/cuti-karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Ajukan Cuti & Izin</span></a></li>
                </li>
                <li>
                    <li><a><span class="text-info panel-title">DATA STAFF</span></a></li>
                    <li><a href="/data-staff" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span>Data Staff</span></a></li>     
                    <li><a href="/absensi-staff" class="waves-effect"><i class="ion-compose"></i><span>Absensi Staff</span></a></li>                         
                    <li><a href="#" class="waves-effect"><i class="fa fa-server"></i><span>Data Cuti Staff</span></a></li>               
                </li>
            </ul>
        </div>

    <?php } elseif ($role == 4) { ?>

        <div class="user-info">
            <div class="dropdown">
                <br>
                <a class="text-info panel-title">{{ $user }}</a>
            </div>
        </div>

        <!--- Role Manager Keuangan -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="karyawandashboard" class="waves-effect">
                        <i class="ti-home"></i><span> Dashboard Manager Keuangan</span>
                    </a>
                </li>
                <li>
                    <li><a><span class="text-info panel-title">DATA MANAGER</span></a></li>
                    <li><a href="/absensi-karyawan" class="waves-effect"><i class="mdi mdi-account-check"></i><span>Absensi</span></a></li>
                    <li><a href="/history-absensi" class="waves-effect"><i class="mdi mdi-clipboard-check"></i><span>History Absensi</span></a></li>
                    <li><a href="/cuti-karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Ajukan Cuti & Izin</span></a></li>
                </li>
                <li>
                    <li><a><span class="text-info panel-title">DATA STAFF</span></a></li>
                    <li><a href="/data-staff" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span>Data Staff</span></a></li>     
                    <li><a href="/absensi-staff" class="waves-effect"><i class="ion-compose"></i><span>Absensi Staff</span></a></li>                         
                    <li><a href="#" class="waves-effect"><i class="fa fa-server"></i><span>Data Cuti Staff</span></a></li>               
                </li>
            </ul>
        </div>

    <?php } elseif ($role == 5) { ?>

        <div class="user-info">
            <div class="dropdown">
                <br>
                <a class="text-info panel-title">{{ $user }}</a>
            </div>
        </div>

        <!--- Role Manager Teknologi Informasi -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="karyawandashboard" class="waves-effect">
                        <i class="ti-home"></i><span> Dashboard Manager TI</span>
                    </a>
                </li>
                <li>
                    <li><a><span class="text-info panel-title">DATA MANAGER</span></a></li>
                    <li><a href="/absensi-karyawan" class="waves-effect"><i class="mdi mdi-account-check"></i><span>Absensi</span></a></li>
                    <li><a href="/history-absensi" class="waves-effect"><i class="mdi mdi-clipboard-check"></i><span>History Absensi</span></a></li>
                    <li><a href="/cuti-karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Ajukan Cuti & Izin</span></a></li>
                </li>
                <li>
                    <li><a><span class="text-info panel-title">DATA STAFF</span></a></li>
                    <li><a href="/data-staff" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span>Data Staff</span></a></li>     
                    <li><a href="/absensi-staff" class="waves-effect"><i class="ion-compose"></i><span>Absensi Staff</span></a></li>                         
                    <li><a href="#" class="waves-effect"><i class="fa fa-server"></i><span>Data Cuti Staff</span></a></li>               
                </li>
            </ul>
        </div>

    <?php } else { ?>

        <div class="user-info">
            <div class="dropdown">
                <br>
                <a class="text-info panel-title">{{ $user }}</a>
            </div>
        </div>

        <!--- Role Manager Human Resources -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="karyawandashboard" class="waves-effect">
                        <i class="ti-home"></i><span> Dashboard Manager Human Resources </span>
                    </a>
                </li>
                <li>
                    <li><a><span class="text-info panel-title">DATA MANAGER</span></a></li>
                    <li><a href="/absensi-karyawan" class="waves-effect"><i class="mdi mdi-account-check"></i><span>Absensi</span></a></li>
                    <li><a href="/history-absensi" class="waves-effect"><i class="mdi mdi-clipboard-check"></i><span>History Absensi</span></a></li>
                    <li><a href="/cuti-karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Ajukan Cuti & Izin</span></a></li>
                </li>
                <li>
                    <li><a><span class="text-info panel-title">DATA STAFF</span></a></li>
                    <li><a href="/data-staff" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span>Data Staff</span></a></li>     
                    <li><a href="/absensi-staff" class="waves-effect"><i class="ion-compose"></i><span>Absensi Staff</span></a></li>                         
                    <li><a href="#" class="waves-effect"><i class="fa fa-server"></i><span>Data Cuti Staff</span></a></li>               
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