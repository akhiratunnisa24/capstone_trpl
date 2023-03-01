@extends('layouts.default')
@section('content')
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type=number] {
                -moz-appearance: textfield;
            }
            
            .form-group{
                margin-left:10px;
                margin-right:10px
            }
        </style>
    </head>
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title ">Tambah Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Tambah Karyawan</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-secondary" id="datakeluarga">
                <div class="panel-heading"></div>
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-20 col-sm-20 col-xs-20" style="margin-left:15px;margin-right:15px;">
                                <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Hubungan</th>
                                            <th>Alamat</th>
                                            <th>Pekerjaan</th>
                                            <th>Pendidikan Terakhir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @foreach($datakeluarga as $data)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$data['nama']}}</td>
                                                <td>{{$data['tgllahir']}}</td>
                                                <td>{{$data['hubungan']}}</td>
                                                <td>{{$data['alamat']}}</td>
                                                <td>{{$data['pekerjaan']}}</td>
                                                <td>{{$data['pendidikan_terakhir']}}</td>
                                                <td>
                                                    <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                        <a class="btn btn-sm btn-primary" id="editKeluarga" style="margin-right:10px">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button onclick="" id="hapus_dakel" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                      
                                <form action="/storedatakeluarga" method="POST" enctype="multipart/form-data">
                                    {{-- <div class="control-group after-add-more"> --}}
                                        @csrf
                                        @method('post')
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <!-- FORM -->
                                                        <div class="col-md-2"></div>
                                                        <!-- SEBELAH KANAN -->
                                                        <div class="col-md-8 m-t-10">
                                                            <div class="bg-info panel-heading  col-sm-15 m-b-10">
                                                                <label class="text-white">Status Pernikahan *)</label>
                                                            </div>
                                                            <div class="form-group m-l-5 m-r-5" style="margin-left:10px;margin-right:10px;">
                                                                <label for="exampleInputEmail1" class="form-label">Status Pernikahan</label>
                                                                <select class="form-control selectpicker" name="status_pernikahan">
                                                                    <option value="">Pilih Status Pernikahan</option>
                                                                    <option value="Sudah Menikah">Sudah Menikah</option>
                                                                    <option value="Belum Menikah">Belum Menikah</option>
                                                                    <option value="Duda">Duda</option>
                                                                    <option value="Janda">Janda</option>
                                                                </select>
                                                            </div>
                                                            <div class="modal-header bg-info panel-heading  col-sm-15 m-b-10 m-t-10">
                                                                <label class="text-white">B. DATA KELUARGA *) </label>
                                                            </div>
                                                            {{-- nomor array --}}
                                                            <input type="hidden" name="nomorArray" id="nomorArray" value="">
                                                            <div class="form-group" style="margin-left:10px;margin-right:10px;">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                                                    <input type="text" id="nama" name="namaPasangan" class="form-control" autocomplete="off" placeholder="Masukkan Nama" required>
                                                            
                                                                </div>
                                                            </div>

                                                            <div class="form-group" style="margin-left:10px;margin-right:10px;">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" placeholder="yyyy/mm/dd"
                                                                            id="datepicker-autoclose8" autocomplete="off" name="tgllahirPasangan" rows="10" required></input><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" style="margin-left:10px;margin-right:10px;">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Hubungan</label>
                                                                    <select class="form-control selectpicker" id="hubungan" name="hubungankeluarga" required>
                                                                        <option value="">Pilih Hubungan</option>
                                                                        <option value="Ayah">Ayah</option>
                                                                        <option value="Ibu">Ibu</option>
                                                                        <option value="Suami">Suami</option>
                                                                        <option value="Istri">Istri</option>
                                                                        <option value="Kakak">Kakak</option>
                                                                        <option value="Adik">Adik</option>
                                                                        <option value="Anak Pertama">Anak Pertama</option>
                                                                        <option value="Anak Ke-2">Anak Ke-2</option>
                                                                        <option value="Anak Ke-3">Anak Ke-3</option>
                                                                        <option value="Anak Ke-4">Anak Ke-4</option>
                                                                        <option value="Anak Ke-5">Anak Ke-5</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                                                    <input class="form-control" id="alamat" name="alamatPasangan" autocomplete="off" rows="9" placeholder="Masukkan Alamat"required></input>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1" class="form-label">Pendidikan Terakhir</label>
                                                                <select class="form-control selectpicker" id="pendidikan_terakhir" name="pendidikan_terakhirPasangan"required>
                                                                    <option value="">Pilih Pendidikan Terakhir</option>
                                                                    <option value="SD">SD</option>
                                                                    <option value="SMP">SMP</option>
                                                                    <option value="SMA/K">SMA/K</option>
                                                                    <option value="D-3">D-3</option>
                                                                    <option value="S-1">S-1</option>
                                                                    <option value="S-2">S-2</option>
                                                                    <option value="S-3">S-3</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Pekerjaan</label>
                                                                    <input type="text" name="pekerjaanPasangan" class="form-control" id="pekerjaan" aria-describedby="emailHelp" placeholder="Masukkan Pekerjaan" required>
                                                                    <div id="emailHelp" class="form-text"></div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="pull-left">
                                                                    <a href="/karyawancreates" class="btn btn-sm btn-info"><i class="fa fa-backward"></i> Sebelumnya</a>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <button type="submit" name="submit" class="btn btn-sm btn-dark">Simpan</button>
                                                                    <a href="{{route('create.konrat')}}" class="btn btn-sm btn-success">Selanjutnya <i class="fa fa-forward"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2"></div>
                                                    </div>
                                                </div>
                                            </table>
                                        </div>
                                    {{-- </div> --}}
                                </form>                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     {{-- <script src="assets/js/jquery.min.js"></script> --}}
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
     <script src="assets/pages/form-advanced.js"></script>

    {{-- <script>
        $(document).ready(function(){
          $.ajax({
            url: "{{ route('get.data.keluarga') }}",
            type: "GET",
            dataType: "JSON",
            success:function(response){
              // Tampilkan data keluarga di halaman web menggunakan jQuery
              $.each(response, function(item){
                // var row = "<tr>"
                //   "<td>" + (i+1) + "</td>" +
                //   "<td>" + item.nama + "</td>" +
                //   "<td>" + item.tgllahir + "</td>" +
                //   "<td>" + item.hubungan + "</td>" +
                //   "<td>" + item.alamat + "</td>" +
                //   "<td>" + item.pekerjaan + "</td>" +
                //   "</tr>";
                // $('#tabel-data-keluarga').append(row);
                $('#a').val(item.nama);
                $('#b').val(item.tgllahir);
                $('#c').val(item.hubungan);
                $('#d').val(item.alamat);
                $('#e').val(item.pekerjaan);
              });
            }
          });
        });
    </script> --}}
    <script>
        $.ajax({
            url: '/getDataKeluarga',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // loop through the data and add it to the table
                $.each(data, function (key, value) {
                    var row = '<tr><td>' + (key+1) + '</td><td>' + value.nama + '</td><td>' + value.tgllahir + '</td><td>' + value.hubungan + '</td><td>' + value.alamat + '</td><td>' + value.pekerjaan + '</td></tr>';
                    $('#datatable-responsive6 tbody').append(row);
                });
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                $('#editKeluarga').on('click', function() {
                    // Ambil nomor array data yang akan dihapus
                    var nomorArray = $(this).closest('tr').find('td:eq(0)').text();

                      // Isi nomor array ke input hidden pada form
                    $('#nomor_array').val(nomorArray);

                    // Ambil data dari kolom yang sesuai dengan nomor array
                    var nama = $(this).closest('tr').find('td:eq(1)').text();
                    var tgllahir = $(this).closest('tr').find('td:eq(2)').text();
                    var hubungan = $(this).closest('tr').find('td:eq(3)').text();
                    var alamat = $(this).closest('tr').find('td:eq(4)').text();
                    var pekerjaan = $(this).closest('tr').find('td:eq(5)').text();
                    var pendidikan_terakhir = $(this).closest('tr').find('td:eq(6)').text();
                    
                    // Isi data ke dalam form
                    $('#nama').val(nama);
                    $('#datepicker-autoclose8').val(tgllahir);
                    $('#hubungan').val(hubungan);
                    $('#alamat').val(alamat);
                    $('#pekerjaan').val(pekerjaan);
                    $('#pendidikan_terakhir').val(pendidikan_terakhir);

                    // Set opsi yang dipilih pada dropdown select option
                    var select = document.getElementById("hubungan");
                    for (var i = 0; i < select.options.length; i++) {
                        if (select.options[i].value == hubungan) {
                            select.options[i].selected = true;
                            break;
                        }
                    }

                    // Set opsi yang dipilih pada dropdown select option
                    var select = document.getElementById("pendidikan_terakhir");
                    for (var i = 0; i < select.options.length; i++) {
                        if (select.options[i].value == pendidikan_terakhir) {
                            select.options[i].selected = true;
                            break;
                        }
                    }
                });
            });
    </script>
    <script>
        $(document).ready(function() {
            $('#hapus_dakel').on('click', function() {
                // Ambil index data yang dihapus
                var index = $(this).closest('tr').index();
                
                // Kirim index ke controller untuk menghapus data dari session
                $.ajax({
                    url: '/delete-keluarga',
                    type: 'POST',
                    data: { index: index },
                    success: function() {
                        // Refresh halaman setelah data dihapus
                        location.reload();
                    }
                });
            });
        });

    </script>
@endsection