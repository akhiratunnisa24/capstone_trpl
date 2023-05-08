@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Hak Cuti Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Alokasi cuti</li>
                </ol>
            
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="a" class="col-md-12">
            <div id="a" class="panel panel-secondary">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="info">
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Cuti Yang Didapat</th>
                                        <th>Durasi Cuti</th>
                                        <th>Durasi Aktif</th>
                                        <th>Berakhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alokasicuti as $alokasi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $alokasi->karyawans->nama }}</td>
                                            <td>{{ $alokasi->jeniscutis->jenis_cuti }}</td>
                                            <td>{{ $alokasi->durasi }} hari</td>
                                            <td>{{ \Carbon\Carbon::parse($alokasi->aktif_dari)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($alokasi->sampai)->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
    
                                    @php
                                        $jml = 0;
                                    @endphp
                                    @foreach ($alokasicuti as $key => $alokasi)
                                        @php
                                            $jml += $alokasi->durasi;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-right"><strong>Jumlah Cuti</strong></td>
                                        <td class="thick-line text-left">{{ $jml }} hari</td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <style>
        #a {
            border-radius: 10px;
        }
    </style>
@endsection
