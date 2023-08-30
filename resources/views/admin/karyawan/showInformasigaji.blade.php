@extends('layouts.default')
@section('content')
    <!-- Header -->
    <style>
        .alert-info1
        {
            color: #000;
            background-color: rgba(24, 186, 226, 0.2); 
        }
    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title ">Informasi Gaji</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Informasi Gaji</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    @if ($informasigaji === null)
        @if(isset($alertMessage))
            <div class="alert alert-info1">
                {{ $alertMessage }}
                {{-- <a href="" class="btn btn-sm btn-primary"> Lengkapi Data Karyawan</a> --}}
            </div>
        @endif
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-secondary">
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-20 col-sm-20 col-xs-20">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="control-group after-add-more">
                                        <div class="panel-body">
                                                <div class="col-md-12">
                                                    <div class="col-md-6 m-t-10">
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Nama</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{$informasigaji ? $informasigaji->karyawans->nama : $karyawan->nama}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Tanggal Masuk</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{ \Carbon\carbon::parse($karyawan->tglmasuk)->format('d/m/Y') }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Tanggal Keluar</label>
                                                                <div class="col-sm-9">
                                                                    @if ($karyawan->tglkeluar)
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{ \Carbon\carbon::parse($karyawan->tglkeluar)->format('d/m/Y') }}" readonly>
                                                                    @else
                                                                    <input type="text" class="form-control" autocomplete="off" value="-" readonly>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Status Karyawan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{$karyawan->status_karyawan ? $karyawan->status_karyawan : 'Masukkan Status Karyawan'}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Gaji Pokok</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{ $karyawan->gaji ? number_format($karyawan->gaji, 0, ',', '.')  : 'Masukkan Gaji Pokok'}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <table class="table dt-responsive nowrap table-striped" cellpadding="0" style="margin: auto; width:500px; margin-bottom:15px;">
                                                            <thead style="background-color: #a1cee6;">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Benefit</th>
                                                                    <th>Nominal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if($detailstruktur !== NULL)
                                                                @foreach ($detailstruktur as $data)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $data->benefit->nama_benefit}}</td>
                                                                        @if($data->benefit->siklus_pembayaran === "Bulan")
                                                                            <td>Rp. {{ number_format($data->benefit->besaran_bulanan, 0, ',', '.') }}/{{$data->benefit->siklus_pembayaran}}</td>
                                                                        @elseif($data->benefit->siklus_pembayaran === "Minggu")
                                                                            <td>Rp. {{ number_format($data->benefit->besaran_mingguan, 0, ',', '.') }}/{{$data->benefit->siklus_pembayaran}}</td>
                                                                        @elseif($data->benefit->siklus_pembayaran === "Hari")
                                                                            <td>Rp. {{ number_format($data->benefit->besaran_harian, 0, ',', '.') }}/{{$data->benefit->siklus_pembayaran}}</td>
                                                                        @elseif($data->benefit->siklus_pembayaran === "Jam")
                                                                            <td>Rp. {{ number_format($data->benefit->besaran_jam, 0, ',', '.') }}/{{$data->benefit->siklus_pembayaran}}</td>
                                                                        @elseif($data->benefit->siklus_pembayaran === "THR")
                                                                            <td>Rp. {{ number_format($data->benefit->besaran, 0, ',', '.') }}/{{$data->benefit->siklus_pembayaran}}</td> 
                                                                        @elseif($data->benefit->siklus_pembayaran === "Bonus")
                                                                            <td>Rp. {{ number_format($data->benefit->besaran, 0, ',', '.') }}/{{$data->benefit->siklus_pembayaran}}</td> 
                                                                        @endif      
                                                                    </tr>
                                                                @endforeach
                                                                @endif
                                                            </tbody>
                        
                                                        </table>
                                                    </div>

                                                    <div class="col-md-6 m-t-10">
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label
                                                                    class="form-label col-sm-3 text-end">Departemen</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off"
                                                                    placeholder="" value="{{$karyawan->departemen->nama_departemen}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Jabatan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{$karyawan->nama_jabatan ? $karyawan->nama_jabatan : 'Masukkan Level Jabatan'}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Level Jabatan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" name="level_jabatan" id="level_jabatan" autocomplete="off"
                                                                    placeholder="Masukkan Level Jabatan" value="{{$karyawan->jabatan ? $karyawan->jabatan : 'Masukkan Level Jabatan'}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Struktur Gaji</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control" name="id_strukturgaji" id="id_strukturgaji" autocomplete="off"
                                                                        placeholder="Masukkan Struktur Gaji" value="{{ $struktur ? $struktur->nama : '' }}" readonly>
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    @if($informasigaji == null)
                                                                        <a class="btn btn-success" style="height:37px; width:65px;" title="Tambah Struktur Gaji" data-toggle="modal" data-target="#add"> <i class="fa fa-plus"></i></a>
                                                                    @else
                                                                        <a class="btn btn-info" style="height:37px; width:65px;" title="Edit Struktur Gaji" data-toggle="modal" data-target="#editD{{ $informasigaji->id }}"><i class="fa fa-edit"></i></a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>

                                
                                    <div class="modal-footer">
                                        @if($informasigaji !== NULL)
                                        <a href="" class="btn btn-success" type="button">Edit Informasi Gaji <i class="fa fa-money"></i></a>
                                        @endif
                                        <a class="btn btn-info"  title="Edit Data Karyawan" data-toggle="modal" data-target="#editDatakaryawan{{ $karyawan->id }}">Edit Data Karyawan <i class="fa fa-user"></i></a>
                                        <a href="karyawan" class="btn btn-danger" type="button">Kembali <i class="fa fa-home"></i></a>
                                    </div>
                                </form>
                                @include('admin.karyawan.editdatashowinformasi')
                                @include('admin.karyawan.tambahstruktur')
                                @include('admin.karyawan.editstruktur')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>


    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    @if (Session::has('pesan'))
        <script>
            swal("Selamat", "{{ Session::get('pesan') }}", 'success', {
                button: true,
                button: "OK",
            });
        </script>
    @endif

    @if (Session::has('pesa'))
        <script>
            swal("Mohon Maaf", "{{ Session::get('pesa') }}", 'error', {
                button: true,
                button: "OK",
            });
        </script>
    @endif
@endsection

