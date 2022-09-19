@extends('layouts.admin.master')

@section('title', 'Tanam')

@push('css')
<link href="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js"></script>
<style>
#map {
  /* grid-column: 1/-1;
  height: 100%;
  position: relative;
  canvas, .mapboxgl-canvas {
    height: 100%;
  } */
}
</style>
@endpush

@section('content')
@component('components.breadcrumb')
@slot('breadcrumb_title')
<h3>Data Tanam {{ $data->nama_petani }}</h3>
@endslot

@slot('action')
<li>
  <a href="{{ url('/tanam/create/'.$data->id) }}">
    <i data-feather="plus"></i>
    <span class="me-3">Tambah Tanam</span>
  </a>
</li>
@endslot

<li class="breadcrumb-item">Tanam</li>
@endcomponent
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
          <form method="get">
            <div class="form-group">
              <label for="">Pilih Bulan - Tahun</label>
              <input type="month" class="form-control" name="tanggal_tanam"> 
            </div>
            <div class="form-group d-flex flex-row-reverse">
              <button class="btn btn-primary">Cari</button>
            </div>
          </form>
          <div id='map' style='width: 100%; min-height: 400px;'></div>
        </div>
    </div>
</div>
@push('scripts')
<script>
let plant = {!! json_encode($getPlant) !!}
mapboxgl.accessToken =  'pk.eyJ1IjoiYmVubm9hbGlmIiwiYSI6ImNrYnJyanZseDE4aW8ydWp6M3VvZHR6aXoifQ.IBqQxxGN8T-7SrY32AVoLQ';
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
}); 

  for(const element of plant) {
    var el = document.createElement('div');
    el.className = 'marker';
    el.style.backgroundImage = `url('{{ asset('uploads/${element.commodity.icon}') }}')`;
    el.style.width = '50px';
    el.style.height = '45px';
    el.style.backgroundRepeat = 'no-repeat';
    new mapboxgl.Marker(el)
      .setLngLat([element.longitude, element.latitude])
      .setPopup(
        new mapboxgl.Popup({
          offset: 25,
        })
        .setHTML(`
          <table>
            <thead>
              <tr>
                <th>Nama Komoditas</th> 
                <th>:</th>
                <th>${element.commodity.nama_komoditas}</th>
              </tr>
              <tr>
                <th>Tanggal Tanam</th> 
                <th>:</th>
                <th>${element.tanggal_tanam}</th>
              </tr>
              <tr>
                <th>Jumlah Tanam</th> 
                <th>:</th>
                <th>${element.jumlah_tanam} Ton</th>
              </tr>
              <tr>
                <th>Luas Tanam</th> 
                <th>:</th>
                <th>${element.luas_tanam} ha</th>
              </tr>
              <tr>
                <th>Biaya Produksi</th> 
                <th>:</th>
                <th>Rp `+addCommas((element.biaya_produksi))+`</th>
              </tr>
              <tr>
                <th>Jenis Pupuk</th> 
                <th>:</th>
                <th>${element.jenis_pupuk}</th>
              </tr>
              <tr>
                <th></th>
                <th></th>
                <th><a class="btn btn-sm btn-primary"
                  onclick="openForm('{{ url('/tanam/edit/${element.id}') }}', 'edit')">Ubah</a>
                </th>
              </tr>
            </thead>
          </table>
        `)
      )
      .addTo(map);
  }

  $(document).on("submit", "#edit-form", function () {
        $.ajax({
            url: $(this).data("target"),
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
                toastAlert("success", response.message);
                formModal.hide();
                setTimeout(() => {
                    location.reload();
                }, 1000);
            },
            error: function (reject) {
                $("button").attr("disabled", false);
                toastAlert("error", "Terjadi kesalahan pada server");
                formModal.hide();
            }
        })
    })

</script>
@endpush
@endsection
