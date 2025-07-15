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
            <form class="form col-sm-12" id="fae-property" action="{{ route($data['route_name'].'.update', $data->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            <input type="hidden" name="update_id" value="{{$data->id}}">
            @else
            <form class="form col-sm-12" id="fae-property" action="{{ route($data['route_name'].'.store') }}" method="POST" enctype="multipart/form-data">
            @endif
            @csrf

              <div class="form-group col-md-3 col-sm-6 is-required">
                <label>Property Name</label>
                <input type="text" name="prop_title" id="prop_title" value="{{old('prop_title', isset($data->prop_title)? $data->prop_title: '')}}" class="form-control full_width @error('prop_title') is-invalid @enderror" placeholder="Enter property address" required>
                @error('prop_title')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group col-md-3 col-sm-6 is-required">
                <label>Property Desc.</label>
                <input type="text" name="prop_description" id="prop_description" value="{{old('prop_description', isset($data->prop_description)? $data->prop_description: '')}}" class="form-control full_width @error('prop_description') is-invalid @enderror" placeholder="Enter property address" required>
                @error('prop_description')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group col-md-3 col-sm-6 is-required">
                <label>Property Type</label>
                <select class="select2_field form-control full_width @error('prop_type') is-invalid @enderror" id="prop_type" name="prop_type" required>
                  <option value=""> ---- Choose any option ---- </option>
                  @if (isset($data['prop_types']) && count($data['prop_types']) > 0 )
                    @foreach ($data['prop_types'] as $key => $type)
                      <option {{ old('prop_type') == $type || (isset($data->prop_type) && $data->prop_type == $type) ? 'selected': '' }} value="{{$type}}"> {{$type}} </option>
                    @endforeach
                  @endif
                </select>
                @error('prop_type')
                  <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                  <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group col-md-3 col-sm-6 is-required">
                <label>Property Address</label>
                <input type="text" name="prop_address" id="prop_address"
                  value="{{old('prop_address', isset($data->prop_address)? $data->prop_address: '')}}"
                  class="form-control full_width @error('prop_address') is-invalid @enderror" placeholder="Enter property address"
                  required>
                @error('prop_address')
                <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                @else
                <span class="invalid-feedback" role="alert"></span>
                @enderror
              </div>

              <div class="form-group action-buttons col-sm-12" style="text-align: center; padding: 10px;">
                <button type="button" class="handle_property btn btn-success">{{ isset($data->id) ? 'Update':'Add' }}</button>
                {{-- <a href="" class="btn btn-warning">Reset</a> --}}
              </div>

              <div class="prop_content"></div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="prop_units_popup" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header modal-header-primary">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3><i class="fa fa-user m-r-5"></i> Add Property Units</h3>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <form class="form-horizontal" id="create_reservation" action="" method="">
                  @method('POST')
                  @csrf
                  <fieldset class="model-ajax">
                    @php $all_floors = get_floors(); @endphp
                    <div class="form-group col-md-4 col-sm-6 is-required">
                      <label class="control-label">Floor No.</label>
                      <select class="select2_field form-control full_width" id="prop_floor" name="prop_floor">
                        <option value=""> ---- Choose any option ---- </option>
                        @if (isset($all_floors) && count($all_floors) > 0 )
                          @foreach ($all_floors as $key => $prop_floor)
                            <option {{ old('prop_floor') == $prop_floor || (isset($data->prop_floor) && $data->prop_floor == $prop_floor) ? 'selected': '' }} value="{{$prop_floor}}"> {{$prop_floor}} </option>
                          @endforeach
                        @endif
                      </select>
                    </div>

                    <div class="form-group col-md-4 col-sm-6 is-required">
                      <label>Rent (AED)</label>
                      <input type="text" name="prop_rent" id="prop_rent" value="" class="form-control full_width only_numbers @error('prop_rent') is-invalid @enderror" placeholder="Enter property rental cost" required>
                      @error('prop_rent')
                      <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                      @else
                      <span class="invalid-feedback" role="alert"></span>
                      @enderror
                    </div>

                    {{-- <div class="table-responsive">
                      <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                        <thead>
                          <tr class="info">
                            <th>Task Name</th>
                            <th>Due date</th>
                            <th>Description</th>
                            <th>Assign to</th>
                            <th>status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>networking</td>
                            <td>01/05/2017</td>
                            <td>Lan,wifi config</td>
                            <td>Smith</td>
                            <td>
                              <span class="label-custom label label-default">completed</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-add btn-xs" data-toggle="modal" data-target="#update"><i
                                  class="fa fa-pencil"></i></button>
                              <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delt"><i
                                  class="fa fa-trash-o"></i> </button>
                            </td>
                          </tr>
                          <tr>
                            <td>Accounts</td>
                            <td>01/05/2017</td>
                            <td>Financial supports</td>
                            <td>lon jacob</td>
                            <td>
                              <span class="label-warning label label-default">waitnng</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-add btn-xs" data-toggle="modal" data-target="#update"><i class="fa fa-pencil"></i></button>
                              <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delt"><i class="fa fa-trash-o"></i> </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div> --}}
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="pull-right">
              <button type="submit" id="add_res_btn" class="btn btn-add">Save</button>
              <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.Modal -->

  </section>
@endsection
