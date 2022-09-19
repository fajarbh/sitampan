@extends('layouts.admin.master')

@section('title', 'Panen')

@push('css')
@endpush

@section('content')
@component('components.breadcrumb')
@slot('breadcrumb_title')
<h3>Panen</h3>
@endslot
<li class="breadcrumb-item">Panen</li>
@endcomponent

<div class="container-fluid">
    <div class="row">
        <form id="search">
            <input type="hidden" value="{{ $data->id }}" name="id_petani">
            <div class="form-group">
                <label for="">Pilih Komoditas (Bulan - Tahun) </label>
                <input type="month" class="form-control" name="tanggal_tanam"> 
            </div>
            <div class="form-group d-flex flex-row-reverse">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form class="theme-form" id="create-form" onsubmit="return false;">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="">Pilih Komoditas Tanam</label>
                            <select name="id_tanam" id="tanam" class="uiselect"></select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label pt-0" for="tanggal_panen">Tanggal Panen</label>
                            <input class="form-control" id="tanggal_panen" name="tanggal_panen" type="date" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label pt-0" for="jumlah_panen">Jumlah Panen (Ton)</label>
                            <input class="form-control numeric" id="jumlah_panen" name="jumlah_panen" type="text" />
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    
    $(document).ready(function(){
        $('.card').hide();
    })

    $(document).on('submit','#search',function(e){
        e.preventDefault();
        var tanggal_tanam  = $("[name='tanggal_tanam']").val();
        var id_petani      = $("[name='id_petani']").val();
        if(tanggal_tanam == '') return toastAlert("warning", "Pilih Tanggal terlebih dahulu");
        var data = { tanggal_tanam: tanggal_tanam, id_petani: id_petani };  
        initPlant(data)
    });

    function initPlant(data){
        $.ajax({
            url: "{{ url('/panen/komoditas') }}",
            type: "GET",
            data: data,
            success: function (response) {
                if(response.status_code == 200){
                    toastAlert("success", response.message);
                    var plant = response.data;
                    $('select[name="id_tanam"]').empty();
                    $('.card').show();
                    $.each(plant, function (i, item) {
                        $('select[name="id_tanam"]').append('<option value="'+item.id+
                            '">' + item.commodity.nama_komoditas + '</option>');
                    });                          
                }else{
                    $('.card').hide();
                    toastAlert("warning", response.message);
                    $('select[name="id_tanam"]').empty();
                }
            },
            error: function (error) {
                toastAlert("warning", "Terjadi kesalahan");
            }
        })
    }
    

    $(document).on("submit", "#create-form", function () {
        $.ajax({
            url: "{{ url('/panen/store') }}",
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

</script>
@endpush
@endsection