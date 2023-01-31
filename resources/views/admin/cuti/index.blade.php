@extends('layouts.default')
@section('content')
<!-- Header -->

<div class="row">
    <div class="col-sm-12">

        <div class="page-header-title">
            <h4 class="pull-left page-title">Data Cuti dan Izin</h4>

            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Data Cuti dan Izin</li>
            </ol>

            <div class="clearfix">
            </div>
        </div>
    </div>
</div>
<!-- Close Header -->

<!-- Start right Content here -->
<!-- Start content -->
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs navtab-bg">
                <li class="active">
                    <a id="tab1" href="#cuti" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Permintaan Cuti</span>
                    </a>
                </li>
                <li class="">
                    <a id="tab2" href="#izin" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Permintaan Izin</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                {{-- LIST CUTI --}}
                <div class="tab-pane active" id="cuti">
                    <!-- Start content -->
                    {{-- <div class="row">
                        <div class="col-sm-6 col-xs-12 text-right" style="margin-top:7px">Filter Data:</div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="input-group">
                                <input id="datepicker-autoclose22" type="text"
                                    class="form-control" placeholder="yyyy/mm/dd" id="datepicker-autoclose22"
                                    name="filter-data" autocomplete="off" rows="10" required><br>
                                <span class="input-group-addon bg-custom b-0"><i
                                        class="mdi mdi-calendar text-white"></i></span>
                            </div><!-- input-group -->
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <button type="submit" id="cari" class="btn btn-md btn-success fa fa-filter" style="margin-left: 15px;height: 37px" > Filter</button>
                            <a href="" class="btn btn-md btn-success fa fa-refresh " style="height: 37px;"> Reset</a>
                            {{-- {{ route('cuti.index') }} --}}
                     {{--   </div>
                    </div> --}}

                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-15">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading"  style="height:35px">
                                            {{-- <strong>Data Permintaan Cuti</strong> --}}
                                        </div>
                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-20 col-sm-20 col-xs-20">
                                                    <table  id="datatable-responsive3" class="table dt-responsive table-striped table-bordered" width="100%">
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
                                                            @foreach($cuti as $data)
                                                            <tr>
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>{{$data->nama}}</td>
                                                                <td>{{$data->jenis_cuti}}</td>
                                                                <td>{{$data->keperluan}}</td>
                                                                <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}}</td>
                                                                <td>{{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td>
                                                                <td>{{$data->jml_cuti}} Hari</td>

                                                                @if($data->status == 'Pending')
                                                                    <td>
                                                                        <span class="badge badge-warning">Pending</span>
                                                                    </td>
                                                                @elseif($data->status == 'Disetujui Manager')
                                                                    <td>
                                                                        <span class="badge badge-info">Disetujui Manager</span>
                                                                    </td>
                                                                @elseif($data->status == 'Disetujui')
                                                                    <td>
                                                                        <span class="badge badge-success">Disetujui</span>
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <span class="badge badge-danger">Ditolak</span>
                                                                    </td>
                                                                @endif

                                                                <td id="b" class="text-center" > 
                                                                    <div class="row">
                                                                        {{-- @if($data->status == 'Pending' || $data->status == 'Disetujui Manager')
                                                                            <div class="col-sm-3">
                                                                                <form action="{{ url('')}}/permintaan_cuti/<php echo $data->id ?>" method="POST"> 
                                                                                    @csrf
                                                                                    <input type="hidden" name="status" value="Disetujui" class="form-control" hidden> 
                                                                                    <button type="submit" class="fa fa-check btn-success btn-sm"></button> 
                                                                                </form>
                                                                            </div>
                                                                            <div class="col-sm-3" style="margin-left:8px">
                                                                                <form action="{{ route('cuti.tolak',$data->id)}}" method="POST"> 
                                                                                    @csrf
                                                                                    @method('POST')
                                                                                    <input type="hidden" name="status" value="Ditolak" class="form-control" hidden> 
                                                                                    <button  type="submit" class="fa fa-times btn-danger btn-sm"></button> 
                                                                                </form>
                                                                            </div>
                                                                        @endif --}}

                                                                        <div class="col-sm-3" style="margin-left:6px">
                                                                            <form action="" method="POST"> 
                                                                                <a  class="btn btn-info btn-sm" style="height:26px" data-toggle="modal" data-target="#Showcuti{{$data->id}}">
                                                                                    <i class="fa fa-eye"></i>
                                                                                </a>
                                                                            </form> 
                                                                        </div>
                                                                    </div>
                                                                </td> 
                                                            </tr>
                                                            {{-- modal show cuti --}}
                                                            @include('admin.cuti.showcuti')
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div> 
                    </div> 
                </div>
                <!-- END CUTI -->

                <!-- LIST IZIN -->
                <div class="tab-pane" id="izin">
                    <!-- Start content -->
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-20">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" style="height:35px">
                                            {{-- <strong>Data Permintaan Izin</strong> --}}
                                        </div>
                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-20 col-sm-20 col-xs-20">
                                                    <table  id="datatable-responsive4" class="table dt-responsive table-striped table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Karyawan</th>
                                                                <th>Kategori Izin</th>
                                                                <th>Keperluan</th>
                                                                <th>Tanggal</th>
                                                                <th>Jml</th>
                                                                <th>Mulai s/d Selesai</th>
                                                                {{-- <th>Jml. Jam</th> --}}
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($izin as $data)
                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>
                                                                    <td>{{$data->karyawans->nama}}</td>
                                                                    <td>{{$data->jenisizins->jenis_izin}}</td>
                                                                    <td>{{$data->keperluan}}</td>

                                                                    {{-- tanggal mulai & tanggal selesai --}}
                                                                    @if($data->tgl_mulai != null && $data->tgl_selesai != null)
                                                                        <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}} s/d {{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td>
                                                                    @else
                                                                        <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/M/Y")}}</td>
                                                                    @endif

                                                                    {{-- Jumlah hari izin --}}
                                                                    @if($data->jml_hari != null)
                                                                        <td>{{$data->jml_hari}} Hari</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif

                                                                    {{-- jam mulai & jam selesai --}}
                                                                    @if($data->jam_mulai != null && $data->jam_mulai !=null)
                                                                        <td>{{\Carbon\Carbon::parse($data->jam_mulai)->format("H:i")}} s/d {{\Carbon\Carbon::parse($data->jam_selesai)->format("H:i")}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif

                                                                    {{-- Jumlah jam --}}
                                                                    {{-- @if($data->jml_jam != null)
                                                                        <td>{{\Carbon\Carbon::parse($data->jml_jam)->format("H:i")}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif --}}

                                                                    {{-- status --}}
                                                                    @if($data->status == 'Pending')
                                                                        <td>
                                                                            <span class="badge badge-warning">Pending</span>
                                                                        </td>
                                                                    @elseif($data->status == 'Disetujui Manager')
                                                                        <td>
                                                                            <span class="badge badge-info">Disetujui Manager</span>
                                                                        </td>
                                                                    @elseif($data->status == 'Disetujui')
                                                                        <td>
                                                                            <span class="badge badge-success">Disetujui</span>
                                                                        </td>
                                                                    @else
                                                                        <td>
                                                                            <span class="badge badge-danger">Ditolak</span>
                                                                        </td>
                                                                    @endif

                                                                    <td> 
                                                                        <div class="row">
                                                                            @if($data->status == 'Pending' || $data->status == 'Disetujui Manager')
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('izinapproved',$data->id)}}" method="POST"> 
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden> 
                                                                                        <button  type="submit" class="fa fa-check btn-success btn-sm"></button> 
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('izinreject',$data->id)}}" method="POST"> 
                                                                                        @csrf
                                                                                        @method('POST')
                                                                                        <input type="hidden" name="status" value="Ditolak" class="form-control" hidden> 
                                                                                        <button type="submit" class="fa fa-times btn-danger btn-sm"></button> 
                                                                                    </form>
                                                                                </div>
                                                                            @endif
                
                                                                            <div class="col-sm-3" style="margin-left:5px">
                                                                                <form action="" method="POST"> 
                                                                                    <a class="btn btn-info btn-sm" style="height:26px" data-toggle="modal" data-target="#Showizinadmin{{$data->id}}">
                                                                                        <i class="fa fa-eye fa-md"></i>
                                                                                    </a>
                                                                                </form> 
                                                                            </div>
                                                                            {{-- modal show izin --}}
                                                                            @include('admin.cuti.showizin')
                                                                        </div>
                                                                    </td> 
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END IZIN --}}
            </div>
        </div>
    </div> 
    <style>
        #b {
            column-width: 90px;
        }
    </style>

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/pages/datatables.init.js"></script>
    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/pages/form-advanced.js"></script>

    <script type="text/javascript">
        let tp = `{{$type}}`;

        if(tp == 1) 
        {
            $('#tab1').click();
        }else{
            $('#tab2').click();
        }
    </script>    
@endsection