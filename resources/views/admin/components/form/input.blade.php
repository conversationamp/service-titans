@php

if (empty($column)) {
    $column = '12';
}

if (empty($default)) {
    $default = '';
}

$required = !empty($required);

if (empty($type)) {
    $type = 'text';
}
if (empty($action)) {
    $action='';
}
if (empty($id)) {
    $id=$name;
}

if (empty($class)) {
    $class='';
}
if (empty($label_class)) {
    $label_class='';
}

@endphp
<div class="col-md-{{ $column }}">
    <label for="{{$id}}" class="{{$label_class}}">{{ $title }} {{ $required ? '*' : '' }}</label>
    <input type="{{$type}}" placeholder="{{ $title }}" class="form-control {{$class}} @error($name) is-invalid @enderror"
        name="{{ $name }}" value="{{ old($name, $default) }}" id="{{ $id }}" autocomplete="off"
        {{ $required ? 'required' : '' }} {{$action}}>
    @error($name)
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
