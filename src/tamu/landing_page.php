<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Anugrah</title>
    <?php
    if (str_contains($_SERVER['HTTP_HOST'], 'ddev.site')): ?>
    <script type="module" src="https://<?=  $_SERVER['HTTP_HOST'] ?>:5173/@vite/client"></script>
    <link rel="stylesheet" href="https://<?=  $_SERVER['HTTP_HOST'] ?>:5173/src/style.css">
    <?php
    else: ?>
    <link rel="stylesheet" href="../../dist/outputHasil.css">
    <?php endif; ?>
</head>
<body class="bg-blue-200">
    <main>
        <section class="bg-[url(/SistemInformasiHotel/dist/images/gambar_hotel.webp)] bg-cover bg-center min-h-screen">
            <div class="flex flex-col pt-116 mb-8">
                <h1 class="text-8xl font-bold text-white animate-slide-in pl-4">HOTEL ANUGRAH</h1>
                <H2 class="text-4xl font-bold text-white animate-slide-in pl-4">BUAT PENGALAMANMU ANDA TAK TERLUPAKAN</H2>
            </div>
            <div class="animate-bounce flex justify-center">
                <a class="px-4 py-2 bg-amber-400 rounded-xl text-2xl" href="pesan_kamar.php">
                    Pesan Kamar</a>
            </div>
        </section>
    </main>
</body>
</html>