@extends('layouts.admin.master')

@section('title', 'Kelompok Tani')

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
<h3>Kelompok Tani</h3>
@endslot
<li class="breadcrumb-item">Kelompok Tani</li>

@slot('action')
<li><a href="#" onclick="openForm('{{ url('/kelompok-tani/create') }}', 'create')"><i data-feather="plus"></i><span
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
                                    <th>Nama Kelompok</th>
                                    <th>Nama Penyuluh</th>
                                    <th>Nama Desa</th>
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
    var API_URL = "{{ url('/kelompok-tani/api') }}";

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
                    {data: 'nama_kelompok', name: 'nama_kelompok'},
                    {data: 'nama_penyuluh', name: 'nama_penyuluh'},
                    {data: 'nama_desa', name: 'nama_desa'},
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
                url: "{{ url('/kelompok-tani/store') }}",
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
