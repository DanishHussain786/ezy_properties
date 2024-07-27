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

              <!-- Section 3 -->
              <fieldset>
                <legend>Company Details</legend>
                <div class="form-group col-md-4 col-sm-6">
                  <label>Full Name</label>
                  <input type="text" name="c_name" value="{{old('c_name', isset($data->c_name)? $data->c_name: '')}}" class="form-control @error('c_name') is-invalid @enderror" placeholder="Enter company full name">
                  @error('c_name')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                  @else
                  <span class="invalid-feedback" role="alert"></span>
                  @enderror
                </div>
                <div class="form-group col-md-4 col-sm-6">
                  <label>Email Address</label>
                  <input type="email" name="c_email" value="{{old('c_email', isset($data->c_email)? $data->c_email: '')}}" class="form-control @error('c_email') is-invalid @enderror" placeholder="Enter company email address">
                  @error('c_email')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                  @else
                  <span class="invalid-feedback" role="alert"></span>
                  @enderror
                </div>
                <div class="form-group col-md-4 col-sm-6">
                  <label>Office Contact</label>
                  <input type="email" name="c_office_ph" value="{{old('c_office_ph', isset($data->c_office_ph)? $data->c_office_ph: '')}}" class="form-control @error('c_office_ph') is-invalid @enderror" placeholder="Enter company office contact">
                  @error('c_office_ph')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                  @else
                  <span class="invalid-feedback" role="alert"></span>
                  @enderror
                </div>
                <div class="form-group col-md-4 col-sm-6">
                  <label>Landline Contact</label>
                  <input type="email" name="c_mobile_ph" value="{{old('c_mobile_ph', isset($data->c_mobile_ph)? $data->c_mobile_ph: '')}}" class="form-control @error('c_mobile_ph') is-invalid @enderror" placeholder="Enter company office contact">
                  @error('c_mobile_ph')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                  @else
                  <span class="invalid-feedback" role="alert"></span>
                  @enderror
                </div>
                <div class="form-group col-md-8 col-sm-6">
                  <label>Address</label>
                  <textarea name="c_address" class="form-control @error('c_address') is-invalid @enderror" rows="4">{{old('c_address', isset($data->c_address)? $data->c_address: '')}}</textarea>
                  @error('c_address')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                  @else
                  <span class="invalid-feedback" role="alert"></span>
                  @enderror
                </div>
              </fieldset>

              <fieldset>
                <legend>Company Logos and Receipts</legend>
                @if(isset($data->c_logo) && !empty($data->c_logo))
                @php $img_path = $data->c_logo; @endphp
                @else
                @php $img_path = ""; @endphp
                @endif
                <div class="form-group col-md-4 col-sm-6">
                  <label for="c_logo">Logo</label>
                  <div class="input-group" style="width: 95%; display: inline-flex;">
                    <div class="display_images">
                      <a data-fancybox="demo" class="form-control" style="padding: 0px !important;"><img title="{{ $img_path }}" src="{{ is_image_exist($img_path, 'profile') }}" height="100" onclick="showModal(this.src)"></a>
                    </div>
                    <input type="file" id="c_logo" class="form-control" placeholder="Company Logo" name="c_logo">
                    @error('c_logo')
                    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                    @else
                    <span class="invalid-feedback" role="alert"></span>
                    @enderror
                  </div>
                </div>
              </fieldset>
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