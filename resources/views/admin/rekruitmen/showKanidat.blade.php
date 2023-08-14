@extends('layouts.default')

@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title ">Detail Rekrutmen</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Detail Rekrutmen</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>



    <div class="panel panel-primary">
        {{-- <div class="panel-heading  col-sm-15 m-b-10">
            <a  class="btn btn-lg btn-dark"> {{ $lowongan->posisi }}</a>
        </div> --}}
        <div class=" col-sm-0 m-b-0">

        </div>

        <form action="#" method="POST">

            @csrf
            @method('put')

            <div class="modal-body">
                <table class="table table-bordered table-striped" style="width:100%">
                    <tbody class="col-sm-20">
                        <label class="">
                            <h4> {{ $lowongan->posisi }} </h4>
                        </label>

                        <tr>
                            <td><label>Jumlah dibutuhkan</label></td>
                            <td><label> {{ $lowongan->jumlah_dibutuhkan }}</label></td>
                        </tr>
                        <tr>
                            <td><label>Persyaratan</label></td>
                            <td><label> {{ $lowongan->persyaratan }}</label></td>
                        </tr>
                        <tr>

                    </tbody>
                </table>


            <div class="row">

                {{-- @foreach ($posisi as $k) --}}
                    <div class="col-sm-6 col-lg-3">
                        <div class="panel panel-primary text-center">
                            <div class="panel-heading btn-success">
                                <a href="#" class="panel-title ">
                                    <h4 class="panel-title">Data Pelamar</h4>
                                </a>
                            </div>
                            <div class="panel-body">
                                <h3 class=""><b>Status Rekruitmen</b></h3>
                                <p class="text-muted"><b>Total Orang</b>
                                </p>
                            </div>
                        </div>
                    </div>
                {{-- @endforeach --}}

            </div>

            </div>


    </div>
    </form>


    <div class="modal-footer">

        {{-- <a href="karyawanedit{{$karyawan->id}}" type="button" class="btn btn-sm btn-primary ">Edit Rekrutmen</a> --}}
        <a href="/data_rekrutmen" class="btn btn-sm btn-danger">Kembali</a>
    </div>
@endsection
