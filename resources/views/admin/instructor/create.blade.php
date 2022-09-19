<form class="theme-form" id="create-form" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0" for="nik">NIK</label>
        <input class="form-control" id="nik" name="nik" type="text" maxlength="16" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="password">Password</label>
        <input class="form-control" id="password" name="password" type="password" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="nama_penyuluh">Nama Penyuluh</label>
        <input class="form-control" id="nama_penyuluh" name="nama_penyuluh" type="text" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="no_hp">No HP</label>
        <input class="form-control numeric" id="no_hp" name="no_hp" type="text" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0">Alamat</label>
        <textarea name="alamat" class="form-control"></textarea>
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>