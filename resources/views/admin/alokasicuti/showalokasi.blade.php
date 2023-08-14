{{-- MODALS SHOW SETTING ALOKASI CUTI --}}
<div class="modal fade" id="showalokasi{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="showalokasi" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="showsalokasi">Detail Alokasi Cuti</h4>
            </div>
            <style>
                #a {
                    font-weight: bold;
                }
            </style>
            <div class="modal-body">
                {{-- <div class="container"> --}}
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                {{-- <tbody> --}}
                                    @php
                                     use \Carbon\Carbon;
                                     $year = Carbon::now()->year;
                                    @endphp
                                    <tr style="text-align: center">
                                        <td id="a" scope="row">JUDUL</td>
                                        <td id="a">DATA</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">NIK</td>
                                        <td id="a">{{$data->nik}}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Nama</td>
                                        <td id="a">{{$data->karyawans->nama}}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Jabatan</td>
                                        <td id="a">{{$data->jabatan}}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Divisi / Departemen</td>
                                        <td id="a">{{$data->departemens->nama_departemen}}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Kategori Cuti</td>
                                        <td id="a">{{$data->jeniscutis->jenis_cuti}}</td>
                                    </tr>
                                    @if($data->id_jeniscuti == 1)
                                        <tr>
                                            <td scope="row">Tanggal Mulai Kerja</td>
                                            <td id="a">{{ \Carbon\Carbon::parse($data->tgl_masuk)->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Jatuh Tempo Pengambilan Hak Cuti</td>
                                            <td id="a">{{ \Carbon\Carbon::parse($data->jatuhtempo_awal)->format('d/m/Y') }} s.d {{ \Carbon\Carbon::parse($data->jatuhtempo_akhir)->format('d/m/Y') }}</td>
                                        </tr>
                                    
                                        <tr>
                                            <td scope="row">Jumlah Hak Cuti {{$year}}</td>
                                            <td id="a">{{$data->jmlhakcuti}}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Cuti Dimuka {{$year}}</td>
                                            <td id="a">{{$data->cutidimuka}}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Cuti Minus {{$year}}</td>
                                            <td id="a">{{$data->cutiminus}}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Cuti Bersama {{$year}}</td>
                                            <td id="a">{{$data->jmlcutibersama}}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Saldo Hak Cuti {{$year}}</td>
                                            <td id="a">{{$data->durasi}}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Keterangan</td>
                                            <td id="a">{{$data->keterangan}}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Masa Aktif Cuti</td>
                                            <td id="a">{{\Carbon\Carbon::parse($data->aktif_dari)->format('d/m/Y')}} s.d {{\Carbon\Carbon::parse($data->sampai)->format('d/m/Y')}}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Status</td>
                                            <td>
                                                @if($data->status == 1)
                                                    <label class="text-white badge bg-info">AKTIF</label>
                                                @else
                                                    <label class="text-white badge bg-danger">KADALUARSA</label>
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td scope="row">Saldo Hak Cuti {{$year}}</td>
                                            <td id="a">{{$data->durasi}}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Keterangan</td>
                                            <td id="a">{{$data->keterangan}}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Masa Aktif Cuti</td>
                                            <td id="a">{{\Carbon\Carbon::parse($data->aktif_dari)->format('d/m/Y')}} s.d {{\Carbon\Carbon::parse($data->sampai)->format('d/m/Y')}}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Status</td>
                                            <td>
                                                @if($data->status == 1)
                                                    <label class="text-white badge bg-info">AKTIF</label>
                                                @else
                                                    <label class="text-white badge bg-danger">KADALUARSA</label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                            </table>
                        </div>
                    </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

