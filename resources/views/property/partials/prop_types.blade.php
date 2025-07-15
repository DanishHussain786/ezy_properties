{{-- <div class="form-group col-md-3 col-sm-6 is-required">
  <label id="property_type">Room No.</label>
  <input type="number" name="room_no" id="room_no" value="{{old('room_no', isset($data->room_no)? $data->room_no: '')}}"
    class="form-control full_width @error('room_no') is-invalid @enderror" placeholder="Enter property room number"
    required>
  @error('room_no')
  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
  @else
  <span class="invalid-feedback" role="alert"></span>
  @enderror
</div> --}}

{{-- <div class="form-group col-md-3 col-sm-6 is-required">
  <label id="property_type">{{ $data->prop_type ? $data->prop_type : 'Property ' }} No.</label>
  <input type="number" name="prop_number" id="prop_number"
    value="{{old('prop_number', isset($data->property_units->prop_number)? $data->property_units->prop_number: '')}}"
    class="form-control full_width @error('prop_number') is-invalid @enderror"
    placeholder="Enter property number or reference" required>
  @error('prop_number')
  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
  @else
  <span class="invalid-feedback" role="alert"></span>
  @enderror
</div> --}}

{{-- @php $all_floors = get_floors(); @endphp
<div class="form-group col-md-3 col-sm-6 is-required">
  <label>Floor No.</label>
  <select class="select2_field form-control full_width @error('prop_floor') is-invalid @enderror" id="prop_floor"
    name="prop_floor" required>
    <option value=""> ---- Choose any option ---- </option>
    @if (isset($all_floors) && count($all_floors) > 0 )
    @foreach ($all_floors as $key => $prop_floor)
    <option {{ old('prop_floor')==$prop_floor || (isset($data->property_units->prop_floor) && $data->property_units->prop_floor == $prop_floor) ?
      'selected': '' }} value="{{$prop_floor}}"> {{$prop_floor}} </option>
    @endforeach
    @endif
  </select>
  @error('role')
  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
  @else
  <span class="invalid-feedback" role="alert"></span>
  @enderror
</div> --}}

{{-- <div class="form-group dy_other_charges col-md-3 col-sm-6 is-required">
  <label>Other Charges</label>
  <select class="form-control full_width" id="other_charges" name="other_charges">
    <option value=""> ---- Choose any option ---- </option>
    <option value="No"> No </option>
    <option value="Yes"> Yes </option>
  </select>
</div> --}}

{{-- <div class="form-group dy_bs_level col-md-3 col-sm-6 is-required">
  <label>Level</label>
  <select class="form-control full_width @error('bs_level') is-invalid @enderror" id="bs_level" name="bs_level"
    required>
    <option value=""> ---- Choose any option ---- </option>
    <option {{ old('bs_level')=="1" || (isset($data->bs_level) && $data->bs_level == "1") ? 'selected': '' }} value="1">
      Down </option>
    <option {{ old('bs_level')=="2" || (isset($data->bs_level) && $data->bs_level == "2") ? 'selected': '' }} value="2">
      1st Up </option>
    <option {{ old('bs_level')=="3" || (isset($data->bs_level) && $data->bs_level == "3") ? 'selected': '' }} value="3">
      2nd Up </option>
  </select>
  @error('role')
  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
  @else
  <span class="invalid-feedback" role="alert"></span>
  @enderror
</div> --}}


<div class="form-group col-sm-12" style="text-align: left; ">
  <button class="btn btn-success btn-sm" id="add_prop_units"><i class="fa fa-plus"></i> Add Property Units</button>
  {{-- <button type="button" class="handle_property btn btn-success">{{ isset($data->property_units->id) ? 'Update':'Save' }}</button> --}}
  {{-- <a href="" class="btn btn-warning">Reset</a> --}}
</div>
