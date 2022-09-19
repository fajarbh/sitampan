<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('tanam/update/'.$data->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="row">
      <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label pt-0">Jenis Komoditas</label>
            <select class="uiselect" name="commodity_type" id="commodity_type">
                <option value="">Pilih Jenis Komoditas</option>
                @foreach($commoditySector as $row)
                    <option value="{{ $row->id }}" {{ $row->id == $data->commodity->id_jenis ? "selected" : "" }}>
                        {{ $row->nama_jenis }}
                    </option>
                @endforeach
            </select>    
        </div>
        <div class="mb-3">
            <input type="hidden" name="id_petani" value="{{ $farmer->id }}">
            <label class="form-label pt-0" for="id_komoditas">Nama Komoditas</label>
            <select class="uiselect" id="id_komoditas" name="id_komoditas">
                @foreach($commodity as $row)
                <option value="{{ $row->id }}" {{ $row->id == $data->id_komoditas ? "selected" : "" }}>
                    {{ $row->nama_komoditas }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label pt-0" for="tanggal_tanam">Tanggal Tanam</label>
            <input class="form-control" id="tanggal_tanam" name="tanggal_tanam" type="date" value="{{ $data->tanggal_tanam }}"/>
        </div>
        <div class="mb-3">
            <label class="form-label pt-0" for="jumlah_tanam">Jumlah Tanam (Ton)</label>
            <input class="form-control numeric" id="jumlah_tanam" name="jumlah_tanam" type="text" value="{{ $data->jumlah_tanam }}" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label pt-0" for="luas_tanam">Luas Tanam (Hektar)</label>
            <input class="form-control numeric" id="luas_tanam" name="luas_tanam" type="text" value="{{ $data->luas_tanam }}" />
        </div>
        <div class="mb-3">
            <label class="form-label pt-0" for="jenis_pupuk">Jenis Pupuk</label>
            <input class="form-control" id="jenis_pupuk" name="jenis_pupuk" type="text" value="{{ $data->jenis_pupuk }}" />
        </div>
        <div class="mb-3">
            <label class="form-label pt-0" for="biaya_produksi">Biaya Produksi</label>
            <input class="form-control comma numeric" id="biaya_produksi" name="biaya_produksi" type="text" value="{{ number_format($data->biaya_produksi,0,'','.') }}" />
        </div>
        <div class="d-flex flex-row-reverse">
            <button class="btn btn-primary" id="save" type="submit">Ubah</button>
        </div>
      </div>
    </div>
</form>