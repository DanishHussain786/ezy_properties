<fieldset>
  <legend class="legend-padds pt-0">Booking Details</legend>
  <input type="hidden" value="{{isset($data['id'])? $data['id'] : ''}}" id="property_id" name="property_id">
  <div class="form-group col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Select Guest</label>
    <select class="select2_field form-control full_width" id="user_id" name="user_id">
      <option value=""> ---- Choose any user ---- </option>
      @if (isset($data['users']) && count($data['users']) > 0 )
        @foreach ($data['users'] as $key => $user)
          <option value="{{$user['id']}}"> {{$user['first_name']}} {{$user['last_name']}} </option>
        @endforeach
      @endif
    </select>
  </div>

  <div class="form-group col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Check-In Date</label>
    <input type="date" value="{{isset($data['checkin_date'])? $data['checkin_date'] : ''}}" id="checkin_date" name="checkin_date" min="{{date('Y-m-d')}}" placeholder="Select check-in date" class="form-control full_width">
  </div>

  <div class="form-group col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Expected Stay</label>
    <select class="form-control full_width" id="stay_months" name="stay_months">
      <option value="" selected> ---- Choose any option ---- </option>
      <option value="1"> 1 Month </option>
      <option value="2"> 2 Month </option>
      <option value="3"> 3 Month </option>
      <option value="4"> 4 Month </option>
      <option value="5"> 5 Month </option>
      <option value="6"> 6 Month </option>
      <option value="7"> 7 Month </option>
      <option value="8"> 8 Month </option>
      <option value="9"> 9 Month </option>
      <option value="10"> 10 Month </option>
      <option value="11"> 11 Month </option>
      <option value="12"> 12 Month </option>
    </select>
  </div>

  <div class="form-group col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Monthly Rent (AED)</label>
    <input type="text" value="{{$data['prop_net_rent']}}" id="prop_rent" name="prop_rent" placeholder="Enter property rental cost" class="form-control full_width only_numbers" readonly>
  </div>

  <div class="form-group col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Markup Rent (AED)</label>
    <input type="text" value="{{isset($data['markup_rent'])? $data['markup_rent'] : ''}}" id="markup_rent" name="markup_rent" placeholder="Enter markup rent" class="form-control full_width only_numbers">
  </div>

  <div class="form-group col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Discount Rent (AED)</label>
    <input type="text" value="{{isset($data['disc_rent'])? $data['disc_rent'] : ''}}" id="disc_rent" name="disc_rent" placeholder="Enter discount rent" class="form-control full_width only_numbers">
  </div>
</fieldset>

{{--
<fieldset>
  <legend class="legend-padds">Initial Deposits</legend>
  <div class="form-group col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Initial Deposit (AED)</label>
    <input type="text" id="init_deposit" name="init_deposit" placeholder="Enter initial deposit amount" class="form-control full_width only_numbers">
  </div>

  <div class="form-group col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Deposit By</label>
    <select class="form-control full_width" id="deposit_by" name="deposit_by">
    <option value="" selected> ---- Choose any option ---- </option>
      <option value="Guest"> Guest </option>
      <option value="Other"> Any other person </option>
    </select>
  </div>

  <div class="form-group d-none depositor_data col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Depositor Name</label>
    <input type="text" value="{{$data['dep_name']}}" id="dep_name" name="dep_name" placeholder="Enter depositor full name" class="form-control full_width">
  </div>

  <div class="form-group d-none depositor_data col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Depositor Email</label>
    <input type="text" value="{{$data['dep_email']}}" id="dep_email" name="dep_email" placeholder="Enter depositor email" class="form-control full_width">
  </div>

  <div class="form-group d-none depositor_data col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Depositor Contact</label>
    <input type="text" value="{{$data['dep_contact']}}" id="dep_contact" name="dep_contact" placeholder="Enter depositor contact number" class="form-control full_width">
  </div>

  <div class="form-group d-none depositor_data col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Payment Method</label>
    <select class="form-control full_width" id="dep_method" name="dep_method">
    <option value="" selected> ---- Choose any option ---- </option>
      @if (isset($data['pay_methods']) && count($data['pay_methods']) > 0 )
        @foreach ($data['pay_methods'] as $key => $method)
          <option value="{{$method}}"> {{$method}} </option>
        @endforeach
      @endif
    </select>
  </div>
</fieldset>
--}}

<fieldset>
  <legend class="legend-padds">Other Charges</legend>
  <div class="form-group col-md-4 col-sm-6 col-xs-12">
    <label class="control-label">Adittional Charges</label>
    <select class="form-control full_width" id="other_charges" name="other_charges">
      <option value="No" selected> No </option>
      <option value="Yes"> Yes </option>
    </select>
  </div>

  {{--
  <div class="form-group d-none hidden_charges col-md-4 col-sm-6 col-xs-12">
    <label class="control-label" for="dewa_ch">DEWA Charges</label>
    <input type="text" class="form-control full_width only_numbers" placeholder="Enter dewa charges" id="dewa_ch" name="dewa_ch">
  </div>
  <div class="form-group d-none hidden_charges col-md-4 col-sm-6 col-xs-12">
    <label class="control-label" for="wifi_ch">Wifi Charges</label>
    <input type="text" class="form-control full_width only_numbers" placeholder="Enter wifi charges" id="wifi_ch" name="wifi_ch">
  </div>
  --}}
  <div class="form-group d-none hidden_charges col-md-4 col-sm-6 col-xs-12">
    <label class="control-label" for="admin_ch">Admin Fee</label>
    <input type="text" class="form-control full_width only_numbers" placeholder="Enter admin charges" id="admin_ch" name="admin_ch">
  </div>
  <div class="form-group d-none hidden_charges col-md-4 col-sm-6 col-xs-12">
    <label class="control-label" for="sec_ch">Security Charges</label>
    <input type="text" class="form-control full_width only_numbers" placeholder="Enter security charges" id="sec_ch" name="sec_ch">
  </div>
</fieldset>
<fieldset>
  <legend class="legend-padds">Total Charges</legend>
  <div class="form-group col-md-4 col-sm-6 col-xs-12">
    <label class="control-label" for="net_total">Net. Discount</label>
    <input type="text" class="form-control full_width only_numbers" placeholder="0" id="net_disc" name="net_disc" readonly>
  </div>
  <div class="form-group col-md-4 col-sm-6 col-xs-12">
    <label class="control-label" for="net_total">Net. Charges</label>
    <input type="text" class="form-control full_width only_numbers" placeholder="0" id="net_total" name="net_total" readonly>
  </div>
</fieldset>