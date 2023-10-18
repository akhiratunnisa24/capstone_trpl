@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Master List Mesin</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Master List Mesin</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Close Header -->

    <!-- Start content -->
    <?php session_start(); ?>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading  clearfix">
                            <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                data-target="#AddMesin"> Tambah Data List Mesin</a>
                        </div>
                        @include('superadmin.listmesin.add')
                        <div class="panel-body">
                            <table id="datatable-responsive42" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>IP Mesin</th>
                                        <th>Port</th>
                                        <th>Comm Key</th>
                                        <th>Partner</th>
                                        <th>Status</th>
                                        <th style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($listmesin as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->ip_mesin }}</td>
                                            <td>{{ $data->port}}</td>
                                            <td>{{ $data->comm_key }}</td>
                                            <td>{{ $data->partners->nama_partner}}</td>

                                            <td>
                                                @if ($data->status == 1)
                                                   <span class="badge badge-success">Sukses</span>
                                                @else
                                                    <span class="badge badge-danger">Idle</span>
                                                @endif
                                            </td>
                                            <td class="">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="" class="btn btn-success btn-sm editmesin" data-toggle="modal"
                                                        data-target="#editMesin{{ $data->id }}"><i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('listmesin.tarikdata', ['id' => $data->id]) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-dark btn-sm">GA</button>
                                                    </form>

                                                    <form action="{{ route('listmesin.getuser', ['id' => $data->id]) }}" method="POST">
                                                        @csrf
                                                        <button id="getUserButton" type="submit" class="btn btn-warning btn-sm">GU</button>
                                                    </form>
                                                    
                                                    <form action="{{ route('connect', ['id' => $data->id]) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm">CN</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('superadmin.listmesin.edit')
                                    @endforeach
                                </tbody>
                            </table>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function () {
            const getUserButton = document.getElementById("getUserButton");
            const userTable = document.getElementById("userTable");
    
            getUserButton.addEventListener("click", function () {
                userTable.style.display = "block"; // Tampilkan tabel saat tombol diklik
            });
        });
    </script> --}}

    {{-- <script>
        $(document).ready(function() {
            $('#getUserButton').click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/list-mesin/daftar-user/{id}') }}", // Rute untuk pemrosesan data
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                    },
                    success: function(response) {
                        // Tampilkan respons dari server pada elemen dengan id "resultContainer"
                        $('.modal-body').html(data);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
                $('#userModal').modal('show');
            });
        });
    </script>  --}}
  
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

    <script>
        function hapus(id) {
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
                        title: "Mohon Menunggu",
                        text: "Data List Mesin sedang diperiksa.",
                        icon: "info",
                        confirmButtonColor: '#3085d6',
                    })
                    location.href = '<?= '/List Mesin/delete' ?>' + id;
                    // location.href = '<?= 'http://localhost:8000/List Mesin/delete' ?>' + id;
                }
            })
        }
    </script>
@endsection
