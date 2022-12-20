@php
    $oppurtunity_status = [
        'open' => 'Open',
        'won' => 'Won',
        'lost' => 'Lost',
        'abondoned' => 'Abondoned',
    ];
    
    $appointment_status = [
        'confirmed' => 'Confirmed',
        'new' => 'New',
        'showed' => 'Showed',
        'noshow' => 'No Show',
        'booked' => 'Booked',
        'cancelled' => 'Cancelled',
    ];
    
    $priorities = [
        'high' => 'High',
        'normal' => 'Normal',
        'low' => 'Low',
        'urgent' => 'Urgent',
    ];
    /*
            
        
            Appointment Status Titan : Scheduled , Dispatched , Working , Hold , Done , Canceled
        
            
            */
@endphp

<div class="col-md-4">
    <div class="form-group">
        <label for="calendars_data"> Select Calendar </label>
        <select name="calendar_id[]" id="calendar_id" data-selected="{{ check_field($data, 'calendar_id') }}"
            class="auto-select form-control">
            <option value="">Select Calendar</option>
            @foreach ($calendars as $key => $calendar)
                <option value="{{ $calendar->id }}">{{ $calendar->name }} </option>
            @endforeach
        </select>
        <input type="hidden" name="calendar_name[]" id="calendar_name" value="" />
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Pipeline </label>
        <select name="pipeline_id[]" data-selected="{{ check_field($data, 'pipeline_id') }}" id="pipeline_id"
            class="auto-select form-control">
            <option value=""> Please Select Pipeline </option>
            @foreach ($pipelines as $key => $pipeline)
                <option value="{{ $pipeline->id }}"> {{ $pipeline->name }}</option>
            @endforeach
        </select>
        <input type="hidden" name="pipeline_name[]" id="pipeline_name" value="" />
    </div>
</div>

<div class="col-md-4">
    <div class="form-group ">
        <div class="pipeline_stages">

        </div>
        <input type="hidden" name="pipeline_stage_name[]" id="pipeline_stage_name" value="" />
    </div>

</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Opportunity Status </label>
        <select name="oppurtunity_status[]" id="oppurtunity_status"
            data-selected="{{ check_field($data, 'oppurtunity_status') }}" class="form-control auto-select">
            @foreach ($oppurtunity_status as $key => $status)
                <option value="{{ $key }}"> {{ $status }}</option>
            @endforeach
        </select>
        <input type="hidden" name="oppurtunity_status_name[]" id="oppurtunity_status_name" value="" />
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Appointment Status </label>

        <select name="appointment_status[]" id="appointment_status"
            data-selected="{{ check_field($data, 'appointment_status') }}" class="auto-select form-control">
            <option value=""> Please Select Appointment Status </option>
            @foreach ($appointment_status as $key => $status)
                <option value="{{ $key }}"> {{ $status }}</option>
            @endforeach
        </select>
        <input type="hidden" name="appointment_status_name[]" value="">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Location </label>
        <select name="location[]" id="location" data-selected="{{ check_field($data, 'titan_location_id') }}"
            class="auto-select form-control">
            <option value=""> Please Select Location </option>
            @foreach ($locations as $key => $location)
                <option value="{{ $location->id }}"> {{ $location->name }}</option>
            @endforeach
        </select>

        <input type="hidden" name="location_name[]" value="">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Business Unit </label>
        <select name="business_unit[]" id="business_unit" data-selected="{{ check_field($data, 'business_unit') }}"
            class="auto-select form-control">
            <option value="">Pleass select Business Unit</option>
            @foreach ($business_units as $key => $business_unit)
                <option value="{{ $business_unit->id }}"> {{ $business_unit->officialName }}</option>
            @endforeach
        </select>

        <input type="hidden" name="business_unit_name[]" value="">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Campaign </label>
        <select name="campaign[]" id="campaign" data-selected="{{ check_field($data, 'campaign') }}"
            class="auto-select form-control">
            <option value=""> Please Select Campaign </option>
            @foreach ($compaigns as $key => $campaign)
                <option value="{{ $campaign->id }}"> {{ $campaign->name }}</option>
            @endforeach
        </select>

        <input type="hidden" name="campaign_name[]" value="">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Priority </label>
        <select name="priority[]" id="priority" data-selected="{{ check_field($data, 'priority') }}"
            class="auto-select form-control">
            <option value=""> Please Select Priority </option>
            @foreach ($priorities as $key => $priority)
                <option value="{{ $key }}"> {{ $priority }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Job Type </label>
        <select name="job_type[]" id="job_type" data-selected="{{ check_field($data, 'job_type') }}"
            class="auto-select form-control">
            <option value=""> Please Select Job Type </option>
            @foreach ($job_types as $key => $job_type)
                <option value="{{ $job_type->id }}"> {{ $job_type->name }}</option>
            @endforeach
        </select>
        <input type="hidden" name="job_type_name[]" class="ht" value="">
    </div>
</div>

{{-- new invoice Id --}}

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Invoice </label>
        <select name="invoice_id[]" id="invoice_id" data-selected="{{ check_field($data, 'titan_invoice_id') }}"
            class="auto-select form-control">
            <option value=""> Please Select Job Type </option>
            @foreach ($invoices as $key => $invoice)
                <option value="{{ $invoice->id }}"> For {{ $invoice->id .'('.$invoice->customer->name .')' }}</option>
            @endforeach
        </select>
        {{-- <input type="hidden" name="titan_invoice_id[]" class="" value=""> --}}
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Technician </label>
        <select name="technician_id[0][]" id="technician_id"
            data-selected="{{ array_string(check_field($data, 'technician_id'), true) }}"
            class="auto-select form-control select2 technician_id" multiple>
            <option value=""> Please Select Technician </option>
            @foreach ($technicians as $key => $technician)
                <option value="{{ $technician->id }}"> {{ $technician->name }}</option>
            @endforeach
        </select>

        <input type="hidden" name="technician_name[]" value="">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="a_time">Apponitment Duration <small>(add minutes in current time)</small></label>
        <input type="number" class="form-control" name="slot[]" value="{{ check_field($data, 'slot') }}"
            placeholder="please  enter number of minutes">
    </div>
</div>
