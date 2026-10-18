<?php

declare(strict_types=1);
include_once __DIR__ . "/../../koneksi.php";

$aksi = $_POST['aksi-form-tamu-baru'] ?? '';
$id = $_POST['id'] ?? '';
$id_tamu_baru = $_POST['id-tamu-baru'] ?? '';
$nama_tamu_baru = $_POST['nama-tamu-baru'] ?? '';
$no_telepon_tamu_baru = $_POST['nomor-telepon-tamu-baru'] ?? '';
$durasi_inap_tamu_baru = $_POST['durasi-inap-tamu-baru'] ?? '';
$fasilitas = $_POST['fasilitas'] ?? '';
$tempat_tidur = $_POST['tempat-tidur'] ?? '';

if ($aksi === 'edit') {
    $stmt_update_tamu_baru = $pdo->prepare("UPDATE tamu_baru SET
    nama = :nama,
    no_telepon = :no_telepon,
    durasi_inap = :durasi_inap,
    fasilitas = :fasilitas,
    tempat_tidur = :tempat_tidur
    WHERE id_tamu_baru = :id");

    $update_tamu_baru = $stmt_update_tamu_baru->execute([
        'nama' => $nama_tamu_baru,
        'no_telepon' => $no_telepon_tamu_baru,
        'durasi_inap' => $durasi_inap_tamu_baru,
        'fasilitas' => $fasilitas,
        'tempat_tidur' => $tempat_tidur,
        'id' => $id
    ]); 
    if ($stmt_update_tamu_baru) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil diubah!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
} else if ($aksi === 'hapus') {
    $stmt_hapus_tamu_baru = $pdo->prepare("DELETE FROM tamu_baru WHERE id_tamu_baru = :id");
    if (empty($id)) {
        echo json_encode(["status" => "error", "pesan" => "Data tidak lengkap untuk diubah"]);
        exit;
    }
    $hapus_tamu_baru = $stmt_hapus_tamu_baru->execute([
        'id' => $id
    ]);
    if ($stmt_hapus_tamu_baru) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil dihapus!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
}