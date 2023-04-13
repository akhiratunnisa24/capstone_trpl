@extends('layouts.default')
@section('content')
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
<!-- Header -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">
            <h4 class="pull-left page-title">Master Alokasi Cuti Karyawan</h4>
            
            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Master Alokasi Cuti Karyawan</li>
            </ol>
           
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- Start content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <a><label></label></a>
                        <a href="" class="btn btn-dark btn-sm fa fa-cloud-download pull-left" data-toggle="modal" data-target="#ModalImport"> Import Excel</a>
                        {{-- <a href="" class="btn btn-primary fa fa-plus pull-right" data-toggle="modal" data-target="#newalokasi"> Tambah
                            Alokasi</a> --}}
                    </div>
                    {{-- modals --}}
                    @include('admin.alokasicuti.addalokasi')
                    @include('admin.alokasicuti.importexcel')
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <div class="panel-body m-b-5">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="datatable-responsive24" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Departemen</th>
                                            <th>Jenis Cuti</th>
                                            {{-- <th>Tanggal Mulai Kerja</th>
                                            <th>Jatuh Tempo Pengambilan Hak Cuti</th>
                                            <th>Jumlah Hak Cuti 2023</th>
                                            <th>Cuti Dimuka 2023</th>
                                            <th>Cuti Minus 2023</th>
                                            <th>Cuti Bersama 2023</th>
                                            <th>Saldo Hak Cuti 2023</th>
                                            <th>Keterangan</th>  --}}
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($alokasicuti as $data)
                                        <tr id="aid{{$data->id}}"></tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->nik}}</td>
                                        <td>{{$data->karyawans->nama}}</td>
                                        <td>{{$data->jabatan}}</td>
                                        <td>{{$data->departemens->nama_departemen}}</td>
                                        <td>{{$data->jeniscutis->jenis_cuti}}</td>
                                        {{-- <td>{{$data->tgl_masuk}}</td>
                                        <td>{{\Carbon\Carbon::parse($data->jatuhtempo_awal)->format('d/m/Y')}} s.d {{\Carbon\Carbon::parse($data->jatuhtempo_akhir)->format('d/m/Y')}}</td>
                                        <td>{{$data->jmlhakcuti}}</td>
                                        <td>{{$data->cutidimuka}}</td>
                                        <td>{{$data->cutiminus}}</td>
                                        <td>{{$data->jmlcutibersama}}</td>
                                        <td>{{$data->durasi}}</td>
                                        <td>{{$data->keterangan}}</td> --}}
                                        {{-- <td>{{\Carbon\Carbon::parse($data->aktif_dari)->format('d/m/Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($data->sampai)->format('d/m/Y')}}</td> --}}
                                        {{-- <td>{{$data->status_durasialokasi}}</td> --}}
                                        <td class="text-center">
                                            <div class="row">
                                                <a id="bs" class="btn btn-info btn-sm showalokasi" data-toggle="modal"
                                                    data-target="#showalokasi{{$data->id}}"><i class="fa fa-eye"></i>
                                                </a>
                                                {{-- <a class="btn btn-sm btn-success btn-editalokasi" data-toggle="modal"
                                                    data-alokasi="{{$data->id}}" data-target="#editalokasi{{$data->id}} ">
                                                    <i class="fa fa-edit"></i>
                                                </a> --}}
                                                {{-- <button onclick="hapus_alokasi({{$data->id}})"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button> --}}
                                            </div>
                                        </td>
                                        </tr>
                                        <!-- modals show -->
                                     
                                        {{-- @include('admin.alokasicuti.editalokasi') --}}
                                        @endforeach
                                    </tbody>
                                </table>
                                @foreach($alokasicuti as $data)
                                 @include('admin.alokasicuti.showalokasi')
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- content -->

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
{{-- <script src="assets/pages/datatables.init.js"></script> --}}

{{-- <script src="assets/js/app.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
</script>

<!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

{{-- Direct halaman tambah data --}}
<script type="text/javascript">
    function hapus_alokasi(id){
           swal.fire({
               title:"Apakah anda yakin?",
               text: "Data yang sudah terhapus tidak dapat dikembalikan kembali",
               icon: "warning",
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: "Ya, hapus!",
               closeOnConfirm: false
           }).then((result) => {
               if (result.isConfirmed) {
                   swal.fire({
                       title : "Terhapus!",
                       text: "Data berhasil di hapus..",
                       icon: "success",
                       confirmButtonColor: '#3085d6',
                   })
                   location.href = '<?= "http://localhost:8000/deletealokasi" ?>'+id;
               }
           })
       }
</script>

<?php if(@$_SESSION['sukses']){ ?>
<script>
    swal.fire("Good job!", "<?php echo $_SESSION['sukses']; ?>", "success");
</script>
<!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->

<?php unset($_SESSION['sukses']); } ?>
@endsection