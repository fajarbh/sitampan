<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('jenis-komoditas/update/'.$data->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="mb-3">
        <label class="form-label pt-0" for="name">Nama</label>
        <input class="form-control" id="nama_jenis" name="nama_jenis" type="text" value="{{ $data->nama_jenis }}" />
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Ubah</button>
    </div>
</form>