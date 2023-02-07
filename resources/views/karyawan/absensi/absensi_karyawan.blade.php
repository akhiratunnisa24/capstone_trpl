@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Absensi karyawan</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Human Resources Management System</a></li>
                    <li class="active">Absensi Karyawan</li>
                </ol>
                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Close Header -->
    <!-- Start content -->
    <div class="content center">
        <div class="container">
            <div class="col-md-6" id="col">
                <div class="panel panel-light">
                    <div class="panel-body">
                        {{-- TAMPILAN ABSENSI karyawan --}}
                        <h3 class="text-center m-t-0 m-b-30">
                            <span class=""><img id="img"
                                    src="{{ !empty($row->foto) ? asset('Foto_Profile/' . $row->foto) : asset('assets/images/users/avatar-1.jpg') }}"
                                    alt="logo" class="img-circle" width="140" height="140"></span>
                            <h3 align="center"><strong>{{ Auth::user()->name }}</strong></h3>

                            <div>
                                @if (!isset($absensi->jam_masuk))
                                    <form action="{{ route('absensi.action') }}" method="POST" align="center">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-info btn-lg">
                                            <i class="fa fa-sign-in fa-3x"></i>
                                        </button>
                                    </form>
                                    <div>
                                        <h3 align="center">Masuk</h3>
                                    </div>

                                @elseif(!isset($absensi->jam_keluar))
                                    <form action="{{ route('absen_pulang', $absensi->id) }}" method="POST" align="center">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-lg m-10">
                                            <i class="fa fa-sign-out fa-3x"></i>
                                        </button>
                                    </form>
                                    <div>
                                        <h3 align="center">Pulang</h3>
                                    </div>
                                    @elseif(isset($absensi->jam_keluar))
                                    <div>
                                        <h3 align="center">Terima kasih</h3>
                                    </div>
                                @else
                                    <div>
                                        <h3 align="center">Anda {{ $status->status }} Hari Ini </h3>
                                    </div>
                                @endif
                                @include('karyawan.absensi.tidakMasukModal')


                        </h3>
                    </div>
                </div>
            </div>
        </div> <!-- End Row -->
    </div> <!-- container -->
    </div> <!-- content -->

    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>
    <script src="assets/js/app.js"></script>
    <style>
        #col {
            margin-top: 3%;
            margin-left: 25%;
        }

        ;
    </style>
@endsection
