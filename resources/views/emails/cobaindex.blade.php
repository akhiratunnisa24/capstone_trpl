<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Pemberitahuan - Permintaan Cuti Baru</title>
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
    <strong>Yth. Manager $data->departemens->nama_departemen</strong>
    <br><br>
    <p>Anda memiliki notifikasi permintaan <strong>{{$data['jenis_cuti']}}</strong> dari Saudara/i <strong>{{$data['nama']}}</strong></p>
    <p>Silahkan buka halaman website Anda untuk melakukan Approval pada permintaan cuti tersebut atau <a href="/cuti-staff">click here!</a> </p>
    <br>
    <label>DETAIL PERMINTAAN CUTI:</label><br>
    <div class="modal-body">
        <div class="form-group row">
            <label for="id" class="col-sm-3 col-form-label">Id Cuti</label><label>: {{$data['id']}}</label>
        </div>

        <div class="form-group row">
            <label for="id_karyawan" class="col-sm-3 col-form-label">Nama Karyawan</label><label>: {{$data['nama']}}</label>
        </div>

        <div class="form-group row">
            <label for="id_jeniscuti" class="col-sm-3 col-form-label">Kategori Cuti</label><label>: {{$data['jenis_cuti']}}</label>
        </div>

        <div class="form-group row">
            <label for="id_karyawan" class="col-sm-3 col-form-label">Keperluan</label><label>: {{$data['keperluan']}}</label>
        </div>

        <div class="form-group row">
            <label for="tgl_mulai" class="col-sm-3 col-form-label">Tanggal Mulai</label><label>: {{\Carbon\Carbon::parse($data['tgl_mulai'])->format("d/m/Y")}}</label>
        </div>

        <div class="form-group row">
            <label for="tgl_selesai" class="col-sm-3 col-form-label">Tanggal Selesai</label><label>: {{\Carbon\Carbon::parse($data['tgl_selesai'])->format("d/m/Y")}}</label>
        </div>
        <div class="form-group row">
            <label for="jml_cuti" class="col-sm-3 col-form-label">Jumlah Cuti</label>
                <label>: {{$data['jml_cuti']}} hari</label>
        </div>
        <div class="form-group row" id="statuscuti">
            <label for="status" class="col-sm-3 col-form-label">Status Cuti</label>
                {{-- @if($data->status == 'Pending') --}}
                    <span class="text-white badge badge-warning">PENDING</span><br><br>
                {{-- @elseif($data->status == 'Disetujui Manager')
                    <span class="text-white badge badge-info">DISETUJUI MANAGER</span><br><br>
                @elseif($data->status == 'Disetujui')
                    <span class="text-white badge badge-success">DISETUJUI</span><br><br>
                @else
                    <span class="text-white badge badge-danger">DITOLAK</span><br><br>
                @endif --}}
        </div>
    </div>
</body>
</html>