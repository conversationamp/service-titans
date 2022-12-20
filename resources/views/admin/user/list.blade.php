@extends('layouts.app')

@section('title', $parent)

@section('content')
    <!-- Page-Title -->
    @include('admin.components.breadcrumb')

    <div class="row">
        <div class="col-md-12 text-right">
            <a href="{{ route($route . '.add') }}" class="btn btn-gradient-primary px-4 mt-0 mb-3"><i
                    class="mdi mdi-plus-circle-outline mr-2"></i>Add New</a>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="thead-light">
                                <tr>

                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    @if (auth()->user()->role == admin_role())
                                        <th>Location</th>
                    
                                        <th class="text-right">Action</th>
                                    @endif
                                </tr>
                                <!--end tr-->
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
                "url": "{{ route($route . '.list') }}",
            },
            columns: [{
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'email',
                    name: 'email'
                }, {
                    data: 'status',
                    name: 'status',
                    searchable: false
                }
                @if (auth()->user()->role == admin_role())
                    , {
                        data: 'location',
                        name: 'location'
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        class: 'text-right'
                    }
                @endif
            ]
        });
    </script>
@endsection
