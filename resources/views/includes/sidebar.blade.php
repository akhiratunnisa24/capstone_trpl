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
                    <a href="/" class="waves-effect"><i class="ti-home"></i><span> Dashboard HRD </span></a>
                </li>
                <li>
                    <a href="/absensi_karyawan" class="waves-effect"><i
                            class="mdi mdi-clipboard-check"></i><span>Absensi HRD</span></a>
                </li>
                <li>
                    <a href="{{ route('karyawan.index') }}" class="waves-effect"><i
                            class="mdi mdi-account-multiple"></i><span>Data Karyawan</span></a>
                </li>
                {{-- <li>
                        <a href="/absensi_karyawan" class="waves-effect"><i class="mdi mdi-clipboard-check"></i><span>Absensi</span></a>
                    </li>
                    <li>
                        <a href="/cuti_karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Cuti & Izin</span></a>
                    </li> --}}

                <li class="has_sub">
                    <a id="menuAbsensi" class="waves-effect"><i class="ti-menu-alt"></i><span>Data Absensi</span><span
                            class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="/absensi"><i class="mdi mdi-account-check"></i><span>Absensi karyawan</span></a>
                        </li>
                        <li><a href="/rekapabsensi"><i class="mdi mdi-account-card-details"></i><span>Rekap
                                    Absensi</span></a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a id="menuCuti" class="waves-effect"><i class="mdi mdi-walk"></i> <span>Cuti & Izin</span><span
                            class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="/permintaan_cuti"><i class="mdi mdi-calendar-check"></i><span>Data Cuti &
                                    Izin</span></a></li>
                        <li><a href="/kategori_cuti"><i class="mdi mdi-calendar"></i><span>Kategori Cuti &
                                    Izin</span></a></li>
                    </ul>
                </li>
            </ul> 
        </div>
        


        <?php
                    
                } else { ?>
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
                    <a href="karyawandashboard" class="waves-effect"><i class="ti-home"></i><span> Dashboard Karyawan
                        </span></a>
                </li>
                <li>
                    <a href="/absensi_karyawan" class="waves-effect"><i
                            class="mdi mdi-clipboard-check"></i><span>Absensi</span></a>
                </li>
                <li>
                    <a href="showkaryawan{{ $id }}" class="waves-effect"><i
                            class="mdi mdi-account-multiple"></i><span>Profile Karyawan</span></a>
                </li>
                <li>
                    <a href="/cuti_karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Cuti &
                            Izin</span></a>
                </li>
                <?php
                    } ?>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->
