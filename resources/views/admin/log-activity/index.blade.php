@extends('layouts.admin.master')

@section('title', 'Log Activity')

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datatables.css')}}">
<style>
    .bookmark ul li:hover a {
        color: white;
    }

    .bookmark ul li a span {
        vertical-align: middle;
    }

    th, td {
        white-space: nowrap;
    }
</style>
@endpush

@section('content')
  @component('components.breadcrumb')
    @slot('breadcrumb_title')
      <h3>Log Activity</h3>
    @endslot
    <li class="breadcrumb-item">Log Activity</li>

    @slot('action')
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
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Subjek</th>
                                        <th>URL</th>
                                        <th>Method</th>
                                        <th>IP</th>
                                        <th>Aksi</th>
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
        var API_URL = "{{ url('/log/api') }}";

        $(document).ready(function() {
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
                    {data: 'user', name: 'user'},
                    {data: 'subject', name: 'subject'},
                    {data: 'url', name: 'url'},
                    {data: 'method', name: 'method'},
                    {data: 'ip', name: 'ip'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
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