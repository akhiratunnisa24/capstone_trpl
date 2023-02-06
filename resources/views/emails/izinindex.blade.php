<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Pemberitahuan - Permintaan Izin Karyawan</title>
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
    {{-- <strong>Yth. Bapak/Ibu {{$data['nama_atasan']}}</strong> --}}
    <strong>Yth. {{$data['jabatan']}}</strong>
    <br><br>
    <p>Anda memiliki notifikasi permintaan <strong>Izin {{$data['jenisizin']}}</strong> dari Saudara/i <strong>{{Auth::user()->name}}</strong></p>
    <p>Silahkan buka halaman website Anda untuk melakukan Approval pada permintaan izin tersebut atau <a href="/cuti-staff">click here!</a> </p>
    <br>
    <label>DETAIL PERMINTAAN IZIN:</label><br>
    <div class="modal-body">
        <div class="form-group row">
            <label for="id" class="col-sm-3 col-form-label">Id Izin</label><label>: {{$data['id']}}</label>
        </div>

        <div class="form-group row">
            <label for="id_karyawan" class="col-sm-3 col-form-label">Nama Karyawan</label><label>: {{Auth::user()->name}}</label>
        </div>

        <div class="form-group row">
            <label for="id_jenisizin" class="col-sm-3 col-form-label">Kategori Izin</label><label>: {{$data['jenisizin']}}</label>
        </div>

        <div class="form-group row">
            <label for="id_karyawan" class="col-sm-3 col-form-label">Keperluan</label><label>: {{$data['keperluan']}}</label>
        </div>

        <div class="form-group row">
            <label for="tgl_mulai" class="col-sm-3 col-form-label">Tanggal Mulai</label><label>: {{$data['tgl_mulai']}}</label>
        </div>

        {{-- @if($data[''])
        <div class="form-group row">
            <label for="tgl_selesai" class="col-sm-3 col-form-label">Tanggal Selesai</label><label>: {{$data['tgl_selesai']}}</label>
        </div> --}}
        <div class="form-group row">
            <label for="jml_hari" class="col-sm-3 col-form-label">Jumlah Hari</label>
            <label>: {{$data['jml_hari']}} hari</label>
        </div>

        <div class="form-group row">
            <label for="jml_jam" class="col-sm-3 col-form-label">Jumlah Jam</label>
            <label>: {{$data['jml_jam']}} jam</label>
        </div>

        <div class="form-group row" id="statuscuti">
            <label for="status" class="col-sm-3 col-form-label">Status Izin</label>
            @if($data['status'] == 'Pending')
                <span class="text-white badge badge-warning">PENDING</span>
            @endif
        </div>
    </div>
</body>
</html>