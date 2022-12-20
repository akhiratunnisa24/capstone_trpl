@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Rekap Absensi</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Human Resources Management System</a></li>
                    <li class="active">Data Absensi</li>
                </ol>
                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Close Header -->
    
    <!-- Filter Data -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <form class="" action="">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <div class="m-t-20">
                                    <div class="form-group">
                                        <label>Karyawan</label>

                                        <select name="id_karyawan" id="id_karyawan" class="form-control">
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
                            <div class="col-sm-2 col-xs-12">
                                <div class="m-t-20">
                                    <div class="form-group">
                                        <label>Bulan</label>
                                        <select name="bulan" id="bulan" class="col-md-3 form-control">
                                            <option value="">-- Pilih Bulan --</option>
                                            {{-- {{ ('01' === request()->bulan) ? 'selected' : '' }} --}}
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
                            <div class="col-sm-2 col-xs-12">
                                <div class="m-t-20">
                                    <div class="form-group">
                                        <label>Tahun</label>
                                        <select name="tahun" id="tahun" class="col-md-3 form-control">
                                            <option value="">-- Pilih Tahun --</option>
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
                            <div class="col-sm-2 col-xs-12">
                                <div class="" style="margin-top:26px">
                                    <div class="form-group">
                                        <label></label>
                                        <div>
                                            <button type="submit" class="btn btn-block btn-success waves-effect waves-light m-l-10">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                    <!-- end row -->
            </div>
        </div>
    </div>

    <!-- Start content -->
    @if (!empty($absensi)) 
        <div class="data" style="margin-left:15px;margin-bottom:10px">
            <a href="/rekapabsensiExcel" class="btn btn-dark">Export Excel</a>
            <a href="{{ route('rekapabsensipdf')}}" class="btn btn-dark">Download PDF</a>
        </div>
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Rekap Absensi Karyawan</h3>
                            </div>
                            <div class="panel-body m-b-5">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table id="datatable-responsive" class="table dt-responsive table-striped table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Karyawan</th>
                                                    <th>Tanggal</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Keluar</th>
                                                    <th>Jml Hadir</th>
                                                    <th>Telat</th>
                                                    <th>P. cepat</th>
                                                </tr>
                                            </thead>
                                            <tbody>    
                                                @forelse($absensi as $key => $d)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$d->karyawans->nama}}</td>
                                                        <td>{{\Carbon\Carbon::parse($d->tanggal)->format('d/m/Y')}}</td>
                                                        <td>{{$d->jam_masuk}}</td>
                                                        <td>{{$d->jam_keluar}}</td>
                                                        <td>{{$d->jam_kerja}}</td>
                                                        <td>{{$d->terlambat}}</td>
                                                        <td>{{$d->plg_cepat}}</td>
                                                    </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="12" class="text-center">Data Tidak Ditemukan</td>
                                                        </tr>
                                                @endforelse
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
    @endif
                   
    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    
    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>
    <script src="assets/js/app.js"></script>
@endsection