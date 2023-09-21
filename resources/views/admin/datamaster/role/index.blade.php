@extends('layouts.default')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Setting Role Login</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Admin</li>
                </ol>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        @if(Auth::user()->role !== 7)
            <div class="panel-heading clearfix">
                <a type="button" class="btn btn-sm btn-dark fa fa-sign-in pull-right" data-toggle="modal" data-target="#myModal"> Tambah
                    Role Login</a>
            </div>
            @include('admin.datamaster.role.addRoleModal')
        @else
            <div class="panel-heading clearfix" style="height:35px;">
            </div>
        @endif
        <div class="panel-body m-b-5">
            <div class="row">
                <div class="col-md-20 col-sm-20 col-xs-20">
                    <table id="datatable-responsive19" class="table dt-responsive table-striped table-bordered"
                        width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Role</th>
                                @if(Auth::user()->role !== 7)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->role }}</td>
                                    @if(Auth::user()->role !== 7)
                                        <td>
                                            <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                <a class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#myModal{{ $data->id }}"><i class="fa fa-pencil"></i></a>

                                                {{-- <button onclick="hapus_karyawan({{ $data->id }})"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                                {{-- modal show cuti --}}
                                @if(Auth::user()->role !== 7)
                                    @include('admin.datamaster.role.editRoleModal')
                                @endif
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
