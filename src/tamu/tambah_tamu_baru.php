<?php

declare(strict_types=1);
include_once __DIR__ . "/../koneksi.php";

$nama = $_POST['nama'];
$no_telepon = $_POST['nomor-telepon'];
$durasi_inap = $_POST['durasi-inap'];
$fasilitas = $_POST['fasilitas'];
$kasur = $_POST['kasur'];

$stmt_insert_tamu_baru = $pdo->prepare("INSERT INTO tamu_baru (nama, no_telepon, durasi_inap, fasilitas, tempat_tidur)
    VALUES (:nama, :no_telepon, :durasi_inap, :fasilitas, :tempat_tidur)");
$insert_tamu_baru = $stmt_insert_tamu_baru->execute([
    'nama' => $nama,
    'no_telepon' => $no_telepon,
    'durasi_inap' => $durasi_inap,
    'fasilitas' => $fasilitas,
    'tempat_tidur' => $kasur
]);

if ($stmt_insert_tamu_baru) {
    echo json_encode(["status" => "sukses", "pesan" => "Data berhasil disimpan!"]);
} else {
    echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
}
