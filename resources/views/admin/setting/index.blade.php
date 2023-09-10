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
        </style>
    </head>
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title ">Setting Organisasi</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Setting Organisasi</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8" style="margin-left:18%;">
            <div class="panel panel-secondary" id="">
                <div class="content">
                    {{-- alert danger --}}
                    <div class="container">
                        <div class="row">
                            <div class="col-md-20 col-sm-20 col-xs-20">
                                <form action="/setting-organisasi/update/{{$settingorganisasi->id}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                            <div class="col-md-12">
                                                <div class="row">
                            
                                                    <div class="col-md-12 m-t-10">
                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Perusahaan</label>
                                                                <input type="text" name="nama_perusahaan" class="form-control" value="{{ $settingorganisasi->nama_perusahaan ?? '' }}" placeholder="Masukkan Nama Perusahaan" autocomplete="off" required>
                                                                    
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">E-mail Perusahaan</label>
                                                                <input type="email" name="email" value="{{ $settingorganisasi->email ?? '' }}" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan Email" autocomplete="off" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">Nomor Telepon Perusahaan</label>
                                                                <input type="text" name="no_telp" value="{{ $settingorganisasi->no_telp ?? '' }}" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan No Telp." autocomplete="off" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">Alamat Perusahaan</label>
                                                                <input type="text" name="alamat" value="{{ $settingorganisasi->alamat ?? '' }}" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan Alamat Perusahaan" autocomplete="off" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">Darah/Kota Administrasi</label>
                                                                <input type="text" name="daerah" value="{{ $settingorganisasi->daerah ?? '' }}" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan Kecamatan/Kota/Kabupaten" autocomplete="off" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">Kode Pos</label>
                                                                <input type="number" name="kode_pos" value="{{ $settingorganisasi->kode_pos ?? '' }}" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan Kode Pos" autocomplete="off" required>
                                                            </div>
                                                        </div>
                        
                                                        <div class="form-group">
                                                            <label class="form-label pull-left">Logo Perusahaan</label><br>
                                                            <div class="mb-3">
                                                                {{-- <label class="form-label col-sm-4 pull-left">Logo Perusahaan</label> --}}
                                                                @if($settingorganisasi->logo != null)
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4" src="{{ asset('images/'.$settingorganisasi->logo) }}">
                                                                    <input type="file" name="logo" class="form-control" id="foto" onchange="previewImage()"> 
                                                                @else
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="logo" class="form-control" id="foto" onchange="previewImage()" required> 
                                                                @endif   
                                                            </div>
                                                        </div>
                                                        <div class="text-center" style="margin-bottom:20px;">
                                                            <button type="submit"  name="submit" value="submit" class="btn btn-sm btn-success">Update</button>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
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
     {{-- <script src="assets/js/jquery.min.js"></script> --}}
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
     <script src="assets/pages/form-advanced.js"></script>

     <script>
        function previewImage() 
        {
            const image = document.querySelector('#foto');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
     </script>
@endsection