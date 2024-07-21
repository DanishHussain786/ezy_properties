@php $title = 'List User' @endphp

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

<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag">
        <div class="panel-heading">
          <div class="btn-group">
            <a class="btn btn-add m-r-5" href="{{ url($data['route_name'] . '/create') }}"> <i class="fa fa-plus"></i> Add User </a>
            <a class="btn btn-add formReset" href="#"> <i class="fa fa-refresh"></i> Reset Filters </a>
          </div>
        </div>
        <div class="panel-body">
          <form method="GET" id="filterForm" class="filter-form" action="{{ url($data['route_name']) }}">
            @csrf
            <input name="page" id="filterPage" value="1" type="hidden">
            <input class="route_name" value="user" type="hidden">
            <div class="left-align">
              <div class="form-group m-r-rem">
                <input type="text" name="search_user" id="search_user" class="form-control formFilter input-min" placeholder="Search here..." style="width: 135%;">
              </div>
            </div>
            <div class="form-group right-align">
              <select class="form-control formFilter input-min" id="user_status" name="status">
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

          <div id="table_data">
            {{ $data['html'] }}
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- customer Modal1 -->
  <div class="modal fade" id="customer1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3><i class="fa fa-user m-r-5"></i> Update Customer</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal">
                <fieldset>
                  <!-- Text input-->
                  <div class="col-md-4 form-group">
                    <label class="control-label">Customer Name:</label>
                    <input type="text" placeholder="Customer Name" class="form-control">
                  </div>
                  <!-- Text input-->
                  <div class="col-md-4 form-group">
                    <label class="control-label">Email:</label>
                    <input type="email" placeholder="Email" class="form-control">
                  </div>
                  <!-- Text input-->
                  <div class="col-md-4 form-group">
                    <label class="control-label">Mobile</label>
                    <input type="number" placeholder="Mobile" class="form-control">
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="control-label">Address</label><br>
                    <textarea name="address" rows="3"></textarea>
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="control-label">type</label>
                    <input type="text" placeholder="type" class="form-control">
                  </div>
                  <div class="col-md-12 form-group user-form-group">
                    <div class="pull-right">
                      <button type="button" class="btn btn-danger btn-sm">Cancel</button>
                      <button type="submit" class="btn btn-add btn-sm">Save</button>
                    </div>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <!-- Modal -->
  <!-- Customer Modal2 -->
  <div class="modal fade" id="del_user_popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3><i class="fa fa-user m-r-5"></i> Delete Customer</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal delete_popup" action="" method="POST">
                @method('delete')
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
</section>
@endsection