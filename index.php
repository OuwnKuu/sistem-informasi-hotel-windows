<?php
declare(strict_types=1);
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitela</title>
    <?php
    if (str_contains($_SERVER['HTTP_HOST'], 'ddev.site')): ?>
    <script type="module" src="https://<?=  $_SERVER['HTTP_HOST'] ?>:5173/@vite/client"></script>
    <link rel="stylesheet" href="https://<?=  $_SERVER['HTTP_HOST'] ?>:5173/src/style.css">
    <?php
    else: ?>
    <link rel="stylesheet" href="dist/outputHasil2.css"
    <?php endif; ?>
</head>
<body>
    <header class="flex justify-between bg-blue-300 p-4 sticky top-0">
        <div>
            <img src="/assets/images/hotel_icon.webp" alt="Gambar Ikon Hotel" width="30">
        </div>
        
        <h1 class="font-bold text-2xl">SISTEM INFORMASI HOTEL ANUGRAH</h1>
    </header>
    <main class="bg-[url('/assets/images/gambar_kota.jpg')] bg-cover min-h-screen grid grid-flow-col grid-rows-1 gap-4">
        <article class="col-span-2 bg-blue-100 flex justify-center items-center m-2 rounded">
            <form action="/login_validasi.php" method="post" class="w-2xl bg-white rounded-xl p-8 px-12">
                <h1 class="text-center font-bold mb-6">Login Sebagai Admin/Petugas</h1>
                <fieldset>
                    <?php
                    if (isset($_GET['pesan'])) {
                        if ($_GET['pesan'] == "Gagal") {
                            echo "<div class='alert'>Username dan Password tidak sesuai!</div>";
                        }
                    }
                    ?>
                    <div class="flex flex-col gap-4">
                        <input class="bg-gray-200 rounded-xl px-6 py-3" name="username" placeholder="username" id="input-username" type="text" required>
                        <input class="bg-gray-200 rounded-xl px-6 py-3" name="password" placeholder="password" id="input-password" type="password" required>
                        <input class="bg-blue-400 w-fit self-center text-white font-bold rounded-2xl cursor-pointer px-6 py-3" name="login" type="submit" value="LOGIN" id="submit">
                        <?php
                        if (isset($_SESSION['error'])): ?>
                        <p class="text-red-500 m-4 text-center">
                            <?=  htmlspecialchars($_SESSION['error']); ?>
                        </p>
                        <?php
                        unset($_SESSION['error']);
                        ?>
                        <?php endif; ?>
                    </div>
                </fieldset>
            </form>
        </article>
        <article class="m-2 bg-gray-50 rounded flex justify-center items-center">
            <a href="src/tamu/landing_page.php" class="italic underline text-4xl cursor-pointer">Atau Masuk sebagai Tamu</a>
        </article>
    </main>
    <footer class="bg-gray-700 p-4">
        <div class="flex flex-col gap-4 text-amber-50 mb-12">
            <h3>
                HUBUNGI KAMI
            </h3>
            <p>Hotel Anugrah</p>
            <p>Jl. P. Antasari No.12</p>
            <p>+62 812-8499-4850</p>
            <p>cs@hotelanugrah.com</p>
        </div>
        <hr>
        <p class="text-amber-50 mt-12">&copy;2026 Hotel Anugrah. All Right Reserved.</p>
    </footer>
</body>
</html>