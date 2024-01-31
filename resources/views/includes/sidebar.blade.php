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
            $row = Karyawan::where('id', Auth::user()->id_pegawai)
                ->select('jabatan')
                ->first();

            ?>

            <div class="user-info">
                <div class="dropdown">
                    <br>
                    <a class="text-info panel-title">{{ $user }}</a>
                </div>
            </div>
        </div>

        {{-- Role HRD Manager --}}
        @if ((Auth::check() && Auth::user()->role == 1) || (Auth::check() && Auth::user()->role == 2) || (Auth::check() && Auth::user()->role == 6))
            <div id="sidebar-menu">
                <ul>
                    <li><a href="/" class="waves-effect"><i class="ti-home"></i><span
                                class="text-info panel-title">Dashboard</span></a></li>
                    <li><a href="/kalender" class="waves-effect"><i class="fa fa-calendar"></i><span
                                class="text-info panel-title">Kalender</span></a></li>

                                <li class="has_sub">
                                    <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-database"></i><span
                                            class="text-info panel-title">DATA POKOK</span><span class="pull-right"><i
                                                class="mdi mdi-plus"></i></span></a>
                                    <ul class="list-unstyled">
                                        @if(Auth::check() && Auth::user()->role !== 6)
                                            <li><a href="/divisi"><i class="fa fa-sitemap"></i><span></span>Divisi</a></li>
                                            <li><a href="/level-jabatan"><i class="fa fa-briefcase"></i><span></span>Level Jabatan</a>
                                            </li>
                                            <li><a href="/jabatan"><i class="fa fa-briefcase"></i><span></span>Jabatan</a></li>
                                            <li><a href="/atasan"><i class="mdi mdi-account-star-variant"></i><span></span>Atasan</a>
                                            </li>
                                            <li><a href="/informasi"><i
                                                        class="fa fa-exclamation-circle"></i><span></span>Informasi</a></li>
                                            <li><a href="/user_mesin"><i class="fa fa-user"></i><span></span>User Mesin</a></li>
                                            <li class="has_sub">
                                                <a href="#"><i class="mdi mdi-calendar-clock"></i><span></span>Jadwal
                                                    Karyawan<span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                                <ul class="list-unstyled">
                                                    <li><a href="/shift"><i class="mdi mdi-calendar"></i><span></span>Shift</a></li>
                                                    <li><a href="jadwal"><i
                                                                class="mdi mdi-calendar-multiple-check"></i><span></span>Jadwal</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                        @if(Auth::check() && Auth::user()->role === 1 || Auth::check() && Auth::user()->role === 6)
                                            <li class="has_sub">
                                                <a href="#"><i class="fa fa-money"></i><span></span>Master Penggajian<span
                                                        class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                                <ul class="list-unstyled">
                                                    {{-- <li><a href="/kategori-salary"><i
                                                                class="fa fa-reorder (alias)"></i><span></span>Kategori Salary</a></li> --}}
                                                    <li><a href="/struktur-penggajian"><i class="mdi mdi-clipboard-text"></i><span></span>Struktur Penggajian</a></li>
                                                </ul>
                                            </li>
                                        @endif
                                        @if(Auth::check() && Auth::user()->role !== 6)
                                            <li><a href="/manajemen-harilibur"><i class="ti-calendar"></i><span>Manajemen
                                                        Libur</span></a></li>
                                        @endif
                                        {{-- <li><a href="settingrole"><i class="fa fa-sign-in"></i><span></span>Role</a></li> --}}
                                        {{-- <li><a href="#"><i class="fa fa-institution (alias)"></i><span></span>Setting
                                                Organisasi</a></li> --}}
                                        {{-- <li><a href="settinguser" class="waves-effect"><i class="mdi mdi-account-settings-variant"></i><span> Managemen User</span></a></li>      --}}
                                        {{-- <li><a href="settinguser" class="waves-effect"><i class="mdi mdi-account-settings-variant"></i><span
                                           >Managemen User</span></a></li> --}}
                                    </ul>
                                </li>                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-circle"></i><span
                                class="text-info panel-title">Informasi Pribadi</span><span class="pull-right"><i
                                    class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            {{-- <li><a href="/absensi-karyawan"><i class="mdi mdi-account-check"></i><span>Absensi</span></a>
                            </li> --}}
                            <li><a href="/riwayat-absensi"><i class="fa fa-history"></i><span>Riwayat
                                        Absensi</span></a></li>
                            <li><a href="/alokasi-cuti"><i class="mdi mdi-walk"></i><span>Alokasi Cuti</span></a> </li>
                            <li><a href="/cuti-karyawan"><i class="mdi mdi-walk"></i><span>Ajukan Cuti &
                                        Izin</span></a>
                            <li><a href="/resign-karyawan"><i class="mdi mdi-account-off"></i><span>Ajukan
                                        Resign</span></a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="{{ route('karyawan.index') }}" class="waves-effect"><i
                                    class="mdi mdi-account-multiple-plus"></i><span class="text-info panel-title">Data
                                    Karyawan</span>
                            </a>
                        </li>
                    @if(Auth::check() && Auth::user()->role !== 6)
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book"></i><span
                                    class="text-info panel-title">Absensi Karyawan</span><span class="pull-right"><i
                                        class="mdi mdi-plus"></i></span></a>
                            <ul class="list-unstyled">
                                {{-- <li><a href=""><i class=" mdi mdi-account-card-details"></i><span>Manajemen Absensi</span></a></li> --}}
                                <li><a href="/absensi"><i class="ion-compose"></i><span>Data Absensi</span></a></li>
                                <li><a href="/absensi-tidak-masuk"><i class="mdi mdi-calendar-remove"></i><span>Data Tidak
                                            Masuk</span></a></li>
                                <li><a href="/setting-absensi"><i class="fa fa-gear (alias)"></i><span>Setting
                                            Absensi</span></a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-walk"></i><span
                                    class="text-info panel-title">Cuti & Sakit/Izin</span><span class="pull-right"><i
                                        class="mdi mdi-plus"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="/permintaan_cuti"><i class="fa fa-server"></i><span>Data Cuti & Izin</span></a>
                                </li>
                                <li><a href="/kategori_cuti"><i class="mdi mdi-calendar"></i><span>Kategori Cuti &
                                            Izin</span></a></li>
                                <li><a href="/settingalokasi"><i class="fa fa-gears"></i><span>Setting Alokasi</span></a>
                                </li>
                                <li><a href="/alokasicuti"><i class="mdi mdi-chart-arc"></i><span>Master Alokasi
                                            Cuti</span></a>
                                </li>
                                {{-- <li><a href="/settingcuti"><i class="fa fa-gear (alias)"></i><span>Setting Cuti
                                            Tahunan</span></a>
                                </li>
                                <li><a href="/sisacuti"><i class="fa fa-hourglass-2"></i><span>Sisa Cuti</span></a></li> --}}
                            </ul>
                        </li>
                    @endif

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
                    @if(Auth::check() && Auth::user()->role !== 6)
                        <li><a href="/data_rekrutmen" class="waves-effect"><i class="fa fa-user-plus"></i><span
                                    class="text-info panel-title">Rekruitmen</span></a></li>
                    @endif
                    @if(Auth::check() && Auth::user()->role === 1 || Auth::check() && Auth::user()->role === 6)
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="fa fa-user-md"></i><span
                                    class="text-info panel-title">Benefit</span><span class="pull-right"><i
                                        class="mdi mdi-plus"></i></span></a>
                            <ul class="list-unstyled">
                                <li class="has_sub">
                                    <a href="#"><i class="mdi mdi-stethoscope"></i><span>Benefit </span><span
                                            class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                    <ul class="list-unstyled">
                                        <li><a href="/kategori-benefit"><i class="fa fa-reorder (alias)"></i><span>Kategori
                                                    Benefit</span></a></li>
                                        <li><a href="/benefit"><i class="mdi mdi-clipboard-text"></i><span></span>Data
                                                Benefit</a></li>
                                        {{-- <li><a href="/benefit-karyawan"><i
                                                    class="mdi mdi-account-star-variant"></i><span></span>Benefit
                                                Karyawan</a></li> --}}
                                    </ul>
                                </li>
                                <li><a href="#"><i class="mdi mdi-cash-usd"></i><span></span>Kompensasi</a></li>
                            </ul>
                        </li>
                        @if(Auth::check() && Auth::user()->role === 1 || Auth::check() && Auth::user()->role === 6)
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i
                                        class="fa fa-usd"></i><span
                                        class="text-info panel-title">Penggajian</span><span class="pull-right"><i
                                            class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                    <li class="has_sub">
                                        <a href="#"><i class="fa fa-money"></i><span>Slip Gaji </span><span
                                                class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                        <ul class="list-unstyled">
                                            <li><a href="/slipgaji-karyawan"><i class="mdi mdi-account-settings"></i><span>Karyawan</span></a></li>
                                            <li><a href="/slipgaji-karyawan-grup"><i class="mdi mdi-account-multiple"></i><span></span>Grup</a></li>

                                        </ul>
                                    </li>
                                    <li class="has_sub">
                                        <a href="#"><i class="fa fa-cogs"></i><span>Konfigurasi</span><span
                                                class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                        <ul class="list-unstyled">
                                            <li><a href="/rekap-kehadiran"><i class="fa fa-user"></i><span>Kehadiran</span></a></li>
                                            {{-- <li><a href=""><i class="mdi mdi-account-multiple"></i><span></span>Grup</a></li> --}}
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @endif
                    @if(Auth::check() && Auth::user()->role !== 6)
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-off"></i><span
                                    class="text-info panel-title">Data Resign</span><span class="pull-right"><i
                                        class="mdi mdi-plus"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="/resign_admin"><i class="fa fa-server"></i><span>Resign Karyawan</span></a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if(Auth::check() && Auth::user()->role !== 6)
                        {{-- <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-server"></i><span
                                    class="text-info panel-title">Data Pokok KPI</span><span class="pull-right"><i
                                        class="mdi mdi-plus"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="/masterkpi"><i class="fa fa-tasks"></i><span></span>Master KPI</a></li>
                                <li><a href="/indikator-kpi" class="waves-effect"><i
                                            class="fa fa-book"></i><span>Indikator</span></a></li>
                                <li><a href="#"><i class="fa fa-file-text"></i><span></span>Penilaian</a></li>
                            </ul>
                        </li> --}}

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-gears"></i><span
                                    class="text-info panel-title">Pengaturan</span><span class="pull-right"><i
                                        class="mdi mdi-plus"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="/setting-organisasi"><i
                                            class="fa fa-institution (alias)"></i><span></span>Organisasi</a></li>
                                <li><a href="settinguser" class="waves-effect"><i class="mdi mdi-account-settings-variant"></i><span
                                                class="text-info panel-title">User</span></a></li>
                               <!-- <li><a href="/setting-kalender"><i class="ti-calendar"></i><span>Manajemen Libur</span></a></li> -->
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        @endif

        <!--- Role HRD Staff dan Role Karyawan  -->
        {{-- @if (Auth::check() && (Auth::user()->role == 2 || Auth::user()->role == 4)) --}}
        @if (Auth::check() && Auth::user()->role == 4)
            <div id="sidebar-menu">
                <ul>
                    <li><a href="/" class="waves-effect"><i class="ti-home"></i><span
                                class="text-info panel-title">Dashboard</span></a></li>
                    <li><a href="kalender"><i class="fa fa-calendar"></i><span>Kalender</span></a></li>
                    {{-- <li><a href="/absensi-karyawan" class="waves-effect"><i class="mdi mdi-account-check"></i><span>Absensi</span></a></li> --}}
                    <li><a href="/riwayat-absensi" class="waves-effect"><i class="fa fa-history"></i><span>Riwayat
                                Absensi</span></a></li>
                    <li><a href="/cuti-karyawan" class="waves-effect"><i class="mdi mdi-airplane"></i><span>Ajukan Cuti & Izin</span></a></li>
                    <li><a href="/resign-karyawan" class="waves-effect"><i
                                class="mdi mdi-account-off"></i><span>Ajukan Resign</span></a>
                </ul>
            </div>
        @endif

        <!--- Role Manager / Asistant Manager / yang mempunyai bawahan  -->
        @if (Auth::check() && (Auth::user()->role == 3 || Auth::user()->role == 7))
            <div id="sidebar-menu">
                <ul>
                    <li><a href="/karyawandashboard" class="waves-effect"><i class="ti-home"></i><span
                                class="text-info panel-title">Dashboard</span></a></li>
                    <li><a href="kalender" class="waves-effect"><i class="fa fa-calendar"></i><span
                                class="text-info panel-title">Kalender</span></a></li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i
                                class="mdi mdi-book-open-page-variant"></i><span
                                class="text-info panel-title">Informasi
                                Pribadi</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <!-- <li><a href="/absensi-karyawan" class="waves-effect"><i class="mdi mdi-account-check"></i><span>Absensi</span></a></li> -->
                            <li><a href="/riwayat-absensi" class="waves-effect"><i
                                        class="fa fa-history"></i><span>Riwayat Absensi</span></a>
                            </li>
                            <li><a href="/cuti-karyawan" class="waves-effect"><i
                                        class="mdi mdi-walk"></i><span>Permohonan Cuti & Izin</span></a></li>
                            <li><a href="/resign-karyawan"><i class="mdi mdi-account-off"></i><span>Ajukan
                                        Resign</span></a>
                        </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book"></i><span
                                class="text-info panel-title">Data Staff</span><span class="pull-right"><i
                                    class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li> <a href="/data-staff" class="waves-effect"><i
                                        class="mdi mdi-account-multiple-plus"></i><span>Data Staff</span></a>
                            </li>
                            @if ($row->jabatan == 'Manager' || $row->jabatan == 'Asistant Manager')
                                <li><a href="/absensi-staff" class="waves-effect"><i
                                            class="ion-compose"></i><span>Absensi</span></a></li>
                                <li><a href="/cuti-staff" class="waves-effect"><i class="fa fa-server"></i><span>Data
                                            Cuti</span></a></li>
                            @elseif($row->jabatan == 'Direksi')
                                <li><a href="/cutistaff" class="waves-effect"><i class="fa fa-server"></i><span>Data
                                            Cuti</span></a></li>
                            @else
                            @endif
                            <li><a href="/resign_manager" class="waves-effect"><i
                                        class="mdi mdi-account-off"></i><span>Data Resign</span></a></li>
                        </ul>
                    </li>
                    @if (Auth::user()->role == 7)
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i
                                class="mdi mdi-account-circle"></i><span class="text-info panel-title">Master
                                Aplikasi</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/partner"><i class="mdi mdi-walk"></i><span>Partner</span></a> </li>
                            <li><a href="/list-mesin"><i class="mdi mdi-walk"></i><span>List Mesin</span></a> </li>
                            <li><a href="/user_mesin"><i class="fa fa-user"></i><span>User Mesin</span></a></li>
                            <li><a href="/shift"><i class="fa fa-calendar-check-o"></i><span></span>Shift</a></li>
                            <li><a href="/jadwal"><i class="fa fa-calendar-check-o"></i><span></span>Jadwal</a></li>
                            <li><a href="/divisi"><i class="fa fa-sitemap"></i><span></span>Divisi</a></li>
                            <li><a href="settinguser" class="waves-effect"><i
                                        class="mdi mdi-account-settings-variant"></i><span>Managemen User</span></a>
                            </li>
                            <li><a href="settingrole" class="waves-effect"><i
                                        class="mdi mdi-account-settings-variant"></i><span>Setting Role
                                        Login</span></a></li>
                            <li><a href="/settingorganisasi"><i
                                        class="fa fa-institution (alias)"></i><span></span>Setting Organisasi</a></li>
                            <li><a href="/setting-kalender"><i class="ti-calendar"></i><span>Manajemen
                                        Libur</span></a></li>
                        </ul>
                    </li>
                    @endif
                    {{-- <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-clipboard-text"></i><span class="text-info panel-title">Tugas</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/tim"><i class="ion-person-stalker"></i><span>Master Tim</span></a></li>
                            <li><a href="/tim-karyawan"><i class="fa fa-group (alias)"></i><span>Data Tim</span></a></li>
                            <li><a href="/tugas-karyawan"><i class="fa fa-list"></i><span>Data Tugas</span></a></li>
                        </ul>
                    </li> --}}
                </ul>
            </div>
        @endif

        <!--- Role Admin -->
        @if (Auth::check() && Auth::user()->role == 5)
            <div id="sidebar-menu">
                <ul>
                    <li>
                        <a href="#" class="waves-effect"><i class="ti-home"></i><span>Dashboard</span></a>
                        <a href="{{ route('karyawan.index') }}" class="waves-effect"><i
                            class="mdi mdi-account-multiple-plus"></i><span class="text-info panel-title">Data Karyawan</span></a>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i
                                class="mdi mdi-account-circle"></i><span class="text-info panel-title">Master Aplikasi</span>
                                <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/partner"><i class="mdi mdi-walk"></i><span>Partner</span></a> </li>
                            <li><a href="/bank"><i class="mdi mdi-walk"></i><span>Bank</span></a> </li>
                            <li><a href="/list-mesin"><i class="mdi mdi-walk"></i><span>List Mesin</span></a> </li>
                            <li><a href="/user_mesin"><i class="fa fa-user"></i><span>User Mesin</span></a></li>
                            <li><a href="/shift"><i class="fa fa-calendar-check-o"></i><span></span>Shift</a></li>
                            <li><a href="/jadwal"><i class="fa fa-calendar-check-o"></i><span></span>Jadwal</a></li>
                            <li><a href="/divisi"><i class="fa fa-sitemap"></i><span></span>Divisi</a></li>
                            <li><a href="settinguser" class="waves-effect"><i class="mdi mdi-account-settings-variant"></i><span>Managemen User</span></a></li>
                            <li><a href="settingrole" class="waves-effect"><i class="mdi mdi-account-settings-variant"></i><span>Setting Role Login</span></a></li>
                            <li><a href="/settingorganisasi"><i class="fa fa-institution (alias)"></i><span></span>Setting Organisasi</a></li>
                            <li><a href="/setting-kalender"><i class="ti-calendar"></i><span>Manajemen Libur</span></a></li>
                        </ul>
                    </li>
                    </li>
                </ul>
            </div>
        @endif

        <!--- Role Staff Keuangan  -->
        {{-- @if (Auth::check() && (Auth::user()->role == 6))
            <div id="sidebar-menu">
                <ul>
                    <li><a href="/karyawandashboard" class="waves-effect"><i class="ti-home"></i><span
                                class="text-info panel-title">Dashboard</span></a></li>
                    <li><a href="kalender" class="waves-effect"><i class="fa fa-calendar"></i><span
                                class="text-info panel-title">Kalender</span></a></li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book-open-page-variant"></i><span
                            class="text-info panel-title">Informasi Pribadi</span><span class="pull-right"><i class="mdi mdi-plus"></i></span>
                        </a>
                        <ul class="list-unstyled">
                            <li><a href="/riwayat-absensi" class="waves-effect"><i class="fa fa-history"></i><span>Riwayat Absensi</span></a></li>
                            <li><a href="/cuti-karyawan" class="waves-effect"><i  class="mdi mdi-walk"></i><span>Permohonan Cuti & Sakit/Izin</span></a></li>
                            <li><a href="/resign-karyawan"><i class="mdi mdi-account-off"></i><span>Ajukan Resign</span></a>
                        </ul>
                    </li>
                    <li><a href="{{ route('karyawan.index') }}" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span class="text-info panel-title">Data Karyawan</span></a></li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book"></i><span class="text-info panel-title">DATA POKOK</span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                        <ul class="list-unstyled">

                        </ul>
                    </li>

                </ul>
            </div>
        @endif --}}


        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
<div class="content-page">
