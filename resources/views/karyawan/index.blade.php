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

                        <a href="karyawancreate" type="button" class="btn btn-sm btn-dark " >Tambah Data Karyawan</a>
                        <a type="button" class="btn btn-sm btn-dark " data-toggle="modal" data-target="#myModal" >Buat Akun Karyawan</a>
                        <a href="" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#Modal2">Import Excel</a>
                        {{-- <a type="button" class="btn btn-sm btn-dark " href="{{ route('register') }}" >Buat Akun Karyawan</a> --}}
                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_menu">Add Staff</button> -->
                        <!-- <a href="{ route('register') }}" type="button" class="btn btn-sm btn-dark " >Buat Akun Karyawan</a> -->
                    </div>
                    @include('karyawan.addAkunModal')
                    <div class="panel-body">
                        <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>L / P</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
                                    <th>Agama</th>
                                    <th>Departemen</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($karyawan as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->nama}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y')}}</td>
                                        <td>{{$k->jenis_kelamin}}</td>
                                        <td>{{$k->alamat}}</td>
                                        <td>{{$k->email}}</td>
                                        <td>{{$k->agama}}</td>
                                        <td>{{$k->divisi}}</td>
                                        <td>
                                            <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                <a href="karyawanshow{{$k->id}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                <button onclick="hapus_karyawan({{$k->id}})"  class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                                        <!-- <button class="btn btn-default waves-effect waves-light" id="sa-success">Click me</button> -->
                                        </td>               
                                    
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

{{-- Modal Import Data Excel --}}
    <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Import Excel</h4>
                </div>
                <form action="/import_excel" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-lg-5">
                                <input type="file" name="file" required>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import Data</button>
                    </div>
                </form>
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