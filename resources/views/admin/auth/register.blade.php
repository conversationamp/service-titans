<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Register - {{config('app.name')}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
       <!-- App favicon -->
       <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
       <!-- App css -->
       <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
       <link href="{{ asset('assets/css/jquery-ui.min.css') }}" rel="stylesheet">
       <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
       <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
       <style>
        .invalid-feedback{
            display:block;
        }
        </style>
    </head>
    <body class="account-body accountbg">
        <!-- Log In page -->
        <div class="container">
            <div class="row vh-100">
                <div class="col-12 align-self-center">
                    <div class="auth-page">
                        <div class="card auth-card shadow-lg">
                            <div class="card-body">
                                <div class="px-3">
                                    <div class="auth-logo-box mt-5">
                                        <a href="{{ route('dashboard') }}" class="logo logo-admin"><img src="{{ asset('assets/images/logo-sm.png') }}" height="55" alt="logo" class="auth-logo"></a>
                                    </div><!--end auth-logo-box-->
                                    <div class="text-center auth-logo-text pt-4">
                                        <h4 class="mt-0 mb-3 mt-5">{!!get_title('')!!}</h4>
                                    </div> <!--end auth-logo-text-->
                                    <form class="form-horizontal auth-form my-4" method="POST" action="{{route('register')}}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <div class="input-group mb-2">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-user"></i>
                                                </span>
                                                <input type="text" class="form-control" required name="name" value="{{old('name')}}" id="name" placeholder="Enter Name">
                                            </div>
                                            @error('name')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div><!--end form-group-->
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <div class="input-group mb-2">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-mail"></i>
                                                </span>
                                                <input type="email" class="form-control" required name="email" value="{{old('email')}}" id="email" placeholder="Enter Email">
                                            </div>
                                            @error('email')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <div class="input-group mb-2">
                                                <span class="auth-form-icon" style="cursor: pointer" onclick="togglePass()">
                                                    <i class="fa fa-eye text-blue"></i>
                                                </span>
                                                <input type="password" class="form-control" minlength="8" required  name="password" id="password" placeholder="Enter password">
                                            </div>
                                              @error('password')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div><!--end form-group-->
                                        <div class="form-group">
                                            <label for="location" class="location_id">Location ID</label>
                                            <div class="input-group mb-2">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-location"></i>
                                                </span>
                                                <input type="text" class="form-control" required name="location" value="{{old('location')}}" id="location" placeholder="Enter Location ID">
                                            </div>
                                            @error('location')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div><!--end form-group-->
                                       
                                        <div class="form-group ">
                                            <label for="location_api" class="api_key">Location API Key</label>
                                            <div class="input-group mb-2">
                                                
                                                <textarea type="text" class="form-control" name="location_api" id="location_api" required placeholder="Copy CRM API Key from location setting">{{old('location_api')}}</textarea>
                                            </div>
                                            @error('location_api')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div><!--end form-group-->
                                        <div class="form-group row mt-3" hidden>
                                            <div class="col-sm-12">
                                                <div class="custom-control custom-switch switch-success">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitchSuccess">
                                                    <label class="custom-control-label text-muted" for="customSwitchSuccess">By registering you agree to the Our <a href="#" class="text-primary">Terms of Use</a></label>
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end form-group-->
                                        <div class="form-group mb-0 row">
                                            <div class="col-12 mt-2">
                                                <button class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light" type="submit">Register <i class="fas fa-sign-in-alt ml-1"></i></button>
                                            </div><!--end col-->
                                        </div> <!--end form-group-->
                                    </form><!--end form-->
                                </div><!--end /div-->
                                <div class="m-3 text-center text-muted">
                                    <p class="">Already have an account ? <a href="{{route('login')}}" class="text-primary ml-2">Log in</a></p>
                                </div>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end auth-card-->
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
        <!-- End Log In page -->

        <!-- jQuery  -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/waves.js') }}"></script>
        <script src="{{ asset('assets/js/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
        <!-- App js -->
        
        <script>
            function togglePass() {
                    var x = document.getElementById("password");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }
                    }

                    function toggleCPass() {
                    var x = document.getElementById("confirm_password");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }
                    }
        </script>
           @include('layouts.usetiful')
    </body>
</html>
