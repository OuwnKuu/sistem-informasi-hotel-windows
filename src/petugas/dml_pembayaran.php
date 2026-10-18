<?php

declare(strict_types=1);
include_once __DIR__ . "/../koneksi.php";

$aksi = $_POST['aksi'] ?? '';
$id = $_POST['id'] ?? '';
$id_pembayaran = $_POST['id-pembayaran'] ?? null;
$id_tamu = !empty($_POST['id-tamu']) ? $_POST['id-tamu'] : null;
$id_petugas = $_POST['id-petugas'] ?? null;
$petugas_bayar = $_POST['petugas-bayar'] ?? '';
$total_bayar = $_POST['total-bayar'] ?? null;
$metode_pembayaran = $_POST['metode-pembayaran'] ?? null;
$status_pembayaran = $_POST['status-pembayaran'] ?? null;

if ($aksi === 'edit') {
    $stmt_update_pembayaran = $pdo->prepare("UPDATE pembayaran SET
    id_pembayaran = :id_pembayaran,
    id_tamu = :id_tamu,
    id_petugas = :id_petugas,
    petugas_bayar = :petugas_bayar,
    total_bayar = :total_bayar,
    metode_pembayaran = :metode_pembayaran,
    status_pembayaran = :status_pembayaran
    WHERE id_pembayaran = :id");
    $update_pembayaran = $stmt_update_pembayaran->execute([
        'id_pembayaran' => $id_pembayaran,
        'id_tamu' => $id_tamu,
        'id_petugas' => $id_petugas,
        'petugas_bayar' => $petugas_bayar,
        'total_bayar' => $total_bayar,
        'metode_pembayaran' => $metode_pembayaran,
        'status_pembayaran' => $status_pembayaran,
        'id' => $id
    ]);
    if ($stmt_update_pembayaran) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil diubah!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
} else if ($aksi === 'hapus') {
    $stmt_hapus_pembayaran = $pdo->prepare("DELETE FROM pembayaran WHERE id_pembayaran = :id");
    if (empty($id)) {
        echo json_encode(["status" => "error", "pesan" => "Data tidak lengkap untuk diubah"]);
        exit;
    }
    $hapus_tamu = $stmt_hapus_pembayaran->execute([
        'id' => $id
    ]);
    if ($stmt_hapus_pembayaran) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil dihapus!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
} else if ($aksi === 'tambah') {
    $stmt_insert_pembayaran = $pdo->prepare("INSERT INTO pembayaran (id_pembayaran, id_tamu, id_petugas, petugas_bayar, total_bayar, metode_pembayaran, status_pembayaran)
    VALUES (:id_pembayaran, :id_tamu, :id_petugas, :petugas_bayar, :total_bayar, :metode_pembayaran, :status_pembayaran)");
    $insert_pembayaran = $stmt_insert_pembayaran->execute([
        'id_pembayaran' => $id_pembayaran,
        'id_tamu' => $id_tamu,
        'id_petugas' => $id_petugas,
        'petugas_bayar' => $petugas_bayar,
        'total_bayar' => $total_bayar,
        'metode_pembayaran' => $metode_pembayaran,
        'status_pembayaran' => $status_pembayaran
    ]);
    if ($stmt_insert_pembayaran) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil disimpan!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
}
