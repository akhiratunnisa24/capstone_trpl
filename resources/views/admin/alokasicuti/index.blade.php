@extends('layouts.default')
@section('content')
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <div class="col-sm-8">
                    <h4 class="pull-left page-title">Alokasi Cuti</h4>
                </div>
                <div align="right" class="col-sm-4">
                    <a href="/permintaan_cuti" class="btn btn-success btn-md">Kembali ke Cuti</a>
                    <a href="/settingalokasi" class="btn btn-success btn-md">Kembali ke Setting</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>    
    </div>
    
    @include('admin.alokasicuti.importexcel')

    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <a href="" class="btn btn-dark fa fa-plus" data-toggle="modal" data-target="#newalokasi"> Tambah Alokasi</a>
                            <a href="" class="btn btn-dark fa fa-cloud-download" data-toggle="modal" data-target="#ModalImport"> Import Excel</a>
                        </div>
                         {{-- form setting --}}
                         @include('admin.alokasicuti.addalokasi')

                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <table  id="datatable-responsive7" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                        <thead>
                                            <tr>
                                                {{-- <th>id</th> --}}
                                                <th>#</th>
                                                <th>Karyawan</th>
                                                <th>Kategori Cuti</th>
                                                <th>Durasi (Hari)</th>
                                                {{-- <th>Mode Alokasi</th> --}}
                                                {{-- <th>Tanggal Masuk</th>
                                                <th>Tanggal Sekarang</th> --}}
                                                <th>Aktif Dari</th>
                                                <th>Sampai</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
                                            @foreach($alokasicuti as $data)
                                                <tr id="aid{{$data->id}}"></tr>
                                                    {{-- <td>{{$data->id}}</td> --}}
                                                    <td>{{$data->id_karyawan}}</td>
                                                    <td>{{$data->karyawans->nama}}</td>
                                                    <td>{{$data->jeniscutis->jenis_cuti}}</td>
                                                    <td>{{$data->durasi}}</td>
                                                    {{-- <td>{{$data->mode_alokasi}}</td> --}}
                                                   {{-- jam mulai & jam selesai --}}
                                                    {{-- @if($data->tgl_masuk != null && $data->tgl_sekarang !=null)
                                                        <td>{{\Carbon\Carbon::parse($data->tgl_masuk)->format('d/m/Y')}}</td>
                                                        <td>{{\Carbon\Carbon::parse($data->tgl_sekarang)->format('d/m/Y')}}</td>
                                                    @else
                                                        <td></td>
                                                        <td></td>
                                                    @endif --}}
                                                    <td>{{\Carbon\Carbon::parse($data->aktif_dari)->format('d/m/Y')}}</td>
                                                    <td>{{\Carbon\Carbon::parse($data->sampai)->format('d/m/Y')}}</td>
                                                    <td class="text-center"> 
                                                        <div class="row">
                                                            <a id="bs" class="btn btn-info btn-sm showalokasi" data-toggle="modal" data-target="#showalokasi{{$data->id}}">
                                                                <i class="fa fa-eye"></i>
                                                            </a> 
                                                            <a class="btn btn-sm btn-success btn-editalokasi" data-toggle="modal" data-alokasi="{{$data->id}}" data-target="#editalokasi">
                                                                <i class="fa fa-edit"></i>
                                                                {{-- {{$data->id}} --}}
                                                            </a> 
                                                            <button onclick="hapus_alokasi({{$data->id}})"  class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </button> 
                                                        </div> 
                                                   </td> 
                                                </tr>
                                                 <!-- modals show -->
                                                @include('admin.alokasicuti.showalokasi')
                                                @include('admin.alokasicuti.editalokasi')
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
    </div> <!-- content -->
    
    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/app.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
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
