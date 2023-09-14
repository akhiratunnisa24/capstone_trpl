<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Notifikasi - Slip Gaji Karyawan</title>

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
		.list {
			margin-left: 2.0rem;
		}
    </style>
</head>
<body>
	<div class="wrapper">
		<div class="content">
            <div>
                <p>Kepada <strong>{{$data['nama']}}</strong></p>

                <p>Kami ingin memberitahu Anda bahwa E-SLIP GAJI Anda untuk Periode <strong>{{$data['periode']}}</strong> telah tersedia dan terlampir.</p>
                <p>Silahkan gunakan password <strong>ddmmyyyy</strong> untuk membuka slip gaji Anda, yang terdiri dari:</p>
                <ul>
                    <li class="list"><strong>dd</strong> &nbsp;&nbsp;&nbsp;&nbsp;: Dua digit tanggal lahir Anda</li>
                    <li class="list"><strong>mm</strong> &nbsp;&nbsp;: Dua digit bulan lahir</li>
                    <li class="list"><strong>yyyy</strong> : Empat digit tahun lahir</li>
                </ul>
                <p>Contoh: Password untuk tanggal lahir 01 Januari 1990 adalah <strong>01011990</strong>.</p>
				<p><strong style="color: #c42007">INFO PENTING !!</strong></p>
                <p>Mohon diperhatikan bahwa E-SLIP GAJI ini bersifat rahasia dan hanya untuk konsumsi pribadi Anda. Jika Anda memiliki pertanyaan atau keberatan terkait dengan rincian gaji Anda, jangan ragu untuk menghubungi bagian HR.</p>
				<p>Segala Kerugian akibat diberikannya / bocornya Data Pribadi Anda dan/ atau  E-SLIP GAJI ini kepada pihak lain <strong>MENJADI TANGGUNG JAWAB ANDA SEPENUHNYA.</strong></p>
				<p>Terima kasih atas kerja keras Anda selama bulan ini.</p>
                <p>Salam Hormat,<br><br></p>
                <p>[Manager/HR]<br>
			</div>
		</div>
		<div class="footer">
			<p>Email ini dikirimkan secara otomatis. Jangan membalas email ini karena tidak akan terbaca. Hubungi kami di <b><a href="mailto:">{{$data['emailperusahaan']}}</a></b> atau anda bisa menghubungi <a href="#">{{$data['notelpperusahaan']}}</a> untuk informasi lebih lanjut.</p>
		</div>
	</div>
</body>
</html>
