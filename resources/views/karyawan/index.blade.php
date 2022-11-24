@extends('layouts.default')
@section('content')

           
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
                        <a href="karyawancreate" type="button" class="btn btn-sm btn-dark " >Tambah Karyawan</a>
                    </div>
                    @include('karyawan.addModal')
                    <div class="panel-body">
                        <table id="datatable" class="table table-striped table-bordered ">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>L / P</th>
                                    <th>Alamat</th>
                                    <th>Status Karyawan</th>
                                    <th>Tipe Karyawan</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Action</th>

                                    <?php $no = 1 ?>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($karyawan as $k)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$k->nama}}</td>
                                    <td>{{$k->tgllahir}}</td>
                                    <td>{{$k->jenis_kelamin}}</td>
                                    <td>{{$k->alamat}}</td>
                                    <td>{{$k->status_karyawan}}</td>
                                    <td>{{$k->tipe_karyawan}}</td>
                                    <td>{{$k->tglmasuk}}</td>
                                    <td>
                                        <div class="d-grid gap-2 " role="group" aria-label="Basic example">

                                            <a href="karyawanshow{{$k->id}}" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye"></i></a>
                                             
                                            <button onclick="hapus_karyawan({{$k->id}})"  class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                            </button>
                                            
                                                    <button class="btn btn-default waves-effect waves-light" id="sa-success">Click me</button>
                                                
                                    </td>               
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



<script>
function hapus_karyawan(id){
    swal.fire({
            title: "Apakah anda yakin ?",
            text: "Data yang sudah terhapus tidak dapat dikembalikan kembali.",
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
                location.href = '<?= "http://localhost:8000/karyawan/destroy/" ?>' + id;
            }
            })
        }
</script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
        </script>
        <!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>


<?php if(@$_SESSION['sukses']){ ?>
        <script>
            swal.fire("Good job!", "<?php echo $_SESSION['sukses']; ?>", "success");
        </script>
    <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
    
    <?php unset($_SESSION['sukses']); } ?>
    


@endsection