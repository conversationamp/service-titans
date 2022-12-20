@extends('layouts.app')
@section('title', 'Opportunity logs')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item ">Dashboard</li>
                        <li class="breadcrumb-item active">Opportunity Logs</li>
                    </ol>
                </div>
                <h4 class="page-title"> Opportunity </h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>

    {{-- {"location_id":"NP4dT88lEnnjb3WVmyAQ","job_id":null,"contact_id":"5coDAF79upEU3Bk8D4Um","monetary_value":10,"name":"test opportunity by ahmad","pipeline_id":"5j9L62X6TviAlmW7QWuw","pipeline_stage_id":"f352101a-1a8b-4a05-9f98-0d1f4cf2b5ba","oppurtunity_status":"open","oppurtunity_id":"ObM4pDNkqdFv38J1IyxC"} --}}

    {{-- <th>Location</th>
    <th>Job</th>
    <th>Contact</th>
    <th>Monetary Value</th>
    <th>Name</th>
    <th>Pipeline</th>
    <th>Pipeline Stage</th>
    <th>Oppurtunity Status</th>
    <th>Oppurtunity Id</th>
     --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Contact Name</th>
                                    <th> Opportunity Name </th>
                                    <th> Opportunity status </th>
                                    <th> Monetary Value </th>
                                </tr>
                                <!--end tr-->
                            </thead>
                            <tbody>
                                {{-- getContactName --}}
                                @foreach ($opportunities as $opportunity)
                                    @php
                                        $opportunity = json_decode($opportunity->go_response ?? '');
                                    @endphp

                                    <tr>
                                        {{-- $opportunity->contact_id  --}}
                                        <td>{{ getContactName($opportunity->contact_id) }}</td>
                                        <td>{{ $opportunity->name }}</td>
                                        <td>{{ $opportunity->oppurtunity_status }}</td>
                                        <td>{{ $opportunity->monetary_value }}</td>
                                    </tr>
                                @endforeach
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
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>
@endsection
