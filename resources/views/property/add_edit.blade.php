@if (isset($data->id))
  @php $title = 'Update Property' @endphp
@else
  @php $title = 'Add Property' @endphp
@endif

@section('title', $title)
@extends('master')
@section('content-view')
  <section class="content-header">
    <div class="header-icon">
      <i class="fa fa-dashboard"></i>
    </div>
    <div class="header-title">
      <h1>Property Panel</h1>
      <small>{{ $title }}</small>
    </div>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <div class="panel-heading">
            <div class="btn-group"> 
              <a class="btn btn-add" href="{{url($data['route_name'])}}">
                <i class="fa fa-list"></i> Properties List 
              </a>
            </div>
          </div>
          <div class="panel-body">
            @if (Session::has('message'))
              <div class="alert alert-success"><b>Success: </b>{{ Session::get('message') }}</div>
            @endif
            @if (Session::has('error_message'))
              <div class="alert alert-danger"><b>Sorry: </b>{{ Session::get('error_message') }}</div>
            @endif

            @if (isset($data->id))
            <form class="form col-sm-12 form-np" action="{{ route($data['route_name'].'.update', $data->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            <input type="hidden" name="update_id" value="{{$data->id}}">
            @else
            <form class="form col-sm-12 form-np" action="{{ route($data['route_name'].'.store') }}" method="POST" enctype="multipart/form-data">
            @endif
            @csrf

              <div class="row" style="margin-left: 0px;">
                <div class="form-group col-md-4 col-sm-6 is-required">
                  <label>Type</label>
                  <select class="select2_field form-control @error('prop_type') is-invalid @enderror" id="prop_type" name="prop_type" required>
                    <option value=""> ---- Choose any option ---- </option>
                    @if (isset($data['prop_types']) && count($data['prop_types']) > 0 )
                      @foreach ($data['prop_types'] as $key => $type)
                        <option {{ old('prop_type') == $type || (isset($data->prop_type) && $data->prop_type == $type) ? 'selected': '' }} value="{{$type}}"> {{$type}} </option>
                      @endforeach
                    @endif
                  </select>
                  @error('role')
                    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                  @else
                    <span class="invalid-feedback" role="alert"></span>
                  @enderror
                </div>
              </div>

              <div class="form-group dy_prop_number col-md-4 col-sm-6 is-required">
                <label id="property_type">Property No.</label>
                <input type="number" name="prop_number" id="prop_number" value="{{old('prop_number', isset($data->prop_number)? $data->prop_number: '')}}" class="form-control @error('prop_number') is-invalid @enderror" placeholder="Enter property number or reference" required>
                @error('prop_number')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group dy_room_no col-md-4 col-sm-6 is-required" style="display: none;">
                <label id="property_type">Room No.</label>
                <input type="number" name="room_no" id="room_no" value="{{old('room_no', isset($data->room_no)? $data->room_no: '')}}" class="form-control @error('room_no') is-invalid @enderror" placeholder="Enter property room number" required>
                @error('room_no')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              @php $all_floors = get_floors(); @endphp
              <div class="form-group dy_floor col-md-4 col-sm-6 is-required">
                <label>Floor No.</label>
                <select class="select2_field form-control @error('prop_floor') is-invalid @enderror" id="prop_floor" name="prop_floor" required>
                  <option value=""> ---- Choose any option ---- </option>
                  @if (isset($all_floors) && count($all_floors) > 0 )
                    @foreach ($all_floors as $key => $prop_floor)
                      <option {{ old('prop_floor') == $prop_floor || (isset($data->prop_floor) && $data->prop_floor == $prop_floor) ? 'selected': '' }} value="{{$prop_floor}}"> {{$prop_floor}} </option>
                    @endforeach
                  @endif
                </select>
                @error('role')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group dy_rent col-md-4 col-sm-6 is-required">
                <label>Rent (AED)</label>
                <input type="number" name="prop_rent" id="prop_rent" value="{{old('prop_rent', isset($data->prop_rent)? $data->prop_rent: '')}}" class="form-control @error('prop_rent') is-invalid @enderror" placeholder="Enter property rental cost" required>
                @error('prop_rent')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group dy_prop_add col-md-4 col-sm-6 is-required">
                <label>Property Address</label>
                <input type="text" name="prop_address" id="prop_address" value="{{old('prop_address', isset($data->prop_address)? $data->prop_address: '')}}" class="form-control @error('prop_address') is-invalid @enderror" placeholder="Enter property address" required>
                @error('prop_address')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="row" style="margin-left: 0px;">
                <div class="form-group dy_bs_level col-md-4 col-sm-6 is-required">
                  <label>Level</label>
                  <select class="form-control @error('bs_level') is-invalid @enderror" id="bs_level" name="bs_level" required>
                    <option value=""> ---- Choose any option ---- </option> 
                    <option {{ old('bs_level') == "1" || (isset($data->bs_level) && $data->bs_level == "1") ? 'selected': '' }} value="1"> Down </option>
                    <option {{ old('bs_level') == "2" || (isset($data->bs_level) && $data->bs_level == "2") ? 'selected': '' }} value="2"> 1st Up </option>
                    <option {{ old('bs_level') == "3" || (isset($data->bs_level) && $data->bs_level == "3") ? 'selected': '' }} value="3"> 2nd Up </option>
                  </select>
                  @error('role')
                    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                  @else
                    <span class="invalid-feedback" role="alert"></span>
                  @enderror
                </div>
              </div>

              <div class="col-sm-12 reset-button">
                <a href="" class="btn btn-warning">Reset</a>
                <button type="submit" id="property_btn" class="btn btn-success">{{ isset($data->id) ? 'Update':'Add' }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection