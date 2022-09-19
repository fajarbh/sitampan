<form class="theme-form" id="create-form" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0" for="id_petani">Nama Petani</label>
        <select class="uiselect" id="id_petani" name="id_petani">
            @foreach($petani as $p)
                <option value="{{ $p->id }}">
                    {{ $p->nama_petani }}
                </option>
            @endforeach
        </select>    
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="id_komoditas">Nama Komoditas</label>
        <select class="uiselect" id="id_komoditas" name="id_komoditas">
            @foreach($komoditas as $k)
                <option value="{{ $k->id }}">
                    {{ $k->nama_komoditas }}
                </option>
            @endforeach
        </select>    
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="periode_bulan">Periode Bulan</label>
        <input class="form-control" id="periode_bulan" name="periode_bulan" type="date" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="harga_tani">Harga Pasar Lokal</label>
        <input class="form-control numeric" id="harga_tani" name="harga_tani" type="text" />
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>