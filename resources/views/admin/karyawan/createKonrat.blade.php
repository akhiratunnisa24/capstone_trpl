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
                <div class="panel panel-secondary" id="riwayatpekerjaan">
                    <div class="panel-heading"></div>
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-20 col-sm-20 col-xs-20" style="margin-left:15px;margin-right:15px;">
                                    <table id="datatable-responsive7" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Hubungan</th>
                                                <th>No HP</th>
                                                <th>Alamat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($kontakdarurat as  $key => $kd)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $kd['nama']}}</td>
                                                    <td>{{ $kd['hubungan']}}</td>
                                                    <td>{{ $kd['no_hp']}}</td>
                                                    <td>{{ $kd['alamat']}}</td>
                                                    <td  class="text-center">
                                                       <div class="row d-grid gap-2 " role="group" aria-label="Basic example">
                                                            <a class="btn btn-sm btn-info" id="editKonrat" data-key="{{ $key }}" style="margin-right:10px">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form class="pull-right" action="{{ route('deletekd') }}" method="POST" style="margin-right: 60px;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="key" value="{{$key}}">
                                                                <button type="submit" class="btn btn-danger btn-sm delete_konrat" data-key="{{$key}}">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                            {{-- action="/delete-kontakdarurat/{{$key}}" --}}
                                                            {{-- <form class="pull-right" action="" method="POST" style="margin-right:80px;">
                                                                <button type="submit" class="btn btn-danger btn-sm delete_dakel" data-key="{{ $key }}"><i class="fa fa-trash"></i></button>
                                                            </form>  --}}
                                                        </div> 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table><br>
                                    <form action="/storekontakdarurat" id="formCreateKontakdarurat"  method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        <div class="control-group after-add-more">
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                                <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5  ">
                                                                    <label class="text-white">C. KONTAK DARURAT</label>
                                                                </div>
                                                                <div class="form-group m-t-10">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                                                        <input type="text" value="{{ $kontakdarurat->nama ?? '' }}" name="namaKdarurat" class="form-control" placeholder="Masukkan Nama" autocomplete="off" required>
                                                                        <div id="emailHelp" class="form-text"></div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Hubungan</label>
                                                                        <select class="form-control selectpicker" name="hubunganKdarurat" required>
                                                                            <option value="">Pilih Hubungan</option>
                                                                            <option value="Ayah" {{ $kontakdarurat->hubungan ?? 'Ayah' == '' ? 'selected' : '' }}>Ayah</option>
                                                                            <option value="Ibu" {{ $kontakdarurat->hubungan ?? 'Ibu' == '' ? 'selected' : '' }}>Ibu</option>
                                                                            <option value="Suami" {{ $kontakdarurat->hubungan ?? 'Suami' == '' ? 'selected' : '' }}>Suami</option>
                                                                            <option value="Istri" {{ $kontakdarurat->hubungan ?? 'Istri' == '' ? 'selected' : '' }}>Istri</option>
                                                                            <option value="Kakak" {{ $kontakdarurat->hubungan ?? 'Kakak' == '' ? 'selected' : '' }}>Kakak</option>
                                                                            <option value="Adik" {{ $kontakdarurat->hubungan ?? 'Adik' == '' ? 'selected' : '' }}>Adik</option>
                                                                            <option value="Anak" {{ $kontakdarurat->jhubungan ?? 'Anak' == '' ? 'selected' : '' }}>Anak</option>
                                                                            <option value="Famili/Saudara/Teman" {{ $kontakdarurat->jhubungan ?? 'Famili/Saudara/Teman' == '' ? 'selected' : '' }}>Famili/Saudara/Teman</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3 ">
                                                                        <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                                                        <input class="form-control" value="{{ $kontakdarurat->alamat ?? '' }}" name="alamatKdarurat" rows="9" placeholder="Masukkan Alamat" autocomplete="off" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">No. Handphone</label>
                                                                        <input type="number" name="no_hpKdarurat" value="{{ $kontakdarurat->no_hp ?? '' }}" class="form-control" id="no_hp" placeholder="Masukkan Nomor Handphone" autocomplete="off" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="pull-left">
                                                                        <a href="/create-data-keluarga" class="btn btn-sm btn-info"><i class="fa fa-backward"></i> Sebelumnya</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <button type="submit" name="submit" id="btn-simpan" class="btn btn-sm btn-dark">Simpan</button>
                                                                        <a href="{{route('create.pendidikan')}}" class="btn btn-sm btn-success" id="btn-selanjutnya">Selanjutnya <i class="fa fa-forward"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2"></div>
                                                        </div>
                                                    </div>
                                                </table>
                                            </div>
                                        </div>
                                    </form>  

                                    <form action="/updatekontakdarurat" id="formUpdateKontakdarurat"  method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        <div class="control-group after-add-more">
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                                <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5  ">
                                                                    <label class="text-white">C. KONTAK DARURAT</label>
                                                                </div>
                                                                <input type="hidden" name="nomor_index" id="nomor_index_update" value="">
                                                                <div class="form-group m-t-10">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                                                        <input type="text" id="namaKdarurat" name="namaKdarurat" class="form-control" placeholder="Masukkan Nama" autocomplete="off" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Hubungan</label>
                                                                        <select class="form-control" id="hubunganKdarurat" name="hubunganKdarurat" required>
                                                                            <option value="">Pilih Hubungan</option>
                                                                            <option value="Ayah" {{ $kontakdarurat->hubungan ?? 'Ayah' == '' ? 'selected' : '' }}>Ayah</option>
                                                                            <option value="Ibu" {{ $kontakdarurat->hubungan ?? 'Ibu' == '' ? 'selected' : '' }}>Ibu</option>
                                                                            <option value="Suami" {{ $kontakdarurat->hubungan ?? 'Suami' == '' ? 'selected' : '' }}>Suami</option>
                                                                            <option value="Istri" {{ $kontakdarurat->hubungan ?? 'Istri' == '' ? 'selected' : '' }}>Istri</option>
                                                                            <option value="Kakak" {{ $kontakdarurat->hubungan ?? 'Kakak' == '' ? 'selected' : '' }}>Kakak</option>
                                                                            <option value="Adik" {{ $kontakdarurat->hubungan ?? 'Adik' == '' ? 'selected' : '' }}>Adik</option>
                                                                            <option value="Anak" {{ $kontakdarurat->jhubungan ?? 'Anak' == '' ? 'selected' : '' }}>Anak</option>
                                                                            <option value="Famili/Saudara/Teman" {{ $kontakdarurat->jhubungan ?? 'Famili/Saudara/Teman' == '' ? 'selected' : '' }}>Famili/Saudara/Teman</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="mb-3 ">
                                                                        <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                                                        <input class="form-control" id="alamatKdarurat" name="alamatKdarurat" rows="9" placeholder="Masukkan Alamat" required></input>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">No. Handphone</label>
                                                                        <input type="number" id="no_hpKdarurat" name="no_hpKdarurat" class="form-control" id="no_hp" placeholder="Masukkan Nomor Handphone" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="pull-left">
                                                                        <a href="/create-data-keluarga" class="btn btn-sm btn-info"><i class="fa fa-backward"></i> Sebelumnya</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <button type="submit" name="submit" id="btn-simpan" class="btn btn-sm btn-dark">Update Data</button>
                                                                        <a href="{{route('create.pendidikan')}}" class="btn btn-sm btn-success" id="btn-selanjutnya">Selanjutnya <i class="fa fa-forward"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2"></div>
                                                        </div>
                                                    </div>
                                                </table>
                                            </div>
                                        </div>
                                    </form>               
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/pages/form-advanced.js"></script> 

        <script type="text/javascript">
            $(document).ready(function() {
                $('#formCreateKontakdarurat').prop('hidden', false);
                $('#formUpdateKontakdarurat').prop('hidden',true);
                $(document).on('click', '#editKonrat', function() {
                    // Menampilkan form update data dan menyembunyikan form create data
                    $('#formCreateKontakdarurat').prop('hidden', true);
                    $('#formUpdateKontakdarurat').prop('hidden', false);
    
                    // Ambil nomor index data yang akan diubah
                    var nomorIndex = $(this).data('key');
    
                    // Isi nomor index ke input hidden pada form update data
                    $('#nomor_index_update').val(nomorIndex);
    
                    // Ambil data dari objek yang sesuai dengan nomor index
                    var data = {!! json_encode($kontakdarurat) !!}[nomorIndex];
                    // Isi data ke dalam form
                        $('#namaKdarurat').val(data.nama);
                        $('#no_hpKdarurat').val(data.no_hp);
                        $('#alamatKdarurat').val(data.alamat);
                        $('#hubunganKdarurat').val(data.hubungan);
            
                        // Set opsi yang dipilih pada dropdown select option
                        var select = document.getElementById("hubunganKdarurat");
                        for (var i = 0; i < select.options.length; i++) {
                            if (select.options[i].value == data.hubungan) {
                                select.options[i].selected = true;
                                break;
                            }
                        }
                });
            });
        </script>

@endsection