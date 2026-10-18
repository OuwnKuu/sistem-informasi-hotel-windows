<?php

declare(strict_types=1);
include_once __DIR__ . "/../../koneksi.php";

$aksi = $_POST['aksi'] ?? '';
$id = $_POST['id'] ?? '';
$id_petugas = $_POST['id-petugas'] ?? null;
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$nama_petugas = $_POST['nama-petugas'] ?? '';
$level = $_POST['level'] ?? '';

$password_hashed = password_hash($password, PASSWORD_DEFAULT);

if ($aksi === 'edit') {
    $stmt_update_petugas = $pdo->prepare("UPDATE petugas SET
    id_petugas = :id_petugas,
    username = :username,
    password = :password_hashed,
    nama_petugas = :nama_petugas,
    level = :level
    WHERE id_petugas = :id");
    $update_petugas = $stmt_update_petugas->execute([
        'id_petugas' => $id_petugas,
        'username' => $username,
        'password_hashed' => $password_hashed,
        'nama_petugas' => $nama_petugas,
        'level' => $level,
        'id' => $id
    ]);
    if ($stmt_update_petugas) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil diubah!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
} else if ($aksi === 'hapus') {
    $stmt_hapus_petugas = $pdo->prepare("DELETE FROM petugas WHERE id_petugas = :id");
    if (empty($id)) {
        echo json_encode(["status" => "error", "pesan" => "Data tidak lengkap untuk diubah"]);
        exit;
    }
    $hapus_petugas = $stmt_hapus_petugas->execute([
        'id' => $id
    ]);
    if ($stmt_hapus_petugas) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil dihapus!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
} else if ($aksi === 'tambah') {
    $stmt_insert_petugas = $pdo->prepare("INSERT INTO petugas (id_petugas, username, password, nama_petugas, level)
    VALUES (:id_petugas, :username, :password_hashed, :nama_petugas, :level)");
    $insert_petugas = $stmt_insert_petugas->execute([
        'id_petugas' => $id_petugas,
        'username' => $username,
        'password_hashed' => $password_hashed,
        'nama_petugas' => $nama_petugas,
        'level' => $level
    ]);
    if ($stmt_insert_petugas) {
        echo json_encode(["status" => "sukses", "pesan" => "Data berhasil disimpan!"]);
    } else {
        echo json_encode(["status" => "error", "pesan" => "Gagal mengeksekusi perintah ke database"]);
    }
}
