<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Pemberitahuan - Permintaan Izin Karyawan</title>
	<style type="text/css">
		/* Reset CSS */
		body, p, h1, h2, h3, h4, h5, h6, ul, ol, li, table, tr, td, img {
			margin: 0;
			padding: 0;
			border: none;
			font-size: 100%;
			font-weight: normal;
			line-height: 1.2;
			text-align: left;
			vertical-align: top;
		}
		img {
			max-width: 100%;
			height: auto;
			display: block;
		}
		table {
			border-collapse: collapse;
			border-spacing: 0;
			width: 100%;
		}
		td {
			vertical-align: top;
			padding: 10px;
		}
		/* Styling Email */
		body {
			background-color: #f8f8f8;
			font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
			color: #333333;
		}
		.wrapper {
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			background-color: #ffffff;
			box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
			border-radius: 5px;
		}
		.header {
			padding: 20px 0;
			text-align: center;
			background-color: #ffffff;
			border-radius: 5px 5px 0 0;
		}
		.header h1 {
			font-size: 24px;
			font-weight: bold;
			color: #ffffff;
			margin-bottom: 10px;
		}
		.content {
			padding: 20px;
			font-size: 14px;
			line-height: 1.5;
		}
		.content h2 {
			font-size: 20px;
			font-weight: bold;
			margin-bottom: 20px;
		}
		.content p {
			margin-bottom: 20px;
            text-align: justify;
		}
		.button {
			display: inline-block;
			padding: 10px 20px;
			background-color: #ffbe00;
			color: #ffffff;
			font-size: 16px;
			font-weight: bold;
			text-decoration: none;
			border-radius: 5px;
		}
		.button:hover {
			background-color: #ffa600;
		}
		.footer {
			padding: 20px;
			text-align: center;
			background-color: #f0f0f0;
			border-radius: 0 0 5px 5px;
		}
		.footer p {
			font-size: 12px;
			color: #999999;
			line-height: 1.2;
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

		ul {
			margin-left: 3.5cm;
		}

		li {
			margin-bottom: 0.5cm;
		}

		.title {
            display: inline-block;
            width: 150px; /* Sesuaikan lebar sesuai kebutuhan */
        }

        .value {
            display: inline-block;
            margin-left: 5px; /* Sesuaikan jarak kiri sesuai kebutuhan */
			width: 350px;
        }
		.subtitle {
			display: inline-block;
			width: 250px; /* Sesuaikan lebar judul (title) sesuai kebutuhan */
		}

		h4 {
			text-align: center;
			margin-bottom: 20px;
			font-weight: bold;
		}
	</style>
</head>
<body>
	<div class="wrapper">
		<div class="header">
        </div>
        <div class="content">
			<div>
				<h4><b>{{$data['title']}}</b></h4>
				<h4><b>{{$data['subtitle']}}</b><br></h4>

				<p class="title">Nomor Registrasi</p><label class="value">: <strong>{{$data['noregistrasi']}}</strong></label>
				<p class="title">Tanggal Permohonan</p><label class="value">: <strong>{{$data['tgl_permohonan']}}</strong></label>
				<p class="title">Nomor Induk Karyawan</p><label class="value">: <strong>{{$data['nik']}}</strong></label>
				<p class="title">Nama Karyawan</p><label class="value">: <strong>{{$data['namakaryawan']}}</strong></label>
				<p class="title">Jabatan</p><label class="value">: <strong>{{$data['jabatankaryawan']}}</strong></label><br>
				<p class="title">Departemen/Divisi</p><label class="value">: <strong>{{$data['departemen']}}</strong></label><br>
				<p class="title">Tanggal Pelaksanaan</p><label class="value">: <strong>{{$data['tgl_mulai']}}</strong> @if($data['tgl_selesai'] != NULL) s/d <strong>{{$data['tgl_selesai']}}</strong> @endif</label><br>
				<p class="title">Status Ketidakhadiran</p><label class="value">: <strong>{{$data['id_jenisizin']}}</strong></label><br>
				<p class="title">Keterangan</p><label class="value">: <strong>{{$data['keperluan']}}</strong></label><br>
				<p class="title">Tanggal Persetujuan</p><label class="value">:</label>
				<ul>
					<li><label class="value">Atasan Karyawan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: -</label></li>
					<li><label class="value">Pimpinan Unit Kerja : -</label></li>
				</ul>
				<p>Karyawan Pemohon,<br>
				<p>Ttd.<br><br></p>
				<p><strong><u>{{$data['namakaryawan']}}</u></strong><br>
					{{$data['jabatankaryawan']}}</p>
            </div>
		</div>
		<div class="footer">
			<p><em>Email ini dikirim secara otomatis kepada yang berkepentingan. Email ini tidak perlu dibalas (no-reply) dan apabila ada kendala harap hubungi administrator-HRMS melalui email ke Departemen HR.</em></p>
		</div>
		
	</div>
</body>
</html>
{{-- <div class="content">
            <div>
                <p>Perihal : Permintaan Izin <br>Lampiran: -</p><br>
                <p>Yth. <strong>{{$data['jabatan']}}</strong><br>
                    PT. Global Risk Management (GRM)<br>
                    Graha GRM Royal Spring Business Park 11,<br>
                    Jl. Ragunan Raya No. 29A, Jakarta Selatan</p>

                <p>Dengan hormat,<br>
                   Bersama dengan surat ini,</p>
                <ul id="ul">
                    <li>Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ucwords(strtolower(Auth::user()->name))}}</li>
                    <li>Kategori izin  : {{$data['jenisizin']}}</li>
                    <li>Keperluan&nbsp;&nbsp;:{{$data['keperluan']}}</li>
                    @if($data['tgl_selesai'] != NULL)
                        <li>Tanggal izin   : {{$data['tgl_mulai']}} s/d {{$data['tgl_selesai']}}</li>
                    @else
                        <li>Tanggal izin   : {{$data['tgl_mulai']}}</li>
                    @endif
                    @if($data['jml_hari'] > 1)
                        <li>Jumlah hari    :  {{$data['jml_hari']}}</li>
                    @endif
					<li>Status         :  <span class="text-white badge badge-warning"><strong>{{$data['status']}}</strong></span></li>
                </ul><br>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Memberitahukan kepada Bapak/Ibu {{$data['jabatan']}}, bahwa saya tidak dapat masuk kerja pada tanggal {{$data['tgl_mulai']}} @if($data['tgl_selesai'] != NULL) sampai {{$data['tgl_selesai']}} @endif.
                    sebagaimana mestinya dikarenakan {{$data['keperluan']}}. Oleh sebab itu, dengan tidak mengurangi rasa hormat, saya berharap Bapak/Ibu {{$data['jabatan']}} dengan kebijaksanaannya dapat memberikan izin tidak masuk kerja kepada saya selama beberapa hari. Adapun tugas-tugas yang tertunda selama ketidakhadiran saya akan diselesaikan ketika saya sudah amsuk berkerja lagi dengan kondusif.
                    </p>
                <p>Atas perhatian Bapak/Ibu. Saya ucapkan terima kasih.</p><br>
                <p>Salam Hormat,<br><br></p>
                <p>{{Auth::user()->name}}<br>
            </div>
		</div> --}}