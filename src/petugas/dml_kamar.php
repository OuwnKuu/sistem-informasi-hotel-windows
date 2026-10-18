<?php

declare(strict_types=1);
include_once __DIR__ . "/../koneksi.php";

$aksi = $_POST['aksi'] ?? '';
$id = $_POST['id'] ?? '';
$id_kamar = $_POST['id-kamar'];
$fasilitas = $_POST['fasilitas'] ?? '';
$tempat_tidur = $_POST['tempat-tidur'] ?? '';
$status = $_POST['status'] ?? '';
$id_tamu = !empty($_POST['id-tamu']) ? $_POST['id-tamu'] : null;
$harga_per_malam = $_POST['harga-per-malam'] ?? null;

if ($aksi === 'edit') {
    $stmt_update_kamar = $pdo->prepare("UPDATE kamar SET
    id_kamar = :id_kamar,
    fasilitas = :fasilitas,
    tempat_tidur = :tempat_tidur,
    status = :status,
    id_tamu = :id_tamu,
    harga_per_malam = :harga_per_malam
    WHERE id_kamar = :id");
    $update_kamar = $stmt_update_kamar->execute([
        'id_kamar' => $id_kamar,
        'fasilitas' => $fasilitas,
        'tempat_tidur' => $tempat_tidur,
        'status' => $status,
        'id_tamu' => $id_tamu,
        'harga_per_malam' => $harga_per_malam,
        'id' => $id
    ]);
    if ($stmt_update_kamar) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil diubah!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
} else if ($aksi === 'hapus') {
    $stmt_hapus_kamar = $pdo->prepare("DELETE FROM kamar WHERE id_kamar = :id");
    if (empty($id)) {
        echo json_encode(["status" => "error", "pesan" => "Data tidak lengkap untuk diubah"]);
        exit;
    }
    $hapus_kamar = $stmt_hapus_kamar->execute([
        'id' => $id
    ]);
    if ($stmt_hapus_kamar) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil dihapus!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
} else if ($aksi === 'tambah') {
    $stmt_insert_kamar = $pdo->prepare("INSERT INTO kamar (id_kamar, fasilitas, tempat_tidur, status, id_tamu, harga_per_malam)
    VALUES (:id_kamar, :fasilitas, :tempat_tidur, :status, :id_tamu, :harga_per_malam)");
    $insert_kamar = $stmt_insert_kamar->execute([
        'id_kamar' => $id_kamar,
        'fasilitas' => $fasilitas,
        'tempat_tidur' => $tempat_tidur,
        'status' => $status,
        'id_tamu' => $id_tamu,
        'harga_per_malam' => $harga_per_malam
    ]);
    if ($stmt_insert_kamar) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil disimpan!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
}
