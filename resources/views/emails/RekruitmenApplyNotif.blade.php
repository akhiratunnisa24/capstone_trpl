<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z">
    <title> Pemberitahuan Penerimaan Lamaran melalui Website {{ $posisi }}</title>
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
    {{-- @if ($data->jenis_kelamin == 'L')
    <strong>Yth. Kepada HRD, {{ $data->nama }}</strong>
    @else
    <strong>Yth. Ibu {{ $data->nama }}</strong>
    @endif --}}

    <strong>Yth. Kepada HRD</strong>

    <br><br>

    <p>Salam Sejahtera!</p>
    <p>REMS ingin memberitahu bahwa ada seorang pelamar yang telah mengisi formulir lamaran pekerjaan melalui website
        perusahaan dan telah memenuhi syarat untuk dipertimbangkan sebagai calon karyawan di perusahaan.</p>

    <p>Berikut ini adalah informasi pelamar:</p>

    {{-- <div style="margin-left: 20px;">
        <strong>
            <p>Posisi yang Dilamar : {{ $posisi->posisi }}</p>
        </strong>
        <p>Tanggal Pengiriman : {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</p>
        <p>Nama Pelamar : {{ $data->nama }}</p>
        <p>Tanggal Lahir : {{ \Carbon\Carbon::parse($data->tgllahir)->format('d M Y') }}</p>
        <p>Tempat Lahir : {{ $data->tempatlahir }}</p>
        <p>Agama : {{ $data->agama }}</p>
        <p>Jenis Kelamin : {{ $data->jenis_kelamin }}</p>
        <p>Status Pernikahan : {{ $data->status_pernikahan }}</p>
        <p>Email : {{ $data->email }}</p>
        <p>Nomor Handphone : {{ $data->no_hp }}</p>

    </div> --}}

    <div style="margin-left: 20px;">
    <strong>Posisi yang Dilamar : </strong><span>{{ $posisi->posisi }}</span><br>
    <strong>Tanggal Pengiriman : </strong><span>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</span><br>
    <strong>Nama Pelamar : </strong><span>{{ $data->nama }}</span><br>
    <strong>Tanggal Lahir : </strong><span>{{ \Carbon\Carbon::parse($data->tgllahir)->format('d M Y') }}</span><br>
    <strong>Tempat Lahir : </strong><span>{{ $data->tempatlahir }}</span><br>
    <strong>Agama : </strong><span>{{ $data->agama }}</span><br>
    <strong>Jenis Kelamin : </strong><span>{{ $data->jenis_kelamin }}</span><br>
    <strong>Status Pernikahan : </strong><span>{{ $data->status_pernikahan }}</span><br>
    <strong>Email : </strong><span>{{ $data->email }}</span><br>
    <strong>Nomor Handphone : </strong><span>{{ $data->no_hp }}</span><br>
</div>

    <br>

    <p>Anda dapat masuk ke website sebagai HRD untuk melihat detail formulir lamaran pekerjaan dan dokumen pendukung
        lainnya yang telah dilampirkan oleh pelamar. atau <a href="dev.rynest-technology./data_rekrutmen">click here!</a> </p>

</body>
<div class="footer">
			<p>Email ini dikirimkan secara otomatis. Jangan membalas email ini karena tidak akan terbaca. Hubungi kami di <b><a href="mailto:">info@grm-risk.com</a></b> atau anda bisa menghubungi <a href="#">(+62) 811-140-840-5</a> untuk informasi lebih lanjut.</p>
		</div>



</html>
