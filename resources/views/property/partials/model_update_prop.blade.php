<div class="col-md-6 form-group">
  <label class="control-label">Property Type</label>
  <select class="form-control full_width" id="prop_type" name="prop_type">
    <option value="{{$data['prop_type']}}" selected> {{$data['prop_type']}} </option>
  </select>
</div>

@if ($data['prop_status'] == 'Available')
  <div class="col-md-6 form-group">
    <label class="control-label">{{$data['prop_type']}} No.</label>
    <input type="number" value="{{$data['prop_number']}}" name="prop_number" placeholder="Enter property number here" class="form-control full_width">
  </div>
@endif

@php $all_floors = get_floors(); @endphp
@if ($data['prop_status'] == 'Available')
  @if ($data['prop_type'] != 'Bed Space')
  <div class="col-md-6 form-group">
    <label class="control-label">Floor No.</label>
    <select class="select2_field form-control full_width" id="prop_floor" name="prop_floor">
      <option value=""> ---- Choose any option ---- </option>
      @if (isset($all_floors) && count($all_floors) > 0 )
        @foreach ($all_floors as $key => $prop_floor)
          <option {{ old('prop_floor') == $prop_floor || (isset($data->prop_floor) && $data->prop_floor == $prop_floor) ? 'selected': '' }} value="{{$prop_floor}}"> {{$prop_floor}} </option>
        @endforeach
      @endif
    </select>
  </div>
  @endif
@endif

<div class="col-md-6 form-group">
  <label class="control-label">Rent (AED)</label>
  <input type="number" value="{{$data['prop_rent']}}" name="prop_rent" placeholder="Enter property rental cost" class="form-control full_width">
</div>

@if ($data['prop_status'] == 'Available')
  @if ($data['prop_type'] != 'Bed Space')
  <div class="col-md-6 form-group">
    <label class="control-label">Property Address</label>
    <input type="text" value="{{$data['prop_address']}}" name="prop_address" placeholder="Enter property address" class="form-control full_width">
  </div>
  @endif
@endif

<div class="col-md-12 form-group user-form-group">
  <div class="pull-right m-t-20">
    <button type="button" class="btn btn-danger btn-sm">Cancel</button>
    <button type="submit" class="btn btn-add btn-sm">Update</button>
  </div>
</div>