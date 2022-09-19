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
<h3>Berita</h3>
@endslot
<li class="breadcrumb-item">Berita</li>
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form id="berita-form" onsubmit="return false;">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="isi_berita" id="editor1" cols="10" rows="2" ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        @if(Auth::user()->level == 1)
                        <div class="form-group">
                            <div class="mb-3">
                                <label class="form-label pt-0">Status</label>
                                <select class="form-control" name="status">
                                    <option value="0">Menunggu Persetujuan</option>
                                    <option value="1">Publish</option>
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
            url: "{{ url('berita/store') }}",
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
                CKEDITOR.instances.editor1.setData( '', function() { this.updateElement(); } )
                $('#berita-form')[0].reset();
                return toastAlert("success", response.message);
            },
            error: function (reject) {
                $("[type='submit']").attr("disabled", false);
                $('#berita-form')[0].reset();
                CKEDITOR.instances.editor1.setData( '', function() { this.updateElement(); } )
                return toastAlert("error", "Terjadi kesalahan pada server");
            }
        })
    })

</script>
@endpush
@endsection
