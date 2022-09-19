<form class="theme-form" id="create-form" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0">Nama Petani</label>
        <select class="uiselect" id="id_petani" name="id_petani">
            @foreach($farmer as $row)
                <option value="{{ $row->id }}" {{ $row->id == $data-> id_petani ? "seleted" : "" }}>
                    {{ $row->nama_petani }}
                </option>
            @endforeach
        </select>    
    </div>
    <div class="mb-3">
        <label class="form-label pt-0">Nama Komoditas</label>
        <select class="uiselect" id="id_komoditas" name="id_komoditas">
            @foreach($commodity as $row)
                <option value="{{ $row->id }}" {{ $row->id == $data-> id_komoditas ? "seleted" : "" }}>
                    {{ $row->nama_komoditas }}
                </option>
            @endforeach
        </select>    
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>