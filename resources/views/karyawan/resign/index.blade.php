@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Ajukan Resign</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employees Management System</li>
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
                          <a href="#" class="btn btn-sm btn-dark fa fa-plus pull-right"
                            @if ($status0 == 5 && $status1 == 8)
                                onclick="alert('Kamu tidak bisa mengajukan resign lagi')" class="alert-button"
                            @elseif ($jumlah_resign > 0 && $status0 != 5)
                                onclick="alert('Kamu tidak bisa mengajukan resign lagi')" class="alert-button"
                            @else
                                data-toggle="modal" data-target="#Modal"
                            @endif>
                            Form Ajukan Resign
                        </a>

                          </div>
                        <!-- modals resign -->
                        @include('karyawan.resign.addresign')

                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable-responsive"
                                        class="table dt-responsive nowrap table-striped table-bordered" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                {{-- <th>#</th> --}}
                                                <th>Karyawan</th>
                                                <th>Departemen</th>
                                                {{-- <th>Tanggal Bergabung</th> --}}
                                                <th>Tanggal Resign</th>
                                                <th>Tipe Resign</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($resign as $r)
                                              @if ($r->id_karyawan == Auth::user()->id_pegawai)
                                                <tr>
                                                  <td>{{ $r->karyawans->nama }}</td>
                                                  <td>{{ $r->departemens->nama_departemen }}</td>
                                                  {{-- <td>{{ \Carbon\Carbon::parse($r->tgl_masuk)->format('d/m/Y') }}</td> --}}
                                                  <td>{{ \Carbon\Carbon::parse($r->tgl_resign)->format('d/m/Y') }}</td>
                                                  <td>{{ $r->tipe_resign }}</td>

                                                  <!-- data for status -->
                                                  <td>
                                                    <span class="badge badge-{{ $r->status == 1 ? 'warning' : ($r->status == 6 ? 'info' : ($r->status == 7 ? 'success' : ($r->status == 5 ? 'danger': 'danger'))) }}">
                                                      {{ $r->status == 1 ? $r->statuses->name_status : ($r->status == 6 ? $r->statuses->name_status : ($r->status == 7 ? $r->statuses->name_status : ($r->status == 5 ? $r->statuses->name_status : 'Ditolak'))) }}
                                                    </span>
                                                  </td>

                                                  <td id="b" class="text-center">
                                                    <div class="btn-group" role="group">
                                                      <form action="" method="POST">
                                                      <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#Showresign{{ $r->id }}">
                                                        <i class="fa fa-eye"></i>
                                                      </a>
                                                    </form>
                                                    @if($r->status == 1)
                                                    <form action="" method="POST">
                                                      <a href="resigndelete{{ $r->id }}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan resign ini?')"><i class="fa fa-trash"></i></a>
                                                    @endif
                                                    </form>
                                                    </div>
                                                  </td>

                                                  {{-- <td class="text-center">
                                                    <form action="" method="POST">
                                                      <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#Showresign{{ $r->id }}">
                                                        <i class="fa fa-eye"></i>
                                                      </a>
                                                    </form>
                                                    @if($r->status == 8)
                                                    <form action="" method="POST">
                                                      <a href="resigndelete{{ $r->id }}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan resign ini?')"><i class="fa fa-trash"></i></a>
                                                    @endif
                                                    </form>
                                                  </td> --}}
                                                </tr>
                                                @include('karyawan.resign.showresign')
                                              @endif
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


    {{-- <script>
        function confirmDeletion() {
          if (confirm("Are you sure you want to delete?")) {
            // User clicked "OK", proceed with delete
          } else {
            // User clicked "Cancel"
          }
        }
      </script> --}}
    {{-- <script type="text/javascript">
    let tp = '{{$tipe}}';

        if(tp == 1) {
            $('#tab1').click();
        } else {
            $('#tab2').click();
        }
</script> --}}
@endsection
