<?php
require 'vendor/autoload.php';

use TADPHP\TADFactory;
use TADPHP\TAD;

// Konfigurasi opsi TAD
$tad_options = [
    'ip' => '192.168.100.51',
	'com_key' => 0,
	'soap_port' => 80,
    'udp_port' => 4370,
	'connection_timeout' =>10,
	//'encoding'] = 'iso8859-1'
	'encoding' => 'utf-8'
];

// Membuat instance TADFactory dengan opsi TADZKLib
$tad_factory = new TADFactory($tad_options);

// Mendapatkan instance TAD
$tad = $tad_factory->get_instance();

// Mendapatkan data log absensi dari mesin
//$response = $tad->get_att_log();

// Menangani data log absensi dan menyimpannya ke dalam tabel 'absensi' pada database Anda
//if ($response->is_success()) {
if ($tad->is_alive()) {
	//$tad->disable();
	$logs = $tad->get_att_log()->to_array();
	//echo var_dump($logs);
    //$logs = $response->to_array();
    $dataAbsen = [];

    foreach ($logs['Row'] as $key => $log) {
        $pin = $log['PIN'];
        $datetime = $log['DateTime'];
        $status = $log['Status'];
        $machine_id = 1; // Ganti 1 dengan ID mesin absensi yang sesuai

        // Menyimpan data log absensi ke dalam array dataAbsen
        $dataAbsen[] = [
            'employee_id' => $pin,
            'date_time' => $datetime,
            'status' => $status,
            'machine_id' => $machine_id,
        ];
    }

    // echo var_dump($dataAbsen);

    //Menyimpan dataAbsen ke dalam tabel 'absensi' pada database
    if (!empty($dataAbsen)) {
        // Koneksi database menggunakan mysqli
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'logabsensi';

        // Membuat koneksi menggunakan mysqli
        $mysqli = new mysqli($host, $username, $password, $database);

        // Memeriksa apakah koneksi berhasil
        if ($mysqli->connect_error) {
            die('Koneksi database gagal: ' . $mysqli->connect_error);
        }

        // SQL query untuk menyimpan dataAbsen ke dalam tabel 'absensi'
        $sql = "INSERT INTO absensi (employee_nik, date,time, status) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);

        // Binding parameter dan eksekusi query menggunakan loop
        foreach ($dataAbsen as $row) {
            $stmt->bind_param("sssi", $row['employee_nik'], $row['date'], $row['time'], $row['status']);
            $stmt->execute();
        }

        // Menutup statement dan koneksi
        $stmt->close();
        $mysqli->close();

        echo json_encode(['status' => true, 'message' => 'Import Data Successfully']);
    } else {
        echo json_encode(['status' => true, 'message' => 'No attendance logs found']);
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Failed to fetch attendance logs from the machine']);
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
