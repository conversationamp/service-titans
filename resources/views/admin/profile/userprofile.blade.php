@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
                <h4 class="page-title">User Profile</h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>

    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0"> General Settings</h4>
                    <form action="{{ route('profile.save') }}" method="POST" id="general_profile"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="last_name"> Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" name="name" class="form-control" autocomplete="off"
                                            autofocus="autofocus" value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="text" name="email" class="form-control" autocomplete="off"
                                            autofocus="autofocus" value="{{ $user->email }}">
                                    </div>
                                </div>

                                @if (auth()->user()->role == company_role())
                                    <div class="form-group row">
                                        @include('admin.components.form.input', [
                                            'column' => '12',
                                            'title' => 'Location',
                                            'name' => 'location',
                                            'default' => $user->location ?? '',
                                            'type' => 'text',
                                            'label_class' => 'location_id',
                                        ])
                                    </div>
                                    {{-- <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="api_key" class="api_key">API Key *</label>
                                            <textarea placeholder="Api Key" class="form-control @error('api_key') is-invalid @enderror" name="api_key">{{ $user->ghl_api_key ?? '' }}</textarea>
                                            @error('api_key')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                @endif
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-gradient-warning px-4 mt-0 mb-0"> Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                {{-- user image --}}
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <div class="input-group">
                                        <input type="file" name="image" class="form-control dropify" autocomplete="off"
                                            autofocus="autofocus" data-default-file="{{ auth()->user()->image ??'' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0"> Security </h4>
                    <form action="{{ route('password.save') }}" method="POST" id="">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Current Password *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" name="current_password" class="form-control" autocomplete="off"
                                    autofocus="autofocus">
                            </div>
                            @error('current_password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control" autocomplete="off"
                                    autofocus="autofocus">
                            </div>
                            @error('password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password">Confirm Password *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="confirm_password" class="form-control" autocomplete="off"
                                    autofocus="autofocus">
                            </div>
                            @error('confirm_password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-gradient-warning px-4 mt-0 mb-0"> Change
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script></script>
@endsection
