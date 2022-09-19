<form class="theme-form" id="create-form" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0">Nama Kecamatan</label>
        <select class="uiselect" id="kecamatan" name="id_kecamatan">
            <option value="">Pilih Kecamatan</option>
            @foreach($district as $k)
            <option value="{{ $k->id }}">
                {{ $k->nama_kecamatan }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="desa">Nama Desa</label>
        <select class="uiselect" name="nama_desa" id="desa">
            <option value=""></option>
        </select>
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>