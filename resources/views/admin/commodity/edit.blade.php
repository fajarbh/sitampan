<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('komoditas/update/'.$data->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="mb-3">
        <label class="form-label pt-0" for="name">Nama Komoditas</label>
        <input class="form-control" id="nama_komoditas" name="nama_komoditas" type="text" value="{{$data->nama_komoditas}}" />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="jenis_komoditas">Jenis Komoditas</label>
        <select class="uiselect" name="id_jenis">
            @foreach($jenisKomoditas as $jk)
            <option {{$data->id_jenis == $jk->id ? "selected" : "" }} value="{{ $jk->id }}">
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
        <button class="btn btn-primary" type="submit">Ubah</button>
    </div>
</form> 