@extends('layouts.default')
@section('content')
    <!-- Header -->

    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Rekrutmen</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Data Rekrutmen</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Close Header -->

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading  col-sm-15 m-b-10">
                            <a type="button" class="btn btn-sm btn-dark fa fa-user-plus " data-toggle="modal"
                                data-target="#myModal"> Tambah Rekrutmen </a>
                            <a href="#" id="share-button" type="button" class="btn btn-sm btn-dark fa fa-clone ">
                                Salin Link Form Rekruitmen </a>
                        </div>
                        @include('admin.rekruitmen.tambahLowonganModal')
                        <div class="panel-body">




                            <div class="row">

                                @foreach ($posisi as $k)
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="panel panel-primary text-center">

                                            {{-- <div class="panel-heading btn-success">
                                                <a href="show_rekrutmen{{ $k->id }}" class="panel-title ">
                                                    <h4 class="panel-title">{{ $k->status }}</h4>
                                                </a>
                                            </div> --}}

                                            @if ($k->status == 'Aktif')
                                                <div class="panel-heading btn-success">
                                                    <a href="show_rekrutmen{{ $k->id }}" class="panel-title ">
                                                        <h4 class="panel-title">{{ $k->status }}</h4>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="panel-heading btn-danger">
                                                    <a href="show_rekrutmen{{ $k->id }}" class="panel-title ">
                                                        <h4 class="panel-title">{{ $k->status }}</h4>
                                                    </a>
                                                </div>
                                            @endif


                                            <div class="panel-body">
                                                <h3 class=""><b>{{ $k->posisi }}</b></h3>
                                                <p class="text-muted"><b>Dibutuhkan {{ $k->jumlah_dibutuhkan }} Orang</b>
                                                </p>
                                            </div>
                                            {{-- <a href="/hapuslowongan{{ $k->id }}" type="button"
                                                class="btn btn-sm btn-danger fa fa-trash"> --}}
                                                
                                                <button onclick="hapus_karyawan({{ $k->id }})"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            {{-- <a href="{{ url('Form-Rekruitmen-RYNEST') }}">Apply</a> --}}
                            {{-- <a href="#" id="share-button">Salin Link Form Rekruitmen</a> --}}



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("share-button").addEventListener("click", function() {
            navigator.clipboard.writeText("{{ url('/Form-Rekruitmen-RYNEST') }}");
            alert("Link berhasil di salin");
        });
    </script>

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
                    location.href = '<?= 'http://localhost:8000/hapuslowongan' ?>' + id;
                }
            })
        }
    </script>
@endsection
