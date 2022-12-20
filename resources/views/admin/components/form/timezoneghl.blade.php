@php
    if(empty($name)){
        $name="settings[timezone]";
    }

    $value = $data->timezone ?? get_custom_settings('timezone');


@endphp
<div class="form-group row">
    <div class="col-md-12">
        <label for="assigned_to">TimeZone </label>
        <select class="select2 form-control" name="{{$name}}">
            <option value="">Select Timezone</option>
            @foreach (get_ghl_timezones() as $timezone)
            <option value="{{ $timezone }}" {{ old('timezone', $value) == $timezone ? 'selected' : '' }}>
                {{ $timezone }}</option>
            @endforeach
        </select>
    </div>
</div>
