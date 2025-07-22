<fieldset>
  <div class="form-group col-md-4 col-sm-6">
    <label>Valid Upto</label>
    <select class="validity_type form-control full_width @error('validity_type') is-invalid @enderror"
      id="validity_type" name="validity_type" required>
      <option value=""> ---- Choose any option ---- </option>
      <option {{ (isset($data->validity_type) && $data->validity_type == "One-Time") ? 'selected': '' }} value="One-Time"> One-Time </option>
      <option {{ (isset($data->validity_type) && $data->validity_type == "Monthly") ? 'selected': '' }} value="Monthly"> Monthly </option>
      <option {{ (isset($data->validity_type) && $data->validity_type == "Yearly") ? 'selected': '' }} value="Yearly"> Yearly </option>
      {{-- @if (isset($all_floors) && count($all_floors) > 0 )
      @foreach ($all_floors as $key => $validity_type)
      <option {{ old('validity_type')==$validity_type || (isset($data->validity_type) && $data->validity_type ==
        $validity_type) ? 'selected': '' }} value="{{$validity_type}}"> {{$validity_type}} </option>
      @endforeach
      @endif --}}
    </select>
  </div>

  <div class="form-group col-md-4 col-sm-6">
    <label>Service Type</label>
    <select class="type form-control full_width @error('type') is-invalid @enderror" id="type" name="type" required>
      <option value=""> ---- Choose any option ---- </option>
      <option {{ (isset($data->type) && $data->type == "Facility") ? 'selected': '' }} value="Facility"> Facility </option>
      <option {{ (isset($data->type) && $data->type == "Service") ? 'selected': '' }} value="Service"> Service </option>

      {{-- @if (isset($all_floors) && count($all_floors) > 0 )
        @foreach ($all_floors as $key => $type)
          <option {{ old('type') == $type || (isset($data->type) && $data->type == $type) ? 'selected': '' }} value="{{$type}}"> {{$type}} </option>
        @endforeach
      @endif --}}
    </select>
  </div>

  <div class="form-group col-md-4 col-sm-6">
    <label>Title</label>
    <input type="text" name="title" value="{{old('title', isset($data->title)? $data->title: '')}}"
      class="title form-control @error('title') is-invalid @enderror full_width" placeholder="Service title or name">
    @error('title')
    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
    @else
    <span class="invalid-feedback" role="alert"></span>
    @enderror
  </div>

  <div class="form-group col-md-4 col-sm-6">
    <label>Description</label>
    <input type="text" name="description"
      value="{{old('description', isset($data->description)? $data->description: '')}}"
      class="description form-control @error('description') is-invalid @enderror full_width"
      placeholder="Service description or information">
    @error('description')
    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
    @else
    <span class="invalid-feedback" role="alert"></span>
    @enderror
  </div>

  <div class="form-group col-md-4 col-sm-6">
    <label>Cost (AED)</label>
    <input type="text" name="amount" id="amount" value="{{old('amount', isset($data->amount)? $data->amount: '')}}"
      class="amount form-control full_width only_numbers @error('amount') is-invalid @enderror"
      placeholder="Amount/cost of service" required>
    @error('amount')
    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
    @else
    <span class="invalid-feedback" role="alert"></span>
    @enderror
  </div>
</fieldset>

<div class="col-md-12 form-group user-form-group">
  <div class="pull-right m-t-20">
    <button type="button" class="btn btn-danger btn-sm">Cancel</button>
    <button type="submit" class="btn btn-add btn-sm update_service_submit">Update</button>
  </div>
</div>
