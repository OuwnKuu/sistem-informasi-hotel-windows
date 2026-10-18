<?php
declare(strict_types=1);
include_once __DIR__ . "/../../koneksi.php";
?>

<table id="tabelPetugas" class="text-center border border-collapse" cellspacing="1" cellpadding="3">
    <tr class="h-10" bgcolor="lightgray">
        <th class="px-4 border">No</th>
        <th class="px-4 border">ID Petugas</th>
        <th class="px-4 border">Username</th>
        <th class="px-4 border">Nama Petugas</th>
        <th class="px-4 border">Level</th>
        <th class="px-12 border" colspan="2" align="center">Tools</th>
    </tr>
    <?php
    $stmt_data_petugas = $pdo->query("SELECT id_petugas, username, nama_petugas, level FROM petugas ORDER BY id_petugas ASC");
    $nomor = 0;
    while ($data = $stmt_data_petugas->fetch()) {
        $nomor++;
    ?>
        <tr class="h-10">
            <td class="border"><?php echo $nomor; ?></td>
            <td class="border"><?php echo $data['id_petugas']; ?></td>
            <td class="border"><?php echo $data['username']; ?></td>
            <td class="border"><?php echo $data['nama_petugas']; ?></td>
            <td class="border"><?php echo $data['level']; ?></td>
            <td class="border">
                <button
                    data-mode="edit"
                    data-id="<?php echo $data['id_petugas'] ?>"
                    data-id-petugas="<?php echo $data['id_petugas'] ?>"
                    data-username="<?php echo $data['username'] ?>"
                    data-nama-petugas="<?php echo $data['nama_petugas'] ?>"
                    data-level="<?php echo $data['level'] ?>"
                    class="js-btnAksi hover:underline hover:underline-offset-4 hover:text-lg hover:text-blue-700 hover:font-bold transition-all cursor-pointer">
                    Edit</button>
            </td>
            <td class="border">
                <button
                    id="btnHapus"
                    data-mode="delete"
                    data-id="<?php echo $data['id_petugas'] ?>"
                    class="js-btnAksi hover:underline hover:underline-offset-4 hover:text-lg hover:text-blue-700 hover:font-bold transition-all cursor-pointer">
                    Hapus</button>
            </td>
        </tr>
    <?php } ?>
</table>
<button data-mode="insert" class="border my-4 px-4 py-1 cursor-pointer hover:animate-pulse bg-indigo-400 text-white font-bold rounded-2xl js-btnAksi">
    Tambah Petugas</button>

<dialog id="popupDialog" class="relative p-4 rounded-xl w-1/2 h-1/2 m-auto">
    <button class="absolute right-1 top-1 hover:bg-gray-100 transition font-bold rounded-lg px-4 py-2" id="closeBtn">X</button>
    <form class="px-4" id="formInput">
        <input type="hidden" name="aksi" id="formAksi" value="">
        <input type="hidden" name="id" id="formId" value="">
        <input id="idPetugas" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="id-petugas" hidden>
        <fieldset>
            <legend class="mb-4 text-2xl font-bold">Input Data:</legend>
            <div class="grid grid-cols-2 gap-y-4 gap-x-24">
                <div>
                    <label>Username</label><br>
                    <input id="username" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="username" required>
                </div>
                <div>
                    <label>Password</label><br>
                    <input id="password" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="password" required>
                </div>
                <div>
                    <label>Nama Petugas</label><br>
                    <input id="namaPetugas" class="bg-gray-200 rounded-2xl px-2 w-full" type="text" name="nama-petugas">
                </div>
                <div>
                    <label>level</label><br>
                    <select id="level" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 transition" name="level">
                        <option value="petugas">
                            Petugas
                        </option>
                        <option value="admin">
                            Admin
                        </option>
                    </select>
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
        <p>Apakah Anda Yakin Ingin Menghapus Petugas: <span id="kodePetugas" class="font-bold"></span></p>
        <form id="formHapus" class="w-full">
            <input type="hidden" name="aksi" value="hapus">
            <input type="hidden" name="id" id="hapusId">
            <input type="hidden" name="id-petugas" id="idPetugasHapus">
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
            document.querySelector('#idPetugas').value = tombolDialog.dataset.idPetugas
            document.querySelector('#username').value = tombolDialog.dataset.username
            document.querySelector('#namaPetugas').value = tombolDialog.dataset.namaPetugas
            document.querySelector('#level').value = tombolDialog.dataset.level
            document.querySelector('#btnKirim').textContent = "Edit"
            popupDlg.showModal()
        } else {
            document.querySelector('#kodePetugas').textContent = tombolDialog.dataset.id + "?"
            document.querySelector('#hapusId').value = tombolDialog.dataset.id
            document.querySelector('#idPetugasHapus').value = tombolDialog.dataset.id
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
            const response = await fetch('dml_petugas.php', {
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
            const response = await fetch('dml_petugas.php', {
                method: 'POST',
                body: formDeleteData
            })

            const hasil = await response.json();
            
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