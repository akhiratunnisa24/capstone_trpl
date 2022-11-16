@extends('layouts.default')
@section('content')

<!-- Sweet Alert -->
<link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">

<!-- Header -->
<div class="row">
    <div class="col-sm-12">

        <div class="page-header-title">
            <h4 class="pull-left page-title">Data Karyawan</h4>

            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Data Karyawan</li>
            </ol>

            <div class="clearfix">
            </div>
        </div>
    </div>
</div>
<!-- Close Header -->

<!-- Start right Content here -->
<!-- Start content -->
<?php session_start(); ?>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading  col-sm-15 m-b-10">

                        <a href="#" type="button" class="btn btn-sm btn-dark " data-toggle="modal" data-target="#myModal">Tambah Karyawan</a>

                    </div>

                    @include('karyawan.addModal')

                    <div class="panel-body">
                        <table id="datatable" class="table table-striped table-bordered ">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Email</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>No. Handphone</th>
                                    <th>Status Karyawan</th>
                                    <th>Tipe Karyawan</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Action</th>

                                    <?php $no = 1 ?>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($karyawan as $k)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$k->nik}}</td>
                                    <td>{{$k->nama}}</td>
                                    <td>{{$k->tgllahir}}</td>
                                    <td>{{$k->email}}</td>
                                    <td>{{$k->jenis_kelamin}}</td>
                                    <td>{{$k->alamat}}</td>
                                    <td>{{$k->no_hp}}</td>
                                    <td>{{$k->status_karyawan}}</td>
                                    <td>{{$k->tipe_karyawan}}</td>
                                    <td>{{$k->tglmasuk}}</td>
                                    <td>{{$k->tglkeluar}}</td>
                                    <td>



                                        <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                            <form action="karyawan/destroy/{{$k->id}}" method="POST">

                                            <a href="karyawanshow{{$k->id}}" class="btn btn-info btn-sm">
                                            <!-- <a href="{{url('/karyawanshow'.$k->id)}}" class="btn btn-info btn-sm"> -->
                                                <i class="fa fa-eye"></i>

                                                <a class="btn btn-success btn-sm" href="#" type="button" data-toggle="modal" data-target="#myModal2{{ $k->id }}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                @csrf
                                                @method ('delete')

                                                <!-- <button id="btn_hapus_karyawan" onclick="hapus_karyawan({{$k->id}})" type="button" class="btn btn-danger btn-sm"> -->
                                                <button onclick="return confirm('Anda yakin mau menghapus item ini ?')" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                
                                                
                                            </form>

                                            <!-- <a data-id="{{$k->id}}" class="btn btn-sm btn-danger alert_notif">Hapus</a>
                                            <button  class="btn btn-danger btn-sm alert_notif">
                                                    <i class="fa fa-trash"></i>
                                                </button> -->
                                                
                                    </td>
                                    <!-- MODAL BEGIN -->


                                    @include('karyawan.editModal')
                    </div>
                </div>
                </tr>
                @endforeach

                </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
</div>




<!-- Sweet-Alert  -->
<?php if(@$_SESSION['sukses']){ ?>
            <script>
                Swal.fire({            
                    icon: 'success',                   
                    title: 'Sukses',    
                    text: 'data berhasil dihapus',                        
                    timer: 3000,                                
                    showConfirmButton: false
                })
            </script>
        <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
        <?php unset($_SESSION['sukses']); } ?>
    
    
        <!-- di bawah ini adalah script untuk konfirmasi hapus data dengan sweet alert  -->
        <script>
            function hapus_karyawan(id_karyawan){
                Swal.fire({
                    title: "Yakin hapus data?",            
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: "Batal"
                
                }).then(result => {
                    //jika klik ya maka arahkan ke proses.php
                    if(result.isConfirmed){
                        location.href = '<?php echo "http://localhost:8000/karyawan/destroy/" ?>' + id_karyawan
                    }
                })
                return false;
            }
            // $('#btn_hapus_karyawan').on('click',function(){
            //     var getLink = $(this).attr('data-id');
                
            // });
        </script>
<script>
   

function konfirmasi(){
Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
  }
})

}


</script>
<script src="assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
<script src="assets/pages/sweet-alert.init.js"></script>
@endsection