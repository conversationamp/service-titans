@php
    if(empty($save)){
        $save='Save';
    }
@endphp
<div class="form-group">
    <a href="{{ route($route.'.list') }}" class="btn btn-danger btn-sm text-light px-4 mt-3 float-right mb-0 ml-2">Cancel</a>
    <button type="submit" name="save_add" class="btn btn-secondary ml-3 btn-sm text-light px-4 mt-3 float-right mb-0">{{$save}} & Back</button>
    <button type="submit" name="save" class="btn btn-primary btn-sm text-light px-4 mt-3 float-right mb-0">{{$save}}</button>
</div>
