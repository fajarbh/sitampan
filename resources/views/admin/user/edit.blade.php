<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('akun/update/'.$data->id) }}" method="PUT">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="mb-3">
        <label class="form-label pt-0" for="nik">NIK</label>
        <input class="form-control" id="nik" name="nik" type="text"  maxlength="16" value="{{ $data->nik }}" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="no_hp">No HP</label>
        <input class="form-control" id="no_hp" name="no_hp" type="text" value="{{ $data->no_hp }}" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="password">Password</label>
        <input class="form-control" id="password" name="password" type="password"/>
        <div id="show-hide"><span data-state="show"></span></div>
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Ubah</button>
    </div>
</form>
