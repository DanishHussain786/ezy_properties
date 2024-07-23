@if (isset($data->id))
  @php $title = 'Update User' @endphp
@else
  @php $title = 'Add User' @endphp
@endif

@section('title', $title)
@extends('master')
@section('content-view')
  <section class="content-header">
    <div class="header-icon">
      <i class="fa fa-dashboard"></i>
    </div>
    <div class="header-title">
      <h1>User Panel</h1>
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
                <i class="fa fa-list"></i> User List 
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

              <div class="form-group col-md-4 col-sm-6">
                <label>First Name</label>
                <input type="text" name="first_name" value="{{old('first_name', isset($data->first_name)? $data->first_name: '')}}" class="form-control @error('first_name') is-invalid @enderror" placeholder="Enter first name">
                @error('first_name')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>
              <div class="form-group col-md-4 col-sm-6">
                <label>Last Name</label>
                <input type="text" name="last_name" value="{{old('last_name', isset($data->last_name)? $data->last_name: '')}}" class="form-control @error('last_name') is-invalid @enderror" placeholder="Enter last name">
                @error('last_name')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>
              
              <div class="form-group col-md-4 col-sm-6">
                <label>Role</label>
                <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                  <option value=""> ---- Choose any role ---- </option>
                  @if (isset($data['roles']) && count($data['roles']) > 0 )
                    @foreach ($data['roles'] as $key => $role)
                      <option {{ old('role') == $role || (isset($data->role) && $data->role == $role) ? 'selected': '' }} value="{{$role}}"> {{$role}} </option>
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
                <label>Email</label>
                <input type="email" name="email" value="{{old('email', isset($data->email)? $data->email: '')}}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email address">
                @error('email')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              @if(isset($data->profile_photo) && !empty($data->profile_photo))
                @php $img_path = $data->profile_photo; @endphp
              @else
                @php $img_path = ""; @endphp
              @endif
              <div class="form-group col-md-4 col-sm-6">
                <label for="profile_photo">Photo</label>
                <div class="input-group" style="width: 95%; display: inline-flex;">
                  <div class="display_images">
                    <a data-fancybox="demo" class="form-control" style="padding: 0px !important;"><img title="{{ $img_path }}" src="{{ is_image_exist($img_path, 'profile') }}" height="100" onclick="showModal(this.src)"></a>
                  </div>
                  <input type="file" id="profile_photo" class="form-control" placeholder="Profile Image" name="profile_photo">
                  @error('profile_photo')
                    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                  @else
                    <span class="invalid-feedback" role="alert"></span>
                  @enderror
                </div>
              </div>

              <div class="form-group col-md-4 col-sm-6">
                <label>Contact Number</label>
                <input type="number" name="contact_no" value="{{old('contact_no', isset($data->contact_no)? $data->contact_no: '')}}" class="form-control @error('contact_no') is-invalid @enderror" placeholder="Enter mobile number">
                @error('contact_no')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              @if(isset($data->passport_photo) && !empty($data->passport_photo))
                @php $img_path = $data->passport_photo; @endphp
              @else
                @php $img_path = ""; @endphp
              @endif
              <div class="form-group col-md-4 col-sm-6">
                <label>Passport Photo</label>
                <div class="input-group" style="width: 95%; display: inline-flex;">
                  <div class="display_images">
                    <a data-fancybox="demo" class="form-control" style="padding: 0px !important;"><img title="{{ $img_path }}" src="{{ is_image_exist($img_path) }}" height="100" onclick="showModal(this.src)"></a>
                  </div>
                  <input type="file" id="passport_photo" class="form-control" placeholder="Profile Image" name="passport_photo">
                </div>
                @error('passport_photo')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group col-md-4 col-sm-6">
                <label>Passport No</label>
                <input type="text" name="passport_id" value="{{old('passport_id', isset($data->passport_id)? $data->passport_id: '')}}" class="form-control @error('passport_id') is-invalid @enderror" placeholder="Enter passport no">
                @error('passport_id')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              @if(isset($data->emirates_photo) && !empty($data->emirates_photo))
                @php $img_path = $data->emirates_photo; @endphp
              @else
                @php $img_path = ""; @endphp
              @endif
              <div class="form-group col-md-4 col-sm-6">
                <label>Emirates ID Photo</label>
                <div class="input-group" style="width: 95%; display: inline-flex;">
                  <div class="display_images">
                    <a data-fancybox="demo" class="form-control" style="padding: 0px !important;"><img title="{{ $img_path }}" src="{{ is_image_exist($img_path) }}" height="100" onclick="showModal(this.src)"></a>
                  </div>
                  <input type="file" id="emirates_photo" class="form-control" placeholder="Profile Image" name="emirates_photo">
                </div>
                @error('emirates_photo')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group col-md-4 col-sm-6">
                <label>Emirates ID</label>
                <input type="text" name="emirates_id" value="{{old('emirates_id', isset($data->emirates_id)? $data->emirates_id: '')}}" class="form-control @error('emirates_id') is-invalid @enderror" placeholder="Enter emirates id">
                @error('emirates_id')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group col-md-4 col-sm-6">
                <label>Date of Birth</label>
                <input id="minMaxExample" type="text" name="dob" value="{{old('dob', isset($data->dob)? $data->dob: '')}}" class="form-control @error('dob') is-invalid @enderror" placeholder="Enter date of birth">
                @error('dob')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>
              
              <div class="form-group col-md-4 col-sm-6">
                <label>Home Address</label>
                <textarea name="home_address" class="form-control @error('home_address') is-invalid @enderror" rows="4">{{old('home_address', isset($data->home_address)? $data->home_address: '')}}</textarea>
                @error('home_address')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group skin-square col-md-4 col-sm-6">
                <label>Gender</label><br>                
                <div class="radio-boxes">
                  <div class="i-check">
                    <input tabindex="11" type="radio" id="gender-1" value="Male" class="form-control @error('gender') is-invalid @enderror" name="gender" {{ old('gender', isset($data->gender) && $data->gender == 'Male' ? 'Male' : '') == 'Male' ? 'checked' : '' }}>
                    <label for="gender-1">Male</label>
                  </div>
                  <div class="i-check p-l-20">
                    <input tabindex="12" type="radio" id="gender-2" value="Female" class="form-control @error('gender') is-invalid @enderror" name="gender" {{ old('gender', isset($data->gender) && $data->gender == 'Female' ? 'Female' : '') == 'Female' ? 'checked' : '' }}>
                    <label for="gender-2">Female</label>
                  </div>
                </div>
                @error('gender')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group skin-square col-md-4 col-sm-6">
                <label>Status</label><br>                
                <div class="radio-boxes">
                  <div class="i-check">
                    <input tabindex="11" type="radio" id="status-1" value="Active" class="form-control @error('status') is-invalid @enderror" name="status" {{ old('status', isset($data->status) && $data->status == 'Active' ? 'Active' : '') == 'Active' ? 'checked' : '' }}>
                    <label for="status-1">Active</label>
                  </div>
                  <div class="i-check p-l-20">
                    <input tabindex="12" type="radio" id="status-2" value="Block" class="form-control @error('status') is-invalid @enderror" name="status" {{ old('status', isset($data->status) && $data->status == 'Block' ? 'Block' : '') == 'Block' ? 'checked' : '' }}>
                    <label for="status-2">Block</label>
                  </div>
                </div>
                @error('status')
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