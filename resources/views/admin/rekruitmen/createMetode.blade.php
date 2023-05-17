@extends('layouts.default')
@section('content')
    <!-- Header -->

    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Data Metode Rekruitmen</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Data Metode Rekruitmen</li>
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
                            {{-- <a type="button" class="btn btn-sm btn-dark fa fa-plus" data-toggle="modal"
                                data-target="#myModal"> Tambah
                                Metode Rekruitmen</a> --}}
                        </div>
                        @include('admin.rekruitmen.tambahMetodeModal')
                        <div class="panel-body">
                            <table id="datatable-responsive6"
                                class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0"
                                width="100%">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tahapan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($metode as $k)
                                            @if ($k->id == '18')

                                            @else
                                        <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $k->nama_tahapan }}</td>
                                                <td>
                                            <div >

                                                {{-- @if ($k->id == '6') --}}
                                                    {{-- @elseif($k->id == '1') --}}
                                                {{-- @else --}}
                                                    <a class="btn btn-sm btn-success btn-editalokasi" data-toggle="modal"
                                                        data-target="#editmetode{{ $k->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                {{-- @endif --}}

                                                {{-- <a class="btn btn-sm btn-success btn-editalokasi" data-toggle="modal"
                                                    data-alokasi="{{$data->id}}" data-target="#editalokasi">
                                                    <i class="fa fa-edit"></i> --}}


                                                {{-- <button onclick="hapus_karyawan({{ $k->id }})"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button> --}}
                                            </div>
                                            <!-- <button class="btn btn-default waves-effect waves-light" id="sa-success">Click me</button> -->
                                            </td>
                                            @endif

                                        </tr>
                                        @include('admin.rekruitmen.editMetodeModal')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script>
        function hapus_karyawan(id) {
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
                        title: "Terhapus!",
                        text: "Data berhasil di hapus..",
                        icon: "success",
                        confirmButtonColor: '#3085d6',
                    })
                    location.href = '<?= 'metode_rekrutmen_destroy' ?>' + id;
                }
            })
        }
    </script>
@endsection
