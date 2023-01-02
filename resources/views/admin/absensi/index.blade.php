@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Data Absensi</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Human Resources Management System</a></li>
                    <li class="active">Data Absensi</li>
                </ol>
                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Close Header -->
    <!-- Start content -->
    <div class="btn-group" style="margin-left:15px;margin-bottom:10px" role="group" aria-label="Basic example">
        <a href="/exportexcel" class="btn btn-dark">Export Excel</a>
        <a href="/exportpdf" class="btn btn-dark">Download PDF</a>
        <a href="" class="btn btn-dark" data-toggle="modal" data-target="#Modal">Import Excel</a>
        <a href="" class="btn btn-dark" data-toggle="modal" data-target="#smallModal">Import CSV</a>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Data Absensi Karyawan</h3>
                        </div>
                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable-responsive3" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Karyawan</th>
                                                <th>Tanggal</th>
                                                <th>Jam Masuk</th>
                                                <th>Jam Keluar</th>
                                                <th>Jml Hadir</th>
                                                <th>Telat</th>
                                                <th>P. cepat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($absensi as $data)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$data->karyawans->nama}}</td>
                                                    <td>{{\Carbon\Carbon::parse($data->tanggal)->format('d/m/Y')}}</td>
                                                    <td>{{$data->jam_masuk}}</td>
                                                    <td>{{$data->jam_keluar}}</td>
                                                    <td>{{$data->jam_kerja}}</td>
                                                    <td>{{$data->terlambat}}</td>
                                                    <td>{{$data->plg_cepat}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End Row -->
        </div> <!-- container -->
    </div> <!-- content -->

    {{-- Modal Import Data Excel --}}
    <div class="modal fade" id="Modal" data-backdrop="-1" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Import Excel</h4>
                </div>
                <form action="{{ route('importexcel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-lg-5">
                                <input type="file" name="file" required>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Import Data CSV--}}
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Import CSV</h4>
                </div>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- {{ route('importexcel') }} --}}
                <form action="importcsv" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-lg-5">
                                <input type="file" name="file" required>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                  
    

@endsection