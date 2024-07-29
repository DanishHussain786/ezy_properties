{{--
<div class="col-md-6 form-group">
  <label class="control-label">Property Type</label>
  <select class="form-control full_width" id="prop_type" name="prop_type">
    <option value="{{$data['prop_type']}}" selected> {{$data['prop_type']}} </option>
  </select>
</div>

<div class="col-md-6 form-group">
  <label class="control-label">{{$data['prop_type']}} No.</label>
  <input type="number" value="{{$data['prop_number']}}" name="prop_number" placeholder="Enter property number here" class="form-control full_width">
</div>
--}}

<div class="col-md-6 form-group">
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

<div class="col-md-6 form-group">
  <label class="control-label">Rent (AED)</label>
  <input type="number" value="{{$data['prop_rent']}}" name="prop_rent" placeholder="Enter property rental cost" class="form-control full_width">
</div>

{{--
@php $all_floors = get_floors(); @endphp
@if ($data['prop_type'] != 'Bed Space')
<div class="col-md-6 form-group">
  <label class="control-label">Floor No.</label>
  <select class="form-control full_width" id="prop_floor" name="prop_floor">
    <option value=""> ---- Choose any option ---- </option>
    @if (isset($all_floors) && count($all_floors) > 0 )
      @foreach ($all_floors as $key => $prop_floor)
        <option {{ old('prop_floor') == $prop_floor || (isset($data->prop_floor) && $data->prop_floor == $prop_floor) ? 'selected': '' }} value="{{$prop_floor}}"> {{$prop_floor}} </option>
      @endforeach
    @endif
  </select>
</div>
@endif

@if ($data['prop_type'] != 'Bed Space')
<div class="col-md-6 form-group">
  <label class="control-label">Property Address</label>
  <input type="text" value="{{$data['prop_address']}}" name="prop_address" placeholder="Enter property address" class="form-control full_width">
</div>
@endif
--}}

{{--
<div class="container-fluid">
  <h2 style="color: white; font-size: 4px;" class="text-center">Excel-like Form</h2>
  <form>
    <div class="table-responsive">
      <table class="table table-bordered excel-table no-border">
        --}}
        {{--
        <thead>
          <tr>
            <th>Label 1</th>
            <th>Field 1</th>
            <th>Label 2</th>
            <th>Field 2</th>
          </tr>
        </thead>
        --}}
        {{--
        <tbody>
          <tr>
            <div class="col-md-4">
              <td class="no-borders">
                <label for="field1">Label 1</label>
              </td>
              <td class="no-border">
                <input type="text" class="form-control full_width" id="field1" name="field1" />
              </td>
            </div>
            <div class="col-md-4">
              <td class="no-borders">
                <label for="field2">Label 2</label>
              </td>
              <td class="no-border">
                <input type="text" class="form-control full_width" id="field2" name="field2" />
              </td>
            </div>
            <div class="col-md-4">
              <td class="no-border">
                <label for="field3">Label 3</label>
              </td>
              <td class="no-border">
                <input type="text" class="form-control full_width" id="field3" name="field3" />
              </td>
            </div>
          </tr>
          <tr>
            <div class="col-md-4">
              <td class="no-border">
                <label for="field4">Label 4</label>
              </td>
              <td class="no-border">
                <input type="text" class="form-control full_width" id="field4" name="field4" />
              </td>
            </div>
            <div class="col-md-4">
              <td class="no-border">
                <label for="field5">Label 5</label>
              </td>
              <td class="no-border">
                <input type="text" class="form-control full_width" id="field5" name="field5" />
              </td>
            </div>
            <div class="col-md-4">
              <td class="no-border">
                <label for="field6">Label 6</label>
              </td>
              <td class="no-border">
                <input type="text" class="form-control full_width" id="field6" name="field6" />
              </td>
            </div>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="form-group no-margin">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>

<div class="col-md-12 form-group user-form-group">
  <div class="pull-right m-t-20">
    <button type="button" class="btn btn-danger btn-sm">Cancel</button>
    <button type="submit" class="btn btn-add btn-sm">Update</button>
  </div>
</div>
--}}

<div class="form-group col-xs-12 col-sm-6 col-md-4">
  <label for="label1">Label 1</label>
  <input type="number" class="form-control" id="label1" name="label1" value="0">
</div>
<div class="form-group col-xs-12 col-sm-6 col-md-4">
  <label for="label2">Label 2</label>
  <input type="number" class="form-control" id="label2" name="label2" value="0">
</div>
<div class="form-group col-xs-12 col-sm-6 col-md-4">
  <label for="label3">Label 3</label>
  <input type="number" class="form-control" id="label3" name="label3" value="0">
</div>
<div class="form-group col-xs-12 col-sm-6 col-md-4">
  <label for="label4">Label 4</label>
  <input type="number" class="form-control" id="label4" name="label4" value="0">
</div>
<div class="form-group col-xs-12 col-sm-6 col-md-4">
  <label for="label5">Label 5</label>
  <input type="number" class="form-control" id="label5" name="label5" value="0">
</div>
<div class="form-group col-xs-12 col-sm-6 col-md-4">
  <label for="label6">Label 6</label>
  <input type="number" class="form-control" id="label6" name="label6" value="0">
</div>
<div class="form-group col-xs-12 total-sum">
  <label for="label7">Label 7 (Total)</label>
  <input type="number" class="form-control" id="label7" name="label7" value="0" readonly>
</div>
<div class="form-group col-xs-12">
  <button type="button" class="btn btn-primary" id="calculateTotal">Calculate Total</button>
</div>