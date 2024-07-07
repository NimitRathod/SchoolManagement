@extends('admin.layouts.app')

@php
$page_title = (isset($modules['title'])) ? $modules['title'] : null;
$folder_path = (isset($modules['folder_path'])) ? $modules['folder_path'] : null;
$route = (isset($modules['route'])) ? $modules['route'] : null;
$permisstion_prefix = (isset($modules['permisstion_prefix'])) ? $modules['permisstion_prefix'] : null;
$i = 0;
@endphp
@section('title', $page_title)

@push('pageStyleFiles')
<link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="d-flex pb-2">
    <h2 class="me-auto">{{ $page_title }}</h2>
    @can($permisstion_prefix.'-create')
    <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add {{ $page_title }}</a>
    @endcan
</div>
@include('admin.partials.flash_messages')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <input type="search" class="form-control" name="search" placeholder="search...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="status">
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="role">
                            <option value="">Select role</option>
                            @foreach ($roles as $item)
                            <option value="{{ $item->id }}">{{ ucfirst($item->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="yajra-datatables" class="display table table-hover" >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th width="15%" class="no-sort text-center">Actions</th>
                                {{-- <th class="text-center wd-15p" >Status</th> --}}
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('pageScriptFiles')
<!-- Data tables -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
@endpush

@section('pageLeavelScript')
<script type="text/javascript">
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    var dtable = null;
    $(document).ready(function() {
        dtable = $('#yajra-datatables').DataTable({
            searching: false,
            processing: true,
            serverSide: true,
            order: [[1, 'desc']],
            ajax: {
                "url" : "{{ route($route.'.index') }}",
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
                },
                type : "GET",
                data : function(data){
                    data.search = $('input[type="search"]').val();
                    data.status = $('select[name="status"] option:selected').val();
                    data.role = $('select[name="role"] option:selected').val();
                },
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'role_name', name: 'role_name', orderable: false, searchable: false},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
            ],
            language: {
                searchPlaceholder: 'Search...',
            },
        });
    });
    $('input[name="search"]').keyup(function() {
        dtable.draw();
    });
    jQuery(document).on('change', 'select', function(event){
        event.preventDefault();
        dtable.draw();
    })
    $(document).on('click', '.deletebutton', function () {
        var uid = $(this).attr("data-id");
        var did = $(this).attr("data-did");
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            type: "warning",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            cancelButtonClass: "btn-success",
            showCancelButton: true,
            closeOnConfirm: false,
            closeOnCancel: false,
            reverseButtons: true
        }).then((isConfirm) => {
            var _token = '{{ csrf_token() }}';
            var _url = did;
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: _url,
                    data: {
                        _token: _token,
                        _method: 'DELETE',
                    },
                    success: function (data) {
                        swal("Deleted!", "Category has been deleted.", "success");
                        $("#yajra-datatables").DataTable().ajax.reload();
                    }, error: function () {
                        swal("Deleted!", "Something Went wrong deleted failed.", "error");
                    }
                });
            } else {
                swal("Cancelled", "Data is safe :)", "error");
            }
        });
    });
</script>
@endsection