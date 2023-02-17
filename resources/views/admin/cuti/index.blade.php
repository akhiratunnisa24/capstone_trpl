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

            <div class="clearfix"></div>
            
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

                            <div class="panel-body">
                    <form class="" action="">
                        <div class="row">
                            {{-- <div class="col-sm-1"></div> --}}
                            <div class="col-sm-3 col-xs-12">
                                <div class="m-t-20">
                                    <div class="form-group">
                                        <label>Karyawan</label>

                                        <select name="id_karyawan" id="id_karyawan" class="form-control selectpicker" data-live-search="true" required>
                                            <option>-- Pilih Karyawan --</option>
                                            @foreach ($karyawan as $data)
                                                <option value="{{ $data->id}}"
                                                    @if ($data->id ==request()->id_karyawan)
                                                    selected
                                                    @endif
                                                    >{{ $data->nama }}
                                                </option>
                                            @endforeach
                                        </select> 
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-sm-3 col-xs-12">
                                <div class="m-t-20">
                                    <div class="form-group">
                                        <label>Departemen</label>

                                        <select name="id_departemen" id="id_departemen" class="form-control">
                                            <option>-- Pilih Departemen --</option>
                                            <option value="KONVENSIONAL" {{ ('KONVENSIONAL' === request()->departemen) ? 'selected' : '' }}>
                                                KONVENSIONAL
                                            </option>
                                            {{-- @foreach ($departemen as $data) --}}
                                                {{-- <option value="{{ $data->id}}" --}}
                                                    {{-- @if ($data->id ==request()->id_departemen)
                                                    selected
                                                    @endif --}}
                                                    {{-- >{{ $data->departemen }}
                                                </option> --}}
                                            {{-- @endforeach --}}
                                        {{-- </select>                                                  
                                    </div>
                                </div>
                            </div>   --}}
                            <div class="col-sm-3 col-xs-12">
                                <div class="m-t-20">
                                    <div class="form-group">
                                        <label>Bulan</label>
                                        <select name="bulan" id="bulan" class="col-md-3 form-control selectpicker" data-live-search="true" required>
                                            <option value="">-- Pilih Bulan --</option>
                                            <option value="01" {{ ('01' === request()->bulan) ? 'selected' : '' }}>Januari</option>
                                            <option value="02" {{ ('02' === request()->bulan) ? 'selected' : '' }}>Februari</option>
                                            <option value="03" {{ ('03' === request()->bulan) ? 'selected' : '' }}>Maret</option>
                                            <option value="04" {{ ('04' === request()->bulan) ? 'selected' : '' }}>April</option>
                                            <option value="05" {{ ('05' === request()->bulan) ? 'selected' : '' }}>Mei</option>
                                            <option value="06" {{ ('06' === request()->bulan) ? 'selected' : '' }}>Juni</option>
                                            <option value="07" {{ ('07' === request()->bulan) ? 'selected' : '' }}>Juli</option>
                                            <option value="08" {{ ('08' === request()->bulan) ? 'selected' : '' }}>Agustus</option>
                                            <option value="09" {{ ('09' === request()->bulan) ? 'selected' : '' }}>September</option>
                                            <option value="10" {{ ('10' === request()->bulan) ? 'selected' : '' }}>Oktober</option>
                                            <option value="11" {{ ('11' === request()->bulan) ? 'selected' : '' }}>November</option>
                                            <option value="12" {{ ('12' === request()->bulan) ? 'selected' : '' }}>Desember</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <div class="m-t-20">
                                    <div class="form-group">
                                        <label>Tahun</label>
                                        <select name="tahun" id="tahun" class="col-md-3 form-control selectpicker" data-live-search="true" required>
                                            <option value="" required>-- Pilih Tahun --</option>
                                            {{-- {{ ('01' === request()->bulan) ? 'selected' : '' }} --}}
                                            <option value="2011" {{ ('2011' === request()->tahun) ? 'selected' : '' }}>2011</option>
                                            <option value="2012" {{ ('2012' === request()->tahun) ? 'selected' : '' }}>2012</option>
                                            <option value="2013" {{ ('2013' === request()->tahun) ? 'selected' : '' }}>2013</option>
                                            <option value="2014" {{ ('2014' === request()->tahun) ? 'selected' : '' }}>2014</option>
                                            <option value="2015" {{ ('2015' === request()->tahun) ? 'selected' : '' }}>2015</option>
                                            <option value="2016" {{ ('2016' === request()->tahun) ? 'selected' : '' }}>2016</option>
                                            <option value="2017" {{ ('2017' === request()->tahun) ? 'selected' : '' }}>2017</option>
                                            <option value="2018" {{ ('2018' === request()->tahun) ? 'selected' : '' }}>2018</option>
                                            <option value="2019" {{ ('2019' === request()->tahun) ? 'selected' : '' }}>2019</option>
                                            <option value="2020" {{ ('2020' === request()->tahun) ? 'selected' : '' }}>2020</option>
                                            <option value="2021" {{ ('2021' === request()->tahun) ? 'selected' : '' }}>2021</option>
                                            <option value="2022" {{ ('2022' === request()->tahun) ? 'selected' : '' }}>2022</option>
                                            <option value="2023" {{ ('2023' === request()->tahun) ? 'selected' : '' }}>2023</option>
                                            <option value="2024" {{ ('2024' === request()->tahun) ? 'selected' : '' }}>2024</option>
                                            <option value="2025" {{ ('2025' === request()->tahun) ? 'selected' : '' }}>2025</option>
                                            <option value="2026" {{ ('2026' === request()->tahun) ? 'selected' : '' }}>2026</option>
                                            <option value="2027" {{ ('2027' === request()->tahun) ? 'selected' : '' }}>2027</option>
                                            <option value="2028" {{ ('2028' === request()->tahun) ? 'selected' : '' }}>2028</option>
                                            <option value="2029" {{ ('2029' === request()->tahun) ? 'selected' : '' }}>2029</option>
                                            <option value="2030" {{ ('2030' === request()->tahun) ? 'selected' : '' }}>2030</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <div class="" style="margin-top:26px">
                                    <div class="form-group">
                                        <label></label>
                                        <div>
                                            <button type="submit" id="search" class="btn btn-md btn-success fa fa-filter"> Filter</button>
                                            <a href="{{ route('absensi.index') }}" class="btn btn-md btn-success fa fa-refresh"> Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                            <div class="row">
                                <div class="col-md-15">
                                    <div class="panel panel-primary">
                                        {{-- <div class="panel-heading"  style="height:35px"> --}}
                                            <div class="panel-heading clearfix">
                                                <a href="/rekapcutiExcel" id="exportToExcel" class="btn btn-dark btn-sm fa fa-file-excel-o">  Export Excel</a>
                            <a href="{{ route('rekapabsensipdf')}}"  id="exportToPdf" class="btn btn-dark btn-sm fa fa fa-file-pdf-o" target="_blank" > Export PDF</a>
                                                <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                                    data-target="#Modals"> Tambah Cuti Karyawan</a>
                                            </div>
                                        <!-- modals tambah data cuti -->
                                        @include('admin.cuti.addcuti')
                                        {{-- </div> --}}
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
                                                                {{-- <td>{{$data->nama}}</td> --}}
                                                                <td>{{$data->karyawans->nama}}</td>
                                                                <td>{{$data->jeniscutis->jenis_cuti}}</td>
                                                                <td>{{$data->keperluan}}</td>
                                                                <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}}</td>
                                                                <td>{{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td>
                                                                <td>{{$data->jml_cuti}} Hari</td>
                                                                <td>
                                                                    {{-- {{ $data->status }} --}}
                                                                    <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : '')))) }}">
                                                                        {{ $data->status == 1 ? 'Pending' : ($data->status == 2 ? 'Disetujui Manager' : ($data->status == 5 ? 'Ditolak' : ($data->status == 6 ? 'Disetujui Supervisor' : ($data->status == 7 ? 'Disetujui' : '')))) }}
                                                                    </span>
                                                                </td>

                                                                <td id="b" class="text-center" > 
                                                                    <div class="row">
                                                                        @if($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1)
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
                                                                        @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2)
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
                                                                        @else
                                                                        @endif

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
                                                                    <td>
                                                                        <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 5 ? 'danger' : ($data->status == 7 ? 'success' : '')) }}">
                                                                            {{ $data->status == 1 ? 'Pending' : ($data->status == 5 ? 'Ditolak' : ($data->status == 7 ? 'Disetujui' : '')) }}
                                                                        </span>
                                                                    </td>
                                                                  
                                                                    <td> 
                                                                        <div class="row">
                                                                            {{-- @if($data->status == 'Pending' || $data->status == 'Disetujui Manager') --}}
                                                                            @if ($data->karyawan->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $data->id_karyawan != Auth::user()->id_pegawai)    
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('izinapproved',$data->id)}}" method="POST"> 
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden> 
                                                                                        <button  type="submit" class="fa fa-check btn-success btn-sm"></button> 
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST"> 
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#izReject{{$data->id}}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                                {{-- <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('izinreject',$data->id)}}" method="POST"> 
                                                                                        @csrf
                                                                                        @method('POST')
                                                                                        <input type="hidden" name="status" value="Ditolak" class="form-control" hidden> 
                                                                                        <button type="submit" class="fa fa-times btn-danger btn-sm"></button> 
                                                                                    </form>
                                                                                </div> --}}
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
                                                                            @include('admin.cuti.izinReject')
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