@php
  if(isset($_GET['mode']) && $_GET['mode'] == 'pay_in')
    $title = 'Payments In';
  else if(isset($_GET['mode']) && $_GET['mode'] == 'pay_out')
    $title = 'Payments Out';
@endphp

@section('title', $title)
@extends('master')
@section('content-view')

<section class="content-header">
  <div class="header-icon">
    <i class="fa fa-dashboard"></i>
  </div>
  <div class="header-title">
    <h1>Accounts Panel</h1>
    <small>{{ $title }}</small>
  </div>
</section>

<style>
  .receipt {
    margin: 20px;
  }

  .table .table-styles th,
  .table .table-styles td {
    text-align: right;
  }

  .table .table-styles th {
    text-align: left;
  }

  .terms {
    margin-top: 20px;
  }

  .guest-details {
    margin-bottom: 20px;
  }

  .guest-details .row {
    margin-bottom: 3px;
  }

  .guest-details .col-xs-3 {
    padding-right: 0;
  }

  .guest-details .col-xs-9 {
    padding-left: 0;
  }
</style>

<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-bd lobidrag">
        <div class="panel-heading">
          <div class="btn-group">
            {{--<a class="btn btn-add m-r-5" href="{{ url($data['route_name'] . '/create') }}"> <i class="fa fa-plus"></i> Add Property </a>--}}
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
                <input type="text" name="search_query" id="search_query" class="form-control formFilter input-min" placeholder="Search here..." style="width: 135%;">
              </div>
            </div>
            <div class="right-align">
              <div class="form-group p-r-10">
                <select class="form-control formFilter input-min full_width" id="" name="orderBy_name">
                  <option value=""> ---- Choose Sort Column ---- </option>
                  <option value="properties.prop_type">Type</option>
                  <option value="properties.unit_number">Property No</option>
                  <option value="properties.unit_floor">Floor</option>
                  <option value="properties.unit_rent">Rent</option>
                </select>
              </div>
              <div class="form-group">
                <select class="form-control formFilter input-min full_width" id="" name="orderBy_value">
                  <option value=""> ---- Choose Sort Order ---- </option>
                  <option value="ASC">ASC</option>
                  <option value="DESC">DESC</option>
                </select>
              </div>
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

  <!-- Modal -->
  <div class="modal fade" id="update_reservation_popup" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 class="font-20"><i class="fa fa-user m-r-5"></i> Update Reservation Details</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal update_popup" id="upd_reservation" action="" method="POST">
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

  <!-- Modal -->
  <div class="modal fade" id="payables_popup" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 class="font-20"><i class="fa fa-money m-r-5"></i> Pending Dues Details</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" id="add_payment_form" action="{{ url('booking/payments') }}" method="POST">
                @csrf
                <fieldset class="model-ajax-receipts">
                </fieldset>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="pull-right">
            <button type="submit" id="add_payment_btn" class="btn btn-add">Save</button>
            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Modal -->

</section>
@endsection
