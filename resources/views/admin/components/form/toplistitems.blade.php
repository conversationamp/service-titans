<div class="col-md-6">
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-secondary active">
            <input type="radio" name="type" id="all" value="both" autocomplete="off"  {{$main_t==''?'checked':""}}> Both
        </label>
        <label class="btn btn-secondary">
            <input type="radio" name="type" id="materials" value="material" autocomplete="off" {{$main_t=='material'?'checked':""}}> Materials
        </label>
        <label class="btn btn-secondary">
            <input type="radio" name="type" id="services" value="service" autocomplete="off"  {{$main_t=='service'?'checked':""}}> Services
        </label>


    </div>
</div>
<div class="col-md-6 text-right">
    <a href="{{ route($route.'.add',$main_t) }}" old-href="{{ route($route.'.add') }}" class="btn btn-gradient-primary btn-add-new px-4 mt-0 mb-3"><i class="mdi mdi-plus-circle-outline mr-2"></i>Add New</a>
</div>
