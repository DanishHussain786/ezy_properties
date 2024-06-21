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
            <form class="col-sm-12">
              @if (Session::has('message'))
                <div class="alert alert-success"><b>Success: </b>{{ Session::get('message') }}</div>
              @endif
              @if (Session::has('error_message'))
                <div class="alert alert-danger"><b>Sorry: </b>{{ Session::get('error_message') }}</div>
              @endif
              <div class="form-group col-sm-6">
                <label>First Name</label>
                <input type="text" class="form-control" placeholder="Enter First Name" required>
                @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>Last Name</label>
                <input type="text" class="form-control" placeholder="Enter Last Name" required>
                @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>User Role</label>
                <select class="form-control">
                  <option>Manager</option>
                  <option>Agent</option>
                  <option>Customer</option>
                </select>
                @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>Email</label>
                <input type="email" class="form-control" placeholder="Enter Email" required>
                @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group col-sm-6">
                <label>Emirates ID</label>
                <input type="text" class="form-control" placeholder="Enter Last Name" required>
                @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group col-sm-6">
                <label>Passport No</label>
                <input type="text" class="form-control" placeholder="Enter Last Name" required>
                @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>



              <div class="form-group col-sm-6">
                <label>Mobile</label>
                <input type="number" class="form-control" placeholder="Enter Mobile" required>
                @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
              <div class="form-group col-sm-6">
                <label>Picture upload</label>
                <input type="file" name="picture">
                <input type="hidden" name="old_picture">
                @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
              
              <div class="form-group col-sm-6">
                <label>Date of Birth</label>
                <input id="minMaxExample" type="text" class="form-control" placeholder="Enter Date...">
              </div>
              <div class="form-group col-sm-6">
                <label>Address</label>
                <textarea class="form-control" rows="3" required></textarea>
              </div>
              <div class="form-group col-sm-6">
                <label>Customer Type</label>
                <select class="form-control">
                  <option>vendor</option>
                  <option>vip</option>
                  <option>regular</option>
                </select>
              </div>
              <div class="form-group col-sm-6">
                <label>Sex</label><br>
                <label class="radio-inline"><input name="sex" value="1" checked="checked" type="radio"> Male</label> 
                <label class="radio-inline"><input name="sex" value="0" type="radio"> Female</label>
              </div>
              <div class="form-group col-sm-6">
                <label>Status</label><br>
                <label class="radio-inline">
                  <input type="radio" name="status" value="1" checked="checked"> Active
                </label>
                <label class="radio-inline">
                  <input type="radio" name="status" value="0"> Inactive
                </label>
              </div>
              <div class="reset-button">
                <a href="#" class="btn btn-warning">Reset</a>
                <a href="#" class="btn btn-success">Save</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection