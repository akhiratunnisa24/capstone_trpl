@extends('layouts.default')

@section('content')
    <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
    <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
        <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Contoh Koneksi Mesin Absensi Menggunakan SOAP Web Service</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Koneksi Mesin Absensi ke Web</a></li>
                </ol>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">

            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading  col-sm-15 m-b-10">
                        </div>
                        <div class="panel-body m-b-5">
                            <div class="row">
                                <a href="{{ url('tarik-data') }}">Download Log Data</a><br><br>
                                <a href="{{ url('upload-nama') }}">Upload Nama</a><br><br><br>
                                <a href="{{ url('download-sidik-jari') }}">Download Sidik Jari</a><br><br>
                                <a href="{{ url('upload-sidik-jari') }}">Upload Sidik Jari</a><br><br><br>
                                {{-- <a href="{{ url('clear-data') }}">Clear Log Data</a><br><br> --}}
                                {{-- <a href="{{ url('hapus-sidik-jari') }}">Hapus Sidik Jari</a><br><br> --}}
                                {{-- <a href="{{ url('syn-time') }}">Syncronize Time</a><br><br> --}}
                                {{-- <a href="{{ url('hapus-user') }}">Hapus User</a><br><br>  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End Row -->
        </div> <!-- container -->
    </div> <!-- content -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

    @if(Session::has('error'))
        <script>
            swal("Mohon Maaf","{{ Session::get('error')}}", 'error', {
                button:true,
                button:"OK",
            });
        </script>
    @endif
@endsection
