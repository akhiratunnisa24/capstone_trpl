<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z">
    <title>Pemberitahuan - Rekruitmen RTI Posisi {{ $posisi }}</title>
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
    @if ($data->jenis_kelamin == 'L')
    <strong>Yth. Bapak {{ $data->nama }}</strong>
    @else
    <strong>Yth. Ibu {{ $data->nama }}</strong>
    @endif
    <br><br>
    {{-- <p>Anda memiliki notifikasi permintaan <strong>{{$data['id_jeniscuti']}}</strong> dari Saudara/i <strong>{{Auth::user()->id_pegawai}}</strong></p> --}}
    <p>Selamat anda diterima di PT. Rynest TI dengan posisi sebagai {{ $lowongan->posisi }} </p>
    <br>
    <label>Silahkan klik link dibawah ini untuk melengkapi data anda</label><br>
    <p> Link  </p>
    

    </div>
</body>
</html>