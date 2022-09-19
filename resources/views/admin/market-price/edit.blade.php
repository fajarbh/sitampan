<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('harga-pasar/update/'.$data->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    @if(Auth::user()->level == 2)
        <input type="hidden" name="id_penyuluh" value="{{ $penyuluh->id }}">
    @else
    <div class="mb-3">
        <label class="form-label pt-0" for="id_penyuluh">Nama Penyuluh</label>
        <select class="uiselect" id="id_penyuluh" name="id_penyuluh">
            @foreach($penyuluh as $p)
                <option value="{{ $p->id }}">
                    {{ $p->nama_penyuluh }}
                </option>
            @endforeach
        </select>    
    </div>
    @endif
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
        <input class="form-control" id="periode_bulan" name="periode_bulan" type="date" value="{{$data->periode_bulan}}"/>
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="harga_pasar_lokal">Harga Pasar Lokal</label>
        <input class="form-control numeric comma" id="harga_pasar_lokal" name="harga_pasar_lokal" type="text" value="{{$data->harga_pasar_lokal}}"/>
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="harga_pasar_induk">Harga Pasar Induk</label>
        <input class="form-control numeric comma" id="harga_pasar_induk" name="harga_pasar_induk" type="text" value="{{$data->harga_pasar_induk}}"/>
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>