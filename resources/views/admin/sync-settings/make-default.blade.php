@extends('layouts.app')

@section('title', $parent)

@section('content')
    <!-- Page-Title -->
    @include('admin.components.breadcrumb')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="p-4 text-info">Default value that will be use for CRM to Service Titan </h4>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Pipeline Name</th>
                                    <th>Pipeline Stage</th>
                                    <th>Calendar Id</th>
                                    <th>Opportunity Status</th>
                                    <th>Position</th>
                                    <th>Default</th>
                                    <th> Titan Location </th>
                                    <th>Business Unit </th>
                                    <th>Compaign </th>
                                    <th>Priority</th>
                                    <th>Job Type</th>
                                    <th>Slot</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- updated icon  --}}
        <style>
            .ico-div-top {
                display: flex;
                /* align-content: stretch; */
                justify-content: center;
                align-items: center;
            }
        </style>
        <div class="col-md-12 text-center text-white font-weight-bold pb-4">
            <div class="ico-div ">
                <i data-feather="arrow-up" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                <i data-feather="arrow-down" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
            </div>
        </div>


        <div class="col-md-12">
            <div class="card">
                <h4 class="p-4 text-info">Default value that will be use for Service Titan to CRM </h4>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable1" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th> Titan Location </th>
                                    <th>Business Unit </th>
                                    <th>Compaign </th>
                                    <th>Priority</th>
                                    <th>Job Type</th>
                                    <th>Slot</th>
                                    <th>Position</th>
                                    <th>Default</th>
                                    {{-- go high level --}}
                                    <th>Pipeline</th>
                                    <th>Pipeline Stage</th>
                                    <th>Calendar</th>
                                    <th>Calendar</th>
                                    <th>Oppurtunity Status</th>
                                    <th>Appointment Status</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
@section('js')
    <script>
        // Datatable
        let table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route($route . '.get-default', 0) }}",
            },
            columns: [{
                    data: 'pipeline_name',
                    name: 'pipeline_name'
                },
                {
                    data: 'pipeline_stage_name',
                    name: 'pipeline_stage_name'
                },
                {
                    data: 'calendar_name',
                    name: 'calendar_name'
                },
                {
                    data: 'oppurtunity_status',
                    name: 'oppurtunity_status'
                },
                {
                    data: 'position',
                    name: 'position'
                },
                {
                    data: 'is_default',
                    name: 'is_default'
                },
                {
                    data: 'titan_location_name',
                    name: 'titan_location_name'
                },
                {
                    data: 'business_unit_name',
                    name: 'business_unit_name'
                },
                {
                    data: 'campaign_name',
                    name: 'campaign_name'
                },
                {
                    data: 'priority',
                    name: 'priority'
                },
                {
                    data: 'job_type_name',
                    name: 'job_type_name'
                },
                {
                    data: 'slot',
                    name: 'slot'
                },
            ],


            order: [
                [5, 'asc']
            ],
            rowGroup: {
                startRender: function(rows, group) {
                    return group + ' Please select default from below rows';
                },
                dataSrc: ['position']
            },
        });

        let table1 = $('#datatable1').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route($route . '.get-default', 1) }}",
            },
            columns: [{
                    data: 'titan_location_name',
                    name: 'titan_location_name'
                },
                {
                    data: 'business_unit_name',
                    name: 'business_unit_name'
                },
                {
                    data: 'campaign_name',
                    name: 'campaign_name'
                },
                {
                    data: 'priority',
                    name: 'priority'
                },
                {
                    data: 'job_type_name',
                    name: 'job_type_name'
                },
                {
                    data: 'slot',
                    name: 'slot'
                },
                {
                    data: 'position',
                    name: 'position'
                },
                {
                    data: 'is_default',
                    name: 'is_default'
                },
                {
                    data: 'pipeline_name',
                    name: 'pipeline_name'
                },
                {
                    data: 'pipeline_stage_name',
                    name: 'pipeline_stage_name'
                },
                {
                    data: 'calendar_name',
                    name: 'calendar_name'
                },
                {
                    data: 'calendar_id',
                    name: 'calendar_id'
                },
                {
                    data: 'oppurtunity_status',
                    name: 'oppurtunity_status'
                },
                {
                    data: 'appointment_status',
                    name: 'appointment_status'
                },
            ],


            order: [
                [5, 'asc']
            ],
            rowGroup: {
                startRender: function(rows, group) {
                    return group + ' Please select default from below rows';
                },
                dataSrc: ['position']
            },
        });
    </script>
@endsection
