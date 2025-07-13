    <head>
        <!-- Datapicker -->
        <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <meta charset="utf-8" />
        <title>REMS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="shortcut icon" href="{{ asset('') }}assets/images/rem.png" width="38px" height="20px">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <div class="container">
        <!-- Page-Title -->
        <div class="row" style="margin-top: 30px">
            <div class="col-sm-12">
                <div class="page-header-title">
                    <h4 class="pull-left page-title">Form Penerimaan Rekruitmen</h4>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-secondary" id="riwayatpendidikan">
                    <div class="panel-heading"></div>
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-20 col-sm-20 col-xs-20" style="margin-left:15px;margin-right:15px;">
                                    <table class="table table-bordered table-striped">
                                        <span class=""><strong>A. PENDIDIKAN FORMAL</strong></span>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tingkat Pendidikan</th>
                                                <th>Nama Sekolah</th>
                                                <th>Jurusan</th>
                                                <th>Tahun Mulai</th>
                                                <th>Tahun Akhir</th>
                                                {{-- <th>Lama Pendidikan</th> --}}
                                                <th>Alamat</th>
                                                <th>Nomor Ijazah</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $no = 1;
                                            $nomor = 1;
                                        @endphp
                                            @foreach ($pendidikan as $key => $p)
                                                @if ($p['tingkat'] != null)
                                                    <tr>
                                                        <td>{{ $nomor++ }}</td>
                                                        <td>{{ $p['tingkat'] }}</td>
                                                        <td>{{ $p['nama_sekolah'] }}</td>
                                                        <td>{{ $p['jurusan'] }}</td>
                                                        {{-- <td>{{$p['tahun_masuk_formal'] }}</td>
                                                    <td>{{$p['tahun_lulus_formal'] }}</td> --}}
                                                        <td>{{$p['tahun_masuk_formal']}}
                                                        </td>
                                                        <td>{{$p['tahun_lulus_formal']}}
                                                        </td>

                                                        {{-- <td></td> --}}
                                                        <td>{{ $p['kota_pformal'] }}</td>
                                                        <td>{{ $p['ijazah_formal'] }}</td>
                                                        <td class="text-center">
                                                            <div class="row d-grid gap-2" role="group" aria-label="Basic example">
                                                                <a href="#formUpdatePendidikan" class="btn btn-sm btn-info" id="editPendidikan" data-key="{{ $key }}"><i class="fa fa-edit" title="Edit"></i>
                                                                </a>
                                                                <form class="pull-right" action="{{ route('delete_pendidikan') }}" method="POST" style="margin-right: 60px;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="key" value="{{$key}}">
                                                                    <button type="submit" class="btn btn-danger btn-sm delete_konrat" data-key="{{$key}}">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                                {{-- /delete-pendidikan/{{$key}} --}}
                                                                {{-- <form class="pull-right" action="" method="POST" style="margin-right:5px;">
                                                                <button type="submit" class="btn btn-danger btn-sm delete_dakel" data-key="{{ $key }}"><i class="fa fa-trash"></i></button>
                                                            </form>  --}}
                                                                {{-- <button type="button" id="hapus_dakel" data-key="{{ $key }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table><br>

                                    <span class=""><strong>B. PENDIDIKAN NON FORMAL</strong></span>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bidang/Jenis</th>
                                                <th>Lembaga Pendidikan</th>
                                                <th>Tahun Mulai</th>
                                                <th>Tahun Akhir</th>
                                                <th>Alamat</th>
                                                <th>Nomor Ijazah</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($pendidikan as $key => $nf)
                                                @if ($nf['jenis_pendidikan'] != null)
                                                    <tr>
                                                        {{-- <td id="key">{{ $key }}</td> --}}
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $nf['jenis_pendidikan'] }}</td>
                                                        <td>{{ $nf['nama_lembaga'] }}</td>
                                                        {{-- <td>{{ $nf['tahun_masuk_nonformal'] }}</td>
                                                    <td>{{ $nf['tahun_lulus_nonformal'] }}</td> --}}
                                                        <td>{{ $nf['tahun_masuk_nonformal']}}</td>
                                                        <td>{{ $nf['tahun_lulus_nonformal']}}</td>
                                                        <td>{{ $nf['kota_pnonformal']}}</td>
                                                        <td>{{ $nf['ijazah_nonformal']}}</td>
                                                        <td class="text-center">
                                                            <div class="row d-grid gap-2" role="group"
                                                                aria-label="Basic example">
                                                                <a href="#formUpdatePendidikan"
                                                                    class="btn btn-sm btn-info" id="edittPendidikan"
                                                                    data-key="{{ $key }}">
                                                                    <i class="fa fa-edit" title="Edit"></i>
                                                                </a>
                                                                <form class="pull-right" action="{{ route('delete_pendidikan') }}" method="POST" style="margin-right: 60px;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="key" value="{{$key}}">
                                                                    <button type="submit" class="btn btn-danger btn-sm delete_konrat" data-key="{{$key}}">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                                {{-- /delete-pendidikan/{{$key}} --}}
                                                                {{-- <form class="pull-right" action="" method="POST" style="margin-right:5px;">
                                                                <button type="submit" class="btn btn-danger btn-sm delete_dakel" data-key="{{ $key }}"><i class="fa fa-trash"></i></button>
                                                            </form>  --}}
                                                                {{-- <button type="button" id="hapus_dakel" data-key="{{ $key }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table><br>
                                    <form action="/storep_formal" method="POST" id="formCreatePendidikan"
                                        enctype="multipart/form-data">
                                        {{-- <div class="control-group after-add-more"> --}}
                                        @csrf
                                        @method('post')
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        {{-- KIRI --}}
                                                        <div class="col-md-12">
                                                            <div
                                                                class="modal-header bg-primary panel-heading  col-sm-15 m-b-5">
                                                                <label class="text-white m-b-10">D. RIWAYAT
                                                                    PENDIDIKAN</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{-- <div class="modal-header panel-heading  col-sm-15 m-b-5 m-t-10"> --}}
                                                            <span
                                                                class="form-group badge badge-secondary col-sm-15 m-b-5 m-t-10"><label
                                                                    class="text-white"> 1. Pendidikan
                                                                    Formal</label></span>
                                                            {{-- </div> --}}
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1"
                                                                    class="form-label">Tingkat Pendidikan</label>
                                                                <select class="form-control selectpicker"
                                                                    name="tingkat_pendidikan">
                                                                    <option value="">Pilih Tingkat Pendidikan
                                                                    </option>
                                                                    <option value="SD">SD</option>
                                                                    <option value="SMP">SMP</option>
                                                                    <option value="SMA/Sederajat">SMA/Sederajat</option>
                                                                    <option value="Sarjana Muda D3">Sarjana Muda D3
                                                                    </option>
                                                                    <option value="Sarjana S1">Sarjana S1</option>
                                                                    <option value="Pasca Sarjana S2">Pasca Sarjana S2
                                                                    </option>
                                                                    <option value="Doktoral/Phd">Doktoral/Phd S3
                                                                    </option>

                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> Jurusan</label>
                                                                    <input type="text" name="jurusan"
                                                                        class="form-control" id="exampleInputEmail1"
                                                                        placeholder="Masukkan Jurusan"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label">Nama Sekolah</label>
                                                                    <input type="text" name="nama_sekolah"
                                                                        class="form-control"
                                                                        placeholder="Masukkan Nama Sekolah"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> Alamat</label>
                                                                    <input type="text" name="kotaPendidikanFormal"
                                                                        class="form-control" id="exampleInputEmail1"
                                                                        placeholder="Masukkan Alamat"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            {{-- <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tahun Lulus</label>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose32" type="text"  class="form-control" placeholder="yyyy" id="4"
                                                                                name="tahun_lulusFormal" rows="10" autocomplete="off"><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div> --}}

                                                            {{-- <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lama Pendidikan</label>
                                                                    <div>
                                                                        <div class="input-daterange input-group"
                                                                            id="date-range8">
                                                                            <input type="text" class="form-control"
                                                                                name="tahun_masukFormal"
                                                                                placeholder="yyyy"
                                                                                autocomplete="off" />
                                                                            <span
                                                                                class="input-group-addon bg-primary text-white b-0">To</span>
                                                                            <input type="text" class="form-control"
                                                                                name="tahun_lulusFormal"
                                                                                placeholder="dd/mm/yyyy"
                                                                                autocomplete="off" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lama Pendidikan</label>
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose500" type="text" class="form-control" placeholder="yyyy"
                                                                            name="tahun_masukFormal" style="text-align: center" autocomplete="off"  rows="10" readonly>
                                                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                                                            <input id="datepicker-autoclose501" type="text" class="form-control" placeholder="yyyy"
                                                                            style="text-align: center" name="tahun_lulusFormal" autocomplete="off"  rows="10" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Ijazah</label>
                                                                    <input type="text" name="noijazahPformal"
                                                                        class="form-control"
                                                                        aria-describedby="emailHelp"
                                                                        placeholder="Masukkan No. Ijazah"
                                                                        autocomplete="off">
                                                                </div>
                                                                <button type="submit" name="submit" class="btn btn-sm btn-dark" style="margin-left:220px;margin-top:30px;">Simpan Pendidikan Formal</button>
                                                            </div>

                                                        </div>

                                                        {{-- KANAN --}}
                                                        <div class="col-md-6">
                                                            {{-- <div class="modal-header  panel-heading  col-sm-15 m-b-5 m-t-10"> --}}
                                                            <span
                                                                class="form-group badge badge-secondary col-sm-15 m-b-5 m-t-10"><label
                                                                    class="text-white"> 2. Pendidikan Non
                                                                    Formal</label></span>
                                                            {{-- </div> --}}
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Bidang / Jenis</label>
                                                                    <input type="text" name="jenis_pendidikan"
                                                                        class="form-control"
                                                                        placeholder="Masukkan Jenis Pendidikan"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lembaga
                                                                        Pendidikan</label>
                                                                    <input type="text" name="namaLembaga"
                                                                        class="form-control"
                                                                        placeholder="Masukkan Nama Lembaga"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> Alamat</label>
                                                                    <input type="text"
                                                                        name="kotaPendidikanNonFormal"
                                                                        class="form-control" id="exampleInputEmail1"
                                                                        aria-describedby="emailHelp"
                                                                        placeholder="Masukkan Alamat"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            {{-- <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lulus Tahun</label>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose31" type="text" class="form-control" placeholder="yyyy" id="4"
                                                                                name="tahunLulusNonFormal" autocomplete="off" rows="10" ><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div> --}}

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lama Pendidikan</label>
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose502" type="text" class="form-control" placeholder="yyyy"
                                                                            name="tahunMasukNonFormal" style="text-align: center" autocomplete="off"  rows="10" readonly>
                                                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                                                            <input id="datepicker-autoclose503" type="text" style="text-align: center" class="form-control" placeholder="yyyy"
                                                                                name="tahunLulusNonFormal" autocomplete="off"  rows="10" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Ijazah</label>
                                                                    <input type="text" name="noijazahPnonformal"
                                                                        class="form-control"
                                                                        aria-describedby="emailHelp"
                                                                        placeholder="Masukkan No. Ijazah"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div></div><br><br><br><br>
                                                            <button type="submit" name="submit" class="btn btn-sm btn-dark" style="margin-left:190px;margin-top:10px;">Simpan Pendidikan Non Formal</button>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="pull-left">
                                                            <a href="/create_kontak_darurat"
                                                                class="btn btn-sm btn-info"><i
                                                                    class="fa fa-backward"></i> Sebelumnya</a>
                                                        </div>
                                                        <div class="pull-right">
                                                            {{-- <button type="submit" name="submit"
                                                                class="btn btn-sm btn-dark">Simpan</button> --}}
                                                            <a href="/create_data_pekerjaan"
                                                                class="btn btn-sm btn-success">Selanjutnya <i
                                                                    class="fa fa-forward"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </table>
                                        </div>
                                        {{-- </div> --}}
                                    </form>

                                    <form action="/update_pendidikan" method="POST" id="formUpdatePendidikan" enctype="multipart/form-data">
                                        {{-- <div class="control-group after-add-more"> --}}
                                        @csrf
                                        @method('post')
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        {{-- KIRI --}}
                                                        <div class="col-md-12">
                                                            <div
                                                                class="modal-header bg-primary panel-heading  col-sm-15 m-b-5">
                                                                <label class="text-white m-b-10">D. RIWAYAT PENDIDIKAN</label>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="nomor_index"id="nomor_index_update" value="">
                                                        <div class="col-md-6">
                                                            {{-- <div class="modal-header panel-heading  col-sm-15 m-b-5 m-t-10"> --}}
                                                            <span class="form-group badge badge-secondary col-sm-15 m-b-5 m-t-10"><label> 1. Pendidikan Formal</label></span>
                                                            {{-- </div> --}}
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1" class="form-label">Tingkat</label>
                                                                <select class="form-control selectpicker"  id="tingkat_pendidikan" name="tingkat_pendidikan">
                                                                    <option value="">Pilih Tingkat Pendidikan </option>
                                                                    <option value="SD">SD</option>
                                                                    <option value="SMP">SMP</option>
                                                                    <option value="SMA/Sederajat">SMA/Sederajat</option>
                                                                    <option value="Sarjana Muda D3">Sarjana Muda D3</option>
                                                                    <option value="Sarjana S1">Sarjana S1</option>
                                                                    <option value="Pasca Sarjana S2">Pasca Sarjana S2</option>
                                                                    <option value="Doktoral/Phd">Doktoral/Phd</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> Jurusan</label>
                                                                    <input type="text" name="jurusan" id="jurusan" class="form-control" placeholder="Masukkan Jurusan" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Nama Sekolah</label>
                                                                    <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" placeholder="Masukkan Sekolah" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> Alamat</label>
                                                                    <input type="text" name="kotaPendidikanFormal" id="kotaPendidikanFormal" class="form-control" placeholder="Masukkan Alamat">
                                                                </div>
                                                            </div>

                                                            {{-- <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tahun Lulus</label>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose20" type="text"  class="form-control" placeholder="yyyy" id="4"
                                                                                name="tahun_lulusFormal" rows="10" autocomplete="off"><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div> --}}

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lama Pendidikan</label>
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose512" type="text" class="form-control" placeholder="yyyy"
                                                                            name="tahun_masukFormal" style="text-align: center" autocomplete="off"  rows="10" readonly>
                                                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                                                            <input id="datepicker-autoclose513" type="text" class="form-control" placeholder="yyyy"
                                                                            style="text-align: center" name="tahun_lulusFormal" autocomplete="off"  rows="10" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Ijazah</label>
                                                                    <input type="text" id="noijazahPformal"
                                                                        name="noijazahPformal" class="form-control"
                                                                        aria-describedby="emailHelp"
                                                                        placeholder="Masukkan No. Ijazah"
                                                                        autocomplete="off">
                                                                </div>
                                                                <button type="submit" name="submit" class="btn btn-sm btn-dark" style="margin-left:220px;margin-top:40px;">Update Pendidikan Formal</button>
                                                            </div>
                                                        </div>

                                                        {{-- KANAN --}}
                                                        <div class="col-md-6">
                                                            {{-- <div class="modal-header  panel-heading  col-sm-15 m-b-5 m-t-10"> --}}
                                                            <span
                                                                class="form-group badge badge-secondary col-sm-15 m-b-5 m-t-10"><label
                                                                    class=""> 2. Pendidikan Non
                                                                    Formal</label></span>
                                                            {{-- </div> --}}
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Bidang / Jenis</label>
                                                                    <input type="text" name="jenis_pendidikan"
                                                                        id="jenis_pendidikan" class="form-control"
                                                                        placeholder="Masukkan Jenis Pendidikan"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lembaga
                                                                        Pendidikan</label>
                                                                    <input type="text" id="namaLembaga"
                                                                        name="namaLembaga" class="form-control"
                                                                        placeholder="Masukkan Nama Lembaga"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alamat</label>
                                                                    <input type="text" id="alamatNonformal"
                                                                        name="kotaPendidikanNonFormal"
                                                                        class="form-control"
                                                                        placeholder="Masukkan Alamat"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            {{-- <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lulus Tahun</label>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose21" type="text" class="form-control" placeholder="yyyy" id="4"
                                                                                name="tahunLulusNonFormal" autocomplete="off" rows="10" ><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div> --}}

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lama Pendidikan</label>
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose514" type="text" class="form-control" placeholder="yyyy"
                                                                            name="tahun_masukNonFormal" style="text-align: center" autocomplete="off"  rows="10" readonly>
                                                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                                                            <input id="datepicker-autoclose515" type="text" class="form-control" placeholder="yyyy"
                                                                            style="text-align: center" name="tahun_lulusNonFormal" autocomplete="off"  rows="10" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Ijazah</label>
                                                                    <input type="text" id="noijazahPnonformal"
                                                                        name="noijazahPnonformal" class="form-control"
                                                                        aria-describedby="emailHelp"
                                                                        placeholder="Masukkan No. Ijazah"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div></div><br><br><br><br><br>
                                                            <button type="submit" name="submit" class="btn btn-sm btn-dark" style="margin-left:190px;">Update Pendidikan Non Formal</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="pull-left">
                                                            <a href="/create_kontak_darurat"
                                                                class="btn btn-sm btn-info"><i
                                                                    class="fa fa-backward"></i> Sebelumnya</a>
                                                        </div>
                                                        <div class="pull-right">
                                                            <a href="/create_data_pekerjaan"
                                                                class="btn btn-sm btn-success">Selanjutnya <i
                                                                    class="fa fa-forward"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </table>
                                        </div>
                                        {{-- </div> --}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <script src="assets/js/jquery.min.js"></script> --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        {{-- <script src="assets/pages/form-advanced.js"></script> --}}

        <script type="text/javascript">
            $(document).ready(function() {
                $('#formCreatePendidikan').prop('hidden', false);
                $('#formUpdatePendidikan').prop('hidden', true);
                $(document).on('click', '#editPendidikan', function() {
                    // Menampilkan form update data dan menyembunyikan form create data
                    $('#formCreatePendidikan').prop('hidden', true);
                    $('#formUpdatePendidikan').prop('hidden', false);

                    // Ambil nomor index data yang akan diubah
                    var nomorIndex = $(this).data('key');

                    // Isi nomor index ke input hidden pada form update data
                    $('#nomor_index_update').val(nomorIndex);

                    // Ambil data dari objek yang sesuai dengan nomor index
                    var data = {!! json_encode($pendidikan) !!}[nomorIndex];
                    // Isi data ke dalam form
                    $('#tingkat_pendidikan').val(data.tingkat);
                    $('#nama_sekolah').val(data.nama_sekolah);
                    $('#jurusan').val(data.jurusan);
                    $('#noijazahPformal').val(data.ijazah_formal);
                    $('#kotaPendidikanFormal').val(data.kota_pformal);
                    $('#datepicker-autoclose512').val(data.tahun_masuk_formal);
                    $('#datepicker-autoclose513').val(data.tahun_lulus_formal);
                    // $('#tahun_lulusFormal').val(data.tahun_lulus_formal);
                    // var tanggal = new Date(data.tahun_masuk_formal);
                    // var tanggalFormatted = ("0" + tanggal.getDate()).slice(-2) + '/' + ("0" + (tanggal
                    //     .getMonth() + 1)).slice(-2) + '/' + tanggal.getFullYear();
                    // $('#tahun_masukFormal').val(tanggalFormatted);
                    // var tanggal = new Date(data.tahun_lulus_formal);
                    // var tanggalFormatted = ("0" + tanggal.getDate()).slice(-2) + '/' + ("0" + (tanggal
                    //     .getMonth() + 1)).slice(-2) + '/' + tanggal.getFullYear();
                    // $('#tahun_lulusFormal').val(tanggalFormatted);

                    $('#jenis_pendidikan').val(data.jenis_pendidikan);
                    $('#namaLembaga').val(data.nama_lembaga);
                    $('#alamatNonformal').val(data.kota_pnonformal);
                    $('#datepicker-autoclose514').val(data.tahun_masuk_nonformal);
                    $('#datepicker-autoclose515').val(data.tahun_lulus_nonformal);
                    $('#noijazahPnonformal').val(data.ijazah_nonformal);

                    // Set opsi yang dipilih pada dropdown select option
                    var select = document.getElementById("tingkat_pendidikan");
                    for (var i = 0; i < select.options.length; i++) {
                        if (select.options[i].value == data.tingkat) {
                            select.options[i].selected = true;
                            break;
                        }
                    }
                });

                $(document).on('click', '#edittPendidikan', function() {
                    // Menampilkan form update data dan menyembunyikan form create data
                    $('#formCreatePendidikan').prop('hidden', true);
                    $('#formUpdatePendidikan').prop('hidden', false);

                    // Ambil nomor index data yang akan diubah
                    var nomorIndex = $(this).data('key');

                    // Isi nomor index ke input hidden pada form update data
                    $('#nomor_index_update').val(nomorIndex);

                    // Ambil data dari objek yang sesuai dengan nomor index
                    var data = {!! json_encode($pendidikan) !!}[nomorIndex];
                    // Isi data ke dalam form
                    $('#tingkat_pendidikan').val(data.tingkat);
                    $('#nama_sekolah').val(data.nama_sekolah);
                    $('#jurusan').val(data.jurusan);
                    $('#noijazahPformal').val(data.ijazah_formal);
                    $('#kotaPendidikanFormal').val(data.kota_pformal);
                    $('#datepicker-autoclose512').val(data.tahun_masuk_formal);
                    $('#datepicker-autoclose513').val(data.tahun_lulus_formal);

                    $('#namaLembaga').val(data.nama_lembaga);
                    $('#jenis_pendidikan').val(data.jenis_pendidikan);
                    $('#alamatNonformal').val(data.kota_pnonformal);
                    $('#datepicker-autoclose514').val(data.tahun_masuk_nonformal);
                    $('#datepicker-autoclose515').val(data.tahun_lulus_nonformal);
                    // $('#datepicker-autoclose21').val(data.tahun_lulus_nonformal);
                    // var tanggal = new Date(data.tahun_masuk_nonformal);
                    // var tanggalFormatted = ("0" + tanggal.getDate()).slice(-2) + '/' + ("0" + (tanggal
                    //     .getMonth() + 1)).slice(-2) + '/' + tanggal.getFullYear();
                    // $('#tahun_masukNonFormal').val(tanggalFormatted);
                    // var tanggal = new Date(data.tahun_lulus_nonformal);
                    // var tanggalFormatted = ("0" + tanggal.getDate()).slice(-2) + '/' + ("0" + (tanggal
                    //     .getMonth() + 1)).slice(-2) + '/' + tanggal.getFullYear();
                    // $('#tahun_lulusNonFormal').val(tanggalFormatted);

                    $('#noijazahPnonformal').val(data.ijazah_nonformal);

                    // Set opsi yang dipilih pada dropdown select option
                    var select = document.getElementById("tingkat_pendidikan");
                    for (var i = 0; i < select.options.length; i++) {
                        if (select.options[i].value == data.tingkat) {
                            select.options[i].selected = true;
                            break;
                        }
                    }
                });
            });
        </script>

        <!-- datepicker  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/pages/form-advanced.js"></script>
