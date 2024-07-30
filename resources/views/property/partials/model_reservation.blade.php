<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Select Guest</label>
  <select class="select2_field form-control full_width" id="users" name="users">
    <option value=""> ---- Choose any user ---- </option>
    @if (isset($data['users']) && count($data['users']) > 0 )
      @foreach ($data['users'] as $key => $user)
        <option value="{{$user['id']}}"> {{$user['first_name']}} {{$user['last_name']}} </option>
      @endforeach
    @endif
  </select>
</div>

<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Rent (AED)</label>
  <input type="number" value="{{$data['prop_rent']}}" id="prop_rent" name="prop_rent" placeholder="Enter property rental cost" class="form-control full_width">
</div>

<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Adittional Charges</label>
  <select class="form-control full_width" id="other_charges" name="other_charges">
    <option value="No" selected> No </option>
    <option value="Yes"> Yes </option>
  </select>
</div>

<div class="form-group d-none hidden_charges col-md-4 col-sm-6 col-xs-12">
  <label class="control-label" for="dewa_ch">DEWA Charges</label>
  <input type="number" class="form-control full_width" placeholder="0" id="dewa_ch" name="dewa_ch">
</div>
<div class="form-group d-none hidden_charges col-md-4 col-sm-6 col-xs-12">
  <label class="control-label" for="wifi_ch">Wifi Charges</label>
  <input type="number" class="form-control full_width" placeholder="0" id="wifi_ch" name="wifi_ch">
</div>
<div class="form-group d-none hidden_charges col-md-4 col-sm-6 col-xs-12">
  <label class="control-label" for="admin_ch">Admin Fee</label>
  <input type="number" class="form-control full_width" placeholder="0" id="admin_ch" name="admin_ch">
</div>
<div class="form-group d-none hidden_charges col-md-4 col-sm-6 col-xs-12">
  <label class="control-label" for="sec_ch">Security Charges</label>
  <input type="number" class="form-control full_width" placeholder="0" id="sec_ch" name="sec_ch">
</div>
<div class="form-group col-md-12 col-sm-12 col-xs-12">
  <label class="control-label" for="net_total">Net. Total</label>
  <input type="number" class="form-control full_width" placeholder="0" id="net_total" name="net_total" readonly>
</div>