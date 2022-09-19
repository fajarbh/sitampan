<form class="theme-form" id="create-form" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0" for="long_komoditas">Longitude Komoditas</label>
        <input class="form-control" id="long_komoditas" name="long_komoditas" type="text" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="lat_komoditas">Latitude Komoditas</label>
        <input class="form-control" id="lat_komoditas" name="lat_komoditas" type="text" />
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>