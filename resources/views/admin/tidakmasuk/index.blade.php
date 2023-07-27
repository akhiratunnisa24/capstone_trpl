@extends('layouts.default')
@section('content')
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Data Tidak Masuk Karyawan</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Human Resources Management System</a></li>
                    <li class="active">Data Tidak Masuk</li>
                </ol>
                <div class="clearfix"></div>
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
                                            <a href="{{ route('tidakmasuk.index') }}" class="btn btn-md btn-success fa fa-refresh"> Reset</a>
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
                        <div class="panel-heading  col-sm-15 m-b-10">
                            <a href="/absensi-tidak-masuk-excel" id="exportToExcel" class="btn btn-dark btn-sm fa fa-file-excel-o">  Export Excel</a>
                            <a href="/absensi-tidak-masuk-pdf"  id="exportToPdf" class="btn btn-dark btn-sm fa fa fa-file-pdf-o" target="_blank" > Export PDF</a>
                        </div>
                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable-responsive21" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Karyawan</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tidakmasuk as $data)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$data->nama}}</td>
                                                    <td>{{\Carbon\Carbon::parse($data->tanggal)->format('d/m/Y')}}</td>
                                                    <td>{{$data->status}}</td>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

    @if(Session::has('pesa'))
        <script>
            swal("Mohon Maaf","{{ Session::get('pesa')}}", 'error', {
                button:true,
                button:"OK",
            });
        </script>
    @endif
@endsection