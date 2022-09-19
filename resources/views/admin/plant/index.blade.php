@extends('layouts.admin.master')

@section('title', 'Data Petani')

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
<h3>Data Tanam Petani</h3>
@endslot
<li class="breadcrumb-item">Data Tanam Petani</li>

@slot('action')
<li><a href="#" data-refresh-btn><i data-feather="refresh-cw"></i><span class="me-3"> Refresh</span></a></li>
@endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div id="farmerGroup"></div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="display">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th>Nama Petani</th>
                                    <th>Nama Desa</th>
                                    <th>Status</th>
                                    <th width="10%">Aksi</th>
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
    var API_URL = "{{ url('/tanam/api') }}";

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
                    {data: 'nama_petani', name: 'nama_petani'},
                    {data: 'nama_desa', name: 'nama_desa'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
            });

            $("[data-refresh-btn]").click(function(e) {
                e.preventDefault();
                toastAlert("info", "Memperbarui data");
                dt.ajax.reload();
            })
    })
</script>
@endpush
@endsection