@extends('admin.layouts.app')

@php
$page_title = (isset($modules['title'])) ? $modules['title'] : null;
$folder_path = (isset($modules['folder_path'])) ? $modules['folder_path'] : null;
$route = (isset($modules['route'])) ? $modules['route'] : null;
@endphp
@section('title', $page_title)

@section('pageStyleFiles')
{{-- <link href="{{ asset('public/assets/admin/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"> --}}
@endsection

@section('content')
<div class="d-flex pb-2">
    <h2 class="me-auto">{{ $page_title }}</h2>
    <a href="{{ route($route.'.index') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back </a>
</div>

@include('admin.partials.flash_messages')

<div class="card shadow">
    <div class="card-header d-none">
        <h2 class="mb-0">
            {{ $page_title }}
        </h2>
    </div>
    <div class="card-body">
        <form action="{{ (isset($edit) && $edit?->id) ? route($route.'.update', [$edit?->id]) : route($route.'.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @isset($edit)
            <input type="hidden" name="id" value="{{ $edit->id }}" />
			@method('PUT')
			@endisset
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label class="form-label"> Name <span class="text-danger">*</span> </label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ (isset($edit?->name)) ? $edit?->name : old('name') }}" autocomplete="name" autofocus placeholder="Enter name">
                        
                        @error('name')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-success mt-1 mb-1">
                        {{ (isset($edit)) ? 'Update' : 'Submit' }}
                    </button>
                    <a href="{{ route($route.'.index') }}" class="btn btn-danger mt-1 mb-1">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection