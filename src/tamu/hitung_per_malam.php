<?php
declare(strict_types=1);

include_once __DIR__ . "/../koneksi.php";

$durasi_inap = $_POST['durasi-inap'];
$fasilitas = $_POST['fasilitas'];
$tempat_tidur = $_POST['kasur'];

$stmt_data_kamar = $pdo->prepare("SELECT fasilitas, tempat_tidur, harga_per_malam FROM kamar WHERE fasilitas = :fasilitas AND tempat_tidur = :tempat_tidur");
$data_kamar = $stmt_data_kamar->execute([
    'fasilitas' => $fasilitas,
    'tempat_tidur' => $tempat_tidur
]);

$harga = $stmt_data_kamar->fetch();

if ($stmt_data_kamar) {
    echo $harga['harga_per_malam'] * $durasi_inap;
}