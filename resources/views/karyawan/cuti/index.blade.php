@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Ajukan Cuti & Izin</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Ajukan Cuti & Izin</li>
                </ol>
                <div class="clearfix"></div>               
            </div>
        </div>
    </div>
    <!-- Close Header -->
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs navtab-bg">
                <li class="active">
                    <a id="tab1" href="#cuti" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Cuti</span>
                    </a>
                </li>
                <li class="">
                    <a id="tab2" href="#izin" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Izin</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                {{-- LIST CUTI --}}
                <div class="tab-pane active" id="cuti">
                    <!-- Start content -->
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading clearfix">
                                            <strong>List Permohonan Cuti</strong>
                                            <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                                data-target="#Modal"> Ajukan Cuti</a>
                                        </div>
                                        <!-- modals tambah data cuti -->
                                        @include('karyawan.cuti.addcuti')

                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <table id="datatable-responsive"
                                                        class="table dt-responsive nowrap table-striped table-bordered"
                                                        cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Karyawan</th>
                                                                <th>Kategori Cuti</th>
                                                                <th>Keperluan</th>
                                                                <th>Tanggal Mulai</th>
                                                                <th>Tanggal Selesai</th>
                                                                <th>Jumlah Cuti</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($cuti as $data)
                                                                @if ($data->id_karyawan == Auth::user()->id_pegawai)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $data->karyawans->nama }}</td>
                                                                        <td>{{ $data->jeniscutis->jenis_cuti }}</td>
                                                                        <td>{{ $data->keperluan }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                                        </td>
                                                                        <td>{{ \Carbon\Carbon::parse($data->tgl_selesai)->format('d/m/Y') }}
                                                                        </td>
                                                                        <td>{{ $data->jml_cuti }} Hari</td>

                                                                        <!-- data for status -->
                                                                        @if ($data->status == 'Pending')
                                                                            <td>
                                                                                <span
                                                                                    class="badge badge-warning">Pending</span>
                                                                            </td>
                                                                        @elseif($data->status == 'Disetujui Manager')
                                                                            <td>
                                                                                <span class="badge badge-info">Disetujui
                                                                                    Manager</span>
                                                                            </td>
                                                                        @elseif($data->status == 'Disetujui')
                                                                            <td>
                                                                                <span
                                                                                    class="badge badge-success">Disetujui</span>
                                                                            </td>
                                                                        @else
                                                                            <td>
                                                                                <span
                                                                                    class="badge badge-danger">Ditolak</span>
                                                                            </td>
                                                                        @endif

                                                                        <td class="text-center">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-info btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#Showcuti{{ $data->id }}">
                                                                                    <i class="fa fa-eye"></i>
                                                                                </a>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    {{-- modal show cuti --}}
                                                                    @include('karyawan.cuti.showcuti')
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End Row -->
                        </div> <!-- container -->
                    </div> <!-- content -->
                </div>

                {{-- END CUTI --}}

                {{-- LIST IZIN --}}
                <div class="tab-pane" id="izin">
                    {{-- Start content --> --}}
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading clearfix">
                                            <strong>List Permohonan Izin</strong>
                                            <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                                data-target="#smallModal"> Ajukan Izin</a>
                                        </div>
                                        {{-- modals tambah data izin --}}
                                        @include('karyawan.cuti.addizin')

                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <table id="datatable-responsive5"
                                                        class="table dt-responsive table-striped table-bordered"
                                                        cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <td>#</td>
                                                                <th>Karyawan</th>
                                                                <th>K. Izin</th>
                                                                <th>Keperluan</th>
                                                                <th>Tanggal</th>
                                                                <th>Jml</th>
                                                                <th>Jam M-S</th>
                                                                <th>Jml. Jam</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($izin as $data)
                                                                @if ($data->id_karyawan == Auth::user()->id_pegawai)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $data->karyawans->nama }}</td>
                                                                        <td>{{ $data->jenisizins->jenis_izin }}</td>
                                                                        <td>{{ $data->keperluan }}</td>

                                                                        <!-- tanggal mulai & tanggal selesai -->
                                                                        @if ($data->tgl_mulai != $data->tgl_selesai)
                                                                            <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                                                s/d
                                                                                {{ \Carbon\Carbon::parse($data->tgl_selesai)->format('d/m/Y') }}
                                                                            </td>
                                                                        @else
                                                                            <td>
                                                                                {{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                                            </td>
                                                                        @endif

                                                                        <!-- Jumlah hari izin -->
                                                                        @if ($data->jml_hari != null)
                                                                            <td>{{ $data->jml_hari }} Hari</td>
                                                                        @else
                                                                            <td></td>
                                                                        @endif

                                                                        <!-- jam mulai & jam selesai -->
                                                                        @if ($data->jam_mulai != null && $data->jam_mulai != null)
                                                                            <td>{{ \Carbon\Carbon::parse($data->jam_mulai)->format('H:i') }}
                                                                                s/d
                                                                                {{ \Carbon\Carbon::parse($data->jam_selesai)->format('H:i') }}
                                                                            </td>
                                                                        @else
                                                                            <td></td>
                                                                        @endif

                                                                        <!-- Jumlah jam -->
                                                                        @if ($data->jml_jam != null)
                                                                            <td>
                                                                                {{ \Carbon\Carbon::parse($data->jml_jam)->format('H:i') }}
                                                                            </td>
                                                                        @else
                                                                            <td></td>
                                                                        @endif

                                                                        <!-- Jumlah jam -->
                                                                        @if ($data->status == 'Pending')
                                                                            <td>
                                                                                <span
                                                                                    class="badge badge-warning">Pending</span>
                                                                            </td>
                                                                        @elseif($data->status == 'Disetujui')
                                                                            <td>
                                                                                <span
                                                                                    class="badge badge-success">Disetujui</span>
                                                                            </td>
                                                                        @else
                                                                            <td>
                                                                                <span
                                                                                    class="badge badge-danger">Ditolak</span>
                                                                            </td>
                                                                        @endif

                                                                        <td class="text-center">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-info btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#Showizin{{ $data->id }}">
                                                                                    <i class="fa fa-eye"></i>
                                                                                </a>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    {{-- modal show izin --}}
                                                                @endif
                                                                @include('karyawan.cuti.showizin')
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End Row -->
                        </div> <!-- container -->
                    </div> <!-- content -->
                </div>
                {{-- END IZIN --}}
            </div>
        </div>
    </div>
</div>



    {{-- <script type="text/javascript">
    let tp = '{{$tipe}}';
    
        if(tp == 1) {
            $('#tab1').click();
        } else {
            $('#tab2').click();
        }
</script> --}}
@endsection