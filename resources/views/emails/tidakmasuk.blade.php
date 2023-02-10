<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Pengurangan Jatah Cuti Tahunan</title>
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
    <h1>Notifikasi Pengurangan Jatah Cuti Tahunan</h1>
    <p>Kepada {{$data['nama']}}</p>
    <p>Kami ingin memberitahukan bahwa jatah cuti tahunan Anda telah berkurang sebanyak <strong>{{$data['jml_cuti']}} hari</strong>.</p>
    <p>Hal ini dapat disebabkan oleh beberapa alasan berikut:</p>
    <ul>
        <li>Anda tidak hadir pada tanggal <strong>{{$data['tanggal']}}</strong> tanpa keterangan dan tanpa pemberitahuan kepada atasan.</li>
        <li>Pada hari <strong>{{$data['tanggal']}}</strong> anda tidak memiliki pengajuan cuti dan izin kepada atasan.</li>
    </ul><br>
    <p>Saat ini jatah Cuti Tahunan Anda tersisa <strong>{{$data['jatahcuti']}} hari.</strong></p>

    <label>DETAIL DATA TIDAK MASUK:</label><br>
    <div class="modal-body">
        <div class="form-group row">
            <label for="id" class="col-sm-3 col-form-label">Id Tidak Masuk</label><label>: {{$data['id']}}</label>
        </div>

        <div class="form-group row">
            <label for="id_karyawan" class="col-sm-3 col-form-label">Nama Karyawan</label><label>: {{$data['nama']}}</label>
        </div>

        <div class="form-group row">
            <label for="id_jeniscuti" class="col-sm-3 col-form-label">Kategori Cuti</label><label>: {{$data['id_jeniscuti']}}</label>
        </div>

        <div class="form-group row">
            <label for="tgl_mulai" class="col-sm-3 col-form-label">Tanggal</label><label>: {{$data['tanggal']}}</label>
        </div>

        <div class="form-group row">
            <label for="id_karyawan" class="col-sm-3 col-form-label">Keterangan</label><label>: {{$data['keterangan']}}</label>
        </div>

    </div>

    <p>Harap segera memperhatikan absensi dan kehadiran Anda agar tidak terjadi pengurangan jatah cuti tahunan lagi di masa yang akan datang.</p><br>
    <p>Terima kasih.</p>
    <p>Hormat kami,</p>
    <br><br>
    <p>HRD</p>
</body>
</html>