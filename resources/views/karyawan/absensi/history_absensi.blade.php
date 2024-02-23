@extends('layouts.default')
@section('content')
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

<!-- Header -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">
            <h4 class="pull-left page-title">Riwayat Absensi Anda</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Rynest Employee Management System</a></li>
                <li class="active">Riwayat Absensi</li>
            </ol>
            <div class="clearfix"></div>
            <div class="panel-body">
                <form class="" action="">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
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
                        <div class="col-sm-4 col-xs-12">
                            <div class="m-t-20">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select name="tahun" id="tahun" class="col-md-3 form-control selectpicker" data-live-search="true" required>
                                        <option value="">-- Pilih Tahun --</option>
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
                                        <a href="{{ route('riwayat.absen') }}" class="btn btn-md btn-success fa fa-refresh"> Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <a href="/export-absensi" id="exportToExcel" class="btn btn-dark btn-sm fa fa-file-excel-o">  Ekspor Excel</a>
                        <a href="/export-absensi-pdf"  id="exportToPdf" class="btn btn-dark btn-sm fa fa fa-file-pdf-o"> Ekspor PDF</a>
                    </div>
                    <div class="panel-body m-b-5">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="datatable-responsive8" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Keluar</th>
                                            <th>Durasi</th>
                                            <th>Telat</th>
                                            <th>P. cepat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($absensi as $data)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$data->karyawans->nama}}</td>
                                                <td>{{\Carbon\Carbon::parse($data->tanggal)->format('d/m/Y')}}</td>
                                                <td>{{$data->jam_masuk}}</td>
                                                <td>{{$data->jam_keluar}}</td>
                                                {{-- @if(isset($data->jam_kerja)) --}}
                                                    <td>{{$data->jam_kerja}}</td>
                                                {{-- @endif --}}
                                                <td>{{$data->terlambat}}</td>
                                                <td>{{$data->plg_cepat}}</td>
                                            </tr>
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

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>
<!-- Datatable init js -->
<script src="assets/pages/datatables.init.js"></script>
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
{{-- <script src="assets/js/app.js"></script> --}}
@endsection
