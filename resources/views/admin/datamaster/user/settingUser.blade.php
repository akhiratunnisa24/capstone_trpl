@extends('layouts.default')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Setting User</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Admin</li>
                </ol>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading clearfix" style="height:35px;">
            {{-- <a href="/rekapcutiExcel" id="exportToExcel" class="btn btn-dark btn-sm fa fa-file-excel-o"> Export Excel</a> --}}
        </div>

        <!-- modal tambah akun -->
        {{-- @include('admin.cuti.addcuti') --}}

        <div class="panel-body m-b-5">
            <div class="row">
                <div class="col-md-20 col-sm-20 col-xs-20">
                    <table id="datatable-responsive20" class="table dt-responsive table-striped table-bordered"
                        width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Status Akun</th>
                                <th>Email</th>
                                @if(Auth::user()->role == 5)
                                    <th>Partner</th>
                                @endif
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->roles->role}}</td>
                                    <td>
                                        @if ($data->status_akun = 1)
                                           <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>{{ $data->email }}</td>
                                    @if(Auth::user()->role == 5)
                                        <td>{{ $data->partner }}</td>
                                    @endif
                                    {{-- <td>{{ $data->password }}</td> --}}
                                    <td>
                                        <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                            <a class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#myModal{{ $data->id }}"><i
                                                    class="fa fa-pencil"></i></a>

                                            {{-- <button  onclick="hapus_karyawan({{ $data->id }})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
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
    @if(Session::has('status'))
        <script>
            swal("Selamat","{{ Session::get('status')}}", 'success', {
                button:true,
                button:"OK",
            });
        </script>
    @endif

    @if(Session::has('success'))
        <script>
            swal("Selamat","{{ Session::get('success')}}", 'success', {
                button:true,
                button:"OK",
            });
        </script>
    @endif

    @if(Session::has('error'))
        <script>
            swal("Mohon Maaf","{{ Session::get('error')}}", 'error', {
                button:true,
                button:"OK",
            });
        </script>
    @endif

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
                    location.href = '<?= '/hapususer' ?>' + id;
                }
            })
        }
    </script>

@endsection
