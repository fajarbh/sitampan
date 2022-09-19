<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('pendaftaran-penyuluh/update/'.$data->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="hidden" value="{{ $data->user->id }}" name="id_user">
    <div class="mb-3">
        <label class="form-label pt-0" for="nik">NIK</label>
        <input class="form-control" id="nik" name="nik" type="text" value="{{ $data->user->nik }}" maxlength="16"  />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="nama_penyuluh">Nama Penyuluh</label>
        <input class="form-control" id="nama_penyuluh" name="nama_penyuluh" type="text" value="{{ $data->nama_penyuluh }}"  />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="no_hp">No HP</label>
        <input class="form-control numeric" id="no_hp" name="no_hp" value="{{ $data->user->no_hp }}" type="text"/>
    </div>
    <div class="mb-3">
        <label class="form-label pt-0">Alamat</label>
        <textarea name="alamat" class="form-control">{{ $data->alamat }}</textarea>
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>