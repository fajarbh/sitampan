<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('desa/update/'.$data->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="mb-3">
        <label class="form-label pt-0" for="id_kecamatan">Nama Kecamatan</label>
        <select class="uiselect" id="kecamatan" name="id_kecamatan">
            <option value="">Pilih Kecamatan</option>
            @foreach($district as $k)
                <option value="{{ $k->id }}" {{ $k->id == $data->id_kecamatan ? "selected" : "" }}  >
                    {{ $k->nama_kecamatan }}
                </option>
            @endforeach
        </select>    
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="nama_desa">Nama Desa</label>
        <select class="uiselect" name="nama_desa" id="desa">
            @foreach($village as $row)
                <option value="{{ $row->nama_desa }}" {{ $row->nama_desa == $data->nama_desa ? "selected" : "" }}  >
                    {{ $row->nama_desa }}
                </option>    
            @endforeach
        </select>
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Ubah</button>
    </div>
</form> 