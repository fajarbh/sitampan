@extends('layouts.admin.master')

@section('title', 'Berita')

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
<h3>Edit Berita</h3>
@endslot
<li class="breadcrumb-item">Berita</li>
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form id="berita-form" onsubmit="return false;" data-target="{{ url('berita/update/'.$data->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="judul" class="form-control" value="{{ $data->judul }}" required>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="isi_berita" value="{{ $data->isi_berita }}" id="editor1" cols="10" rows="2" >{{ $data->isi_berita }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        @if(Auth::user()->level == 1)
                        <div class="form-group">
                            <div class="mb-3">
                                <label class="form-label pt-0">Status</label>
                                <select class="form-control" name="status">
                                    <option value="0" {{ $data->is_verified == 0 ? "selected" : "" }} > Menunggu Persetujuan </option>
                                    <option value="1" {{ $data->is_verified == 1 ? "selected" : "" }} > Publish </option>
                                </select>
                            </div>
                        </div>
                        @else
                        <input type="hidden" name="status" value="0">
                        @endif
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script src="{{ asset('assets/utilities/ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('assets/utilities/ckeditor/adapters/jquery.js')}}"></script>
<script>
    $(document).ready(function(){
        CKEDITOR.replace('editor1', {
            removePlugins : 'resize',
            entities : false,
            toolbar: [{
                    name: 'basicstyles',
                    groups: ['basicstyles'],
                    items: [
                        'Format',
                        'Bold',
                        'Italic',
                        'Underline'
                    ]
                },
                {
                    name: 'paragraph',
                    groups: [
                        'list',
                        'indent',
                        'blocks',
                        'align',
                        'bidi'
                    ],
                    items: [
                        'NumberedList',
                        'BulletedList',
                        'JustifyLeft',
                        'JustifyCenter',
                        'JustifyRight',
                    ]
                },
                {
                    name: 'links',
                    items: [
                        'Link',
                        'Unlink'
                    ]
                },
            ],
        });
    });

    $("#berita-form").submit(function () {
        var data = new FormData($(this)[0]);
        data.append('isi_berita', CKEDITOR.instances.editor1.getData());
        $.ajax({
            url: $(this).data("target"),
            type: "POST",
            data: data,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("[type='submit']").attr("disabled", true);
            },
            success: function (response) {
                $("[type='submit']").attr("disabled", false);
                if (response.status_code == 500) 
                return toastAlert("error", response.message);
                if (response.status_code == 400) return populateErrorMessage(response
                    .errors);
                return toastAlert("success", response.message);
            },
            error: function (reject) {
                $("[type='submit']").attr("disabled", false);
                return toastAlert("error", "Terjadi kesalahan pada server");
            }
        })
    })

</script>
@endpush
@endsection
