@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Tindak Lanjut Ketidakhadiran Karyawan</h4>
                    <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Tindak Lanjut Ketidakhadiran Karyawan</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Header -->
    @if(isset($potonguangmakan))
        {{-- @php dd($potonguangmakan); @endphp --}}
        <div class="content" id="">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading  col-sm-15">
                                <h5  class="text-white">Sanksi Potong Uang Makan</h5>
                            </div>
                            <div class="panel-body" >
                                <table id="datatable-responsive19" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Karyawan</th>
                                            <th>Jumlah Tidak Masuk</th>
                                            <th>Status</th>
                                            <th>Sanksi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @foreach($potonguangmakan as $item)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item->nama}}</td>
                                                <td>{{$item->jumlah}} kali</td>
                                                <td>{{$item->keterangan}}</td>
                                                <td>{{$item->sanksi}}</td>
                                                <td class="text-center">
                                                    <a href="/show-detail{{$item->id_pegawai}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(isset($potongtransport))
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading  col-sm-15">
                            <h5 class="text-white">Sanksi Potong Uang Transportasi</h5>
                            </div>
                            <div class="panel-body" >
                                <table id="datatable-responsive20" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Karyawan</th>
                                            <th>Jumlah Tidak Masuk</th>
                                            <th>Status</th>
                                            <th>Sanksi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
                                        @foreach($potongtransport as $item)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item->nama}}</td>
                                                <td>{{$item->jumlah}} kali</td>
                                                <td>{{$item->keterangan}}</td>
                                                <td>{{$item->sanksi}}</td>
                                                <td class="text-center">
                                                    <a href="/show-detail{{$item->id_pegawai}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
    @endif

    <a href="/" class="btn btn-sm btn-danger pull-right" style="margin-right:15px;">Kembali <i class="fa fa-home"></i></a>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('#formCreateDatakeluarga').prop('hidden', false);
            $('#showcuti').prop('hidden',true);
            $(document).on('click', '#editKeluarga', function() {
                // Menampilkan form update data dan menyembunyikan form create data
                $('#formCreateDatakeluarga').prop('hidden', true);
                $('#formUpdateDatakeluarga').prop('hidden', false);

                // Ambil nomor index data yang akan diubah
                var nomorIndex = $(this).data('key');

                // Isi nomor index ke input hidden pada form update data
                $('#nomor_index_update').val(nomorIndex);

                // Ambil data dari objek yang sesuai dengan nomor index
                var data = {!! json_encode($datakeluarga) !!}[nomorIndex];
                // Isi data ke dalam form
                    $('#nama').val(data.nama);
                    $('#datepicker-autoclose30').val(data.tgllahir);
                    $('#hubungankeluargaa').val(data.hubungan);
                    $('#alamat').val(data.alamat);
                    $('#pekerjaan').val(data.pekerjaan);
                    $('#pendidikan_terakhir').val(data.pendidikan_terakhir);
        
                    // Set opsi yang dipilih pada dropdown select option
                    var select = document.getElementById("hubungankeluargaa");
                    for (var i = 0; i < select.options.length; i++) {
                        if (select.options[i].value == data.hubungan) {
                            select.options[i].selected = true;
                            break;
                        }
                    }
                    // Set opsi yang dipilih pada dropdown select option
                    var select = document.getElementById("pendidikan_terakhir");
                    for (var i = 0; i < select.options.length; i++) {
                        if (select.options[i].value == data.pendidikan_terakhir) {
                            select.options[i].selected = true;
                            break;
                        }
                    }
            });
        });
    </script> --}}
@endsection
