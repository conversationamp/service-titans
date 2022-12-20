@extends('layouts.app')
@section('title', 'Contacts logs')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item ">Dashboard</li>
                        <li class="breadcrumb-item active">Contacts Logs</li>
                    </ol>
                </div>
                <h4 class="page-title"> Contacts </h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address </th>
                                </tr>
                                <!--end tr-->
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                    @php $contact = json_decode($contact->go_response ?? '') @endphp

                                    <tr>
                                        <td>{{ $contact->firstName ?? '' }} {{ $contact->lastName ??'' }}</td>
                                        <td>{{ $contact->email??"" }}</td>
                                        <td>{{ $contact->phone??"" }}</td>
                                        <td>{{ $contact->address->street??"" }} {{ $contact->address->unit ??"" }}
                                            {{ $contact->address->city??"" }} {{ $contact->address->state??"" }}
                                            {{ $contact->address->zip??"" }} {{ $contact->address->country??"" }}</td>
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

@endsection
