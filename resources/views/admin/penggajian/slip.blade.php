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
                <h4 class="pull-left page-title ">Slip Gaji Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Slip Gaji</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
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
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{$slipgaji->karyawans->nama}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Tanggal Masuk</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{ \Carbon\carbon::parse($slipgaji->karyawans->tglmasuk)->format('d/m/Y') }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Status Karyawan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{$slipgaji->karyawans->status_karyawan}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Gaji Pokok</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{ number_format($slipgaji->gaji_pokok, 0, ',', '.')}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 m-t-10">
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label
                                                                    class="form-label col-sm-3 text-end">Departemen</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off"
                                                                    placeholder="" value="{{$slipgaji->karyawans->departemen->nama_departemen}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Jabatan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{$slipgaji->karyawans->nama_jabatan ? $slipgaji->karyawans->nama_jabatan : ''}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Level Jabatan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" name="level_jabatan" id="level_jabatan" autocomplete="off"
                                                                    placeholder="Masukkan Level Jabatan" value="{{$slipgaji->karyawans->jabatan ? $slipgaji->karyawans->jabatan : ''}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md">
                                                            <div class="row">
                                                               
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table dt-responsive nowrap table-striped" cellpadding="0" style="margin: auto; width:500px; margin-bottom:15px;">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Komponen</th>
                                                                <th>Jumlah Hari</th>
                                                                <th>Akumulasi Kehadiran</th>
                                                            </tr>
                                                        </thead>
                                                    
                                                        <tbody>
                                                            @if($kehadiran!== NULL)
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>Kehadiran</td>
                                                                    <td>{{ $kehadiran->jumlah_hadir }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>Lembur</td>
                                                                    <td>{{ $kehadiran->jumlah_lembur }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>Cuti</td>
                                                                    <td>{{ $kehadiran->jumlah_cuti }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>4</td>
                                                                    <td>Sakit</td>
                                                                    <td>{{ $kehadiran->jumlah_sakit }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>5</td>
                                                                    <td>Izin</td>
                                                                    <td>{{ $kehadiran->jumlah_izin }}</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                    
                                                    </table>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <a href="karyawan" class="btn btn-danger" type="button">Kembali <i class="fa fa-home"></i></a>
                                    </div>
                                </form>
                              
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

