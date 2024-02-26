@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Ajukan Cuti & Izin</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
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
                <li class="active" id="act">
                    <a id="tab1" href="#cuti" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Cuti</span>
                    </a>
                </li>
                <li class="" id="aiz">
                    <a id="tab2" href="#izin" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Sakit/Izin</span>
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
                                                <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                                    data-target="#Modal"> Pengajuan Cuti</a>
                                        </div>
                                        <!-- modals tambah data cuti -->
                                        @include('karyawan.cuti.addcuti')

                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <table id="datatable-responsive" class="table dt-responsive nowrap table-striped table-bordered" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Tgl Permohonan</th>
                                                                <th>Nama</th>
                                                                {{-- <th>Jabatan</th> --}}
                                                                <th>Tanggal Cuti</th>
                                                                <th>Kategori Cuti</th>
                                                                <th>Persetujuan</th>
                                                                <th>Catatan</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($cuti as $data)
                                                                @if ($data->id_karyawan == Auth::user()->id_pegawai)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{\Carbon\Carbon::parse($data->tgl_permohonan)->format("d/m/Y")}}</td>
                                                                        <td>{{$data->nama}}</td>
                                                                        {{-- <td>{{$data->jabatan}}</td> --}}
                                                                        <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}} s.d {{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td>
                                                                        <td>{{$data->jenis_cuti}}</td>

                                                                        <td>
                                                                            {{-- <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'danger' : 'secondary' ))))))))) }}">
                                                                                {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status : ''))))))))) }}
                                                                            </span> --}}
                                                                            <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'danger' : ($data->status == 14 ? 'warning' :($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                                                {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status :  ($data->status == 14 ?  $data->name_status :  ($data->status == 15 ?  $data->name_status :  ($data->status == 16 ?  $data->name_status : '')))))))))))) }}
                                                                            </span>

                                                                        </td>
                                                                        <td>
                                                                            {{ $data->catatan ?? ''}}
                                                                            {{-- {{ ($data->catatan >= 9 && $data->catatan <= 16) ? $data->name_status : '' }} --}}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{-- @if($data->status == ) --}}
                                                                                <form action="" method="POST">
                                                                                    <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#Showcuti{{ $data->id }}">
                                                                                        <i class="fa fa-eye" title="Lihat Detail"></i>
                                                                                    </a>
                                                                                </form>
                                                                                @if($data->status == 1 && $data->catatan == null || $data->status == 6 && $data->catatan == null || $data->status == 7 && $data->catatan == null)
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#Editcuti{{ $data->id }}">
                                                                                            <i class="fa fa-edit" title="Edit"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                    {{-- {{ route('cuti.batal', $data->id) }}" --}}

                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#Batalcuti{{ $data->id }}">
                                                                                            <i class="fa fa-undo" title="Batal"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                @endif

                                                                        </td>
                                                                    </tr>
                                                                    {{-- modal show cuti --}}
                                                                @endif
                                                                @include('karyawan.cuti.showcuti')
                                                                @include('karyawan.cuti.pembatalan')
                                                                @include('karyawan.cuti.update')
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
                                            <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                                data-target="#smallModal"> Sakit/Izin/Alpa/Lain-lain</a>
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
                                                                <th>No</th>
                                                                <th>Tgl Permohonan</th>
                                                                <th>Nama</th>
                                                                {{-- <th>Jabatan</th> --}}
                                                                <th>Tanggal Pelaksanaan</th>
                                                                <th>Kategori</th>
                                                                <th>Persetujuan</th>
                                                                <th>Catatan</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($izin as $data)
                                                                {{-- @if ($data->id_karyawan == Auth::user()->id_pegawai) --}}
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($data->tgl_permohonan)->format('d/m/Y') }}</td>
                                                                        <td>{{ $data->nama }}</td>
                                                                        <td>
                                                                            {{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }} @if($data->tgl_selesai !== NULL) s/d
                                                                            {{ \Carbon\Carbon::parse($data->tgl_selesai)->format('d/m/Y') }} @endif
                                                                        </td>
                                                                        <td>{{ $data->jenis_izin }}</td>
                                                                        <td>
                                                                            <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'danger' : ($data->status == 14 ? 'warning' :($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                                                {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status :  ($data->status == 14 ?  $data->name_status :  ($data->status == 15 ?  $data->name_status :  ($data->status == 16 ?  $data->name_status : '')))))))))))) }}
                                                                            </span>

                                                                        </td>
                                                                        <td>{{ $data->catatan }}</td>
                                                                        <td class="text-center">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-info btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-target="#Showizin{{ $data->id }}">
                                                                                    <i class="fa fa-eye" title="Lihat Detail"></i>
                                                                                </a>
                                                                            </form>
                                                                            @if($data->status == 1 && $data->catatan == null || $data->status == 6 && $data->catatan == null || $data->status == 7 && $data->catatan == null)
                                                                                <form action="" method="POST">
                                                                                    <a class="btn btn-success btn-sm"
                                                                                        data-toggle="modal"data-target="#Editizin{{ $data->id }}">
                                                                                        <i class="fa fa-edit" title="Edit"></i>
                                                                                    </a>
                                                                                </form>
                                                                                    {{-- {{ route('cuti.batal', $data->id) }}" --}}

                                                                                <form action="" method="POST">
                                                                                    <a class="btn btn-warning btn-sm"
                                                                                        data-toggle="modal" data-target="#Batalizin{{ $data->id }}">
                                                                                        <i class="fa fa-undo" title="Batal"></i>
                                                                                    </a>
                                                                                </form>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    {{-- modal show izin --}}
                                                                {{-- @endif --}}
                                                                @include('karyawan.cuti.showizin')
                                                                @include('karyawan.cuti.pembatalanIzin')
                                                                @include('karyawan.cuti.updateIzin')
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
</script>
<!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

@if(Session::has('success'))
    <script>
        swal("Selamat","{{ Session::get('success')}}", 'success', {
            button:true,
            button:"OK",
        });
    </script>
@endif

@if(Session::has('error'))
    <script>
        swal("Mohon Maaf","{{ Session::get('error')}}", 'error', {
            button:true,
            button:"OK",
        });
    </script>
@endif

<script type="text/javascript">
    let tp = '{{$tipe}}';

        if(tp == 1) {
            $('#tab1').click();
            $('#tab1').addClass('active');
            $('#tab2').removeClass('active');
            $('#cuti').addClass('active');
            $('#izin').removeClass('active');
            $('#act').addClass('active');
            $('#aiz').removeClass('active');
        } else {
            $('#tab2').click();
            $('#tab1').removeClass('active');
            $('#tab2').addClass('active');
            $('#cuti').removeClass('active');
            $('#izin').addClass('active');
            $('#act').removeClass('active');
            $('#aiz').addClass('active');
        }
</script>
@endsection
