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
                <li>Rynest Employees Management System</li>
                <li class="active">Master Alokasi Cuti</li>
            </ol>
           
            <div class="clearfix"></div>
        </div>
    </div>
<!-- Start content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <a href="" class="btn btn-dark btn-sm fa fa-cloud-download pull-left" data-toggle="modal" data-target="#ModalImport"> Import Excel</a>
                    </div>
                    @include('admin.alokasicuti.importexcel')
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
                                            <th>Kategori Cuti</th>
                                            <th>Saldo Hak Cuti</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($alokasicuti as $data)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$data->nik}}</td>
                                            <td>{{$data->karyawans->nama}}</td>
                                            <td>{{$data->jabatan}}</td>
                                            <td>{{$data->jeniscutis->jenis_cuti}}</td>
                                            <td>{{$data->durasi}}</td>
                                            <td class="text-center">
                                                <div class="row">
                                                    <a id="bs" class="btn btn-info btn-sm showalokasi" data-toggle="modal"
                                                        data-target="#showalokasi{{$data->id}}"><i class="fa fa-eye"></i>
                                                    </a>
                        
                                                </div>
                                            </td>
                                        </tr>
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
    </div> <!-- content -->
</div>

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    {{-- <script src="assets/js/app.js"></script> --}}
    
    <!-- sweet alert -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

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
                       location.href = '<?='/deletealokasi' ?>'+id;
                   }
               })
           }
    </script>
@endsection