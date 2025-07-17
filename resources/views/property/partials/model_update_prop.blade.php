<div class="col-md-6 form-group">
  <label class="control-label">Property Type</label>
  <select class="form-control full_width" id="prop_type" name="prop_type">
    <option value="{{$data['prop_type']}}" selected> {{$data['prop_type']}} </option>
  </select>
</div>

@if ($data['prop_status'] == 'Available')
  <div class="col-md-6 form-group">
    <label class="control-label">{{$data['prop_type']}} No.</label>
    <input type="text" value="{{$data['unit_number']}}" name="unit_number" placeholder="Enter property number here" class="form-control full_width only_numbers">
  </div>
@endif

@php $all_floors = get_floors(); @endphp
@if ($data['prop_status'] == 'Available')
  @if ($data['prop_type'] != 'Bed Space')
  <div class="col-md-6 form-group">
    <label class="control-label">Floor No.</label>
    <select class="select2_field form-control full_width" id="unit_floor" name="unit_floor">
      <option value=""> ---- Choose any option ---- </option>
      @if (isset($all_floors) && count($all_floors) > 0 )
        @foreach ($all_floors as $key => $unit_floor)
          <option {{ old('unit_floor') == $unit_floor || (isset($data->unit_floor) && $data->unit_floor == $unit_floor) ? 'selected': '' }} value="{{$unit_floor}}"> {{$unit_floor}} </option>
        @endforeach
      @endif
    </select>
  </div>
  @endif
@endif

<div class="col-md-6 form-group">
  <label class="control-label">Rent (AED)</label>
  <input type="text" value="{{$data['unit_rent']}}" name="unit_rent" placeholder="Enter property rental cost" class="form-control full_width only_numbers">
</div>

<div class="col-md-6 form-group">
  <label>Other Charges</label>
  <select class="form-control full_width" id="other_charges" name="other_charges">
    <option {{(isset($data['other_charges']) && $data['other_charges'] == 'No') ? 'selected': '' }} value="No"> No </option>
    <option {{(isset($data['other_charges']) && $data['other_charges'] == 'Yes') ? 'selected': '' }} value="Yes"> Yes </option>
  </select>
</div>

<div class="col-md-6 form-group dy_dewa_ch {{$data['dewa_charges'] > 0 && $data['other_charges'] == 'Yes' ? '' : 'd-none'}}">
  <label class="control-label">Dewa Charges</label>
  <input type="text" value="{{$data['dewa_charges']}}" id="dewa_ch" name="dewa_ch" placeholder="Enter property dewa charges" class="form-control full_width only_numbers">
</div>

<div class="col-md-6 form-group dy_wifi_ch {{$data['wifi_charges'] > 0 && $data['other_charges'] == 'Yes' ? '' : 'd-none'}}">
  <label class="control-label">Wifi Charges</label>
  <input type="text" value="{{$data['wifi_charges']}}" id="wifi_ch" name="wifi_ch" placeholder="Enter property wifi charges" class="form-control full_width only_numbers">
</div>

<div class="col-md-6 form-group dy_misc_ch {{$data['misc_charges'] > 0 && $data['other_charges'] == 'Yes' ? '' : 'd-none'}}">
  <label class="control-label">Misc. Address</label>
  <input type="text" value="{{$data['misc_charges']}}" id="misc_ch" name="misc_ch" placeholder="Enter property misc charges" class="form-control full_width only_numbers">
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
