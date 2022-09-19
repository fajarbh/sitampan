@extends('layouts.admin.master')

@section('title', 'Ubah Data Petani')

@push('css')
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
<h3>Ubah Data Petani</h3>
@endslot
<li class="breadcrumb-item">Ubah Data Petani</li>
@endcomponent
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form class="theme-form" id="edit-form" onsubmit="return false;"
                        data-target="{{ url('pendaftaran-petani/update/'.$data->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id_user" value="{{ $data->user->id  }}">
                                <div class="mb-3">
                                    <label class="form-label pt-0" for="nik">NIK</label>
                                    <input class="form-control" value="{{ $data->user->nik }}" maxlength="16" id="nik"
                                        name="nik" type="text" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label pt-0" for="nama_petani">Nama Petani</label>
                                    <input class="form-control" id="nama_petani" name="nama_petani" type="text"
                                        value="{{ $data->nama_petani }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label pt-0" for="password">Password</label>
                                    <input class="form-control" id="password" name="password" type="password" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label pt-0" for="no_hp">No HP</label>
                                    <input class="form-control" value="{{ $data->user->no_hp }}" id="no_hp" name="no_hp" type="text" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label pt-0" for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" type="text" value="{{ $data->alamat }}">{{ $data->alamat }}
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                            @if(Auth::user()->level == 1)
                                <div class="mb-3">
                                    <label class="form-label pt-0">Nama Kecamatan</label>
                                    <select class="uiselect" id="kecamatan" name="id_kecamatan">
                                        @foreach($district as $k)
                                        <option value="{{ $k->id }}" {{ $k->id == $farmerDistrict->id ? "selected" : "" }}>
                                            {{ $k->nama_kecamatan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label pt-0">Nama Desa</label>
                                    <select class="uiselect" id="desa" name="id_desa">
                                        @foreach($village as $row)
                                        <option  value="{{ $row->id }}" {{$farmerVillage->id == $row->id ? "selected" : "" }}>
                                            {{ $row->nama_desa }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label pt-0">Nama Kelompok</label>
                                    <select class="uiselect" id="kelompok" name="id_kelompok">
                                        @foreach($farmerGroup as $row)
                                        <option {{$data->id_kelompok == $row->id ? "selected" : "" }}
                                            value="{{ $row->id }}">
                                            {{ $row->nama_kelompok }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label class="form-label pt-0">Nama Desa</label>
                                    <input class="form-control" name="id_desa" type="text" value="{{ $data->village->nama_desa }}" readonly/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label pt-0">Nama Kelompok</label>
                                    <select class="form-control" name="id_kelompok">
                                        <option value="{{ $data->farmer_group->nama_kelompok }}">{{ $data->farmer_group->nama_kelompok }}</option>
                                    </select>
                                </div>
                            @endif
                                <div class="mb-3">
                                    <label class="form-label pt-0">Status</label>
                                    <select class="uiselect" id="status" name="status">
                                    @if(Auth::user()->level == 1)
                                        <option {{ $data->status == 1 ? "selected" : "" }} value="1">Ketua Kelompok Tani
                                        </option>
                                    @else
                                        <option {{ $data->status == 2 ? "selected" : "" }} value="2">Petani</option>
                                        <option {{ $data->status == 3 ? "selected" : "" }} value="3">Petani Tidak Aktif
                                        </option>
                                    @endif   
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-row-reverse">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>

    $('#kecamatan').on('change', function () {
        var value = $(this).val();
        if (value) {
            $.ajax({
                url: '{{ url('/api/village-geo/') }}'+'/'+value,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    var village = data.data
                    $('select[name="id_desa"]').empty();
                    $('select[name="id_desa"]').append('<option value="">Pilih Desa</option>');
                    $('#desa').select2({
                        placeholder: 'Pilih Desa',
                        allowClear: true
                    });
                    $.each(village, function (i, item) {
                        $('select[name="id_desa"]').append('<option value="' + item.id +
                            '">' + item.nama_desa + '</option>');
                    });
                    $('select[name="id_kelompok"]').empty();
                }
            });
        } else {
            $('select[name="id_desa"]').empty();
            $('select[name="id_kelompok"]').empty();
        }
    });

    $('#desa').on('change', function(){
        var value = $(this).val()
        if (value){
            $.ajax({
                url: '{{ url('/api/farmer-group/') }}' + '/' + value,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    var farmerGroup = data.data
                    $('select[name="id_kelompok"]').empty();
                    $('select[name="id_kelompok"]').append('<option value="">Pilih Kelompok</option>');
                    $('#kelompok').select2({
                        placeholder: 'Pilih Kelompok',
                        allowClear: true
                    });
                    $.each(farmerGroup, function (i, item) {
                        $('select[name="id_kelompok"]').append('<option value="'+item.id+
                            '">' + item.nama_kelompok + '</option>');
                    });                          
                }
            });
        }else{
            $('select[name="id_kelompok"]').empty();
        }
    })

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
