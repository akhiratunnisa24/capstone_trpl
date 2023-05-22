@extends('layouts.default')
@section('content')
<!-- Header -->

<div class="row">
    <div class="col-sm-12">

        <div class="page-header-title">
            <h4 class="pull-left page-title">Transaksi Cuti dan Izin</h4>

            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Transaksi Cuti dan Izin</li>
            </ol>

            <div class="clearfix"></div>
            
        </div>
    </div>
</div>
<!-- Close Header -->

<!-- Start content -->
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs navtab-bg">
                <li class="active" id="a">
                    <a id="tab1" href="#cuti" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Transaksi Cuti</span>
                    </a>
                </li>
                <li class="" id="b">
                    <a id="tab2" href="#izin" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Transaksi Izin</span>
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
                        </div> --}}
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-20">
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
                                                            <option value="2011" {{ ('2011' === request()->tahun) ? 'selected' : '' }}>2031</option>
                                                            <option value="2012" {{ ('2012' === request()->tahun) ? 'selected' : '' }}>2032</option>
                                                            <option value="2013" {{ ('2013' === request()->tahun) ? 'selected' : '' }}>2033</option>
                                                            <option value="2014" {{ ('2014' === request()->tahun) ? 'selected' : '' }}>2034</option>
                                                            <option value="2015" {{ ('2015' === request()->tahun) ? 'selected' : '' }}>2035</option>
                                                            <option value="2016" {{ ('2016' === request()->tahun) ? 'selected' : '' }}>2036</option>
                                                            <option value="2017" {{ ('2017' === request()->tahun) ? 'selected' : '' }}>2037</option>
                                                            <option value="2018" {{ ('2018' === request()->tahun) ? 'selected' : '' }}>2038</option>
                                                            <option value="2019" {{ ('2019' === request()->tahun) ? 'selected' : '' }}>2039</option>
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
                                                            <a href="/permintaan_cuti" class="btn btn-md btn-success fa fa-refresh"> Reset</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="panel panel-primary">
                                        {{-- <div class="panel-heading"  style="height:35px"> --}}
                                            <div class="panel-heading clearfix">
                                                <a href="/rekapcutiExcel" id="exportToExcel" class="btn btn-dark btn-sm fa fa-file-excel-o">  Export Excel</a>
                                                <a href="/rekapcutipdf"  id="exportToPdf" class="btn btn-dark btn-sm fa fa fa-file-pdf-o" target="_blank" > Export PDF</a>
                                                
                                                <a class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                                    data-target="#Modals"> Tambah Cuti Karyawan</a>

                                            </div>
                                        <!-- modals tambah data cuti -->
                                        @include('admin.cuti.addcuti')
                                        {{-- </div> --}}
                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-20 col-sm-20 col-xs-20">
                                                    <table  id="datatable-responsive18" class="table dt-responsive table-striped table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                @php
                                                                    use \Carbon\Carbon;
                                                                    $year = Carbon::now()->year;

                                                                @endphp
                                                                <th>No</th>
                                                                <th>Tgl Permohonan</th>
                                                                <th>NIK</th>
                                                                <th>Nama</th>
                                                                <th>Jabatan</th>
                                                                <th>Tanggal Cuti</th>
                                                                <th>Kategori Cuti</th>
                                                                <th>Jumlah Hari Kerja</th>
                                                                <th>Saldo Hak Cuti {{$year}}</th>
                                                                <th>Jumlah Cuti {{$year}}</th>
                                                                <th>Sisa Cuti {{$year}}</th>
                                                                <th>Status Persetujuan</th>
                                                                <th>Aksi</th>   
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($cuti as $data)
                                                            <tr>
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>{{\Carbon\Carbon::parse($data->tgl_permohonan)->format("d/m/Y")}}</td>
                                                                <td>{{$data->nik}}</td>
                                                                <td>{{$data->nama}}</td>
                                                                <td>{{$data->jabatan}}</td>
                                                                <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}} s.d {{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td>
                                                                <td>{{$data->jenis_cuti}}</td>
                                                                <td>{{$data->jmlharikerja}}</td>
                                                                <td>{{$data->saldohakcuti}}</td>
                                                                <td>{{$data->jml_cuti}}</td>
                                                                <td>{{$data->sisacuti}}</td>
                                                                <td>
                                                                    <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'success' : ($data->status == 14 ? 'warning' :($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                                        {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status :  ($data->status == 14 ?  $data->name_status :  ($data->status == 15 ?  $data->name_status :  ($data->status == 16 ?  $data->name_status : '')))))))))))) }}
                                                                    </span>
                                                                </td>

                                                                <td id="b" class="text-center" > 
                                                                    <div class="row">
                                                                        @if($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1)
                                                                            <div class="col-sm-3">
                                                                                <form action="/permintaan_cuti/{{ $data->id }}" method="POST">
                                                                                    @csrf
                                                                                    <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                    <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                </form>
                                                                            </div>
                                                                            <div class="col-sm-3" style="margin-left:7px">
                                                                                <form action="" method="POST">
                                                                                    <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#cuReject{{ $data->id }}">
                                                                                        <i class="fa fa-times fa-md"></i>
                                                                                    </a>
                                                                                </form>
                                                                            </div>
                                                                            {{-- <div class="col-sm-3" style="margin-left:8px">
                                                                                <form action="{{ route('cuti.tolak',$data->id)}}" method="POST"> 
                                                                                    @csrf
                                                                                    @method('POST')
                                                                                    <input type="hidden" name="status" value="Ditolak" class="form-control" hidden> 
                                                                                    <button  type="submit" class="fa fa-times btn-danger btn-sm"></button> 
                                                                                </form>
                                                                            </div> --}}
                                                                        @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6)
                                                                            <div class="col-sm-3">
                                                                                <form action="/permintaan_cuti/{{ $data->id }}" method="POST">
                                                                                    @csrf
                                                                                    <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                    <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                </form>
                                                                            </div>
                                                                            <div class="col-sm-3" style="margin-left:7px">
                                                                                <form action="" method="POST">
                                                                                    <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#cuReject{{ $data->id }}">
                                                                                        <i class="fa fa-times fa-md"></i>
                                                                                    </a>
                                                                                </form>
                                                                            </div>

                                                                            {{-- <div class="col-sm-3" style="margin-left:8px">
                                                                                <form action="{{ route('cuti.tolak',$data->id)}}" method="POST"> 
                                                                                    @csrf
                                                                                    @method('POST')
                                                                                    <input type="hidden" name="status" value="Ditolak" class="form-control" hidden> 
                                                                                    <button  type="submit" class="fa fa-times btn-danger btn-sm"></button> 
                                                                                </form>
                                                                            </div> --}}
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
                                    {{-- <div class="panel-body">
                                    
                                    </div> --}}
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div>
                <!-- END CUTI -->

                <!-- LIST IZIN -->
                <div class="tab-pane" id="izin">
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-20">
                                    {{-- /permintaan_izin --}}
                                    <form class="" action="">
                                        {{-- @csrf --}}
                                        <div class="row">
                                            {{-- <div class="col-sm-1"></div> --}}
                                            <div class="col-sm-3 col-xs-12">
                                                <div class="m-t-20">
                                                    <div class="form-group">
                                                        <label>Karyawan</label>
    
                                                        <select name="idpegawai" id="idpegawai" class="form-control selectpicker" data-live-search="true" required>
                                                            <option>-- Pilih Karyawan --</option>
                                                            @foreach ($pegawai as $data)
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
    
                                            <div class="col-sm-3 col-xs-12">
                                                <div class="m-t-20">
                                                    <div class="form-group">
                                                        <label>Bulan</label>
                                                        <select name="month" id="month" class="col-md-3 form-control selectpicker" data-live-search="true" required>
                                                            <option value="">-- Pilih Bulan --</option>
                                                            <option value="01" {{ ('01' === request()->month) ? 'selected' : '' }}>Januari</option>
                                                            <option value="02" {{ ('02' === request()->month) ? 'selected' : '' }}>Februari</option>
                                                            <option value="03" {{ ('03' === request()->month) ? 'selected' : '' }}>Maret</option>
                                                            <option value="04" {{ ('04' === request()->month) ? 'selected' : '' }}>April</option>
                                                            <option value="05" {{ ('05' === request()->month) ? 'selected' : '' }}>Mei</option>
                                                            <option value="06" {{ ('06' === request()->month) ? 'selected' : '' }}>Juni</option>
                                                            <option value="07" {{ ('07' === request()->month) ? 'selected' : '' }}>Juli</option>
                                                            <option value="08" {{ ('08' === request()->month) ? 'selected' : '' }}>Agustus</option>
                                                            <option value="09" {{ ('09' === request()->month) ? 'selected' : '' }}>September</option>
                                                            <option value="10" {{ ('10' === request()->month) ? 'selected' : '' }}>Oktober</option>
                                                            <option value="11" {{ ('11' === request()->month) ? 'selected' : '' }}>November</option>
                                                            <option value="12" {{ ('12' === request()->month) ? 'selected' : '' }}>Desember</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-xs-12">
                                                <div class="m-t-20">
                                                    <div class="form-group">
                                                        <label>Tahun</label>
                                                        <select name="year" id="year" class="col-md-3 form-control selectpicker" data-live-search="true" required>
                                                            <option value="" required>-- Pilih Tahun --</option>
                                                            {{-- {{ ('01' === request()->bulan) ? 'selected' : '' }} --}}
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
                                                            <option value="2011" {{ ('2011' === request()->tahun) ? 'selected' : '' }}>2031</option>
                                                            <option value="2012" {{ ('2012' === request()->tahun) ? 'selected' : '' }}>2032</option>
                                                            <option value="2013" {{ ('2013' === request()->tahun) ? 'selected' : '' }}>2033</option>
                                                            <option value="2014" {{ ('2014' === request()->tahun) ? 'selected' : '' }}>2034</option>
                                                            <option value="2015" {{ ('2015' === request()->tahun) ? 'selected' : '' }}>2035</option>
                                                            <option value="2016" {{ ('2016' === request()->tahun) ? 'selected' : '' }}>2036</option>
                                                            <option value="2017" {{ ('2017' === request()->tahun) ? 'selected' : '' }}>2037</option>
                                                            <option value="2018" {{ ('2018' === request()->tahun) ? 'selected' : '' }}>2038</option>
                                                            <option value="2019" {{ ('2019' === request()->tahun) ? 'selected' : '' }}>2039</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-xs-12">
                                                <div class="" style="margin-top:26px">
                                                    <div class="form-group">
                                                        <label></label>
                                                        <div>
                                                            <button type="submit" id="searchs" class="btn btn-md btn-success fa fa-filter"> Filter</button>
                                                            <a href="/permintaan_cuti" class="btn btn-md btn-success fa fa-refresh"> Reset</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading clearfix">
                                            {{-- /rekapizinExcel --}}
                                            <a href="/rekapizinExcel" id="exportToExcel" class="btn btn-dark btn-sm fa fa-file-excel-o">  Export Excel</a>
                                            <a href="/rekapizinpdf"  id="exportToPdf" class="btn btn-dark btn-sm fa fa fa-file-pdf-o" target="_blank" > Export PDF</a>
                                        </div>
                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-20 col-sm-20 col-xs-20">
                                                    <table  id="datatable-responsive14" class="table dt-responsive table-striped table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Karyawan</th>
                                                                <th>Kategori</th>
                                                                <th>Keperluan</th>
                                                                <th>Tanggal</th>
                                                                <th>Jml</th>
                                                                <th>Mulai s/d Selesai</th>
                                                                {{-- <th>Jml. Jam</th> --}}
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($izin as $data)
                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>
                                                                    {{-- <td>{{$data->karyawans->nama}}</td>
                                                                    <td>{{$data->jenisizins->jenis_izin}}</td> --}}
                                                                    <td>{{$data->nama}}</td>
                                                                    <td>{{$data->jenis_izin}}</td>
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
                                                                        <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'success' : ($data->status == 14 ? 'warning' :($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                                            {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status :  ($data->status == 14 ?  $data->name_status :  ($data->status == 15 ?  $data->name_status :  ($data->status == 16 ?  $data->name_status : '')))))))))))) }}
                                                                        </span>
                                                                    </td>
                                                                  
                                                                    <td> 
                                                                        <div class="row">
                                                                            {{-- @if($data->status == 'Pending' || $data->status == 'Disetujui Manager') --}}
                                                                            @if($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1)
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
                                                                
                                                                            @endif

                                                                            {{-- @if($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6)
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('izinapproved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status"  value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit"  class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal"  data-target="#izReject{{ $data->id }}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                            @endif --}}
                
                                                                            <div class="col-sm-3" style="margin-left:6px">
                                                                                <form action="" method="POST"> 
                                                                                    <a class="btn btn-info btn-sm" style="height:26px" data-toggle="modal" data-target="#Showizinadmin{{$data->id}}">
                                                                                        <i class="fa fa-eye fa-md"></i>
                                                                                    </a>
                                                                                </form> 
                                                                            </div>
                                                                        </div>
                                                                    </td> 
                                                                </tr>
                                                                {{-- modal show izin --}}
                                                                @include('admin.cuti.showizin')
                                                                @include('admin.cuti.izinReject')
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

    @if(Session::has('pesan'))
        <script>
            swal("Selamat","{{ Session::get('pesan')}}", 'success', {
                button:true,
                button:"OK",
            });
        </script>
    @endif

    @if(Session::has('pesa'))
        <script>
            swal("Mohon Maaf","{{ Session::get('pesa')}}", 'error', {
                button:true,
                button:"OK",
            });
        </script>
    @endif

    <script type="text/javascript">
        let tp = `{{$type}}`;
        if(tp == 1) 
        {
            $('#tab1').click();
            $('#tab1').addClass('active');
            $('#tab2').removeClass('active');
            $('#cuti').addClass('active');
            $('#izin').removeClass('active');
            $('#a').addClass('active');
            $('#b').removeClass('active');
        }else{
            $('#tab2').click();
            $('#tab1').removeClass('active');
            $('#tab2').addClass('active');
            $('#cuti').removeClass('active');
            $('#izin').addClass('active');
            $('#a').removeClass('active');
            $('#b').addClass('active');
        }
    </script>  

    <script>
        $(document).ready(function() {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr('href');
                if (target === '#izin') {
                    // Panggil fungsi untuk mengambil data pada tab izin
                    getIzin();
                }
            });

            function getIzin()
            {
                $.ajax({
                url: '/izin',
                type: 'GET',
                success: function(response) {
                    var data = response.izin;
                    $('#datatable-responsive14').DataTable().clear().draw();
                    $('#datatable-responsive14').DataTable({
                        "data": data,
                        "columns": [
                            { "data": "id" },
                            { "data": "nama" },
                            { "data": "jenis_izin" },
                            { "data": "keperluan" },
                            { "data": "tgl_mulai" },
                            { "data": "tgl_selesai" },
                            { "data": "lama_izin" },
                            { "data": "name_status" },
                            { "data": "action" }
                        ],
                        "columnDefs": [
                            { "searchable": false, "orderable": false, "targets": 8 },
                            { "className": "text-center", "targets": [0, 6, 7, 8] },
                            { "width": "10%", "targets": [6] }
                        ],
                        "order": [[ 0, "desc" ]],
                        "language": {
                            "url": "/js/Indonesian.json"
                        },
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            }); 
            }
        });
    </script>
      
@endsection