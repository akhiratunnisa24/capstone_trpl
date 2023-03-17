<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Pemberitahuan - Sisa Cuti Tahunan</title>
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
        <p>Kepada <strong>{{$data['nama']}}</strong></p>

        <p>Salam sejahtera,</p>

        <p>Saya ingin mengingatkan Anda masih memiliki sisa <strong>{{$data['kategori']}}</strong> dari <strong>{{$data['tahun']}}</strong> yang belum digunakan hingga
            batas waktu yang sudah ditetapkan oleh manager HRD. Kami ingin mengingatkan untuk segera menggunakan sisa cuti tersebut 
            sebelum batas waktu yang sudah ditentukan. Anda masih memiliki <strong>{{$data['kategori']}}</strong> sebanyak  <strong>{{$data['sisacuti']}}</strong> hari.</p>

        <p>Kami mengingatkan Anda bahwa sisa cuti tahunan yang tidak digunakan hingga batas waktu yang ditentukan akan hilang, dan tidak akan ditransfer ke 
            tahun berikutnya. Oleh karena itu, kami mendorong Anda untuk segera mengambil cuti Anda.</p>

        <p>Jika Anda tidak yakin apakah Anda memiliki sisa cuti tahunan yang belum digunakan, silakan menghubungi departemen HR untuk mengetahui informasi terkait.</p>

        <p>Terima kasih atas perhatian dan kerja sama Anda dalam hal ini.</p>

        <p>Salam Hormat,</p>
        <p>[Manager/HR]</p>
    </body>
</html>
