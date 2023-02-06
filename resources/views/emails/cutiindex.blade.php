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
    @if($data['role'] == 2)
        <strong>Yth. SUPERVISOR </strong>
    @else
        {{-- @if($role == 1 || $role == 3) --}}
            <strong>Yth. Direktur PT...</strong>
        {{-- @endif --}}
    @endif
    <br><br>
    <p>Anda memiliki notifikasi permintaan <strong>{{$data['id_jeniscuti']}}</strong> dari Saudara/i <strong>{{Auth::user()->name}}</strong></p>
    <p>Silahkan buka halaman website Anda untuk melakukan Approval pada permintaan cuti tersebut atau <a href="/cuti-staff">click here!</a> </p>
    <br>
    <label>DETAIL PERMINTAAN CUTI:</label><br>
    <div class="modal-body">
        <div class="form-group row">
            <label for="id" class="col-sm-3 col-form-label">Id Cuti</label><label>: {{$data['id']}}</label>
        </div>

        <div class="form-group row">
            <label for="id_karyawan" class="col-sm-3 col-form-label">Nama Karyawan</label><label>: {{Auth::user()->name}}</label>
        </div>

        <div class="form-group row">
            <label for="id_jeniscuti" class="col-sm-3 col-form-label">Kategori Cuti</label><label>: {{$data['id_jeniscuti']}}</label>
        </div>

        <div class="form-group row">
            <label for="id_karyawan" class="col-sm-3 col-form-label">Keperluan</label><label>: {{$data['keperluan']}}</label>
        </div>

        <div class="form-group row">
            <label for="tgl_mulai" class="col-sm-3 col-form-label">Tanggal Mulai</label><label>: {{$data['tgl_mulai']}}</label>
        </div>

        <div class="form-group row">
            <label for="tgl_selesai" class="col-sm-3 col-form-label">Tanggal Selesai</label><label>: {{$data['tgl_selesai']}}</label>
        </div>
        <div class="form-group row">
            <label for="jml_cuti" class="col-sm-3 col-form-label">Jumlah Cuti</label>
                <label>: {{$data['jml_cuti']}} hari</label>
        </div>
        <div class="form-group row" id="statuscuti">
            <label for="status" class="col-sm-3 col-form-label">Status Cuti</label>
            <span class="text-white badge badge-warning">PENDING</span>
        </div>
    </div>
</body>
</html>