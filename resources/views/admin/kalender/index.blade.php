@extends('layouts.default')
@section('content')
<!-- Header -->
    <link href="assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet" />
    <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
    <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>

    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Kalender Kerja</h4>
                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Kalender Kerja</li>
                </ol>
                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-sm-3">
                    <div class="panel panel-secondary">
                        @if(Session::has('pesan'))
                            <script>
                                swal("Selamat","{{ Session::get('pesan')}}", 'success', {
                                    button:true,
                                    button:"OK",
                                });
                            </script>
                        @endif
                        <div class="panel panel-heading">
                            <h4  style="margin-left:35px">Form Kegiatan</h4>
                        </div>
                        {{-- @include('admin.kalender.updateKegiatan') --}}
                       
                        <div class="panel-body">
                            <form method="POST" id="add_event_form" action="/store-kegiatan">
                                @csrf
                                @method('post')
                                <div class="form-group">
                                    <div class="form-label">Judul Kegiatan</div>
                                    <input type="text" class="form-control" name="judul" id="tglmulai" autocomplete="off" placeholder="Masukkan Judul.." required>
                                    <input type="hidden" class="form-control" name="id_pegawai" id="id_pegawai" value="{{Auth::user()->id_pegawai}}">
                                </div>
                                <div class="form-group mt-4">
                                    <div class="form-label">Tgl Mulai</div>
                                    <input type="datetime-local" class="form-control" name="tglmulai" id="mulai" required>
                                </div>
                                <div class="form-group mt-4">
                                    <div class="form-label">Tgl Selesai</div>
                                    <input type="datetime-local" class="form-control" name="tglselesai" id="selesai">
                                </div>
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-success" style="margin-left:65px">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id='calendar' class="col-md- col-lg-9"></div>
            </div>
        </div> <!-- container -->
    </div> 

    <script src="assets/plugins/moment/moment.js"></script>
    <script src='assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>

    <script>
        var id_pegawai = {{ $id_pegawai }};
    </script>
    <script src="assets/pages/calendar-init.js"></script>

@endsection