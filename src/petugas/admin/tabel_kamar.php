<?php
declare(strict_types=1);
include_once __DIR__ . "/../../koneksi.php";
?>

<table class="text-center border border-collapse" cellspacing="1" cellpadding="3">
    <tr class="h-10" bgcolor="lightgray">
        <th class="px-4 border">No</th>
        <th class="px-4 border">ID Kamar</th>
        <th class="px-4 border">Fasilitas</th>
        <th class="px-4 border">Tempat Tidur</th>
        <th class="px-4 border">Status</th>
        <th class="px-4 border">ID Tamu</th>
        <th class="px-4 border">Harga Per Malam</th>
        <th class="px-12 border" colspan="2" align="center">Tools</th>
    </tr>
    <?php
    $stmt_data_kamar = $pdo->query("SELECT * FROM kamar ORDER BY id_kamar ASC");
    $nomor = 0;
    while ($data = $stmt_data_kamar->fetch()) {
        $nomor++;
    ?>
        <tr class="h-10">
            <td class="border"><?php echo $nomor; ?></td>
            <td class="border"><?php echo $data['id_kamar']; ?></td>
            <td class="border"><?php echo $data['fasilitas']; ?></td>
            <td class="border"><?php echo $data['tempat_tidur']; ?></td>
            <td class="border"><?php echo $data['status']; ?></td>
            <td class="border"><?php echo $data['id_tamu']; ?></td>
            <td class="border"><?php echo $data['harga_per_malam']; ?></td>
            <td class="border">
                <button
                    data-mode="edit"
                    data-id="<?php echo $data['id_kamar'] ?>"
                    data-id-kamar="<?php echo $data['id_kamar'] ?>"
                    data-fasilitas="<?php echo $data['fasilitas'] ?>"
                    data-tempat-tidur="<?php echo $data['tempat_tidur'] ?>"
                    data-status="<?php echo $data['status'] ?>"
                    data-id-tamu="<?php echo $data['id_tamu'] ?>"
                    data-harga-per-malam="<?php echo $data['harga_per_malam'] ?>"
                    class="js-btnAksi hover:underline hover:underline-offset-4 hover:text-lg hover:text-blue-700 hover:font-bold transition-all cursor-pointer">
                    Edit</button>
            </td>
            <td class="border">
                <button
                    id="btnHapus"
                    data-mode="delete"
                    data-id="<?php echo $data['id_kamar'] ?>"
                    class="js-btnAksi hover:underline hover:underline-offset-4 hover:text-lg hover:text-blue-700 hover:font-bold transition-all cursor-pointer">
                    Hapus</button>
            </td>
        </tr>
    <?php } ?>
</table>
<button data-mode="insert" class="border my-4 px-4 py-1 cursor-pointer hover:animate-pulse bg-indigo-400 text-white font-bold rounded-2xl js-btnAksi">
    Tambah Kamar</button>

<dialog id="popupDialog" class="relative p-4 rounded-xl w-1/2 h-1/2 m-auto">
    <button class="absolute right-1 top-1 hover:bg-gray-100 transition font-bold rounded-lg px-4 py-2" id="closeBtn">X</button>
    <form class="px-4" id="formInput">
        <input type="hidden" name="aksi" id="formAksi" value="">
        <input type="hidden" name="id" id="formId" value="">
        <fieldset>
            <legend class="mb-4 text-2xl font-bold">Input Data:</legend>
            <div class="grid grid-cols-2 gap-y-4 gap-x-24">
                <div>
                    <label>ID Kamar</label><br>
                    <input id="idKamar" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="id-kamar" required>
                </div>
                <div>
                    <label>Fasilitas</label><br>
                    <input id="fasilitas" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="fasilitas" required>
                </div>
                <div>
                    <label>Tempat Tidur</label><br>
                    <input id="tempatTidur" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="tempat-tidur" required>
                </div>
                <div>
                    <label>Status</label><br>
                    <select id="status" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 transition" name="status">
                        <option value="Kosong">
                            Kosong
                        </option>
                        <option value="Terisi">
                            Terisi
                        </option>
                    </select>
                </div>
                <div>
                    <label>ID Tamu</label><br>
                    <input id="idTamu" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="id-tamu">
                </div>
                <div>
                    <label>Harga Per Malam</label><br>
                    <input id="hargaPerMalam" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="harga-per-malam">
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
        <p>Apakah Anda Yakin Ingin Menghapus Kamar: <span id="kodeKamar" class="font-bold"></span></p>
        <form id="formHapus" class="w-full">
            <input type="hidden" name="aksi" value="hapus">
            <input type="hidden" name="id" id="hapusId">
            <input type="hidden" name="id-kamar" id="idKamarHapus">
            <div class="flex w-full justify-between">
                <button type="submit" data-btn-ya="hapus" class="w-1/3 mt-8 rounded-2xl bg-indigo-500 hover:animate-pulse px-4 py-2 font-bold text-white cursor-pointer">Ya</button>
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
            document.querySelector('#idKamar').value = tombolDialog.dataset.idKamar
            document.querySelector('#fasilitas').value = tombolDialog.dataset.fasilitas
            document.querySelector('#tempatTidur').value = tombolDialog.dataset.tempatTidur
            document.querySelector('#status').value = tombolDialog.dataset.status
            document.querySelector('#idTamu').value = tombolDialog.dataset.idTamu
            document.querySelector('#hargaPerMalam').value = tombolDialog.dataset.hargaPerMalam
            document.querySelector('#btnKirim').textContent = "Edit"
            popupDlg.showModal()
        } else {
            document.querySelector('#kodeKamar').textContent = tombolDialog.dataset.id + "?"
            document.querySelector('#hapusId').value = tombolDialog.dataset.id
            document.querySelector('#idKamarHapus').value = tombolDialog.dataset.id
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
            const response = await fetch('dml_kamar.php', {
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
            const response = await fetch('dml_kamar.php', {
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