<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <div class="user-details">
            <div class="text-center">
            </div>

            <?php
            
            use Illuminate\Support\Facades\Auth;
            use App\Models\Karyawan;
            
            $id = Auth::user()->id_pegawai;
            $user = Auth::user()->name;
            $role = Auth::user()->role;
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->select('jabatan')->first();
            
            ?>

            <div class="user-info">
                <div class="dropdown">
                    <br>
                    <a class="text-info panel-title">{{ $user }}</a>
                </div>
            </div>
        </div>

        {{-- Role HRD Manajer --}}
        @if (Auth::check() && Auth::user()->role == 1 || Auth::check() && Auth::user()->role == 2)
            <div id="sidebar-menu">
                <ul>
                    <li><a href="/" class="waves-effect"><i class="ti-home"></i><span class="text-info panel-title">Dashboard</span></a></li>
                    <li><a href="/kalender" class="waves-effect"><i class="fa fa-calendar"></i><span class="text-info panel-title">Kalender</span></a></li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-circle"></i><span
                                class="text-info panel-title">Informasi Pribadi</span><span class="pull-right"><i
                                    class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/absensi-karyawan"><i class="mdi mdi-account-check"></i><span>Absensi</span></a>
                            </li>
                            <li><a href="/history-absensi"><i class="fa fa-history"></i><span>History
                                        Absensi</span></a></li>
                            <li><a href="/alokasi-cuti"><i class="mdi mdi-walk"></i><span>Alokasi Cuti</span></a> </li>
                            <li><a href="/cuti-karyawan"><i class="mdi mdi-walk"></i><span>Ajukan Cuti & Izin</span></a>
                            <li><a href="/resign-karyawan"><i class="mdi mdi-account-off"></i><span>Ajukan Resign</span></a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="{{ route('karyawan.index') }}" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span class="text-info panel-title">Data Karyawan</span></a></li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book"></i><span class="text-info panel-title">Absensi Karyawan</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/absensi"><i class="ion-compose"></i><span>Data Absensi</span></a></li>
                            <li><a href="/absensi-tidak-masuk"><i class="mdi mdi-calendar-remove"></i><span>Data Tidak Masuk</span></a></li>
                            <li><a href="/setting-absensi"><i class="fa fa-gear (alias)"></i><span>Setting Absensi</span></a></li>
                        </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-walk"></i><span
                                class="text-info panel-title">Cuti & Izin</span><span class="pull-right"><i
                                    class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/permintaan_cuti"><i class="fa fa-server"></i><span>Transaksi Cuti & Izin</span></a>
                            </li>
                            <li><a href="/kategori_cuti"><i class="mdi mdi-calendar"></i><span>Kategori Cuti &
                                        Izin</span></a></li>
                            <li><a href="/settingalokasi"><i class="fa fa-gears"></i><span>Setting Alokasi</span></a>
                            </li>
                            <li><a href="/alokasicuti"><i class="mdi mdi-chart-arc"></i><span>Master Alokasi Cuti</span></a>
                            </li>
                            <li><a href="/settingcuti"><i class="fa fa-gear (alias)"></i><span>Setting Cuti Tahunan</span></a>
                            </li>
                            <li><a href="/sisacuti"><i class="fa fa-hourglass-2"></i><span>Sisa Cuti</span></a></li>
                        </ul>
                    </li>

                    {{-- Jangan di hapus ! --}}
                    {{-- <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-briefcase-check"></i><span
                                class="text-info panel-title">Rekruitmen</span><span class="pull-right"><i
                                    class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/data_rekrutmen"><i class="fa fa-check-square"></i><span>Rekruitmen</span></a>
                            </li>
                            <li><a href="/metode_rekrutmen"><i class="fa fa-sitemap"></i><span>Tahapan Rekruitmen</span></a></li>
                        </ul>
                    </li> --}}

                    <li><a href="/data_rekrutmen" class="waves-effect"><i class="fa fa-user-plus"></i><span
                                class="text-info panel-title">Rekruitmen</span></a></li>
                    <li><a href="settinguser" class="waves-effect"><i class="mdi mdi-account-settings-variant"></i><span
                                class="text-info panel-title">Managemen User</span></a></li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-off"></i><span
                                class="text-info panel-title">Data Resign</span><span class="pull-right"><i
                                    class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="/resign_admin"><i class="fa fa-server"></i><span>Resign Karyawan</span></a>
                                    </li>
                                </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-database"></i><span
                                class="text-info panel-title">Data Master</span><span class="pull-right"><i
                                    class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/departemen"><i class="fa fa-sitemap"></i><span></span>Departemen</a></li>
                            <li><a href="/level-jabatan"><i class="fa fa-briefcase"></i><span></span>Level Jabatan</a></li>
                            <li><a href="/jabatan"><i class="fa fa-briefcase"></i><span></span>Jabatan</a></li>  
                            <li><a href="/shift"><i class="fa fa-calendar-check-o"></i><span></span>Shift</a></li>
                            <li><a href="jadwal"><i class="fa fa-calendar-check-o"></i><span></span>Jadwal</a></li>
                            <li><a href="/metode_rekrutmen"><i class="fa fa-user-plus"></i><span></span>Rekruitmen</a></li>
                            {{-- <li><a href="settingrole"><i class="fa fa-sign-in"></i><span></span>Role</a></li> --}}
                            {{-- <li><a href="#"><i class="fa fa-institution (alias)"></i><span></span>Setting
                                    Organisasi</a></li> --}}
                            {{-- <li><a href="settinguser" class="waves-effect"><i class="mdi mdi-account-settings-variant"></i><span> Managemen User</span></a></li>      --}}
                            {{-- <li><a href="settinguser" class="waves-effect"><i class="mdi mdi-account-settings-variant"></i><span
                               >Managemen User</span></a></li> --}}
                        </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-server"></i><span
                                class="text-info panel-title">Data Master KPI</span><span class="pull-right"><i
                                    class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/masterkpi"><i class="fa fa-tasks"></i><span></span>Master KPI</a></li>
                            <li><a href="/indikator-kpi" class="waves-effect"><i
                                        class="fa fa-book"></i><span>Indikator</span></a></li>
                            <li><a href="#"><i class="fa fa-file-text"></i><span></span>Penilaian</a></li>
                        </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-gears"></i><span
                                class="text-info panel-title">Setting Aplikasi</span><span class="pull-right"><i
                                    class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            {{-- <li><a href="settingrole"><i class="fa fa-sign-in"></i><span></span>Setting Role</a></li> --}}
                            {{-- <li><a href="settinguser"><i class="fa fa-group (alias)"></i><span></span>Managemen
                                    User</a></li> --}}
                            <li><a href="/setting-organisasi"><i class="fa fa-institution (alias)"></i><span></span>Setting Organisasi</a></li>
                            <li><a href="/setting-kalender"><i class="ti-calendar"></i><span>SettingKalender</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        @endif

        <!--- Role HRD Staff dan Role Karyawan  -->
        {{-- @if (Auth::check() && (Auth::user()->role == 2 || Auth::user()->role == 4)) --}}
        @if (Auth::check() && Auth::user()->role == 4)
            <div id="sidebar-menu">
                <ul>
                    <li><a href="/karyawandashboard" class="waves-effect"><i class="ti-home"></i><span class="text-info panel-title">Dashboard</span></a></li>
                    <li><a href="kalender"><i class="fa fa-calendar"></i><span>Kalender</span></a></li>
                    <li><a href="/absensi-karyawan" class="waves-effect"><i class="mdi mdi-account-check"></i><span>Absensi</span></a></li>
                    <li><a href="/history-absensi" class="waves-effect"><i class="fa fa-history"></i><span>History Absensi</span></a></li>
                    <li><a href="/cuti-karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Ajukan Cuti & Izin</span></a></li>
                    <li><a href="/resign-karyawan" class="waves-effect"><i class="mdi mdi-account-off"></i><span>Ajukan Resign</span></a>
                </ul>
            </div>
        @endif

        <!--- Role Manajer / Asisten Manajer / yang mempunyai bawahan  -->
        @if (Auth::check() && Auth::user()->role == 3)
            <div id="sidebar-menu">
                <ul>
                    <li><a href="/karyawandashboard" class="waves-effect"><i class="ti-home"></i><span
                        class="text-info panel-title">Dashboard</span></a></li>
                    <li><a href="kalender"  class="waves-effect"><i class="fa fa-calendar"></i><span
                        class="text-info panel-title">Kalender</span></a></li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i
                                class="mdi mdi-book-open-page-variant"></i><span
                                class="text-info panel-title">Informasi
                                Pribadi</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/absensi-karyawan" class="waves-effect"><i class="mdi mdi-account-check"></i><span>Absensi</span></a></li>
                            <li><a href="/history-absensi" class="waves-effect"><i class="fa fa-history"></i><span>History Absensi</span></a>
                            </li>
                            <li><a href="/cuti-karyawan" class="waves-effect"><i class="mdi mdi-walk"></i><span>Ajukan Cuti & Izin</span></a></li>
                            <li><a href="/resign-karyawan"><i class="mdi mdi-account-off"></i><span>Ajukan Resign</span></a>
                        </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book"></i><span
                                class="text-info panel-title">Data Staff</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li> <a href="/data-staff" class="waves-effect"><i
                                        class="mdi mdi-account-multiple-plus"></i><span>Data Staff</span></a>
                            </li>
                            @if($row->jabatan == "Manajer" || $row->jabatan == "Asisten Manajer")
                                <li><a href="/absensi-staff" class="waves-effect"><i class="ion-compose"></i><span>Absensi</span></a></li>
                                <li><a href="/cuti-staff" class="waves-effect"><i class="fa fa-server"></i><span>Transaksi Cuti</span></a></li>
                            @elseif($row->jabatan == "Direksi")
                                <li><a href="/cutistaff" class="waves-effect"><i class="fa fa-server"></i><span>Transaksi Cuti</span></a></li>
                            @else
                            @endif
                            <li><a href="/resign_manager" class="waves-effect"><i
                                        class="mdi mdi-account-off"></i><span>Data Resign</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        @endif


        <!--- Role Admin -->
        @if (Auth::check() && Auth::user()->role == 5)
            <div id="sidebar-menu">
                <ul>
                    <li>
                        <a href="#" class="waves-effect"><i class="ti-home"></i><span>Dashboard</span></a>
                        <a href="settinguser" class="waves-effect"><i class="mdi mdi-account-settings-variant"></i><span>Managemen User</span></a>
                        <a href="settingrole" class="waves-effect"><i class="mdi mdi-account-settings-variant"></i><span>Setting Role Login</span></a>
                        <a href="/setting-organisasi"><i class="fa fa-institution (alias)"></i><span></span>Setting Organisasi</a>
                        <a href="/setting-kalender"><i class="ti-calendar"></i><span>Setting Kalender</span></a>
                    </li>
                </ul>
            </div>
        @endif

        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
<div class="content-page">




