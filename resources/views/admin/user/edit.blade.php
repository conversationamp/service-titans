@extends('layouts.app')

@section('title', $parent)

@section('content')
<!-- Page-Title -->
@include('admin.components.breadcrumb')

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route($route.'.save', $data->id) }}" method="POST" class="card-box">
                        @include(admin_prefix().$route.'.form')
                        @include(admin_prefix().'components.form.savebutton')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
