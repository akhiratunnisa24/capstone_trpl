<!DOCTYPE html>
<html>
<head>
    <title>Data Attendance</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php

require_once 'vendor/autoload.php';

use TADPHP\TADFactory;
use TADPHP\TAD;

$tad_factory = new TADPHP\TADFactory();
$comands = TAD::commands_available();
$ip = '192.168.1.8';
// $ip = '192.168.100.51';
$com_key = 0;
$tad = (new TADFactory(['ip'=>$ip, 'com_key'=>$com_key]))->get_instance();

$Connect = $tad->is_alive();
if ($Connect) {
    echo 'Berhasil terkoneksi ke ' . $ip;
  
    $users = $tad->get_user_info();
    $buf = explode("<Row>", $users);
        
    $data = $tad->get_att_log();
    $buffer = explode("<Row>", $data);
    $data_array = [];

    foreach ($buffer as $row) {
        if (!empty($row)) {
            preg_match("/(\d+)-(\d+-\d+ \d+:\d+:\d+)(\d+)/", $row, $matches);
            if (count($matches) == 4) {
                $id = $matches[1];
                $date_time = $matches[2];
                $keterangan = $matches[3];
                $date = substr($date_time, 0, 10);
                $time = substr($date_time, 11);

                $data_array[] = array(
                    'id' => $id,
                    'user_id' => $id,
                    'date' => $date,
                    'time' => $time,
                    'keterangan' => $keterangan
                );
            }
        }
    }

    echo var_dump($data_array);
?>

<?php
} else {
    echo 'Gagal Terkoneksi ke mesin Absensi '. $ip;
}

?>

</body>
</html>
