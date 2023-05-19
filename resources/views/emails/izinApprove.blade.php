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
					@if($data['status'] == "Pending Atasan")
							<li><label class="value">Permohonan Ditolak:  <strong>{{$data['tglditolak']}}</strong> WIB</label></li>
							<li><label class="value">Departemen HRD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong>{{$data['tglditolak']}}</strong> WIB</label></li>
						@elseif($data['status'] == "Pending Pimpinan")
							<li><label class="value">Permohonan Disetujui:  <strong>{{$data['tgldisetujuiatasan']}}</strong> WIB</label></li>
							<li><label class="value">Permohonan Ditolak&nbsp;&nbsp;:  <strong>{{$data['tglditolak']}}</strong> WIB</label></li>
							<li><label class="value">Departemen HRD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:  <strong>{{$data['tglditolak']}}</strong> WIB</label></li>
						@elseif($data['status'] == "Disetujui")
						<li><label class="value">Atasan Karyawan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$data['tgldisetujuiatasan']}} WIB</label></li>
							<li><label class="value">Pimpinan Unit Kerja : {{$data['tgldisetujuipimpinan']}} WIB</label></li>
							<li><label class="value">Departemen HRD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$data['tgldisetujuipimpinan']}} WIB</label></li>
						@else
							<li><label class="value">Atasan Karyawan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: -</label></li>
							<li><label class="value">Pimpinan Unit Kerja : -</label></li>
						@endif
				</ul>
			</div>
		</div>
		<div class="footer">
			<p><em>Email ini dikirim secara otomatis kepada yang berkepentingan. Email ini tidak perlu dibalas (no-reply) dan apabila ada kendala harap hubungi administrator-HRMS melalui email ke Departemen HR.</em></p>
		</div>
	</div>
</body>
<body>
</html>
{{-- <div class="content">
	<div>
		<p>Kepada <strong>{{$data['nama']}}</strong></p>
		<p>Salam sejahtera,</p>

		@if($data['status'] == 'Disetujui')
			<p>Ada Kabar baik nih buat Anda,</p>
			
			<p>Kami ingin memberitahukan bahwa permintaan <strong>Izin {{$data['jenisizin']}}</strong> pada tanggal <strong>{{$data['tgl_mulai']}}</strong>  @if($data['tgl_selesai'] !== NULL) hingga <strong>{{$data['tgl_selesai']}}</strong> @endif telah <b>DISETUJUI</b> oleh atasan Anda <strong>{{Auth::user()->name}}</strong></p>
				<ul>
					<li>Nama karyawan  : {{$data['namakaryawan']}}</li>
					<li>Kategori : {{$data['jenisizin']}}</li>
					<li>Keperluan      : {{$data['keperluan']}}</li>
					@if($data['tgl_selesai'] != NULL)
						<li>Tanggal Izin   : {{$data['tgl_mulai']}} s/d {{$data['tgl_selesai']}}</li>
					@else
						<li>Tanggal Izin   : {{$data['tgl_mulai']}}</li>
					@endif
					@if($data['jml_hari'] > 1)
						<li>Jumlah Izin    :  {{$data['jml_hari']}} hari</li>
					@endif
					<li>Status         :  <span class="text-white badge badge-success"><strong>{{$data['status']}}</strong></span></li>
				</ul><br>
			<p>Silakan melakukan konfirmasi dengan menghubungi bagian HRD kami jika Anda memerlukan informasi lebih lanjut.</p>
		@else  
			<strong>Mohon Maaf</strong>

			<p>Kami ingin memberitahukan bahwa permintaan <strong>Izin {{$data['jenisizin']}}</strong> pada tanggal <strong>{{$data['tgl_mulai']}}</strong> @if($data['tgl_selesai'] !== NULL) hingga <strong>{{$data['tgl_selesai']}}</strong> @endif <b>DITOLAK</b> oleh atasan Anda <strong>{{Auth::user()->name}}</strong> dengan alasan <strong>{{$data['alasan']}}</strong></p> 
			<ul>
				<li>Nama karyawan  : {{$data['namakaryawan']}}</li>
				<li>Kategori : {{$data['jenisizin']}}</li>
				<li>Keperluan      : {{$data['keperluan']}}</li>
				@if($data['tgl_selesai'] != NULL)
					<li>Tanggal Izin   : {{$data['tgl_mulai']}} s/d {{$data['tgl_selesai']}}</li>
				@else
					<li>Tanggal Izin   : {{$data['tgl_mulai']}}</li>
				@endif
				@if($data['jml_hari'] > 1)
					<li>Jumlah Izin    :  {{$data['jml_hari']}} hari</li>
				@endif
				<li>Status         :  <span class="text-white badge badge-danger"><strong>{{$data['status']}}</strong></span></li>
				</ul><br>
			<p>Silakan melakukan konfirmasi dengan menghubungi bagian HRD kami jika Anda memerlukan informasi lebih lanjut.</p>
		@endif
		<p>Terima kasih</p>
	
		<p>Salam Hormat,<br><br></p>
		<p>[Manager/HR]<br>
	</div>
</div> --}}