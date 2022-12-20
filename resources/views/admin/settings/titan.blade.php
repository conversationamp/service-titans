@extends('layouts.app')
@section('title', 'Service Titans ')

@section('content')
    {{-- breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Service Titans Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">Service Titans Settings</h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <h4 class="p-3"> Service Titans Assentials </h4>
                <div class="card-body">
                    <form action="{{ route('setting.save') }}" method="POST" class="card-box"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name"> Tenant ID </label>
                            <input type="text" class="form-control" name="titan_tenant_id" id="titan_tenant_id"
                                value="{{ get_values_by_id('titan_tenant_id', login_id()) }}" placeholder="Enter Tenant Id">
                        </div>
                        <div class="form-group">
                            <label for="name"> App ID </label>
                            <input type="text" class="form-control" name="titan_app_id" id="titan_app_id"
                                value="{{ get_values_by_id('titan_app_id', login_id()) }}" placeholder="Enter App id">
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

        <div class="col-md-6">
            <div class="card">
                <h4 class="p-3"> Select Location </h4>
                <div class="card-body">
                    <form action="{{ route('setting.save') }}" method="POST" class="card-box"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name"> Select Location </label>
                            <input type="hidden" name="its_locations" value="1">
                            <select name="titan_selected_location[]" multiple="multiple" id="titan_selected_location"
                                class="form-control select2">

                                @foreach ($locations as $location)
                                    @php
                                        $val = [
                                            'name' => $location->name,
                                            'address' => $location->address,
                                        ];
                                        $val = json_encode($val);
                                        
                                        $selected = '';
                                        $loc = get_values_by_id('titan_selected_location', login_id());
                                        if ($loc) {
                                            $loc = json_decode($loc);
                                            foreach ($loc as $key => $value) {
                                                if ($value->name == $location->name) {
                                                    $selected = 'selected';
                                                }
                                            }
                                        }
                                    @endphp
                                    <option value="{{ $val }}" {{ $selected }}>
                                        {{ $location->name }}</option>
                                @endforeach
                            </select>

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

        <div class="col-md-6">
            <div class="card">
                <h4 class="p-3">Default Calendar for bookings</h4>
                <div class="card-body">
                    <form method="POST" action="{{ route('setting.save') }}">
                        @csrf
                        <label for="adjustment"> </label>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="calendar"> Select a default calendar for bookings </label>
                                <select name="titan_booking_calendar" id="titan_booking_calendar" class="form-control">
                                    <option value="">Select Calendar</option>
                                    @foreach ($calendars as $calendar)
                                        <option value="{{ $calendar->id }}"
                                            {{ get_values_by_id('titan_booking_calendar', login_id()) == $calendar->id ? 'selected' : '' }}>
                                            {{ $calendar->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right p-3">
                                <input type="submit" class="btn btn-info" value="Save Settings">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <h4 class="p-3">Default calendar for non job Appointments</h4>
                <div class="card-body">
                    <form method="POST" action="{{ route('setting.save') }}">
                        @csrf
                        <label for="adjustment"> </label>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="calendar"> Select a default calendar for bookings </label>
                                <select name="titan_nonjob_booking_calendar" id="titan_nonjob_booking_calendar"
                                    class="form-control">
                                    <option value="">Select Calendar</option>
                                    @foreach ($calendars as $calendar)
                                        <option value="{{ $calendar->id }}"
                                            {{ get_values_by_id('titan_nonjob_booking_calendar', login_id()) == $calendar->id ? 'selected' : '' }}>
                                            {{ $calendar->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right p-3">
                                <input type="submit" class="btn btn-info" value="Save Settings">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
