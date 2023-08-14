@extends('layouts.default')
@section('content')
    <!-- Header -->

    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Rekrutmen</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
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
                            <a id="share-button" type="button" class="btn btn-sm btn-dark fa fa-clone ">
                                Salin Link Form Rekruitmen </a>
                        </div>
                        @include('admin.rekruitmen.tambahLowonganModal')

                        <div class="panel-body">
                            <div class="row">

                                @foreach ($posisi as $k)
                                    <div class="col-sm-3">
                                        {{-- <div class="col-sm-3"> --}}
                                        <div class="panel panel-primary panel-rekruitmen"
                                            style="width: 240px; height: 280px;">

                                            @if ($k->status == 'Aktif' && $k->tgl_selesai > Carbon\Carbon::now() && $k->jumlah_dibutuhkan > 0)
                                                <div class="panel-heading btn-success">
                                                    <a href="show_rekrutmen{{ $k->id }}" class="panel-title ">
                                                        <h4 class="panel-title">{{ $k->status }}</h4>
                                                    </a>
                                                @else
                                                    <div class="panel-heading btn-danger">
                                                        <a href="show_rekrutmen{{ $k->id }}" class="panel-title ">
                                                            <h4 class="panel-title">Tidak Aktif</h4>
                                                        </a>
                                            @endif

                                        </div>

                                        <div class="panel-rekruitmen" style="width: 190px; height: 64px; margin-left:10px">
                                            <h4><b>
                                                    @if (strlen($k->posisi) > 30)
                                                        {!! nl2br(e(substr($k->posisi, 0, 30) . '...')) !!}
                                                    @else
                                                        {!! nl2br(e($k->posisi)) !!}
                                                        <br> <!-- Add <br> tag if $k->posisi is one line -->
                                                    @endif
                                                </b></h4>
                                        </div>
                                        <div class="panel-body">
                                            <p class="text-muted"><b>Dibutuhkan {{ $k->jumlah_dibutuhkan }} Orang</b></p>
                                            @if ($k->tgl_selesai < Carbon\Carbon::now())
                                                <p class="text-muted">
                                                    <b>Lowongan sudah kadaluarsa sejak tanggal<br>
                                                        <span class="text-danger">
                                                            {{ Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y') }}</span></b>
                                                </p>
                                            @elseif ($k->jumlah_dibutuhkan == 0)
                                                <p class="text-danger"><b>Lowongan sudah terisi</b></p>
                                            @endif
                                        </div>
                                        <div class="panel-footer-rekruitmen" style="padding:10px">
                                            <button onclick="hapus_karyawan({{ $k->id }})"
                                                class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash" hidden></i>
                                            </button>
                                            <button data-toggle="modal" data-target="#myModal{{ $k->id }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fa fa-pencil" hidden></i>
                                            </button>
                                        </div>
                                    </div>
                            </div>
                            @include('admin.rekruitmen.editLowonganModal')
                            @endforeach
                        </div>
                        {{-- <a href="{{ url('Form-Rekruitmen-RYNEST') }}">Apply</a> --}}
                        {{-- <a href="#" id="share-button">Salin Link Form Rekruitmen</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-sm-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .panel-footer-rekruitmen {
            /* background: #fafafa; */
            border-top: 0;
            position: absolute;
            bottom: 0;

        }

        .panel-rekruitmen {
            padding: 10px;
            float: left;
            margin-right: 10px;
            margin-bottom: 10px;
            -moz-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.1);
            -webkit-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.1);
            border-radius: 0px;
            border: none;
            box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0);
        }
    </style>


    <script>
        document.getElementById("share-button").addEventListener("click", function() {
            @if (auth()->user()->partner == 2)
                var url = "{{ route('Form-Rekruitmen-RTI') }}";
                var partnerName = "Rynest Technology Indomedia";
            @elseif (auth()->user()->partner == 1)
                var url = "{{ route('Form-Rekruitmen-GRM') }}";
                var partnerName = "Global Risk Management";
            @elseif (auth()->user()->partner == 3)
                var url = "{{ route('Form-Rekruitmen-RFT') }}";
                var partnerName = "RFT";
            @elseif (auth()->user()->partner == 4)
                var url = "{{ route('Form-Rekruitmen-QST') }}";
                var partnerName = "Qonstanta";
            @endif

            navigator.clipboard.writeText(url);
            alert("Link untuk form Rekruitmen " + partnerName + " berhasil disalin.");
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
                    // location.href = '<?= 'http://localhost:8000/hapuslowongan' ?>' + id;
                    // location.href = '<?= 'http://dev.rynest-technology.com/hapuslowongan' ?>' + id;
                    location.href = '<?= '/hapuslowongan' ?>' + id;

                }
            })
        }
    </script>
@endsection
