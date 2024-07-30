{{--
<div class="form-group col-md-4">
  <label class="control-label">Property Type</label>
  <select class="form-control full_width" id="prop_type" name="prop_type">
    <option value="{{$data['prop_type']}}" selected> {{$data['prop_type']}} </option>
  </select>
</div>

<div class="form-group col-md-4">
  <label class="control-label">{{$data['prop_type']}} No.</label>
  <input type="number" value="{{$data['prop_number']}}" name="prop_number" placeholder="Enter property number here" class="form-control full_width">
</div>
--}}

<div class="form-group col-md-4">
  <label class="control-label wrap-labels">Select Guest</label>
  <select class="select2_field form-control full_width" id="users" name="users">
    <option value=""> ---- Choose any user ---- </option>
    @if (isset($data['users']) && count($data['users']) > 0 )
      @foreach ($data['users'] as $key => $user)
        <option value="{{$user['id']}}"> {{$user['first_name']}} {{$user['last_name']}} </option>
      @endforeach
    @endif
  </select>
</div>

<div class="form-group col-md-4">
  <label class="control-label wrap-label">Rent (AED)</label>
  <input type="number" value="{{$data['prop_rent']}}" name="prop_rent" placeholder="Enter property rental cost" class="form-control full_width">
</div>

<div class="form-group col-md-4">
  <label class="control-label">Adittional Charges</label>
  <select class="form-control full_width" id="other_charges" name="other_charges">
    <option value="No" selected> No </option>
    <option value="Yes"> Yes </option>
  </select>
</div>

<div class="form-group col-md-4">
  <label class="control-label wrap-label" for="label1">Label 1</label>
  <input type="number" class="form-control" id="label1" name="label1" value="0">
</div>
<div class="form-group col-md-4">
  <label class="control-label wrap-label" for="label2">Label 2</label>
  <input type="number" class="form-control" id="label2" name="label2" value="0">
</div>
<div class="form-group col-md-4">
  <label class="control-label wrap-label" for="label3">Label 3</label>
  <input type="number" class="form-control" id="label3" name="label3" value="0">
</div>
<div class="form-group col-md-4">
  <label class="control-label wrap-label" for="label4">Label 4</label>
  <input type="number" class="form-control" id="label4" name="label4" value="0">
</div>
<div class="form-group col-md-4">
  <label class="control-label wrap-label" for="label5">Label 5</label>
  <input type="number" class="form-control" id="label5" name="label5" value="0">
</div>
<div class="form-group col-md-4">
  <label class="control-label wrap-label" for="label6">Label 6</label>
  <input type="number" class="form-control" id="label6" name="label6" value="0">
</div>
<div class="form-group col-md-4">
  <label class="control-label wrap-label" for="label7">Net. Total</label>
  <input type="number" class="form-control" id="label7" name="label7" value="0" readonly>
</div>