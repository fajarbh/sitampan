@extends('layouts.admin.master')

@section('title', 'Tanam')

@push('css')
<link href="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js"></script>
@endpush

@section('content')
@component('components.breadcrumb')
@slot('breadcrumb_title')
<h3>Tanam</h3>
@endslot
<li class="breadcrumb-item">Tanam</li>
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div id='map' style='width: 100%; min-height: 300px;' class="mb-3"></div>
                    <form class="theme-form" id="create-form" onsubmit="return false;">
                        {{ csrf_field() }}
                        <input type="hidden" name="id_petani" value="{{ $data->id }}">
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
                            <label class="form-label pt-0" for="tanggal_tanam">Tanggal Tanam</label>
                            <input class="form-control" id="tanggal_tanam" name="tanggal_tanam" type="date" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label pt-0" for="jumlah_tanam">Jumlah Tanam (Ton)</label>
                            <input class="form-control numeric" id="jumlah_tanam" name="jumlah_tanam" type="text"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label pt-0" for="luas_tanam">Luas Tanam (Hektar)</label>
                            <input class="form-control numeric" id="luas_tanam" name="luas_tanam" type="text"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label pt-0" for="jenis_pupuk">Jenis Pupuk</label>
                            <input class="form-control" id="jenis_pupuk" name="jenis_pupuk" type="text"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label pt-0" for="biaya_produksi">Biaya Produksi</label>
                            <input class="form-control numeric comma" id="biaya_produksi" name="biaya_produksi" type="text"/>
                        </div>
                        <input type="hidden" id="lat" name="latitude">
                        <input type="hidden" id="lng" name="longitude">
                        <div class="d-flex flex-row-reverse">
                            <button class="btn btn-primary" id="save" type="submit" disabled>Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiYmVubm9hbGlmIiwiYSI6ImNrYnJyanZseDE4aW8ydWp6M3VvZHR6aXoifQ.IBqQxxGN8T-7SrY32AVoLQ';
    const map = new mapboxgl.Map({
    container: 'map', // container ID
    // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
    style: 'mapbox://styles/mapbox/light-v10', // style URL
    center: {!! $center !!},
    zoom: 12 // starting zoom
    });

    map.on('load', () => {
    map.resize();

    // Add a data source containing GeoJSON data.
    map.addSource('maine', {
        'type': 'geojson',
        'data': {
        'type': 'Feature',
        'geometry':{!! json_encode($geoJson) !!}
        }
    });

    // Add a new layer to visualize the polygon.
    map.addLayer({
        'id': 'maine',
        'type': 'fill',
        'source': 'maine', // reference the data source
        'layout': {},
        'paint': {
        'fill-color': '#47BC6E', // blue color fill
        'fill-opacity': 0.5
        }
    });

    // Add a outline around the polygon.
    map.addLayer({
        'id': 'outline',
        'type': 'line',
        'source': 'maine',
        'layout': {},
        'paint': {
        'line-color': '#47BC6E',
        'line-width': 1
        }
    });

    map.on('click', 'maine', function (e) {
        var coordinates = e.lngLat;
        var lat = $('#lat').val(coordinates['lat']);
        var lng = $('#lng').val(coordinates['lng']);
        var marker = new mapboxgl.Marker()
            .setLngLat(coordinates)
            .addTo(map);
        map.on('click', 'maine',function(e){
            marker.remove();
        })
        if(lat != null && lng != null){
            return $('#save').removeAttr('disabled');
        } 
    });

    $(document).on("submit", "#create-form", function () {
        $.ajax({
            url: "{{ url('/tanam/store') }}",
            type: "POST",
            data: new FormData(this),
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("button").attr("disabled", true);
            },
            success: function (response) {
                $("button").attr("disabled", false);
                if (response.status_code == 500) return toastAlert("error", response
                    .message);
                if (response.status_code == 400) return populateErrorMessage(response
                    .errors);
                $('.mapboxgl-marker').remove();
                toastAlert("success", response.message);
                $("#create-form").trigger("reset");
                $('#save').attr('disabled', true);
            },
            error: function (reject) {
                $("button").attr("disabled", false);
                toastAlert("error", "Terjadi kesalahan pada server");
            }
        })
    })
}); 
    $('#commodity_type').on('change', function () {
        var value = $(this).val(); 
        if (value) {
            $.ajax({
                url: '{{ url('/api/commodity/') }}' + '/' + value,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    var commodity = data.data
                    $('select[name="id_komoditas"]').empty();
                    $('select[name="id_komoditas"]').append('<option value="">Pilih Komoditas</option>');
                    $('#commodity').select2({
                        placeholder: 'Pilih Komoditas',
                        allowClear: true
                    });
                    $.each(commodity, function (i, item) {
                        $('select[name="id_komoditas"]').append('<option value="'+item.id+
                            '">' + item.nama_komoditas + '</option>');
                    });                          
                }
            });
        } else {
            $('select[name="id_komoditas"]').empty();
        }
    }); 
</script>
@endpush
@endsection