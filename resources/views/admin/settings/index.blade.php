@extends('layouts.app')
@section('title', 'Auth Settings')
@section('content')
    {{-- breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Auth Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">Auth Settings</h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    <!-- end page title end breadcrumb -->

    <div class="row">
        <div class="col-md-6">
            @if (auth()->user()->role == 0)
                <div class="card">
                    <h4 class="p-3"> CRM Settings </h4>
                    <div class="card-body">
                        <form action="{{ route('setting.save') }}" method="POST" class="card-box"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name"> Client ID </label>
                                <input type="text" class="form-control" name="go_client_id" id="go_client_id"
                                    value="{{ get_values_by_id('go_client_id', login_id()) }}"
                                    placeholder="Enter client id">
                            </div>
                            <div class="form-group">
                                <label for="name"> Client Secret </label>
                                <input type="text" class="form-control" name="go_client_secret" id="go_client_secret"
                                    value="{{ get_values_by_id('go_client_secret', login_id()) }}"
                                    placeholder="Enter client secret">
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <input type="submit" class="btn btn-info" value="Save Settings">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <img src="{{ asset('assets/images/gohighlevel.jpeg') }}" class="form-control"
                    style="height: 94%; padding:0px; background:transparent">
            @endif
        </div>
        @if (auth()->user()->role == 1)
            <div class="col-md-6">
                <div class="card">
                    <h4 class="p-3"> Service Titans </h4>
                    <div class="card-body">
                        <form action="{{ route('setting.save') }}" method="POST" class="card-box"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Client ID</label>
                                <input type="text" class="form-control" name="titan_client_id" id="titan_client_id"
                                    value="{{ get_values_by_id('titan_client_id', login_id()) }}"
                                    placeholder="Enter client id">
                            </div>
                            <div class="form-group">
                                <label for="name">Client Secret</label>
                                <input type="text" class="form-control" name="titan_client_secret"
                                    id="titan_client_secret"
                                    value="{{ get_values_by_id('titan_client_secret', login_id()) }}"
                                    placeholder="Enter client secret">
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <input type="submit" class="btn btn-info" value="Save Settings">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>


    <div class="row">
        <div class="col-md-6">
            <a href="https://marketplace.gohighlevel.com/oauth/chooselocation?response_type=code&redirect_uri={{ route('authorization.gohighlevel.callback') }}&client_id={{ get_values_by_id('go_client_id', 1) }}&scope=calendars.readonly campaigns.readonly contacts.write contacts.readonly locations.readonly calendars/events.readonly locations/customFields.readonly locations/customValues.write opportunities.readonly calendars/events.write opportunities.write users.readonly users.write locations/customFields.write"
                class="form-control btn btn-gradient-primary"> Connect To CRM </a>
        </div>
        @if (auth()->user()->role == 1)
        <div class="col-md-6">
            <a href="{{ route('authorization.servicetitan') }}" class="form-control btn btn-gradient-primary">Connect To
                Service Titans</a>
        </div>
        @endif
    </div>
@endsection

@section('js')
    <script></script>
@endsection
