<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Notifikasi - Sisa Cuti Tahunan</title>

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
	</style>
</head>
<body>
	<div class="wrapper">
		{{-- <div class="header"> --}}
			{{-- <h1>Promo Terbaru dari Toko Online</h1> --}}
            {{-- <a class="logo"><img src="assets/images/grm.png" height="135" width="195"></a> --}}
		{{-- </div> --}}
		<div class="content">
            <div>
                <p>Kepada <strong>{{$data['nama']}}</strong></p>
                <p>Salam sejahtera,</p>

                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saya ingin mengingatkan, bahwa Anda masih memiliki sisa <strong>{{$data['kategori']}}</strong> dari <strong>{{$data['tahun']}}</strong> yang belum digunakan hingga
                    batas waktu yang sudah ditetapkan oleh manager HRD yaitu <strong>{{$data['aktifdari']}}</strong> sampai dengan <strong>{{$data['sampai']}}</strong>. Kami ingin mengingatkan untuk segera menggunakan sisa cuti tersebut 
                    sebelum batas waktu yang sudah ditentukan. Anda masih memiliki <strong>{{$data['kategori']}}</strong> sebanyak  <strong>{{$data['sisacuti']}}</strong> hari.</p>

                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kami mengingatkan Anda bahwa sisa cuti tahunan yang tidak digunakan hingga batas waktu yang ditentukan akan hilang, dan tidak akan ditransfer ke 
                    tahun berikutnya. Oleh karena itu, kami mendorong Anda untuk segera mengambil cuti Anda.</p>

                <p>Jika Anda tidak yakin apakah Anda memiliki sisa cuti tahunan yang belum digunakan, silakan menghubungi departemen HR untuk mengetahui informasi terkait.</p>

                <p>Terima kasih atas perhatian dan kerja sama Anda dalam hal ini.</p>
            
                <p>Salam Hormat,<br><br></p>
                <p>[Manager/HR]<br>
			</div>
		</div>
		<div class="footer">
			<p>Email ini dikirimkan secara otomatis. Jangan membalas email ini karena tidak akan terbaca. Hubungi kami di <b><a href="mailto:">info@grm-risk.com</a></b> atau anda bisa menghubungi <a href="#">(+62) 811-140-840-5</a> untuk informasi lebih lanjut.</p>
		</div>
	</div>
</body>
</html>

{{-- <!DOCTYPE html>
<html> --}}
    {{-- <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
                integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <title>Notifikasi - Sisa Cuti Tahunan</title>

        <style>
            .badge {
                padding: 5px 10px;
                font-size: 12px;
                font-weight: 600;
                border-radius: 20px;
                text-transform: uppercase;
            }

            .wrapper {
                background-color: #004aad;
                margin: 0;
                padding: 0;
                width: 100%;
            }

            .container {
                background-color: #9ab8df;
                margin: 10px;
                padding: 10px;
                width: 100%;
            }
            
        </style>
    </head> --}}
    {{-- <body>
        <table class="wrapper">
            <tr>
                <td class="container">
                    <!-- Message start -->
                    <table>
                        <tr>
                            <td align="center" class="masthead">
                                <img src="public/images/grm.png" alt="tidak ada logo">
                            </td>
                        </tr>
                        <tr>
                            <td class="content">
                                <p>Kepada <strong>{{$data['nama']}}</strong></p>
                                <p>Salam sejahtera,</p>

                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saya ingin mengingatkan, bahwa Anda masih memiliki sisa <strong>{{$data['kategori']}}</strong> dari <strong>{{$data['tahun']}}</strong> yang belum digunakan hingga
                                    batas waktu yang sudah ditetapkan oleh manager HRD yaitu <strong>{{$data['aktifdari']}}</strong> sampai dengan <strong>{{$data['sampai']}}</strong>. Kami ingin mengingatkan untuk segera menggunakan sisa cuti tersebut 
                                    sebelum batas waktu yang sudah ditentukan. Anda masih memiliki <strong>{{$data['kategori']}}</strong> sebanyak  <strong>{{$data['sisacuti']}}</strong> hari.</p>

                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kami mengingatkan Anda bahwa sisa cuti tahunan yang tidak digunakan hingga batas waktu yang ditentukan akan hilang, dan tidak akan ditransfer ke 
                                    tahun berikutnya. Oleh karena itu, kami mendorong Anda untuk segera mengambil cuti Anda.</p>

                                <p>Jika Anda tidak yakin apakah Anda memiliki sisa cuti tahunan yang belum digunakan, silakan menghubungi departemen HR untuk mengetahui informasi terkait.</p>

                                <p>Terima kasih atas perhatian dan kerja sama Anda dalam hal ini.</p>
                            
                                <p>Salam Hormat,<br><br></p>
                                <p>[Manager/HR]<br>
        
                            </td>
                        </tr>
                    </table>
        
                </td>
            </tr>
            <tr>
                <td class="container">
                    <table>
                        <tr>
                            <td class="content footer" align="center">
                                <p>Sent by <a href="#">PT. Global Risk Management</a>, Graha GRM Royal Spring Business Park 11, Jl. Ragunan Raya No. 29A, Jakarta Selatan, 12540</p>
                                <p><a href="mailto:">info@grm-risk.com</a> | <a href="#">(+62) 811-140-840-5</a></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body> --}}
{{-- </html> --}}
