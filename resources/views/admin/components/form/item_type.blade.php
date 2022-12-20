<div class="col-md-12">
    <label for="item_type">Type</label>
    <select class="select2 form-control" name="item_type">

         @foreach ($items ?? items_list() as $value=>$item)
        <option value="{{$value}}" {{ old('item_type', $data->item_type??$main_t??'') == $value ?'selected':'' }}>{{$item}}</option>
        @endforeach
    </select>

    @error('item_type')
    <span class="invalid-feedback">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
