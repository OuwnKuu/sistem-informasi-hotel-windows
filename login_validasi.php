<?php

declare(strict_types=1);

session_start();
require_once __DIR__ . '/src/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $peringatan = 'Username dan password wajib diisi!';
        $_SESSION['error'] = $peringatan;
        header('Location: index.php');
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM petugas WHERE username = :username");
    $stmt->execute([$username]);
    $petugas = $stmt->fetch();

    if ($petugas && password_verify($password, $petugas['password']) && $petugas['level'] === 'admin') {
        session_regenerate_id(true);

        $_SESSION['petugas_id'] = $petugas['id_petugas'];
        $_SESSION['username'] = $petugas['username'];
        $_SESSION['nama_petugas'] = $petugas['nama_petugas'];
        $_SESSION['level'] = $petugas['level'];
        $_SESSION['is_logged_in'] = true;

        header('Location: ./src/petugas/admin/halaman_utama.php');
        exit;
    } else if ($petugas && password_verify($password, $petugas['password'])) {
        session_regenerate_id(true);

        $_SESSION['petugas_id'] = $petugas['id_petugas'];
        $_SESSION['username'] = $petugas['username'];
        $_SESSION['nama_petugas'] = $petugas['nama_petugas'];
        $_SESSION['level'] = $petugas['level'];
        $_SESSION['is_logged_in'] = true;

        header('Location: ./src/petugas/halaman_utama.php');
    }
    else {
        $_SESSION['error'] = 'Username atau password salah!';
        header('Location: index.php');
        exit;
    }
}



// $stmt->execute([
//     ':username' => $username,
//     ':password' => $password
// ]);

// $user = $stmt->fetch();

// if ($user) {
//     echo "Login Berhasil!";
// }