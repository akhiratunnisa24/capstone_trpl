@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Manage Kategori Cuti</h4>
                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Manage Kategori Cuti</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- Close Header -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading clearfix" style="height:35px;">
                        </div>

                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable-responsive" class="table dt-responsive table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kategori Cuti</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($setcuti as $data)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$data->jenis_cuti}}</td>
                                                <td>
                                                    @if ($data->status == 1)
                                                       <span class="badge badge-success">Aktif</span>
                                                    @else
                                                        <span class="badge badge-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($data->status == 0)
                                                        <div class="col-sm-3">
                                                            <form action="/update-kategori/{{ $data->id }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-sm btn-success" style="color:black;">Aktifkan</button>
                                                                <input type="hidden" name="status" value="1">
                                                            </form>
                                                        </div>
                                                    @else
                                                        <div class="col-sm-3">
                                                            <form action="/update-kategori/{{ $data->id }}" method="POST" style="width:200px">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-sm btn-danger" style="color: rgb(249, 7, 7);">Non-Aktifkan</button>
                                                                <input type="hidden" name="status" value="0">
                                                            </form>
                                                        </div>
                                                    @endif
                                                
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="/kategori_cuti" class="btn btn-sm btn-danger">Kembali</a>
                        </div>
                    </div>
                </div>
            </div> <!-- End Row -->
        </div> <!-- container -->
    </div> 
@endsection