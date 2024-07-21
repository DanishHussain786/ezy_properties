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
            <form class="form" action="{{ route($data['route_name'].'.update', $data->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            <input type="hidden" name="update_id" value="{{$data->id}}">
            @else
            <form class="form col-sm-12" action="{{ route($data['route_name'].'.store') }}" method="POST" enctype="multipart/form-data">
            @endif
            @csrf

              <div class="row" style="margin-left: 0px;">
                <div class="form-group col-md-4 col-sm-6">
                  <label>Type</label>
                  <select class="form-control @error('prop_type') is-invalid @enderror" id="prop_type" name="prop_type">
                    <option value=""> ---- Choose any type ---- </option>
                    @if (isset($data['prop_types']) && count($data['prop_types']) > 0 )
                      @foreach ($data['prop_types'] as $key => $type)
                        <option {{ old('prop_type') == $type || (isset($data->prop_type) && $data->prop_type == $type) ? 'selected': '' }} value="{{$prop_type}}"> {{$prop_type}} </option>
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

              <div class="form-group col-md-4 col-sm-6">
                <label>Property No.</label>
                <input type="number" name="prop_no" value="{{old('prop_no', isset($data->prop_no)? $data->prop_no: '')}}" class="form-control @error('prop_no') is-invalid @enderror" placeholder="Enter property number or reference">
                @error('prop_no')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              @php $all_floors = get_floors(); @endphp
              <div class="form-group col-md-4 col-sm-6">
                <label>Floor No.</label>
                <select class="form-control @error('prop_floor') is-invalid @enderror" id="prop_floor" name="prop_floor">
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

              <div class="form-group col-md-4 col-sm-6">
                <label>Rent (AED)</label>
                <input type="number" name="prop_rent" value="{{old('prop_rent', isset($data->prop_rent)? $data->prop_rent: '')}}" class="form-control @error('prop_rent') is-invalid @enderror" placeholder="Enter property rental cost">
                @error('prop_rent')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group col-md-4 col-sm-6">
                <label>Property Address</label>
                <input type="text" name="prop_address" value="{{old('prop_address', isset($data->prop_address)? $data->prop_address: '')}}" class="form-control @error('prop_address') is-invalid @enderror" placeholder="Enter property address">
                @error('prop_address')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="col-sm-12 reset-button">
                <a href="" class="btn btn-warning">Reset</a>
                <button type="submit" class="btn btn-success">{{ isset($data->id) ? 'Update':'Add' }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection