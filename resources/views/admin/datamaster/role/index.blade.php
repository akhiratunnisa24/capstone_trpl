@extends('layouts.default')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Setting Role Login</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Admin</li>
                </ol>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading clearfix">
            <a href="#" id="exportToExcel" class="btn btn-dark btn-sm fa fa-file-excel-o"> Tambah Role Login</a>
        </div>


        <div class="panel-body m-b-5">
            <div class="row">
                <div class="col-md-20 col-sm-20 col-xs-20">
                    <table id="datatable-responsive3" class="table dt-responsive table-striped table-bordered"
                        width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Status Akun</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->role }}</td>
                                    <td>
                                        @if ($data->status_akun = 1)
                                           <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>{{ $data->email }}</td>
                                    <td>
                                        <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                            <a class="btn btn-info btn-sm" data-toggle="modal"
                                data-target="#myModal{{ $data->id }}"><i
                                                    class="fa fa-pencil"></i></a>

                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td>

                                </tr>
                                {{-- modal show cuti --}}
                                @include('admin.datamaster.user.editPasswordModal')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
