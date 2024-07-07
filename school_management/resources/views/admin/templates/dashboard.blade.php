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
<h2>Dashboard</h2>
@endsection


@push('pageScriptFiles')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
@endpush