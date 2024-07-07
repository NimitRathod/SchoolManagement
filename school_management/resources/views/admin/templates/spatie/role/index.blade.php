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
            <div class="card-body">
                <div class="table-responsive">
                    <table id="yajra-datatables" class="display table table-hover" >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>User</th>
                                <th width="15%" class="no-sort text-center">Actions</th>
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
			searching: true,
			processing: true,
			serverSide: true,
			order: [[0, 'ASC']],
			ajax: {
				"url": "{{ route($route.'.index') }}",
				'beforeSend': function(request) {
					request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
				},
				type: "GET",
				data: function(data) {
					data.search = $('input[type="search"]').val();
					// data.search_by_number = $('input[name="search_by_number"]').val();
					// data.search_by_opportunity_type = $(".search_by_opportunity_type option:selected").val();
					// data.search_by_industry = $(".search_by_industry option:selected").val();
					// data.search =  $(".filter_by_product_name").val();
				},
			},
			columns: [
                {data: 'name', name: 'name'},
                {data: 'users_count', name: 'users_count', orderable: false, searchable: false, className: 'text-center'},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
			],
			language: {
				searchPlaceholder: 'Search...',
			}
		});
    });

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