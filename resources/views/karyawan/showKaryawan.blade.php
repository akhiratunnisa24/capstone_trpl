@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <div class="flex-grow-1 mt-1 ms-4 col-mb-12 d-flex">
                    <div class="row col-mb-12" style="margin-left:20px">
                        <a href="" class="dropdown-toggle profile waves-effect waves-light pull-left"><img
                                src="{{ asset('Foto_Profile/' . $karyawan->foto) }}" alt="user-img" class="img-circle"
                                style="width:80px;height:80px"> </a>
                        <div class="col-md-7 pull-left m-t-10">
                            <span class="text-muted font-size-14">Selamat Datang,</span>
                            <span class="text-muted d-block mb-2">
                                <h4 class="fw-bolder mb-3">{{ $karyawan->nama }}</h4>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-primary" style="border-radius:25px">
                <div class="panel-body">
                    <div class="row col-mb-12" style="margin-left:10px">
                        <a href="#data-keluarga"><i class="fa m-t-15 fa-users fa-3x text-success pull-left"></i></a>
                        <div class="col-md-7 pull-left">
                            <a href="#data-keluarga">
                                <h2 class=""><b>{{ $keluarga->count() }}</b></h2>
                            </a>
                            <a href="#data-keluarga"><span class="text-muted font-size-14">Data Keluarga</span></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-primary" style="border-radius:25px">
                <div class="panel-body">
                    <div class="row col-mb-12" style="margin-left:15px">
                        <a href="#kontak-darurat"><i class="fa m-t-15 fa-phone-square fa-3x text-success pull-left"></i></a>
                        <div class="col-md-7 pull-left">
                            <a href="#kontak-darurat">
                                <h2 class=""><b>{{ $kdarurat->count() }}</b></h2>
                            </a>
                            <a href="#kontak-darurat"><span class="text-muted font-size-14">Kontak Darurat</span></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-primary" style="border-radius:25px">
                <div class="panel-body">
                    <div class="row col-mb-12" style="margin-left:15px">
                        <a href="#riwayat-pendidikan"><i
                                class="fa m-t-15 fa-mortar-board (alias) fa-3x text-success pull-left"></i></a>
                        <div class="col-md-7 pull-left">
                            <a href="#riwayat-pendidikan">
                                <h2 class=""><b>{{ $rpendidikan->count() }}</b></h2>
                            </a>
                            <a href="#riwayat-pendidikan"><span class="text-muted font-size-14">Data Pendidikan</span></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-primary" style="border-radius:25px">
                <div class="panel-body">
                    <div class="row col-mb-12" style="margin-left:10px">
                        <a href="#riwayat-pekerjaan"><i class="fa m-t-15 fa-briefcase fa-3x text-success pull-left"></i></a>
                        <div class="col-md-7 pull-left">
                            <a href="#riwayat-pekerjaan">
                                <h2 class=""><b>{{ $rpekerjaan->count() }}</b></h2>
                            </a>
                            <a href="#riwayat-pekerjaan"><span class="text-muted font-size-14">Data Pekerjaan</span></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card" style="margin: 20px">
            <div>
                <div class="card-header">
                    <h4> A. DATA DIRI</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label>Nama lengkap *</label>
                            <input type="text" class="form-control" value="{{ $karyawan->nama ? $karyawan->nama : '-' }}">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Agama *</label>
                            <input type="text" class="form-control" value="{{ $karyawan->agama ? $karyawan->agama : '-' }}">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>NIK (No. KTP) *</label>
                            <input type="text" class="form-control" value="{{ $karyawan->nik ? $karyawan->nik : '-' }}">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>E-Mail *</label>
                            <input type="text" class="form-control" value="{{ $karyawan->email ? $karyawan->email : '-' }}">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Tanggal Lahir *</label>
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($karyawan->tgllahir)->format('d/m/Y') ? Carbon\Carbon::parse($karyawan->tgllahir)->format('d/m/Y')  : '-'}}">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Jabatan *</label>
                            <input type="text" class="form-control" value="{{ $karyawan->nama_jabatan ? $karyawan->nama_jabatan : '-' }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label>Jenis Kelamin</label>
                            <input type="email" class="form-control" value="{{$karyawan->jenis_kelamin ? $karyawan->jenis_kelamin : '-' }}">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Departemen *</label>
                            <input type="tel" class="form-control" value="{{ $karyawan->departemens->nama_departemen ? $karyawan->departemens->nama_departemen : '-' }}">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Golongan Darah *</label>
                            <input type="text" class="form-control" value="{{ $karyawan->gol_darah ? $karyawan->gol_darah : '-' }}">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Jabatan *</label>
                            <input type="text" class="form-control" value="{{ $karyawan->nama_jabatan ? $karyawan->nama_jabatan : '-' }}">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Alamat *</label>
                            <input type="text" class="form-control" value="{{ $karyawan->alamat ? $karyawan->alamat : '-' }}">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Atasan/Pimpinan (Manager/Direksi)</label>
                            <input type="text" class="form-control" value="{{$atasan_kedua_nama ? $atasan_kedua_nama : '-' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="panel panel-primary">
        <div id="data-keluarga">
            <div class="modal-body" style="margin-left:15px;margin-right:15px;">
                <label>
                    <h4>B. DATA KELUARGA & TANGGUNGAN</h4>
                </label>
                <table class="table table-striped">
                    <thead class="alert alert-info">
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Hubungan</th>
                            <th>Alamat</th>
                            <th>Pendidikan Terakhir</th>
                            <th>Pekerjaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keluarga as $keluarga)
                            <tr>
                                <td>{{ $keluarga->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($keluarga->tgllahir)->format('d/m/Y') }}</td>
                                <td>{{ $keluarga->hubungan }}</td>
                                <td>{{ $keluarga->alamat }}</td>
                                <td>{{ $keluarga->pendidikan_terakhir }}</td>
                                <td>{{ $keluarga->pekerjaan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}

        {{-- <div id="kontak-darurat">
            <div class="modal-body" style="margin-left:15px;margin-right:15px;">
                <label>
                    <h4>C. KONTAK DARURAT </h4>
                </label>
                <a class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#addKontak"
                    style="margin-right:10px;margin-bottom:10px"> <i class="fa fa-plus"> <strong>Tambah Data</strong></i>
                </a>
                @include('karyawan.addKontak')
                <table class="table table-striped">
                    <thead class="alert alert-info">
                        <tr>
                            <th>Nama</th>
                            <th>Hubungan</th>
                            <th>Nomor Handphone</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kdarurat as $kdarurat)
                            <tr>
                                <td>{{ $kdarurat->nama }}</td>
                                <td>{{ $kdarurat->hubungan }}</td>
                                <td>{{ $kdarurat->no_hp }}</td>
                                <td>{{ $kdarurat->alamat }}</td>
                                <td class=""><a class="btn btn-sm btn-primary editPformal" data-toggle="modal"
                                        data-target="#editDarurat{{ $kdarurat->id }}" style="margin-right:10px">
                                        <i class="fa fa-edit" title="Edit"></i>
                                    </a>
                            </tr>
                            @include('karyawan.editKontakdarurat')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="riwayat-pendidikan">
            <div class="modal-body" style="margin-left:15px;margin-right:15px;">
                <label class="" width="100%">
                    <h4>D. RIWAYAT PENDIDIKAN</h4>
                </label><br>
                <table class="table table-striped">
                    <label class="text-white badge bg-info">Pendidikan Formal</label>
                    <a class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#addPformal"
                        style="margin-right:10px;margin-bottom:10px"> <i class="fa fa-plus"> <strong>Tambah
                                Data</strong></i>
                    </a>
                    @include('karyawan.addPformal')
                    <thead class="alert alert-info">
                        <tr>
                            <th>Tingkat Pendidikan</th>
                            <th>Nama Sekolah</th>
                            <th>Jurusan</th>
                            <th>Tahun Masuk</th>
                            <th>Tahun Lulus</th>
                            <th>Alamat</th>
                            <th>Nomor Ijazah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rpendidikan as $rpendidikan)
                            @if ($rpendidikan->tingkat != null)
                                <tr>
                                    <td>{{ $rpendidikan->tingkat }}</td>
                                    <td>{{ $rpendidikan->nama_sekolah }}</td>
                                    <td>{{ $rpendidikan->jurusan }}</td>
                                    @if ($rpendidikan->tahun_masuk_formal !== null)
                                        <td>{{ $rpendidikan->tahun_masuk_formal }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if ($rpendidikan->tahun_lulus_formal !== null)
                                        <td>{{ $rpendidikan->tahun_lulus_formal }}
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>{{ $rpendidikan->kota_pformal }}</td>
                                    <td>{{ $rpendidikan->ijazah_formal }}</td>
                                    <td class="">
                                        <a class="btn btn-sm btn-primary editPformal " data-toggle="modal"
                                            data-target="#editPformal{{ $rpendidikan->id }}" style="margin-right:10px">
                                            <i class="fa fa-edit" title="Edit"></i>
                                        </a>
                                </tr>
                            @endif
                            @include('karyawan.editPformal')
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-body" style="margin-left:15px;margin-right:15px;">
                <label class="text-white badge bg-info">Pendidikan Non Formal</label>
                <a class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#addPnformal"
                    style="margin-right:10px;margin-bottom:10px"><i class="fa fa-plus"> <strong>Tambah Data</strong></i>
                </a>
                @include('karyawan.addPnformal')
                <table class="table table-striped">
                    <thead class="alert alert-info">
                        <tr> --}}
                            {{-- <th>No</th> --}}
                            {{-- <th>Bidang/Jenis</th>
                            <th>Lembaga Pendidikan</th>
                            <th>Tahun Mulai</th>
                            <th>Tahun Lulus</th>
                            <th>Alamat</th>
                            <th>Nomor Ijazah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendidikan as $pendidikan)
                            @if ($pendidikan->jenis_pendidikan != null)
                                <tr>
                                    <td>{{ $pendidikan->jenis_pendidikan }}</td>
                                    <td>{{ $pendidikan->nama_lembaga }}</td>
                                    @if ($pendidikan->tahun_masuk_nonformal !== null)
                                        <td>{{ $pendidikan->tahun_masuk_nonformal }}
                                        </td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if ($pendidikan->tahun_lulus_nonformal !== null)
                                        <td>{{ $pendidikan->tahun_lulus_nonformal }}
                                        </td>
                                    @else
                                        <td></td>
                                    @endif

                                    <td>{{ $pendidikan->kota_pnonformal }}</td>
                                    <td>{{ $pendidikan->ijazah_nonformal }}</td>
                                    <td class="">
                                        <a class="btn btn-sm btn-primary editPnformal" data-toggle="modal"
                                            data-target="#editPnformal{{ $pendidikan->id }}" style="margin-right:10px">
                                            <i class="fa fa-edit" title="Edit"></i>
                                    </td>
                                </tr>
                                @include('karyawan.editPnformal')
                            @endif
                        @empty
                            <td>No data available on table</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> --}}

        {{-- <div id="riwayat-pekerjaan">
            <div class="modal-body" style="margin-left:15px;margin-right:15px;">
                <label class="" width="100%">
                    <h4>E. RIWAYAT PENGALAMAN BEKERJA</h4>
                </label>
                <table class="table table-striped">
                    <thead class="alert alert-info">
                        <tr>
                            <th>Perusahaan</th>
                            <th>Jenis Usaha</th>
                            <th>Jabatan</th>
                            <th>Lama Kerja</th>
                            <th>Gaji</th>
                            <th>Atasan</th>
                            <th>Direktur</th>
                            <th>Alamat</th>
                            <th>Alasan Berhenti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rpekerjaan as $rpekerjaan)
                            <tr>
                                <td>{{ $rpekerjaan->nama_perusahaan }}</td>
                                <td>{{ $rpekerjaan->jenis_usaha }}</td>
                                <td>{{ $rpekerjaan->jabatan }}</td>
                                <td>{{ $rpekerjaan->lama_kerja }}</td>
                                <td>Rp. {{ $rpekerjaan->gaji }},-</td>
                                <td>{{ $rpekerjaan->nama_atasan }}</td>
                                <td>{{ $rpekerjaan->nama_direktur }}</td>
                                <td>{{ $rpekerjaan->alamat }}</td>
                                <td>{{ $rpekerjaan->alasan_berhenti }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a href="karyawandashboard" class="btn btn-sm btn-danger">Kembali</a>
        </div>
    </div> --}}

@endsection
