<div class="col-md-6">
    <div class="btn-group btn-group-toggle" data-toggle="buttons">

        @if(isset($show_all))

        <label class="btn btn-secondary active" hidden>
            <input type="radio" name="type" id="all" value="all" autocomplete="off"  {{$main_t=='all'?'checked':""}}> All
        </label>

        @endif
        <label class="btn btn-secondary active">
            <input type="radio" name="type" id="both" value="both" autocomplete="off"  {{$main_t=='both'?'checked':""}}> Both
        </label>
        <label class="btn btn-secondary ">
            <input type="radio" name="type" id="workorder" value="workorder" autocomplete="off" {{$main_t=='workorder'?'checked':""}}> Work Order
        </label>
        <label class="btn btn-secondary">
            <input type="radio" name="type" id="job" value="job" autocomplete="off"  {{$main_t=='job'?'checked':""}}> Job
        </label>

    </div>
</div>
@php
    if(!isset($prefix)){
        $prefix='add';
    }
@endphp

@php
    $col='6';
@endphp

@if(isset($folder) && $folder=="")
@php
     $col='3';
@endphp
<div class="col-md-3 text-right">
    <a href="{{ route($route.'.add',[$main_t,'folder']) }}" class="btn btn-gradient-primary btn-create_folder px-4 mt-0 mb-3"><i class="mdi mdi-plus-circle-outline mr-2"></i>Create Folder</a>
</div>
@endif

<div class="col-md-{{$col}} text-right">
    <a href="{{ route($route.'.'.$prefix??'add',[$main_t]) }}" old-href="{{ route($route.'.'.$prefix??'add') }}" class="btn btn-gradient-primary btn-add-new px-4 mt-0 mb-3"><i class="mdi mdi-plus-circle-outline mr-2"></i>Add New</a>
</div>
