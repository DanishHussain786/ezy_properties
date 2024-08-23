@if (isset($data->id))
@php $title = 'Update Service' @endphp
@else
@php $title = 'Add Service' @endphp
@endif

@section('title', $title)
@extends('master')
@section('content-view')
<section class="content-header">
  <div class="header-icon">
    <i class="fa fa-dashboard"></i>
  </div>
  <div class="header-title">
    <h1>Service Panel</h1>
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
              <i class="fa fa-list"></i> Service List
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

            <!-- Section 3 -->
            <div class="form-group col-md-4 col-sm-6">
              <label>Service Name</label>
              <input type="text" name="title" value="{{old('title', isset($data->title)? $data->title: '')}}" class="form-control @error('title') is-invalid @enderror full_width" placeholder="Enter company full name">
              @error('title')
              <span class="invalid-feedback" role="alert"> {{ $message }} </span>
              @else
              <span class="invalid-feedback" role="alert"></span>
              @enderror
            </div>
            <div class="form-group col-md-4 col-sm-6">
              <label>Charges</label>
              <input type="text" name="charges" value="{{old('charges', isset($data->charges)? $data->charges: '')}}" class="form-control @error('charges') is-invalid @enderror full_width only_numbers" placeholder="Enter company email address">
              @error('charges')
              <span class="invalid-feedback" role="alert"> {{ $message }} </span>
              @else
              <span class="invalid-feedback" role="alert"></span>
              @enderror
            </div>
            <div class="form-group col-md-4 col-sm-6">
              <label>Type</label>
              <select class="form-control @error('type') is-invalid @enderror full_width" id="type" name="type">
                <option value=""> ---- Choose any option ---- </option>
                <option {{(isset($data['type']) && $data['type'] == 'One-Time') ? 'selected': '' }} value="One-Time"> One Time </option>
                <option {{(isset($data['type']) && $data['type'] == 'Monthly') ? 'selected': '' }} value="Monthly"> Monthly </option>
              </select>
              @error('type')
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