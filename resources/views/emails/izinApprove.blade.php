<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Pemberitahuan - Permintaan Izin Karyawan</title>

    <style>
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
	<div class="wrapper">
		<div class="content">
            <div>
                <p>Kepada <strong>{{$data['nama']}}</strong></p>
                <p>Salam sejahtera,</p>

                @if($data['status'] == 'Disetujui')
                    <strong>Ada Kabar baik nih buat Anda,</strong>
                    <br><br>
                    <p>Kami ingin memberitahukan bahwa permintaan <strong>Izin {{$data['jenisizin']}}</strong> pada tanggal [tanggal mulai] hingga [tanggal selesai] telah <b>DISETUJUI</b> oleh atasan Anda <strong>{{Auth::user()->name}}</strong>
                        Silakan melakukan konfirmasi dengan menghubungi bagian HRD kami jika Anda memerlukan informasi lebih lanjut.</p>
                    
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
                            @if($data['status'] == 7)
                                <span class="text-white badge badge-info">DISETUJUI</span>
                            @else
                                <span class="text-white badge badge-danger">DITOLAK</span>
                            @endif
                        </div>
                    </div>
                @else  
                    <strong>Mohon Maaf</strong>
                    <br><br>
                    <p>Kami ingin memberitahukan bahwa permintaan <strong>Izin {{$data['jenisizin']}}</strong> pada tanggal [tanggal mulai] hingga [tanggal selesai] <b>DISTOLAK</b> oleh atasan Anda <strong>{{Auth::user()->name}}</strong></p> 
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
                            @if($data['status'] == 7)
                                <span class="text-white badge badge-info">DISETUJUI</span>
                            @else
                                <span class="text-white badge badge-danger">DITOLAK</span>
                            @endif
                        </div>
                    </div>
                @endif

                <p>Terima kasih</p>
            
                <p>Salam Hormat,<br><br></p>
                <p>[Manager/HR]<br>
			</div>
		</div>
		<div class="footer">
			<p>Email ini dikirimkan secara otomatis. Jangan membalas email ini karena tidak akan terbaca. Hubungi kami di <b><a href="mailto:">info@grm-risk.com</a></b> atau anda bisa menghubungi <a href="#">(+62) 811-140-840-5</a> untuk informasi lebih lanjut.</p>
		</div>
	</div>
</body>
<body>
</html>