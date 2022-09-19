<form class="theme-form" id="create-form" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0" for="nama_pengepul">Nama Pengepul</label>
        <input class="form-control" id="nama_pengepul" name="nama_pengepul" type="text" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="kontak">Kontak</label>
        <input class="form-control" id="kontak" name="kontak" type="text" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="alamat">Alamat</label>
        <input class="form-control" id="alamat" name="alamat" type="text" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="lokasi_distribusi">Lokasi Distribusi</label>
        <input class="form-control" id="lokasi_distribusi" name="lokasi_distribusi" type="text" />
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>