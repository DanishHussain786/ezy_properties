@if (isset($data->id))
  @section('title', 'Update Chapter')
@else
  @section('title', 'Add Chapter')
@endif

@extends('master')

@section('content-view')
  <section class="content-header">
    <div class="header-icon">
      <i class="fa fa-dashboard"></i>
    </div>
    <div class="header-title">
      <h1>CRM Admin Dashboard</h1>
      <small>Very detailed & featured admin.</small>
    </div>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- Form controls -->
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <div class="panel-heading">
            <div class="btn-group" id="buttonlist"> 
              <a class="btn btn-add" href="{{url('user')}}">
                <i class="fa fa-list"></i> Customer List 
              </a>  
            </div>
          </div>
          <div class="panel-body">

            @if (isset($data->id))
            <form class="form" action="{{ route('user.update', $data->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            <input type="hidden" name="update_id" value="{{$data->id}}">
            @else
            <form class="form col-sm-12" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @endif
            @csrf

              @if (Session::has('message'))
              <div class="alert alert-success"><b>Success: </b>{{ Session::get('message') }}</div>
              @endif
              @if (Session::has('error_message'))
              <div class="alert alert-danger"><b>Sorry: </b>{{ Session::get('error_message') }}</div>
              @endif
              <div class="form-group col-sm-6">
                <label>First Name</label>
                <input type="text" name="first_name" value="{{old('first_name', isset($data->first_name)? $data->first_name: '')}}" class="form-control @error('first_name') is-invalid @enderror" placeholder="Enter first name">
                @error('first_name')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>Last Name</label>
                <input type="text" name="last_name" value="{{old('last_name', isset($data->last_name)? $data->last_name: '')}}" class="form-control @error('last_name') is-invalid @enderror" placeholder="Enter last name">
                @error('last_name')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>User Role</label>
                <select class="form-control @error('user_role') is-invalid @enderror" name="user_role">
                  <option value=""> ---- Choose an option ---- </option>
                  <option>Manager</option>
                  <option>Agent</option>
                  <option>Customer</option>
                </select>
                @error('user_role')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email address">
                @error('email')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @enderror
              </div>

              <div class="form-group col-sm-6">
                <label>Emirates ID</label>
                <input type="text" name="eid" class="form-control @error('eid') is-invalid @enderror" placeholder="Enter emirates id">
                @error('eid')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>Passport No</label>
                <input type="text" name="passport_no" class="form-control @error('passport_no') is-invalid @enderror" placeholder="Enter passport no">
                @error('passport_no')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>Mobile</label>
                <input type="number" name="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror" placeholder="Enter mobile number">
                @error('mobile_no')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>Picture upload</label>
                <input type="file" name="profile_photo">
                <input type="hidden" name="old_picture">
                @error('profile_photo')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @enderror
              </div>
              
              <div class="form-group col-sm-6">
                <label>Date of Birth</label>
                <input id="minMaxExample" type="text" name="dob" class="form-control @error('dob') is-invalid @enderror" placeholder="Enter date of birth">
                @error('dob')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>Address</label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3"></textarea>
                @error('address')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>Sex</label><br>
                <label class="radio-inline"><input name="sex" value="1" checked="checked" type="radio"> Male</label> 
                <label class="radio-inline"><input name="sex" value="0" type="radio"> Female</label>
                @error('sex')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>Status</label><br>
                <label class="radio-inline">
                  <input type="radio" name="status" value="1" checked="checked"> Active
                </label>
                <label class="radio-inline">
                  <input type="radio" name="status" value="0"> Inactive
                </label>
                @error('status')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @enderror
              </div>
              <div class="reset-button">
                <a href="#" class="btn btn-warning">Reset</a>
                <button type="submit" class="btn btn-success">{{ isset($data->id)? 'Update':'Add' }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection