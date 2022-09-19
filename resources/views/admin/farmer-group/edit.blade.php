<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('kelompok-tani/update/'.$data->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="mb-3">
        <label class="form-label pt-0">Nama Kelompok</label>
        <input class="form-control" id="nama_kelompok" value="{{ $data->nama_kelompok }}" name="nama_kelompok" type="text" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0">Nama Penyuluh</label>
        <select class="uiselect" id="id_penyuluh" name="id_penyuluh">
            @foreach($instructor as $row)
                <option {{$data->id_penyuluh == $row->id ? "selected" : "" }} value="{{ $row->id }}">
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
            <option value="{{ $k->id }}" {{ $k->id == $farmerGroupDistrict->id ? "selected" : "" }}>
                {{ $k->nama_kecamatan }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
    <label class="form-label pt-0">Nama Desa</label>
        <select class="uiselect" id="id_desa" name="id_desa">
            @foreach($village as $row)
            <option  value="{{ $row->id }}" {{$farmerGroupVillage->id == $row->id ? "selected" : "" }}>
                {{ $row->nama_desa }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>