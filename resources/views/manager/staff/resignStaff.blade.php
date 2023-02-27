@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Ajukan Resign</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Ajukan Resign</li>
                </ol>
                <div class="clearfix"></div>               
            </div>
        </div>
    </div>
    <!-- Close Header -->
    
               
                    <!-- Start content -->
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading clearfix">
                                            <strong>List Resign Staff</strong>
                                            {{-- <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                                data-target="#Modal"> Form Ajukan Resign</a> --}}
                                        </div>
                                        <!-- modals tambah data cuti -->
                                        {{-- @include('admin.resign.addresign') --}}

                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <table id="datatable-responsive"
                                                        class="table dt-responsive nowrap table-striped table-bordered"
                                                        cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Karyawan</th>
                                                                <th>Departemen</th>
                                                                {{-- <th>Tanggal Bergabung</th> --}}
                                                                <th>Tanggal Resign</th>
                                                                {{-- <th>Tipe Resign</th> --}}
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($staff1 as $r)
                                                              <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $r->karyawans->nama }}</td>
                                                                <td>{{ $r->departemens->nama_departemen }}</td>
                                                                {{-- <td>{{ \Carbon\Carbon::parse($r->tgl_masuk)->format('d/m/Y') }}</td> --}}
                                                                <td>{{ \Carbon\Carbon::parse($r->tgl_resign)->format('d/m/Y') }}</td>
                                                                {{-- <td>{{ $r->tipe_resign }}</td> --}}
                                                                <td>
                                                                    <span class="badge badge-{{ $r->status == 8 ? 'warning' : ($r->status == 2 ? 'info' : ($r->status == 3 ? 'success' : ($r->status == 4 ? 'warning' : 'danger'))) }}">
                                                                        {{ $r->status == 8 ? $r->statuses->name_status : ($r->status == 2 ? $r->statuses->name_status : ($r->status == 3 ? $r->statuses->name_status : ($r->status == 4 ? $r->statuses->name_status : 'Ditolak'))) }}
                                                                      </span>
                                                                </td>
                                                                    {{-- <td class="text-center d-flex justify-content-between">
                                                                    @if ($r->status === 1)
                                                                    <form action="{{ route('resign_approved_manager', $r->id) }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status" value=2 hidden>
                                                                        <button type="submit" class="btn btn-success btn-sm mx-1">
                                                                          <i class="fa fa-check"></i>
                                                                        </button>
                                                                      </form>
                                                                      <form action="{{ route('resignreject', $r->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="status" value=5 hidden>
                                                                        <button type="submit" class="btn btn-danger btn-sm mx-1">
                                                                          <i class="fa fa-times"></i>
                                                                        </button>
                                                                      </form>
                                                                    @endif  
                                                                      <form action="" method="POST">
                                                                        <a class="btn btn-info btn-sm mx-1" data-toggle="modal" data-target="#Showresign{{ $r->id }}">
                                                                          <i class="fa fa-eye"></i>
                                                                        </a>
                                                                      </form>
                                                                    </td> --}}

                                                                    <td id="b" class="text-center">
                                                                        <div class="btn-group" role="group">
                                                                            @if ($r->status === 8)
                                                                            <form action="{{ route('resign_approved_manager', $r->id) }}" method="POST">
                                                                              @csrf
                                                                              <input type="hidden" name="status" value=2 class="form-control" hidden>
                                                                              <button type="submit" class="btn btn-success btn-sm">
                                                                                <i class="fa fa-check"></i>
                                                                              </button>
                                                                            </form>
                                                                            <form action="{{ route('resignreject', $r->id) }}" method="POST">
                                                                              @csrf
                                                                              @method('POST')
                                                                              <input type="hidden" name="status" value=5 class="form-control" hidden>
                                                                              <button type="submit" class="btn btn-danger btn-sm">
                                                                                <i class="fa fa-times"></i>
                                                                              </button>
                                                                            </form>
                                                                          @endif
                                                                          <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#Showresign{{ $r->id }}">
                                                                            <i class="fa fa-eye"></i>
                                                                          </a>
                                                                        </div>
                                                                      </td>
                                                              </tr>
                                                              @include('karyawan.resign.showresign')
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
                </div>

             

            </div>
        </div>
    </div>
</div>



    {{-- <script type="text/javascript">
    let tp = '{{$tipe}}';
    
        if(tp == 1) {
            $('#tab1').click();
        } else {
            $('#tab2').click();
        }
</script> --}}
@endsection