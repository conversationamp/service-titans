@extends('layouts.app')

@section('title', $title)

@section('content')
    <!-- Page-Title -->
  @include('admin.components.breadcrumb')
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route($route.'.save') }}" method="POST" class="card-box" enctype="multipart/form-data">
                        @include('admin.'.$route.'.form')
                        @include('admin.components.form.savebutton',['save'=>'Add New'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
