<?php
declare(strict_types=1);
include_once __DIR__ . "/../koneksi.php";

$stmt_jumlah_kamar = $pdo->query("SELECT COUNT(id_kamar) FROM kamar");
$jumlah_kamar = $stmt_jumlah_kamar->fetchColumn();

$stmt_kamar_terisi = $pdo->query("SELECT COUNT(id_tamu) FROM kamar");
$jumlah_kamar_terisi = $stmt_kamar_terisi->fetchColumn();

$stmt_jumlah_pembayaran = $pdo->query("SELECT COUNT(id_pembayaran) FROM pembayaran");
$jumlah_pembayaran = $stmt_jumlah_pembayaran->fetchColumn();

$stmt_pembayaran_tamu_lunas = $pdo->query("SELECT COUNT(status_pembayaran) FROM pembayaran WHERE status_pembayaran = 'Lunas'");
$pembayaran_tamu_lunas = $stmt_pembayaran_tamu_lunas->fetchColumn();

$stmt_jumlah_tamu_baru = $pdo->query("SELECT COUNT(id_tamu_baru) FROM tamu_baru");
$jumlah_tamu_baru = $stmt_jumlah_tamu_baru->fetchColumn();