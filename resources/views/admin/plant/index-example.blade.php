@extends('layouts.admin.master')

@section('title', 'Data Tanam')

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datatables.css')}}">
<style>
    .bookmark ul li:hover a {
        color: white;
    }

    .bookmark ul li a span {
        vertical-align: middle;
    }

    th,
    td {
        white-space: nowrap;
    }

</style>
@endpush

@section('content')
@component('components.breadcrumb')
@slot('breadcrumb_title')
<h3>Data Tanam</h3>
@endslot
<li class="breadcrumb-item">Data Tanam</li>

@slot('action')
<li><a href="#" data-refresh-btn><i data-feather="refresh-cw"></i><span class="me-3"> Refresh</span></a></li>
@endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <form id="search">
        <div class="form-group">
            <label class="form-label pt-0">Nama Kecamatan</label>
            <select class="uiselect" id="kecamatan" name="id_kecamatan">
                @foreach($district as $k)
                <option value="{{ $k->id }}">
                    {{ $k->nama_kecamatan }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
        <label class="form-label pt-0">Nama Desa</label>
            <select name="id_desa" class="uiselect">
                <option></option>
            </select>
        </div>
        <div class="form-group d-flex flex-row-reverse">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
        </form>
        <div id="farmerGroup" class="row"></div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script>
$('#kecamatan').on('change', function () {
    var value = $(this).val();
    if (value) {
        $.ajax({
            url: '{{ url('/api/village-geo/') }}' + '/' + value,
            type: "GET",
            dataType: "json",
            success: function (data) {
                var village = data.data
                $('select[name="id_desa"]').empty();
                $.each(village, function (i, item) {
                    $('select[name="id_desa"]').append('<option value="'+item.id+
                        '">' + item.nama_desa + '</option>');
                });                          
            }
        });
    } else {
        $('select[name="id_desa"]').empty();
    }
}); 

$(document).on('submit','#search',function(e){
    e.preventDefault();
    var desa  = $("[name='id_desa']").val();
    if(desa == '') return toastAlert("warning", "Pilih desa terlebih dahulu");
    var data = { id_desa: desa }
    initFarmerGroup(data)
 });

function initFarmerGroup(data){
    $.ajax({
        url: "{{ url('/tanam/kelompok-tani') }}",
        type: "GET",
        data: data,
        success: function (response) {
            if(response.status_code == 200){
                toastAlert("success", response.message);
                var farmerGroup = response.data
                let html = '';
                farmerGroup.forEach(items => $('#farmerGroup').html(html += `
                <div class="col-md-4">
                    <a href="{{url('/tanam/petani/${items.id}')}}">
                        <div class="bg-success p-3">
                            ${items.nama_kelompok}
                            <div class="mt-3" style="font-size: 12px;">
                                ${items.village.nama_desa}
                            </div>
                        </div>
                    </a>
                </div>
                `
                ));
            }else{
                toastAlert("warning", response.message);
            }
        },
        error: function (error) {
            toastAlert("warning", "Terjadi kesalahan");
        }
    })
}

</script>
@endpush
@endsection
