<?php

declare(strict_types=1);
include_once __DIR__ . "/../../koneksi.php";
?>

<table id="tabelKamar" class="text-center border border-collapse" cellspacing="1" cellpadding="3">
    <tr class="h-10" bgcolor="lightgray">
        <th class="px-4 border">No</th>
        <th class="px-4 border">ID Tamu</th>
        <th class="px-4 border">Nama</th>
        <th class="px-4 border">No Telepon</th>
        <th class="px-4 border">ID Kamar</th>
        <th class="px-4 border">Waktu Check-in</th>
        <th class="px-4 border">Waktu Check-out</th>
        <th class="px-4 border">Durasi Inap</th>
        <th class="px-4 border">ID Pembayaran</th>
        <th class="px-12 border" colspan="2" align="center">Tools</th>
    </tr>
    <?php
    $stmt_data_tamu = $pdo->query("SELECT * FROM tamu ORDER BY id_tamu ASC");
    $nomor = 0;
    while ($data = $stmt_data_tamu->fetch()) {
        $nomor++;
    ?>
        <tr class="h-10">
            <td class="border"><?php echo $nomor; ?></td>
            <td class="border"><?php echo $data['id_tamu']; ?></td>
            <td class="border"><?php echo $data['nama']; ?></td>
            <td class="border"><?php echo $data['no_telepon']; ?></td>
            <td class="border"><?php echo $data['id_kamar']; ?></td>
            <td class="border"><?php echo $data['waktu_check_in']; ?></td>
            <td class="border"><?php echo $data['waktu_check_out']; ?></td>
            <td class="border"><?php echo $data['durasi_inap']; ?></td>
            <td class="border"><?php echo $data['id_pembayaran']; ?></td>
            <td class="border">
                <button
                    data-mode="edit"
                    data-id="<?php echo $data['id_tamu'] ?>"
                    data-id-tamu="<?php echo $data['id_tamu'] ?>"
                    data-nama="<?php echo $data['nama'] ?>"
                    data-no-telepon="<?php echo $data['no_telepon'] ?>"
                    data-id-kamar="<?php echo $data['id_kamar'] ?>"
                    data-waktu-check-in="<?php echo $data['waktu_check_in'] ?>"
                    data-waktu-check-out="<?php echo $data['waktu_check_out'] ?>"
                    data-durasi-inap="<?php echo $data['durasi_inap'] ?>"
                    class="js-btnAksi hover:underline hover:underline-offset-4 hover:text-lg hover:text-blue-700 hover:font-bold transition-all cursor-pointer">
                    Edit</button>
            </td>
            <td class="border">
                <button
                    id="btnHapus"
                    data-mode="delete"
                    data-id="<?php echo $data['id_tamu'] ?>"
                    class="js-btnAksi hover:underline hover:underline-offset-4 hover:text-lg hover:text-blue-700 hover:font-bold transition-all cursor-pointer">
                    Hapus</button>
            </td>
        </tr>
    <?php } ?>
</table>
<button data-mode="insert" class="border my-4 px-4 py-1 cursor-pointer hover:animate-pulse bg-indigo-400 text-white font-bold rounded-2xl js-btnAksi">
    Tambah Tamu</button>

<dialog id="popupDialog" class="relative p-4 rounded-xl w-1/2 h-1/2 m-auto">
    <button class="absolute right-1 top-1 hover:bg-gray-100 transition font-bold rounded-lg px-4 py-2" id="closeBtn">X</button>
    <form class="px-4" id="formInput">
        <input type="hidden" name="aksi" id="formAksi" value="">
        <input type="hidden" name="id" id="formId" value="">
        <input id="idTamu" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="id-tamu" hidden>
        <fieldset>
            <legend class="mb-4 text-2xl font-bold">Input Data:</legend>
            <div class="grid grid-cols-2 gap-y-4 gap-x-24">
                <div>
                    <label>Nama</label><br>
                    <input id="nama" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="nama" required>
                </div>
                <div>
                    <label>Nomor Telepon</label><br>
                    <input id="noTelepon" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="nomor-telepon" required>
                </div>
                <div>
                    <label>ID Kamar</label><br>
                    <input id="idKamar" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="id-kamar" required>
                </div>
                <div>
                    <label>Waktu Check-in</label><br>
                    <input id="waktuCheckIn" class="bg-gray-200 rounded-2xl px-2 w-full" type="datetime-local" step="1" name="waktu-check-in">
                </div>
                <div>
                    <label>Waktu Check-out</label><br>
                    <input id="waktuCheckOut" class="bg-gray-200 rounded-2xl px-2 w-full" type="datetime-local" step="1" name="waktu-check-out">
                </div>
                <div>
                    <label>Durasi Inap</label><br>
                    <input id="durasiInap" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="durasi-inap">
                </div>
            </div>
            <div class="flex justify-center">
                <button id="btnKirim" type="submit" class="w-1/3 mt-8 rounded-2xl bg-indigo-500 hover:animate-pulse py-2 font-bold text-white cursor-pointer"></button>
            </div>
        </fieldset>
    </form>
</dialog>

<dialog id="dlgDelete" class="p-4 rounded-xl w-1/4 h-1/4 m-auto">
    <div class="flex flex-col justify-center items-center h-full">
        <p>Apakah Anda Yakin Ingin Menghapus Tamu: <span id="kodeTamu" class="font-bold"></span></p>
        <form id="formHapus" class="w-full">
            <input type="hidden" name="aksi" value="hapus">
            <input type="hidden" name="id" id="hapusId">
            <input type="hidden" name="id-tamu" id="idTamuHapus">
            <div class="flex w-full justify-between">
                <button type="submit" class="w-1/3 mt-8 rounded-2xl bg-indigo-500 hover:animate-pulse px-4 py-2 font-bold text-white cursor-pointer">Ya</button>
                <button type="button" id="btnBatal" class="w-1/3 mt-8 rounded-2xl border border-gray-400 hover:animate-pulse px-4 py-2 font-bold cursor-pointer">Tidak</button>
            </div>
        </form>
    </div>
</dialog>

<dialog id="dlgTunggu" class="p-4 rounded-xl w-1/4 h-1/4 m-auto">
    <div class="flex justify-center items-center h-full">
        <p>Harap Tunggu</p>
    </div>
</dialog>

<script>
    const popupDlg = document.querySelector('#popupDialog')
    const closeBtn = document.querySelector('#closeBtn')
    const btnBatal = document.querySelector('#btnBatal')
    const btnHapus = document.querySelector('#btnHapus')
    const formInput = document.querySelector('#formInput')
    const formHapus = document.querySelector('#formHapus')
    const dlgDelete = document.querySelector('#dlgDelete')
    const dlgTunggu = document.querySelector('#dlgTunggu')

    document.addEventListener('click', e => {
        const tombolDialog = e.target.closest('.js-btnAksi')
        if (!tombolDialog) return
        const mode = tombolDialog.dataset.mode

        if (mode === 'insert') {
            formInput.reset()
            document.querySelector('#formAksi').value = "tambah"
            document.querySelector('#formId').value = ""
            document.querySelector('#btnKirim').textContent = "Tambah"
            popupDlg.showModal()
        } else if (mode === 'edit') {
            document.querySelector('#formAksi').value = "edit"
            document.querySelector('#formId').value = tombolDialog.dataset.id
            document.querySelector('#idTamu').value = tombolDialog.dataset.id
            document.querySelector('#nama').value = tombolDialog.dataset.nama
            document.querySelector('#noTelepon').value = tombolDialog.dataset.noTelepon
            document.querySelector('#idKamar').value = tombolDialog.dataset.idKamar
            document.querySelector('#waktuCheckIn').value = tombolDialog.dataset.waktuCheckIn
            document.querySelector('#waktuCheckOut').value = tombolDialog.dataset.waktuCheckOut
            document.querySelector('#durasiInap').value = tombolDialog.dataset.durasiInap
            document.querySelector('#btnKirim').textContent = "Edit"
            popupDlg.showModal()
        } else {
            document.querySelector('#kodeTamu').textContent = tombolDialog.dataset.id + "?"
            document.querySelector('#hapusId').value = tombolDialog.dataset.id
            document.querySelector('#idTamuHapus').value = tombolDialog.dataset.id
            dlgDelete.showModal()
        }
    })

    closeBtn.addEventListener('click', () => {
        popupDlg.close()
    })

    btnBatal.addEventListener('click', () => {
        dlgDelete.close()
    })

    formInput.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(formInput)

        try {
            const response = await fetch('dml_tamu.php', {
                method: 'POST',
                body: formData
            })

            const hasil = await response.json()
            
            if (hasil.status === 'sukses') {
                formInput.reset()
                popupDlg.close();
                dlgTunggu.showModal();
                setTimeout(() => {
                    location.reload()
                }, 2000)
            } else {
                alert('Gagal: ' + hasil.pesan)
            }
        } catch (error) {
            console.error('Error: ', error)
            alert('Terjadi kesalahan sistem')
        }
    })

    dlgDelete.addEventListener('submit', async e => {
        e.preventDefault();
        const formDeleteData = new FormData(formHapus)

        try {
            const response = await fetch('dml_tamu.php', {
                method: 'POST',
                body: formDeleteData
            })

            const hasil = await response.json()
            
            if (hasil.status === 'sukses') {
                formHapus.reset()
                dlgDelete.close();
                dlgTunggu.showModal();
                setTimeout(() => {
                    location.reload()
                }, 2000)
            } else {
                alert('Gagal: ' + hasil.pesan)
            }
        } catch (error) {
            console.error('Error: ', error)
            alert('Terjadi kesalahan sistem')
        }
    })
</script>