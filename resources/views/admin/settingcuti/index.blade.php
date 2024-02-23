@extends('layouts.default')
@section('content')
<!-- Header -->
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">
            <h4 class="pull-left page-title">Setting Cuti tahunan</h4>

            <ol class="breadcrumb pull-right">
                <li>Rynest Employee Management System</li>
                <li class="active">Setting Cuti Tahunan</li>
            </ol>

            <div class="clearfix"></div>
        </div>
    </div>

<!-- Start content -->
    @php
        $currentDate = date('Y-m-d');
        $lastWeekDecember = date('Y-12-25', strtotime('-1 week'));

        // Jika saat ini berada dalam satu minggu terakhir di bulan Desember, tombol akan ditampilkan
        $showButton = ($currentDate >= $lastWeekDecember);
    @endphp
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading clearfix" style="height:45px">
                            @if(date('m') == 4 && date('d') == 1)
                                <form action="/reset-cuti-tahun-ini" method="POST" align="center">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-dark btn-sm fa fa-refresh pull-right"> Kosongkan Sisa Cuti Tahun Lalu</button>
                                </form>
                            @elseif($showButton)
                                <form action="/reset-cuti-tahunan" method="POST" align="center">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-dark btn-sm fa fa-refresh pull-right"> Reset Cuti Tahunan</button>
                                </form>
                            @else
                            @endif

                        </div>

                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable-responsive11" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Karyawan</th>
                                                <th>kategori Cuti</th>
                                                <th>Jumlah Cuti Tahun Ini</th>
                                                <th>Sisa Cuti Tahun Lalu</th>
                                                <th>Periode</th>
                                                {{-- <th>Aksi</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($settingcuti as $item)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->karyawans->nama}}</td>
                                                    <td>{{$item->jeniscutis->jenis_cuti}}</td>
                                                    <td>{{$item->jumlah_cuti}}</td>
                                                    <td>{{$item->sisa_cuti}}</td>
                                                    <td>{{$item->periode}}</td>
                                                                {{--<td class="text-center">
                                                                    <a id="bs" class="btn btn-info btn-sm Modalshowsetting"
                                                                        data-toggle="modal" data-target="#Modalshowsetting{{$data->id}}">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a> --}}
                                                                    {{-- <a id="bs" class="btn btn-sm btn-success editsetting"
                                                                        data-toggle="modal" data-target="#editsetting{{$data->id}}">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a> --}}
                                                                    {{-- <button onclick="settingalokasi({{$data->id}})"
                                                                        class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr> --}}
                                                        {{-- modals show setting --}}
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
        </div> <!-- content -->
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"></script>
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
@endsection
