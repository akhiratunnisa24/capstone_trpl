@extends('layouts.default')
@section('content')
    <!-- Header -->

    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Data Rekrutmen</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Data Rekrutmen</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Close Header -->

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading  col-sm-15 m-b-10">
                            <a type="button" class="btn btn-sm btn-dark fa fa-user-plus " data-toggle="modal"
                                data-target="#myModal"> Tambah Rekrutmen </a>
                                <a href="create_pelamar" type="button" class="btn btn-sm btn-dark fa fa-user-plus " > Tambah pelamar Sementara </a>
                        </div>
                        @include('admin.rekruitmen.tambahLowonganModal')
                        <div class="panel-body">

                           


                            <div class="row">

                                @foreach ($posisi as $k)
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="panel panel-primary text-center">
                                            <div class="panel-heading btn-success">
                                                <a href="show_rekrutmen{{$k->id}}" class="panel-title ">
                                                    <h4 class="panel-title">{{ $k->status }}</h4>
                                                </a>
                                            </div>
                                            <div class="panel-body">
                                                <h3 class=""><b>{{ $k->posisi }}</b></h3>
                                                <p class="text-muted"><b>Dibutuhkan {{ $k->jumlah_dibutuhkan }} Orang</b>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
