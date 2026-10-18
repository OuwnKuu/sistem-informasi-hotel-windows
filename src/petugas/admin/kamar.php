<?php
declare(strict_types=1);
session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true || $_SESSION['level'] !== 'admin') {
    header('Location: ../../../index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Hotel Anugrah</title>
    <?php
    if (str_contains($_SERVER['HTTP_HOST'], 'ddev.site')): ?>
    <script type="module" src="https://<?=  $_SERVER['HTTP_HOST'] ?>:5173/@vite/client"></script>
    <link rel="stylesheet" href="https://<?=  $_SERVER['HTTP_HOST'] ?>:5173/src/style.css">
    <?php
    else: ?>
    <link rel="stylesheet" href="dist/outputHasil2.css">
    <?php endif; ?>
</head>
<body class="bg-mauve-200">
    <header class="flex justify-between items-center bg-cyan-100 p-4">
        <div>
            <p class="font-bold text-2xl tracking-wider">SISTEM INFORMASI HOTEL</p>
        </div>
        <div>
            <a class="py-2 px-4 bg-gray-200 rounded-2xl border border-gray-500 font-bold tracking-wider" href="logout.php">LOGOUT</a>
        </div>
    </header>
    <div class="flex p-4 gap-4">
        <main class="bg-white min-w-[75vw] rounded-3xl p-4 ">
            <p class="text-3xl font-medium">DATA KAMAR</p>
            <hr class="my-8">
            <?php include "tabel_kamar.php" ?>
        </main>
        <aside class="bg-white w-full rounded-3xl p-4">
            <ul class="flex flex-col gap-2 justify-center items-center cursor-pointer">
                <li class="w-full rounded-3xl">
                    <a class="hover:bg-gray-200 active:bg-gray-300 transition inline-block w-full text-center text-xl rounded-3xl py-3" href="./halaman_utama.php">Overview</a>
                </li>
                <li class="w-full rounded-3xl">
                    <a class="hover:bg-gray-200 active:bg-gray-300 bg-gray-100 transition inline-block w-full text-center text-xl rounded-3xl py-3">Kamar</a>
                </li>
                <li class="w-full rounded-3xl">
                    <a class="hover:bg-gray-200 active:bg-gray-300 transition inline-block w-full text-center text-xl rounded-3xl py-3" href="./tamu.php">Tamu</a>
                </li>
                <li class="w-full rounded-3xl">
                    <a class="hover:bg-gray-200 active:bg-gray-300 transition inline-block w-full text-center text-xl rounded-3xl py-3" href="./pembayaran.php">Pembayaran</a>
                </li>
                <li class="w-full rounded-3xl">
                    <a class="hover:bg-gray-200 active:bg-gray-300 transition inline-block w-full text-center text-xl rounded-3xl py-3" href="./petugas.php">Petugas</a>
                </li>
            </ul>
        </aside>
    </div>
</body>
</html>