@extends('layouts.app')

@section('title', $title)
@section('content')
    @php
        if (isset($id) && !is_null($id)) {
            $id = $id;
        } else {
            $id = null;
        }
    @endphp
    <!-- Page-Title -->
    @include('admin.components.breadcrumb')
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-md-12 mx-auto">
            <form action="{{ route($route . '.save') }}" method="POST" class="card-box" enctype="multipart/form-data"
                id="sync_setting_save_form">
                @csrf
                @include('admin.sync-settings.form')
            </form>

        </div>
    </div>
@endsection


@section('js')
    @include('admin.sync-settings.formscript')
@endsection
