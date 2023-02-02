@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Ajukan Resign</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Ajukan Resign</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- Close Header -->


    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading clearfix">
                            {{-- <strong>List Permohonan Cuti</strong> --}}
                            @if (!$cek)
                                <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                    data-target="#Modal"> Form Ajukan Resign</a>
                            @else
                                <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right alert-button"
                                    data-toggle="modal"
                                    onclick="alert('Kamu tidak bisa mengajukan resign lebih dari satu')">Form Ajukan
                                    Resign</a>
                            @endif
                        </div>
                        <!-- modals tambah data cuti -->
                        @include('karyawan.resign.addresign')

                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable-responsive"
                                        class="table dt-responsive nowrap table-striped table-bordered" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                {{-- <th>#</th> --}}
                                                <th>Karyawan</th>
                                                <th>Departemen</th>
                                                <th>Tanggal Bergabung</th>
                                                <th>Tanggal Resign</th>
                                                <th>Tipe Resign</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($resign as $r)
                                                @if ($r->id_karyawan == Auth::user()->id_pegawai)
                                                    <tr>
                                                        {{-- <td>1</td> --}}
                                                        <td>{{ $r->karyawans->nama }}</td>
                                                        <td>{{ $r->departemens->nama_departemen }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($r->tgl_masuk)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($r->tgl_resign)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $r->tipe_resign }}</td>



                                                        <!-- data for status -->
                                                        @if ($r->status == 'Pending')
                                                            <td>
                                                                <span class="badge badge-warning">Pending</span>
                                                            </td>
                                                        @elseif($r->status == 'Disetujui Manager')
                                                            <td>
                                                                <span class="badge badge-info">Disetujui
                                                                    Manager</span>
                                                            </td>
                                                        @elseif($r->status == 'Disetujui')
                                                            <td>
                                                                <span class="badge badge-success">Disetujui</span>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <span class="badge badge-danger">Ditolak</span>
                                                            </td>
                                                        @endif

                                                        <td class="text-center">
                                                            <form action="" method="POST">
                                                                <a class="btn btn-info btn-sm" data-toggle="modal"
                                                                    data-target="#Showresign{{ $r->id }}">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    {{-- modal show cuti --}}
                                                    @include('karyawan.resign.showresign')
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