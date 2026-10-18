<?php

declare(strict_types=1);
include_once __DIR__ . "/../koneksi.php";
?>

<table id="tabelTamuBaru" class="text-center border border-collapse mb-8" cellspacing="1" cellpadding="3">
    <tr class="h-10" bgcolor="lightgray">
        <th class="px-4 border">No</th>
        <th class="px-4 border">ID Tamu Baru</th>
        <th class="px-4 border">Nama</th>
        <th class="px-4 border">No Telepon</th>
        <th class="px-4 border">Durasi Inap</th>
        <th class="px-4 border">Fasilitas</th>
        <th class="px-4 border">Tempat Tidur</th>
        <th class="px-12 border" colspan="2" align="center">Tools</th>
    </tr>
    <?php
    $stmt_data_tamu_baru = $pdo->query("SELECT * FROM tamu_baru ORDER BY id_tamu_baru ASC");
    $nomor = 0;
    while ($data = $stmt_data_tamu_baru->fetch()) {
        $nomor++;
    ?>
        <tr class="h-10">
            <td class="border"><?php echo $nomor; ?></td>
            <td class="border"><?php echo $data['id_tamu_baru']; ?></td>
            <td class="border"><?php echo $data['nama']; ?></td>
            <td class="border"><?php echo $data['no_telepon']; ?></td>
            <td class="border"><?php echo $data['durasi_inap']; ?> Malam</td>
            <td class="border"><?php echo $data['fasilitas']; ?></td>
            <td class="border"><?php echo $data['tempat_tidur']; ?></td>
            <td class="border">
                <button
                    data-mode="edit"
                    data-id="<?php echo $data['id_tamu_baru'] ?>"
                    data-id-tamu-baru="<?php echo $data['id_tamu_baru'] ?>"
                    data-nama-tamu-baru="<?php echo $data['nama'] ?>"
                    data-no-telepon-tamu-baru="<?php echo $data['no_telepon'] ?>"
                    data-durasi-inap-tamu-baru="<?php echo $data['durasi_inap'] ?>"
                    data-fasilitas="<?php echo $data['fasilitas'] ?>"
                    data-tempat-tidur="<?php echo $data['tempat_tidur'] ?>"
                    class="js-btnAksiTamuBaru hover:underline hover:underline-offset-4 hover:text-lg hover:text-blue-700 hover:font-bold transition-all cursor-pointer">
                    Edit</button>
            </td>
            <td class="border">
                <button
                    id="btnHapus"
                    data-mode="delete"
                    data-id="<?php echo $data['id_tamu_baru'] ?>"
                    class="js-btnAksiTamuBaru hover:underline hover:underline-offset-4 hover:text-lg hover:text-blue-700 hover:font-bold transition-all cursor-pointer">
                    Hapus</button>
            </td>
        </tr>
    <?php } ?>
</table>

<dialog id="popupDialogTamuBaru" class="relative p-4 rounded-xl w-1/2 h-1/2 m-auto">
    <button class="absolute right-1 top-1 hover:bg-gray-100 transition font-bold rounded-lg px-4 py-2" id="closeBtnDlgTamuBaru">X</button>
    <form class="px-4" id="formEditTamuBaru">
        <input type="hidden" name="aksi-form-tamu-baru" value="edit">
        <input type="hidden" name="id" id="formIdTamuBaru" value="">
        <input id="idTamuBaru" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="id-tamu-baru" hidden>
        <fieldset>
            <legend class="mb-4 text-2xl font-bold">Input Data:</legend>
            <div class="grid grid-cols-2 gap-y-4 gap-x-24">
                <div>
                    <label>Nama</label><br>
                    <input id="namaTamuBaru" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="nama-tamu-baru" required>
                </div>
                <div>
                    <label>Nomor Telepon</label><br>
                    <input id="noTeleponTamuBaru" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="nomor-telepon-tamu-baru" required>
                </div>
                <div>
                    <label>Durasi Inap</label><br>
                    <input id="durasiInapTamuBaru" class="bg-gray-200 rounded-2xl px-2 w-full" type="number" name="durasi-inap-tamu-baru" min="1" max="7" required>
                </div>
                <div>
                    <label>Fasilitas</label><br>
                    <input id="fasilitas" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="fasilitas" required>
                </div>
                <div>
                    <label>Tempat Tidur</label><br>
                    <input id="tempatTidur" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="tempat-tidur" required>
                </div>
            </div>
            <div class="flex justify-center">
                <button id="btnKirim" type="submit" class="w-1/3 mt-8 rounded-2xl bg-indigo-500 hover:animate-pulse py-2 font-bold text-white cursor-pointer">Edit</button>
            </div>
        </fieldset>
    </form>
</dialog>

<dialog id="dlgDeleteTamuBaru" class="p-4 rounded-xl w-1/4 h-1/4 m-auto">
    <div class="flex flex-col justify-center items-center h-full">
        <p>Apakah Anda Yakin Ingin Menghapus Tamu Baru: <span id="kodeTamuBaru" class="font-bold"></span></p>
        <form id="formHapusTamuBaru" class="w-full">
            <input type="hidden" name="aksi-form-tamu-baru" value="hapus">
            <input type="hidden" name="id" id="hapusIdFormTamuBaru">
            <input type="hidden" name="id-tamu-baru" id="idTamuBaruHapus">
            <div class="flex w-full justify-between">
                <button type="submit" class="w-1/3 mt-8 rounded-2xl bg-indigo-500 hover:animate-pulse px-4 py-2 font-bold text-white cursor-pointer">Ya</button>
                <button type="button" id="btnBatalHapusTamuBaru" class="w-1/3 mt-8 rounded-2xl border border-gray-400 hover:animate-pulse px-4 py-2 font-bold cursor-pointer">Tidak</button>
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
    const popupDlgTamuBaru = document.querySelector('#popupDialogTamuBaru')
    const formEditTamuBaru = document.querySelector('#formEditTamuBaru')
    const formHapusTamuBaru = document.querySelector('#formHapusTamuBaru')
    const dlgDeleteTamuBaru = document.querySelector('#dlgDeleteTamuBaru')
    const closeBtnDlgTamuBaru = document.querySelector('#closeBtnDlgTamuBaru')
    const btnBatalHapusTamuBaru = document.querySelector('#btnBatalHapusTamuBaru')

    document.addEventListener('click', e => {
        const tombolDialog = e.target.closest('.js-btnAksiTamuBaru')
        if (!tombolDialog) return
        const mode = tombolDialog.dataset.mode

        if (mode === 'edit') {
            document.querySelector('#formIdTamuBaru').value = tombolDialog.dataset.id
            document.querySelector('#idTamuBaru').value = tombolDialog.dataset.id
            document.querySelector('#namaTamuBaru').value = tombolDialog.dataset.namaTamuBaru
            document.querySelector('#noTeleponTamuBaru').value = tombolDialog.dataset.noTeleponTamuBaru
            document.querySelector('#durasiInapTamuBaru').value = tombolDialog.dataset.durasiInapTamuBaru
            document.querySelector('#fasilitas').value = tombolDialog.dataset.fasilitas
            document.querySelector('#tempatTidur').value = tombolDialog.dataset.tempatTidur
            popupDlgTamuBaru.showModal()
        } else {
            document.querySelector('#kodeTamuBaru').textContent = tombolDialog.dataset.id + "?"
            document.querySelector('#hapusIdFormTamuBaru').value = tombolDialog.dataset.id
            document.querySelector('#idTamuBaruHapus').value = tombolDialog.dataset.id
            dlgDeleteTamuBaru.showModal()
        }
    })

    closeBtnDlgTamuBaru.addEventListener('click', () => {
        popupDlgTamuBaru.close()
    })

    btnBatalHapusTamuBaru.addEventListener('click', () => {
        dlgDeleteTamuBaru.close()
    })

    formEditTamuBaru.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(formEditTamuBaru)

        try {
            const response = await fetch('dml_tamu_baru.php', {
                method: 'POST',
                body: formData
            })

            const hasil = await response.json()
            
            if (hasil.status === 'sukses') {
                formEditTamuBaru.reset()
                popupDlgTamuBaru.close();
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

    dlgDeleteTamuBaru.addEventListener('submit', async e => {
        e.preventDefault();
        const formDeleteData = new FormData(formHapusTamuBaru)

        try {
            const response = await fetch('dml_tamu_baru.php', {
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