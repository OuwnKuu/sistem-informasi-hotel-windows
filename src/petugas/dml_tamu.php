<?php

declare(strict_types=1);
include_once __DIR__ . "/../koneksi.php";

$aksi = $_POST['aksi'] ?? '';
$id = $_POST['id'] ?? '';
$id_tamu = $_POST['id-tamu'] ?? null;
$nama = $_POST['nama'] ?? '';
$no_telepon = $_POST['nomor-telepon'] ?? null;
$id_kamar = $_POST['id-kamar'] ?? null;
$waktu_check_in = $_POST['waktu-check-in'] ?? null;
$waktu_check_out = !empty($_POST['waktu-check-out']) ? $_POST['waktu-check-out'] : null;
$durasi_inap = $_POST['durasi-inap'] ?? null;

if ($aksi === 'edit') {
    $stmt_update_tamu = $pdo->prepare("UPDATE tamu SET
    nama = :nama,
    no_telepon = :no_telepon,
    id_kamar = :id_kamar,
    waktu_check_in = :waktu_check_in,
    waktu_check_out = :waktu_check_out,
    durasi_inap = :durasi_inap,
    WHERE id_tamu = :id");
    $update_tamu = $stmt_update_tamu->execute([
        'nama' => $nama,
        'no_telepon' => $no_telepon,
        'id_kamar' => $id_kamar,
        'waktu_check_in' => $waktu_check_in,
        'waktu_check_out' => $waktu_check_out,
        'durasi_inap' => $durasi_inap,
        'id' => $id
    ]);
    if ($stmt_update_tamu) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil diubah!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
} else if ($aksi === 'hapus') {
    $stmt_hapus_tamu = $pdo->prepare("DELETE FROM tamu WHERE id_tamu = :id");
    if (empty($id)) {
        echo json_encode(["status" => "error", "pesan" => "Data tidak lengkap untuk diubah"]);
        exit;
    }
    $hapus_tamu = $stmt_hapus_tamu->execute([
        'id' => $id
    ]);
    if ($stmt_hapus_tamu) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil dihapus!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
} else if ($aksi === 'tambah') {
    $stmt_insert_tamu = $pdo->prepare("INSERT INTO tamu (nama, no_telepon, id_kamar, waktu_check_in, waktu_check_out, durasi_inap)
    VALUES (:nama, :no_telepon, :id_kamar, :waktu_check_in, :waktu_check_out, :durasi_inap)");
    $insert_tamu = $stmt_insert_tamu->execute([
        'nama' => $nama,
        'no_telepon' => $no_telepon,
        'id_kamar' => $id_kamar,
        'waktu_check_in' => $waktu_check_in,
        'waktu_check_out' => $waktu_check_out,
        'durasi_inap' => $durasi_inap
    ]);

    $id_tamu_untuk_insert_update = $pdo->lastInsertId();

    $stmt_insert_pembayaran = $pdo->prepare("INSERT INTO pembayaran (id_tamu)
    VALUES (:id_tamu)");
    $insert_pembayaran = $stmt_insert_pembayaran->execute([
        'id_tamu' => $id_tamu_untuk_insert_update
    ]);

    $stmt_update_tamu = $pdo->prepare("UPDATE tamu SET
    id_pembayaran = (SELECT id_pembayaran FROM pembayaran WHERE id_tamu = :id_tamu)
    WHERE id_tamu = $id_tamu_untuk_insert_update");
    $update_tamu = $stmt_update_tamu->execute([
        'id_tamu' => $id_tamu_untuk_insert_update
    ]);

    if ($stmt_insert_tamu && $stmt_insert_pembayaran && $stmt_update_tamu) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil disimpan!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
}
