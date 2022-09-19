<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('harga-petani/update/'.$data->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
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
        <input class="form-control" id="periode_bulan" name="periode_bulan" type="date" value="{{$data->periode_bulan}}" required />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="harga_tani">Harga Pasar Lokal</label>
        <input class="form-control numeric" id="harga_tani" name="harga_tani" type="text" value="{{$data->harga_tani}}" required />
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>