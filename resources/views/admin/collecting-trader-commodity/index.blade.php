@extends('layouts.admin.master')

@section('title', 'Komoditas Pengepul')

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
<h3>Data Komoditas Pengepul</h3>
@endslot
<li class="breadcrumb-item">Komoditas Pengepul</li>

@slot('action')
<li><a href="#" onclick="openForm('{{ url('/komoditas-pengepul/create') }}', 'create')"><i data-feather="plus"></i><span
            class="me-3"> Tambah</span></a></li>
<li><a href="#" data-refresh-btn><i data-feather="refresh-cw"></i><span class="me-3"> Refresh</span></a></li>
@endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="display">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th>Nama Pengepul</th>
                                    <th>Nama Penyuluh</th>
                                    <th>Nama Komoditas</th>
                                    <th>Harga</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script>
    var dt;
    var API_URL = "{{ url('/komoditas-pengepul/api') }}";

    $(document).ready(function () {
        dt = $("#datatable").DataTable({
            "language": {
                "url": "{{ asset('assets/json/datatable-id.json') }}"
            },
            ajax: {
                url: API_URL,
                type: "GET"
            },
            processing: true,
            serverSide: true,
            columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'nama_pengepul', name: 'nama_pengepul'},
                    {data: 'nama_penyuluh', name: 'nama_penyuluh'},
                    {data: 'nama_komoditas', name: 'nama_komoditas'},
                    {data: 'harga', name: 'harga'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            $("[data-refresh-btn]").click(function(e) {
                e.preventDefault();
                
                toastAlert("info", "Memperbarui data");
                dt.ajax.reload();
            })

        $(document).on("submit", "#create-form", function () {
            $.ajax({
                url: "{{ url('/komoditas-pengepul/store') }}",
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
                    $("#create-form").trigger("reset");
                    dt.ajax.reload();
                    formModal.hide();
                },
                error: function (reject) {
                    $("button").attr("disabled", false);
                    toastAlert("error", "Terjadi kesalahan pada server");
                    formModal.hide();
                }
            })
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
                    $("#create-form").trigger("reset");
                    dt.ajax.reload();
                    formModal.hide();
                },
                error: function (reject) {
                    $("button").attr("disabled", false);
                    toastAlert("error", "Terjadi kesalahan pada server");
                    formModal.hide();
                }
            })
        })
    })

</script>
@endpush
@endsection
