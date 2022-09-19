<form class="theme-form" id="create-form" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0">Nama Komoditas</label>
        <input class="form-control" id="nama_komoditas" name="nama_komoditas" type="text" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="jenis_komoditas">Jenis Komoditas</label>
        <select class="uiselect" id="jenis_komoditas" name="id">
            @foreach($jenisKomoditas as $jk)
                <option value="{{ $jk->id }}">
                    {{ $jk->nama_jenis }}
                </option>
            @endforeach
        </select>    
    </div>
    <div class="mb-3">
        <label for="icon" class="form-label">Upload icon komoditas</label>
        <input class="form-control" type="file" id="icon" name="icon">
    </div> 
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>