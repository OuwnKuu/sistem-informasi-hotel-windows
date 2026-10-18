<?php
declare(strict_types=1);

include_once __DIR__ . "/../koneksi.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kamar</title>
    <?php
    if (str_contains($_SERVER['HTTP_HOST'], 'ddev.site')): ?>
        <script type="module" src="https://<?= $_SERVER['HTTP_HOST'] ?>:5173/@vite/client"></script>
        <link rel="stylesheet" href="https://<?= $_SERVER['HTTP_HOST'] ?>:5173/src/style.css">
    <?php
    else: ?>
        <link rel="stylesheet" href="dist/outputHasil2.css">
    <?php endif; ?>
</head>

<body>
    <main class="flex justify-center bg-blue-400">
        <form id="formPesanKamar" class="bg-white px-6 py-3 my-16 rounded-xl w-fit">
            <h2 class="text-center font-bold text-2xl mt-4 mb-4">FORMULIR PEMESANAN KAMAR</h2>
            <hr class="mb-4">
            <fieldset>
                <legend class="my-4 font-bold text-xl">Informasi Pribadi</legend>

                <div class="flex justify-start gap-18">
                    <div>
                        <label for="nama">Nama:</label>
                        <input class="bg-gray-200 rounded-lg px-2" type="text" id="nama" name="nama" required>
                    </div>

                    <div>
                        <label for="nomorTelepon">Nomor Telepon:</label>
                        <input class="bg-gray-200 rounded-lg px-2" type="tel" id="nomorTelepon" name="nomor-telepon" required>
                    </div>
                </div>

            </fieldset>
            <fieldset>
                <legend class="my-4 font-bold text-xl">Durasi Inap & Tipe Kamar</legend>

                <label for="durasiInap">Durasi Inap:</label>
                <input class="bg-gray-200 rounded-lg px-2 mb-4 mr-4" type="number" min="1" max="7" value="1" id="durasiInap" name="durasi-inap" required>
                <span>Malam</span>
                <br>
                <label>Tipe Kamar:</label>
                <br>
                <div class="flex gap-12">
                    <div>
                        <input class="cursor-pointer" type="radio" id="standard" name="fasilitas" value="Standard">
                        <label for="standard">Standard</label>
                        <img class="rounded-lg" src="../../assets/images/kamar_standard.jpg" width="300">
                    </div>
                    <div>
                        <input class="cursor-pointer" type="radio" id="deluxe" name="fasilitas" value="Deluxe">
                        <label for="deluxe">Deluxe</label>
                        <img class="rounded-lg" src="../../assets/images/kamar_deluxe.jpg" width="300">
                    </div>
                    <div>
                        <input class="cursor-pointer" type="radio" id="executive" name="fasilitas" value="Executive">
                        <label for="executive">Executive</label>
                        <img class="rounded-lg" src="../../assets/images/kamar_executive.jpg" width="300">
                    </div>
                </div>
                <br>
                <label>Tempat Tidur:</label>
                <select class="bg-gray-200 rounded-lg px-2 ml-2" name="kasur" id="selectKasur" onchange="cekPilihan(this)">
                    <option value="default">
                        Pilih Jenis Kamar Terlebih Dahulu
                    </option>
                </select>
                <br>
                <p class="font-bold text-2xl mt-8" id="totalHarga">Total Harga: </p>
            </fieldset>
            <div class="flex justify-center">
                <button id="btnKirim" type="submit" class="w-1/3 mt-8 mb-4 rounded-2xl bg-indigo-500 hover:animate-pulse py-2 font-bold text-white cursor-pointer">Kirim</button>
            </div>
        </form>
    </main>

    <dialog id="dlgHasil" class="p-4 rounded-xl w-1/4 h-1/4 m-auto">
        <div class="flex flex-col justify-center items-center h-full">
            <p>Formulir reservasimu Berhasil Dikirim</p>
            <p>Harap Tunggu Balasan Dari Hotel Anugrah</p>
        </div>
        <button id="btnOk" type="button" class="text-center w-1/3 mt-8 rounded-2xl bg-indigo-500 hover:animate-pulse px-4 py-2 font-bold text-white cursor-pointer">Baik</button>
    </dialog>

    <script>
        const formPesanKamar = document.querySelector('#formPesanKamar')
        const btnHitung = document.querySelector('#btnHitung')
        const totalHarga = document.querySelector('#totalHarga')
        const btnKirim = document.querySelector('#btnKirim')
        const dlgHasil = document.querySelector('#dlgHasil')
        const btnOk = document.querySelector('#btnOk')
        const durasiInap = document.querySelector('#durasiInap')

        

        btnKirim.addEventListener('click', async (e) => {
            e.preventDefault()
            const formData = new FormData(formPesanKamar)

            try {
                const response = await fetch('tambah_tamu_baru.php', {
                    method: 'POST',
                    body: formData
                })

                const hasil = await response.json()

                if (hasil.status === 'sukses') {
                    formPesanKamar.reset()
                    dlgHasil.showModal();
                } else {
                    alert('Gagal: ' + hasil.pesan)
                }
            } catch (error) {
                console.error('Error: ', error)
                alert('Terjadi kesalahan sistem')
            }
        })

        btnOk.addEventListener('click', () => {
            location.reload()
        })

        const daftarKasur = {
            Standard: ["Single", "Queen"],
            Deluxe: ["Twin Bed", "Queen"],
            Executive: ["Twin Bed", "King"]
        }

        const radioJenisKamar = document.querySelectorAll('input[name="fasilitas"]')
        const selectKasur = document.querySelector('#selectKasur')
        durasiInap.addEventListener('change', () => cekPilihan(this))

        function perbaruiSelect(jenisKamarTerpilih) {
            selectKasur.innerHTML = ""

            const jenisKasur = daftarKasur[jenisKamarTerpilih]

            jenisKasur.forEach(kasur => {
                const option = document.createElement('option')
                option.value = kasur
                option.textContent = kasur
                selectKasur.appendChild(option)
            })
        }

        radioJenisKamar.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    perbaruiSelect(this.value)
                }
                cekPilihan(this)
            })
        })

        async function cekPilihan(elemen) {
            if (selectKasur.value === "default") return
            
            const formData = new FormData(formPesanKamar)

            try {
                const response = await fetch('hitung_per_malam.php', {
                    method: 'POST',
                    body: formData
                })

                const hasil = await response.text()

                if (hasil !== null) {
                    const formatRupiah = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(hasil)
                    totalHarga.textContent = "Total Harga: " + formatRupiah
                } else {
                    alert('Gagal: ' + hasil.pesan)
                }
            } catch (error) {
                console.error('Error: ', error)
                alert('Terjadi kesalahan sistem')
            }
        
        }
    </script>

</body>


</html>