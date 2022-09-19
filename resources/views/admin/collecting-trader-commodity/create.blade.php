<form class="theme-form" id="create-form" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0" for="id_pengepul">Nama Pengepul</label>
        <select class="uiselect" id="id_pengepul" name="id_pengepul">
            @foreach($pengepul as $p)
                <option value="{{ $p->id }}">
                    {{ $p->nama_pengepul }}
                </option>
            @endforeach
        </select>    
    </div>
    @if(Auth::user()->level == 2)
        <input type="hidden" name="id_penyuluh" value="{{ $penyuluh->id }}" />
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
        <label class="form-label pt-0">Jenis Komoditas</label>
        <select class="uiselect" name="commodity_type" id="commodity_type">
            <option value="">Pilih Jenis Komoditas</option>
            @foreach($commoditySector as $row)
                <option value="{{ $row->id }}">
                    {{ $row->nama_jenis }}
                </option>
            @endforeach
        </select>    
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="id_komoditas">Nama Komoditas</label>
        <select class="uiselect" name="id_komoditas" id="commodity">
        </select>    
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="harga">Harga</label>
        <input class="form-control numeric comma" id="harga" name="harga" type="text" />
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>