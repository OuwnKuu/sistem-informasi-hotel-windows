<?php
declare(strict_types=1);
session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true || $_SESSION['level'] !== 'admin') {
    header('Location: ../../../index.php');
    exit;
}

include_once __DIR__ . "/tampil_data_overview.php";

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
            <p class="text-3xl font-medium">OVERVIEW</p>
            <hr class="my-8">
            <p class="text-lg font-bold">Selamat Datang <?php echo $_SESSION['level'] ?>!</p>
            <section class="grid grid-cols-2 gap-4 w-1/2 items-center mt-16">
                <article class="bg-yellow-200 rounded-2xl p-4 min-h-52">
                    <p class="font-bold text-2xl mb-4">Jumlah Kamar Terisi:</p>
                    <span class="text-6xl font-extrabold"><?php echo $jumlah_kamar_terisi . "/" . $jumlah_kamar ?></span>
                </article>
                <article class="bg-yellow-200 rounded-2xl p-4 min-h-52">
                    <p class="font-bold text-2xl mb-4">Jumlah Tamu Pembayaran Lunas:</p>
                    <span class="text-6xl font-extrabold"><?php echo $pembayaran_tamu_lunas . "/" . $jumlah_pembayaran ?></span>
                </article>
                <article class="bg-yellow-200 rounded-2xl p-4 min-h-52">
                    <p class="font-bold text-2xl mb-4">Jumlah Petugas:</p>
                    <span class="text-6xl font-extrabold"><?php echo $jumlah_petugas ?></span>
                </article>
                <article class="bg-yellow-200 rounded-2xl p-4 min-h-52">
                    <p class="font-bold text-2xl mb-4">Jumlah Tamu Baru:</p>
                    <span class="text-6xl font-extrabold"><?php echo $jumlah_tamu_baru ?></span>
                </article>
            </section>
        </main>
        <aside class="bg-white w-full rounded-3xl p-4">
            <ul class="flex flex-col gap-2 justify-center cursor-pointer">
                <li class="w-full rounded-3xl">
                    <a class="hover:bg-gray-200 active:bg-gray-300 bg-gray-100 transition inline-block w-full text-center text-xl rounded-3xl py-3">Overview</a>
                </li>
                <li class="w-full rounded-3xl">
                    <a class="hover:bg-gray-200 active:bg-gray-300 transition inline-block w-full text-center text-xl rounded-3xl py-3" href="./kamar.php">Kamar</a>
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