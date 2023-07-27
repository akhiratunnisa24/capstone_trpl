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
    @if ($data->jenis_kelamin == 'Laki-Laki')
    <strong>Yth. Bapak {{ $data->nama }}</strong>
    @else
    <strong>Yth. Ibu {{ $data->nama }}</strong>
    @endif
    <br><br>
    {{-- <p>Anda memiliki notifikasi permintaan <strong>{{$data['id_jeniscuti']}}</strong> dari Saudara/i <strong>{{Auth::user()->id_pegawai}}</strong></p> --}}
    {{-- <p>Selamat anda lolos ke tahap {{ $data->mrekruitmen->nama_tahapan }} </p> --}}
    <p> Kami ingin memberitahukan bahwa setelah melakukan evaluasi terhadap berkas lamaran yang telah Anda kirimkan, kami memutuskan untuk melanjutkan tahap seleksi Anda ke tahap <strong>{{ $data->mrekruitmen->nama_tahapan }}</strong> . </p>
    <br>
    <p>Detail Pelamar :</p>

    <div class="modal-body">
        <div style="margin-left: 20px;">

    <strong>NIK : </strong><span>{{ $data->nik }}</span><br>
    <strong>Nama Lengkap : </strong><span>{{$data->nama}}</span><br>
    <strong>Tanggal Lahir : </strong><span>{{\Carbon\Carbon::parse($data->tgllahir)->format("d M Y")}}</span><br>
    <strong>Email : </strong><span>{{ $data->email }}</span><br>
    <strong>Agama : </strong><span>{{ $data->agama }}</span><br>
    <strong>Jenis Kelamin : </strong><span>{{ $data->jenis_kelamin }}</span><br>

        <strong>Alamat : </strong><span>{{ $data->alamat }}</span><br>
        <strong>Nomor Handphone : </strong><span>{{ $data->no_hp }}</span><br>
        <strong>Status Rekruitmen : </strong><span>Lanjut ke tahap <strong>{{ $data->mrekruitmen->nama_tahapan }} </strong> </span><br>
        <strong>Tanggal {{ $data->mrekruitmen->nama_tahapan }} : </strong><span>{{ \Carbon\Carbon::parse($data->tanggal_tahapan)->format('d M Y') }}</span><br>
        @if ($data->link)
        <strong>Link {{ $data->mrekruitmen->nama_tahapan }} : </strong><span>{{ $data->link }}</span><br>
        @endif
        {{-- <div class="form-group row">
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
            <label for="id_karyawan" class="col-sm-3 col-form-label">Jenis Kelamin</label>
            @if($data->jenis_kelamin == 'P')
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
            <label>Lanjut ke tahap {{ $data->mrekruitmen->nama_tahapan }}</label>
        </div>

         <div class="form-group row">
            <label for="status" class="col-sm-3 col-form-label">{{ $data->mrekruitmen->nama_tahapan }} akan dilaksanakan pada </label>
            <br>
            <label for="status" class="col-sm-3 col-form-label">Tanggal : </label>
            <label class="col-sm-3 col-form-label">{{ $data->tanggal_tahapan }}</label>
        </div>

        <div class="form-group row">
        @if ($data->link)
            <label for="status" class="col-sm-3 col-form-label">Link : </label>
            <label class="col-sm-3 col-form-label">{{ $data->link }}</label>
        @endif
        </div> --}}

    </div>
    </div>

    <p>Kami juga ingin mengucapkan terima kasih atas minat dan partisipasi Anda dalam mengikuti seleksi di perusahaan kami.</p>

</body>
<div class="footer">
			<p>Email ini dikirimkan secara otomatis. Jangan membalas email ini karena tidak akan terbaca. Hubungi kami di <b><a href="mailto:">info@grm-risk.com</a></b> atau anda bisa menghubungi <a href="#">(+62) 811-140-840-5</a> untuk informasi lebih lanjut.</p>
		</div>
</html>