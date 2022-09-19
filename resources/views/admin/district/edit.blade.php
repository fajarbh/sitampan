<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('kecamatan/update/'.$data->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="mb-3">
        <label class="form-label pt-0" for="name">Nama Kecamatan</label>
        <input class="form-control" id="nama_kecamatan" name="nama_kecamatan" value="{{ $data->nama_kecamatan }}" type="text" />
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Ubah</button>
    </div>
</form> 