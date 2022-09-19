<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('lokasi-komoditas/update/'.$data->id) }}">
    {{ csrf_field() }}  
    {{ method_field('PUT') }}
    <div class="mb-3">
        <label class="form-label pt-0" for="long_komoditas">Longitude Komoditas</label>
        <input class="form-control" id="long_komoditas" name="long_komoditas" type="text" value="{{$data->long_komoditas}}" required />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="lat_komoditas">Latitude Komoditas</label>
        <input class="form-control" id="lat_komoditas" name="lat_komoditas" type="text" value="{{$data->lat_komoditas}}" required />
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Ubah</button>
    </div>
</form>