<form class="theme-form" id="create-form" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0">Nama Kelompok</label>
        <input class="form-control" id="nama_kelompok" name="nama_kelompok" type="text" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0">Nama Penyuluh</label>
        <select class="uiselect" id="id_penyuluh" name="id_penyuluh">
            @foreach($instructor as $row)
                <option value="{{ $row->id }}">
                    {{ $row->nama_penyuluh }}
                </option>
            @endforeach
        </select>    
    </div>
    <div class="mb-3">
        <label class="form-label pt-0">Nama Kecamatan</label>
        <select class="uiselect" id="id_kecamatan" name="id_kecamatan">
            <option value="">Pilih Kecamatan</option>
            @foreach($district as $k)
            <option value="{{ $k->id }}">
                {{ $k->nama_kecamatan }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label pt-0">Nama Desa</label>
        <select class="uiselect" id="desa" name="id_desa"></select>    
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>