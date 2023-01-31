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
    @if($data['status'] == 'Disetujui')
        <strong>Ada Kabar baik nih buat Anda,</strong>
        <br><br>
        <p>permintaan <strong>Izin {{$data['jenisizin']}}</strong> Anda telah DISETUJUI oleh <strong>{{Auth::user()->name}}</strong></p>
    @else  
        <strong>Mohon Maaf</strong>
        <br><br>
        <p>permintaan <strong>Izin {{$data['jenisizin']}}</strong> Anda DITOLAK oleh <strong>{{Auth::user()->name}}</strong></p> 
    @endif
    
    <p>Silahkan buka halaman website Anda untuk mengetahui detail lebih lanjut atau <a href="/cuti-staff">click here!</a> </p>
    <br>
    <label>DETAIL PERMINTAAN IZIN:</label><br>
    <div class="modal-body">
        <div class="form-group row">
            <label for="id" class="col-sm-3 col-form-label">Id Izin</label><label>: {{$data['id']}}</label>
        </div>
        <div class="form-group row">
            <label for="id_karyawan" class="col-sm-3 col-form-label">Nama Karyawan</label><label>: {{$data['nama']}}</label>
        </div>

        <div class="form-group row">
            <label for="id_jenisizin" class="col-sm-3 col-form-label">Kategori Izin</label><label>: {{$data['jenisizin']}}</label>
        </div>

        <div class="form-group row" id="statuscuti">
            <label for="status" class="col-sm-3 col-form-label">Status Izin</label>
            @if($data['status'] == 'Disetujui')
                <span class="text-white badge badge-info">DISETUJUI</span>
            @else
                <span class="text-white badge badge-danger">DITOLAK</span>
            @endif
        </div>
    </div>
</body>
</html>

 {{-- <div class="form-group row">
            <label for="id_karyawan" class="col-sm-3 col-form-label">Keperluan</label><label>: {{$data['keperluan']}}</label>
        </div> --}}

        {{-- <div class="form-group row">
            <label for="tgl_mulai" class="col-sm-3 col-form-label">Tanggal Mulai</label><label>: {{$data['tgl_mulai']}}</label>
        </div> --}}

        {{-- @if($data[''])
        <div class="form-group row">
            <label for="tgl_selesai" class="col-sm-3 col-form-label">Tanggal Selesai</label><label>: {{$data['tgl_selesai']}}</label>
        </div> --}}
        {{-- <div class="form-group row">
            <label for="jml_hari" class="col-sm-3 col-form-label">Jumlah Hari</label>
            <label>: {{$data['jml_hari']}} hari</label>
        </div>

        <div class="form-group row">
            <label for="jml_jam" class="col-sm-3 col-form-label">Jumlah Jam</label>
            <label>: {{$data['jml_jam']}} jam</label>
        </div> --}}