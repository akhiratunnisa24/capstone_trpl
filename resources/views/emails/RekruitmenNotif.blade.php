<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z">
    <title>Pemberitahuan - Rekruitmen RTI Posisi {{ $data->posisi }}</title>
    <style>
        .badge {
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 20px;
            text-transform: uppercase;
        }
        .badge-warning {
            background-color: #dffb07;
        }
        .badge-info {
            background-color: #1acce8; 
        }
        .badge-success {
            background-color: #11e041;
        }
        .badge-danger {
            background-color: #f13012;
        }
    </style>
</head>
<body>
    <strong>Yth. Bapak / Ibu {{ $data->nama }}</strong>
    <br><br>
    {{-- <p>Anda memiliki notifikasi permintaan <strong>{{$data['id_jeniscuti']}}</strong> dari Saudara/i <strong>{{Auth::user()->id_pegawai}}</strong></p> --}}
    <p>Selamat anda lolos ke tahap selanjutnya ! </p>
    <br>
    <label>Detail Pelamar :</label><br>
    <div class="modal-body">
        <div class="form-group row">
            <label for="id" class="col-sm-3 col-form-label">NIK</label><label>: {{$data->nik}}</label>
        </div>

        <div class="form-group row">
            <label for="id" class="col-sm-3 col-form-label">Nama Lengkap</label><label>: {{$data->nama}}</label>
        </div>

        <div class="form-group row">
            <label for="id_karyawan" class="col-sm-3 col-form-label">Tanggal Lahir</label><label>: {{\Carbon\Carbon::parse($data->tgllahir)->format("d M Y")}}</label>
        </div>

        <div class="form-group row">
            <label for="id_jeniscuti" class="col-sm-3 col-form-label">Email</label><label>: {{$data->email}}</label>
        </div>

        <div class="form-group row">
            <label for="id_jeniscuti" class="col-sm-3 col-form-label">Agama</label><label>: {{$data->agama}}</label>
        </div>

        <div class="form-group row">
            <label for="id_karyawan" class="col-sm-3 col-form-label">Jenis Kelamin</label>@if($data->jenis_kelamin == 'P')
                            <label>Perempuan</label>
                        @else
                            <label>Laki-Laki</label>
                        @endif
        </div>

        <div class="form-group row">
            <label for="tgl_mulai" class="col-sm-3 col-form-label">Alamat</label><label>: {{$data->alamat}}</label>
        </div>

        <div class="form-group row">
            <label for="tgl_selesai" class="col-sm-3 col-form-label">Nomor Handphone</label><label>: {{$data->no_hp}}</label>
        </div>

        <div class="form-group row">
            <label for="tgl_selesai" class="col-sm-3 col-form-label">Nomor Kartu Keluarga</label><label>: {{$data->no_kk}}</label>
        </div>

        <div class="form-group row">
            <label for="status" class="col-sm-3 col-form-label">Status Rekruitmen</label>
            <span class="text-white badge badge-success">Lanjut ke tahap {{ $data->mrekruitmen->nama_tahapan }}</span>
        </div>

    </div>
</body>
</html>