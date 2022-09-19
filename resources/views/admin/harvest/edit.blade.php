<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('panen/update/'.$data->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="mb-3">
        <label class="form-label pt-0" for="id_tanam">Nama Komoditas Tanam</label>
        <select class="uiselect" id="id_tanam" name="id_tanam">
            @foreach($commodityPlant as $row)
                <option value="{{ $row->id }}" {{ $row->id == $data->id_tanam ? "selected" : ""  }} >
                    {{ $row->commodity->nama_komoditas }}
                </option>
            @endforeach
        </select>    
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="tanggal_panen">Tanggal Panen</label>
        <input class="form-control" id="tanggal_panen" name="tanggal_panen" type="date" value="{{$data->tanggal_panen}}" required />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="jumlah_panen">Jumlah Panen (Ton)</label>
        <input class="form-control numeric" id="jumlah_panen" name="jumlah_panen" type="text" value="{{$data->jumlah_panen}}" required />
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>