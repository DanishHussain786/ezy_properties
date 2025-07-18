@php $title = 'List Facility' @endphp

@section('title', $title)
@extends('master')
@section('content-view')
<section class="content-header">
  <div class="header-icon">
    <i class="fa fa-dashboard"></i>
  </div>
  <div class="header-title">
    <h1>Facility Panel</h1>
    <small>{{ $title }}</small>
  </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag">
        <div class="panel-heading">
          <div class="btn-group">
            <a class="btn btn-add m-r-5" id="add_facility" href="{{ url($data['route_name'] . '/create') }}"> <i class="fa fa-plus"></i> Add Facility </a>
            <a class="btn btn-add formReset" href="#"> <i class="fa fa-refresh"></i> Reset Filters </a>
          </div>
        </div>
        <div class="panel-body">
          <form method="GET" id="filterForm" class="filter-form" action="{{ url($data['route_name']) }}">
            @csrf
            <input name="page" id="filterPage" value="1" type="hidden">
            <input class="route_name" value="facility" type="hidden">
            <div class="left-align">
              <div class="form-group m-r-rem">
                <input type="text" name="search_query" id="search_query" class="form-control formFilter input-min" placeholder="Search here..." style="width: 135%;">
              </div>
            </div>
            <div class="form-group right-align">
              <select class="form-control formFilter input-min full_width" id="user_status" name="status">
                <option value="" selected> ---- Select Status ---- </option>
                <option value="Active">Active</option>
                <option value="Block">Block</option>
              </select>
            </div>
          </form>

          @if (Session::has('message'))
            <div class="alert alert-success"><b>Success: </b>{{ Session::get('message') }}</div>
          @endif
          @if (Session::has('error_message'))
            <div class="alert alert-danger"><b>Sorry: </b>{{ Session::get('error_message') }}</div>
          @endif

          <div id="table_data" class="dynamic_data">
            {{ $data['html'] }}
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="facility_popup" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 class="font-20"><i class="fa fa-user m-r-5"></i> Add Facility</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" id="manage-facility" action="{{ url('facility') }}" method="POST">
                {{-- @method('POST') --}}
                @csrf
                <fieldset>
                  <div class="form-group col-md-4 col-sm-6">
                    <label>Facility Type</label>
                    <select class="validity_type form-control full_width @error('validity_type') is-invalid @enderror" id="validity_type" name="validity_type" required>
                      <option value=""> ---- Choose any option ---- </option>
                      <option value="One-Time"> One-Time </option>
                      <option value="Monthly"> Monthly </option>
                      <option value="Yearly"> Yearly </option>
                      {{-- @if (isset($all_floors) && count($all_floors) > 0 )
                        @foreach ($all_floors as $key => $validity_type)
                          <option {{ old('validity_type') == $validity_type || (isset($data->validity_type) && $data->validity_type == $validity_type) ? 'selected': '' }} value="{{$validity_type}}"> {{$validity_type}} </option>
                        @endforeach
                      @endif --}}
                    </select>
                  </div>

                  <div class="form-group col-md-4 col-sm-6">
                    <label>Title</label>
                    <input type="text" name="title" value="{{old('title', isset($data->title)? $data->title: '')}}" class="title form-control @error('title') is-invalid @enderror full_width" placeholder="Facility title or name">
                    @error('title')
                    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                    @else
                    <span class="invalid-feedback" role="alert"></span>
                    @enderror
                  </div>

                  <div class="form-group col-md-4 col-sm-6">
                    <label>Description</label>
                    <input type="text" name="description" value="{{old('description', isset($data->description)? $data->description: '')}}" class="description form-control @error('description') is-invalid @enderror full_width" placeholder="Facility description or information">
                    @error('description')
                    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                    @else
                    <span class="invalid-feedback" role="alert"></span>
                    @enderror
                  </div>

                  <div class="form-group col-md-4 col-sm-6">
                    <label>Cost (AED)</label>
                    <input type="text" name="amount" id="amount" value="" class="amount form-control full_width only_numbers @error('amount') is-invalid @enderror" placeholder="Amount/cost of facility" required>
                    @error('amount')
                    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                    @else
                    <span class="invalid-feedback" role="alert"></span>
                    @enderror
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="pull-right">
            <button type="button" id="add_facility_btn" class="btn btn-add">Save</button>
            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Modal -->

  <!-- Modal -->
  <div class="modal fade" id="del_user_popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 class="font-20"><i class="fa fa-user m-r-5"></i> Delete User</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal delete_popup" action="" method="POST">
                @method('DELETE')
                @csrf
                <fieldset>
                  <div class="col-md-12 form-group user-form-group">
                    <label style="font-weight: 500;" class="control-label">Are you sure to delete user?</label>
                    <div class="pull-right">
                      <button type="button" class="btn btn-danger btn-sm">No</button>
                      <button type="submit" class="btn btn-add btn-sm">Yes</button>
                    </div>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal -->
  <div class="modal fade" id="update_facility_popup" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 class="font-20"><i class="fa fa-user m-r-5"></i> Update Facility Details</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal update_popup" id="upd_facility" action="" method="POST">
                @method('PUT')
                @csrf
                <fieldset class="model-ajax">
                </fieldset>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Modal -->
</section>
@endsection
