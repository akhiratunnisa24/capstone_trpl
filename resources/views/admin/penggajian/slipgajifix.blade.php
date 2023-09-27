@extends('layouts.default')
@section('content')
    <style>
        .alert-info1
        {
            color: #000;
            background-color: rgba(24, 186, 226, 0.2); 
        }

        .garis {
            margin-top: 10px;
            height: 3px;
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            margin-bottom: 5px;
        }
    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title ">Slip Gaji Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Slip Gaji</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-secondary">
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-20 col-sm-20 col-xs-20">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="control-group after-add-more">
                                        <div class="panel-body">
                                                <div class="col-md-12">
                                                    <div class="col-md-6 m-t-10">
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Nama</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" name="nama" class="form-control" autocomplete="off" value="{{$slipgaji->karyawans->nama}}" readonly>
                                                                    <input type="hidden" name="id_karyawan" class="form-control" autocomplete="off" value="{{$slipgaji->id_karyawan}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Tanggal Masuk</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{ \Carbon\carbon::parse($slipgaji->karyawans->tglmasuk)->format('d/m/Y') }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Status Karyawan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{$slipgaji->informasigajis->karyawans->status_karyawan}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Gaji Pokok</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{ number_format($slipgaji->informasigajis->gaji_pokok, 0, ',', '.')}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label
                                                                    class="form-label col-sm-3 text-end">Departemen</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off"
                                                                    placeholder="" value="{{$slipgaji->karyawans->departemen->nama_departemen}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 m-t-10">
                                            
                                                        <div class="form-group col-sm">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Jabatan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" autocomplete="off" value="{{$slipgaji->karyawans->nama_jabatan ? $slipgaji->karyawans->nama_jabatan : ''}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Level Jabatan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" name="level_jabatan" id="level_jabatan" autocomplete="off"
                                                                    placeholder="Masukkan Level Jabatan" value="{{$slipgaji->informasigajis->karyawans->jabatan ? $slipgaji->informasigajis->karyawans->jabatan : ''}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Struktur Gaji</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" name="id_struktur" id="id_struktur" autocomplete="off"
                                                                    placeholder="Masukkan Level Jabatan" value="{{$slipgaji->informasigajis->strukturgajis->nama ? $slipgaji->informasigajis->strukturgajis->nama : ''}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Periode Gaji</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" name="periode" id="periode" autocomplete="off"
                                                                    placeholder="Masukkan Level Jabatan" value="{{\Carbon\Carbon::parse($slipgaji->tglawal)->format('d/m/Y')}} s.d {{\Carbon\Carbon::parse($slipgaji->tglakhir)->format('d/m/Y')}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md">
                                                            <div class="row">
                                                                <label class="form-label col-sm-3 text-end">Tanggal Penggajian</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" name="tgl_gai" id="tgl_gaji" autocomplete="off"
                                                                    placeholder="Masukkan Level Jabatan" value="{{\Carbon\Carbon::parse($slipgaji->tglgajian)->format('d/m/Y')}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-md-6">
                                                        @php
                                                            $no = 2;
                                                        @endphp
                                                        <label><strong>PENGHASILAN :</strong></label>
                                                        <table class="table dt-responsive nowrap table-striped" cellpadding="0" style="margin: auto; margin-bottom:15px;">
                                                            <thead style="background-color: #b8e2f8;">
                                                                <tr>
                                                                    <th style="width: 10%;">No</th>
                                                                    <th style="width: 40%;">Komponen Gaji</th>
                                                                    <th style="width: 20%;">Nominal</th>
                                                                    <th style="width: 10%;">Jumlah</th>
                                                                    <th style="width: 20%;">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($detailgaji !== null)
                                                                    @foreach($detailgaji as $detail)
                                                                        @if($detail->id_benefit === 1 )
                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>{{ $detail->benefit->nama_benefit}}</td>
                                                                                <td>{{ number_format($detail->nominal, 0, ',', '.') }}/{{$detail->detailinformasigajis->siklus_bayar}}</td>
                                                                                <td>{{ number_format($detail->jumlah,0) }}</td>
                                                                                <td>{{ number_format($detail->total, 0, ',', '.') }}</td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                    @foreach($detailgaji as $detail)
                                                                        @if($detail->benefit->partner !== 0 &&  $detail->benefit->id_kategori !== 5 &&  $detail->benefit->id_kategori !== 6)
                                                                            <tr>
                                                                                <td>{{ $no++ }}</td>
                                                                                <td>{{ $detail->benefit->nama_benefit}}</td>
                                                                                <td>{{ number_format($detail->nominal, 0, ',', '.') }}/{{$detail->detailinformasigajis->siklus_bayar}}</td>
                                                                                <td>{{ number_format($detail->jumlah,0) }}</td>
                                                                                <td>{{ number_format($detail->total, 0, ',', '.')}}</td>
                                                                            </tr>
                                                                           
                                                                        @endif
                                                                    @endforeach
                                                                    @foreach($detailgaji as $detail)
                                                                        @if($detail->id_benefit === 2)
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                {{-- <td><strong>{{ $detail->benefit->nama_benefit}}</strong></td> --}}
                                                                                <td><strong>Total</strong></td>
                                                                                <td></td>
                                                                                <td>{{ number_format($detail->total, 0, ',', '.') }}</td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        @php
                                                            $nomor = 1;
                                                        @endphp
                                                        <label><strong>POTONGAN :</strong></label>
                                                        <table class="table dt-responsive nowrap table-striped" cellpadding="0" style="margin: auto; margin-bottom:15px;">
                                                            <thead style="background-color: #b8e2f8;">
                                                                <tr>
                                                                    <th style="width: 10%;">No</th>
                                                                    <th style="width: 40%;">Komponen Gaji</th>
                                                                    <th style="width: 20%;">Nominal</th>
                                                                    <th style="width: 10%;">Jumlah</th>
                                                                    <th style="width: 20%;">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                                @if($detailgaji !== null)
                                                                    @foreach($detailgaji as $detail)
                                                                        @if($detail->benefit->id_kategori === 5 && $detail->benefit->dibayarkan_oleh == "Karyawan" || $detail->benefit->id_kategori === 6)
                                                                            <tr>
                                                                                <td>{{ $nomor++ }}</td>
                                                                                <td>{{ $detail->benefit->nama_benefit}}</td>
                                                                                <td>{{ number_format($detail->nominal, 0, ',', '.') }}/{{$detail->detailinformasigajis->siklus_bayar}}</td>
                                                                                <td>{{ number_format($detail->jumlah,0) }}</td>
                                                                                <td>{{ number_format($detail->total, 0, ',', '.')}}</td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                    @if($slipgaji !== null)
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td><strong>Total</strong></td>
                                                                            <td></td>
                                                                            <td>{{ number_format($slipgaji->potongan, 0, ',', '.') }}</td>
                                                                        </tr>
                                                                    @endif
                                                                @else
                                                                    {{-- @if($slipgaji !== null) --}}
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>Asuransi</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>{{ number_format($slipgaji->asuransi, 0, ',', '.') }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td>Pph21</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>{{ number_format($slipgaji->pajak, 0, ',', '.') }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td><strong>Total</strong></td>
                                                                            <td></td>
                                                                            <td>{{ number_format($slipgaji->potongan, 0, ',', '.') }}</td>
                                                                        </tr>
                                                                    {{-- @endif --}}
                                                                @endif

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center" style="margin-top: 20px;">
                                                    <div class="col-md-12">
                                                        <table class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" style="margin: auto; margin-bottom:15px;">
                                                            @foreach($detailgaji as $detail)
                                                                @if($detail->id_benefit === 3)
                                                                    <thead style="background-color: #fcfcfc;">
                                                                        <th style="text-transform: uppercase; text-align: center;">{{ strtoupper($detail->benefit->nama_benefit) }}</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Rp. {{ number_format($detail->total, 0, ',', '.') }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                @endif
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>                                                
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="id_slip" value ="{{$slipgaji->id}}">
                                    <div class="modal-footer">
                                        @if($slipgaji->statusmail == 0)
                                            <button type="submit" class="btn btn-sm btn-success" title="Kirim Slip Gaji" >Kirim Slip Gaji  <i class="fa fa-paper-plane-o"></i></button>
                                        @endif
                                        <a href="/slipgaji-pdf/{{ $slipgaji->id }}" class="btn btn-info btn-sm btn-info"  title="Print Slip Gaji" target="_blank">Print <i class="fa fa-file-pdf-o"></i></a>
                                        <a href="/slipgaji-karyawan" class="btn btn-sm btn-danger" type="button">Kembali  <i class="fa fa-home"></i></a>
                                    </div>
                                </form>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>


    @if (Session::has('pesan'))
        <script>
            swal("Selamat", "{{ Session::get('pesan') }}", 'success', {
                button: true,
                button: "OK",
            });
        </script>
    @endif

    @if (Session::has('pesa'))
        <script>
            swal("Mohon Maaf", "{{ Session::get('pesa') }}", 'error', {
                button: true,
                button: "OK",
            });
        </script>
    @endif
@endsection

