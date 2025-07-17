<input type="hidden" value="{{isset($data['property_id'])? $data['property_id'] : ''}}" id="property_id" name="property_id">
<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Select Guest</label>
  <select class="select2_field form-control full_width" id="booked_for" name="booked_for">
    <option value=""> ---- Choose any user ---- </option>
    @if (isset($data['users']) && count($data['users']) > 0 )
      @foreach ($data['users'] as $key => $user)
        <option value="{{$user['id']}}" {{isset($data->booked_for) && $data->booked_for == $user['id'] ? 'selected': ''}}> {{$user['first_name']}} {{$user['last_name']}} </option>
      @endforeach
    @endif
  </select>
</div>

<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Check-In Date</label>
  <input type="date" value="{{default_value($data['checkin_date'])}}" id="checkin_date" name="checkin_date" min="{{date('Y-m-d')}}" placeholder="Select check-in date" class="form-control full_width">
</div>

<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Expected Stay</label>
  <select class="form-control full_width" id="stay_months" name="stay_months">
    <option value="" {{$data['for_months'] == "" ? "selected" : ''}} > ---- Choose any option ---- </option>
    <option value="1" {{$data['for_months'] == "1" ? "selected" : ''}} > 1 Month </option>
    <option value="2" {{$data['for_months'] == "2" ? "selected" : ''}} > 2 Month </option>
    <option value="3" {{$data['for_months'] == "3" ? "selected" : ''}} > 3 Month </option>
    <option value="4" {{$data['for_months'] == "4" ? "selected" : ''}} > 4 Month </option>
    <option value="5" {{$data['for_months'] == "5" ? "selected" : ''}} > 5 Month </option>
    <option value="6" {{$data['for_months'] == "6" ? "selected" : ''}} > 6 Month </option>
    <option value="7" {{$data['for_months'] == "7" ? "selected" : ''}} > 7 Month </option>
    <option value="8" {{$data['for_months'] == "8" ? "selected" : ''}} > 8 Month </option>
    <option value="9" {{$data['for_months'] == "9" ? "selected" : ''}} > 9 Month </option>
    <option value="10" {{$data['for_months'] == "10" ? "selected" : ''}} > 10 Month </option>
    <option value="11" {{$data['for_months'] == "11" ? "selected" : ''}} > 11 Month </option>
    <option value="12" {{$data['for_months'] == "12" ? "selected" : ''}} > 12 Month </option>
  </select>
</div>

<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Monthly Rent (AED)</label>
  <input type="number" value="{{$data['rent']}}" id="unit_rent" name="unit_rent" placeholder="Enter property rental cost" class="form-control full_width" readonly>
</div>

<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Markup Rent (AED)</label>
  <input type="number" value="{{$data['markup_rent']}}" id="markup_rent" name="markup_rent" placeholder="Enter markup rent" class="form-control full_width">
</div>

<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Adittional Charges</label>
  <select class="form-control full_width" id="other_charges" name="other_charges">
    <option value="No" {{$data['other_charges'] == "No" ? "selected" : ''}} > No </option>
    <option value="Yes" {{$data['other_charges'] == "Yes" ? "selected" : ''}} > Yes </option>
  </select>
</div>

<div class="form-group {{$data['other_charges'] == 'No' ? 'd-none' : ''}} hidden_charges col-md-4 col-sm-6 col-xs-12">
  <label class="control-label" for="dewa_ch">DEWA Charges</label>
  <input type="number" class="form-control full_width" placeholder="0" value="{{$data['dewa_charges']}}" id="dewa_ch" name="dewa_ch">
</div>
<div class="form-group {{$data['other_charges'] == 'No' ? 'd-none' : ''}} hidden_charges col-md-4 col-sm-6 col-xs-12">
  <label class="control-label" for="wifi_ch">Wifi Charges</label>
  <input type="number" class="form-control full_width" placeholder="0" value="{{$data['wifi_charges']}}" id="wifi_ch" name="wifi_ch">
</div>
<div class="form-group {{$data['other_charges'] == 'No' ? 'd-none' : ''}} hidden_charges col-md-4 col-sm-6 col-xs-12">
  <label class="control-label" for="admin_ch">Admin Fee</label>
  <input type="number" class="form-control full_width" placeholder="0" value="{{$data['admin_charges']}}" id="admin_ch" name="admin_ch">
</div>
<div class="form-group {{$data['other_charges'] == 'No' ? 'd-none' : ''}} hidden_charges col-md-4 col-sm-6 col-xs-12">
  <label class="control-label" for="sec_ch">Security Charges</label>
  <input type="number" class="form-control full_width" placeholder="0" value="{{$data['security_charges']}}" id="sec_ch" name="sec_ch">
</div>
<div class="form-group col-md-12 col-sm-12 col-xs-12">
  <label class="control-label" for="net_total">Net. Total</label>
  <input type="number" class="form-control full_width" placeholder="0" value="{{$data['net_total']}}" id="net_total" name="net_total" readonly>
</div>

<div class="col-md-12 form-group user-form-group">
  <div class="pull-right m-t-20">
    <button type="button" class="btn btn-danger btn-sm">Cancel</button>
    <button type="submit" class="btn btn-add btn-sm update_reserv_submit">Update</button>
  </div>
</div>
