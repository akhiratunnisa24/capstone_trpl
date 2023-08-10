@extends('layouts.default')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Setting Role Login</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employees Management System</li>
                    <li class="active">Admin</li>
                </ol>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading clearfix">
            {{-- <a type="button" class="btn btn-sm btn-dark fa fa-sign-in" data-toggle="modal" data-target="#myModal"> Tambah
                Role Login</a> --}}
        </div>
        @include('admin.datamaster.role.addRoleModal')

        <div class="panel-body m-b-5">
            <div class="row">
                <div class="col-md-20 col-sm-20 col-xs-20">
                    <table id="datatable-responsive19" class="table dt-responsive table-striped table-bordered"
                        width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->role }}</td>
                                    <td>
                                        <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                            <a class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#myModal{{ $data->id }}"><i class="fa fa-pencil"></i></a>

                                            {{-- <button onclick="hapus_karyawan({{ $data->id }})"
                                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
                                        </div>
                                    </td>

                                </tr>
                                {{-- modal show cuti --}}
                                @include('admin.datamaster.role.editRoleModal')
                            @endforeach
                        </tbody>
                    </table>
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
                    location.href = '<?= '/hapusrole' ?>' + id;
                }
            })
        }
    </script>
@endsection
