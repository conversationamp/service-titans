@extends('layouts.app')
@section('title', 'Auth Settings')
<style>
    .cl-custom-check {
        display: none;
    }

    .cl-custom-check+.cl-custom-check-label {
        /* Unchecked style  */
        background-color: #ccc;
        color: #fff;
        padding: 5px 10px;
        font-family: sans-serif;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 4px;
        display: inline-block;
        margin: 0 10px 10px 0;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        transition: all 0.6s ease;
    }

    .cl-custom-check:checked+.cl-custom-check-label {
        /* Checked style  */
        background-color: #0a0;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        transform: rotateY(360deg);
        /* append custom text in text */
    }
</style>
@section('content')
    {{-- breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">CRM General Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">CRM General Settings</h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="p-3"> CRM Account Permissions </h4>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="py-2">Click to Grant/Deny the permissions</label>
                                    <div class="row">
                                        @foreach ($permissions as $key => $permission)
                                            <div class="col-md-3 form-group">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input cl-custom-check"
                                                        id="webhook-{{ $key }}" name="{{ $key }}"
                                                        value="{{ $permission }}">
                                                    <label class="form-check-label cl-custom-check-label"
                                                        for="webhook-{{ $key }}">{{ breakCamelCase($key) }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" id="save-permissions"
                                        value="Save Permissions">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="page-title p-3"> CRM Appointment Settings  </h4>
                <form action="{{ route('setting.save') }}" method="POST">
                    @csrf
                <div class="row p-3 ">
                    <div class="col-md-6">
                        <label for=""> Select Default Calendar </label>
                        <select name="go_calendar_id" id="go_calendar_id" class="form-control">
                            @foreach ($calendars as $key => $calendar)
                                <option value="{{ $calendar->id }}"
                                    {{ get_values_by_id('go_calendar_id', login_id()) == $calendar->id ? 'selected' : '' }}>
                                    {{ $calendar->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col-md-6">
                        <label for=""> Select Pipeline </label>
                        <select name="go_pipeline_id" id="go_pipeline_id" class="form-control">
                            @foreach ($pipelines as $key => $pipeline)
                                <option value="{{ $pipeline->id }}"
                                    {{ get_values_by_id('go_pipeline_id', login_id()) == $pipeline->id ? 'selected' : '' }}>
                                    {{ $pipeline->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 pipeline_stages">
                    </div>

                    <div class="col-md-12 text-right p-2 mt-3">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" id="save-permissions" value="Save Permissions">
                        </div>
                    </div>
                    
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function() {
            //if value is 1 then make background green
            $('.cl-custom-check').each(function() {
                if ($(this).val() == '1') {
                    console.log($(this).val());
                    $(this).closest('.form-check').find('.cl-custom-check-label').css('background-color',
                        '#0a0');
                }
            });
        })

        //if the value is 1 then 0 else 1
        $('.cl-custom-check').change(function() {
            if ($(this).val() == '1') {
                $(this).closest('.form-check').find('.cl-custom-check-label').css('background-color', '#ccc');
                $(this).val('0');
            } else {
                $(this).closest('.form-check').find('.cl-custom-check-label').css('background-color', '#0a0');
                $(this).val('1');
            }
        });

        //insert true for checked and false for unchecked and put them in object
        var permissions = {
            @foreach ($permissions as $key => $permission)
                '{{ $key }}': '{{ $permission }}',
            @endforeach
        };

        //send ajax request to save the permissions
        $('#save-permissions').on('click', function(e) {
            e.preventDefault();
            var formData = {};
            $('.cl-custom-check').each(function() {
                if ($(this).val() == '1') {
                    formData[$(this).attr('name')] = true;
                } else {
                    formData[$(this).attr('name')] = false;
                }
            });
            formData['permissions'] = JSON.stringify(formData);
            $.ajax({
                url: "{{ route('authorization.permission.save', $id) }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    permissions: formData
                },
                success: function(data) {
                    toastr.success(data)
                },

            });
        });

        $('body').on('change', '#go_pipeline_id', function() {
            var pipeline_id = $(this).val();
            console.log()
            var pipelines = @json($pipelines);
            //find pipeline stages where id is equal to pipeline id
            var pipeline_stages = pipelines.find(function(pipeline) {
                return pipeline.id == pipeline_id;
            });
            // console.log(pipeline_stages.stages);
            var html = '';
            html += '<label for=""> Select Stage </label>';
            html += '<select name="go_stage_id" id="go_stage_id" class="form-control">';
            $.each(pipeline_stages.stages, function(key, value) {
                html += '<option value="' + value.id + '">' + value.name + '</option>';
            });
            html += '</select>';
            $('.pipeline_stages').html(html);
        });
    </script>
@endsection
