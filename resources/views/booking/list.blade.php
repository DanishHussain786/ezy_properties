@php $title = 'List Bookings' @endphp

@section('title', $title)
@extends('master')
@section('content-view')

<section class="content-header">
  <div class="header-icon">
    <i class="fa fa-dashboard"></i>
  </div>
  <div class="header-title">
    <h1>Bookings Panel</h1>
    <small>{{ $title }}</small>
  </div>
</section>

<style>
  .summary-row {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 10px;
  }

  .summary-label {
    text-align: left;
    margin-bottom: 3px;
  }

  .summary-value {
    text-align: right;
    margin-bottom: 3px;
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
                  <option value="properties.prop_number">Property No</option>
                  <option value="properties.prop_floor">Floor</option>
                  <option value="properties.prop_rent">Rent</option>
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
          <h3><i class="fa fa-user m-r-5"></i> Update Reservation Details</h3>
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
  <div class="modal fade" id="del_reservation_popup" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3><i class="fa fa-user m-r-5"></i> Delete Reservation</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal delete_popup" action="" method="POST">
                @method('DELETE')
                @csrf
                <fieldset>
                  <div class="col-md-12 form-group user-form-group">
                    <label style="font-weight: 500;" class="control-label">Are you sure to delete reservation?</label>
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
  <div class="modal fade" id="checkin_popup" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3><i class="fa fa-user m-r-5"></i> Check-In Details</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" id="create_checkin" action="" method="">
                @csrf
                <fieldset>
                  <input type="hidden" value="" id="book_id" name="book_id">
                  <input type="hidden" value="" id="prop_id" name="prop_id">
                  <input type="hidden" value="" id="user_id" name="user_id">
                  <div class="form-group col-md-4 col-sm-6 col-xs-12">
                    <label class="control-label">Charges</label>
                    <input type="number" value="" name="tot_payable" placeholder="Enter payable charges" class="form-control full_width tot_payable" readonly>
                  </div>
                  <div class="form-group col-md-4 col-sm-6 col-xs-12">
                    <label class="control-label">VAT (5%)</label>
                    <select class="form-control full_width" id="vat_apply" name="vat_apply">
                      <option value="No" selected> No </option>
                      <option value="Inclusive"> Inclusive </option>
                      <option value="Exclusive"> Exclusive </option>
                    </select>
                  </div>
                  <div class="form-group col-md-4 col-sm-6 col-xs-12">
                    <label class="control-label">Discount</label>
                    <input type="text" value="" id="discount" name="discount" placeholder="Enter discount amount" class="form-control full_width only_numbers">
                  </div>
                  <div class="form-group col-md-4 col-sm-6 col-xs-12">
                    <label class="control-label">Pay Method</label>
                    <select class="form-control full_width" id="pay_with" name="pay_with">
                      <option value="Cash" selected> Cash </option>
                      <option value="Online"> Online </option>
                      <option value="Credit-Card"> Credit Card </option>
                      <option value="Bank-Transfer"> Bank Transfer </option>
                      <option value="Cheque"> Cheque </option>
                    </select>
                  </div>
                  <div class="form-group col-md-4 col-sm-6 col-xs-12">
                    <label class="control-label">Amount Paid</label>
                    <input type="text" value="" id="amt_pay" name="amt_pay" placeholder="Enter total amount paid" class="form-control full_width only_numbers">
                  </div>
                  <div class="form-group col-md-4 col-sm-6 col-xs-12">
                    <label class="control-label">Any comments</label>
                    <input type="text" value="" id="comments" name="comments" placeholder="Enter any description or comments" class="form-control full_width">
                  </div>

                  <div class="col-md-7"></div>
                  <div class="col-md-5 text-right" style="padding-top: 15px; display: grid;">
                    <div class="summary-row">
                      <p class="summary-label"><strong>Sub Total:</strong></p>
                      <p class="summary-value" id="sum_st">0</p>
                    </div>
                    <div class="summary-row">
                      <p class="summary-label"><strong>VAT (5%):</strong></p>
                      <p class="summary-value" id="sum_vat">0</p>
                    </div>
                    <div class="summary-row">
                      <p class="summary-label"><strong>Discount:</strong></p>
                      <p class="summary-value" id="sum_disc">0</p>
                    </div>
                    <div class="summary-row">
                      <p class="summary-label"><strong>Grand Total:</strong></p>
                      <p class="summary-value" id="sum_gt">0</p>
                    </div>
                    <div class="summary-row">
                      <p class="summary-label"><strong>Total Paid:</strong></p>
                      <p class="summary-value" id="sum_tp">0</p>
                    </div>
                    <div class="summary-row">
                      <p class="summary-label"><strong>Balance:</strong></p>
                      <p class="summary-value" id="sum_bal">0</p>
                    </div>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="pull-right">
            <button type="submit" id="do_checkin_btn" class="btn btn-add">Save</button>
            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Modal -->

  <!-- Modal -->
  <div class="modal fade" id="payment_popup" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3><i class="fa fa-user m-r-5"></i> Add Payment</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" id="add_payment_form" action="{{ url('booking/payments') }}" method="POST">
                @csrf
                <fieldset>
                  <input type="hidden" value="initial_dep" id="paying_for" name="paying_for">
                  <!-- <input type="hidden" value="" id="prop_id" name="prop_id">
                  <input type="hidden" value="" id="user_id" name="user_id"> -->
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label">Charges</label>
                    <input type="number" value="" name="tot_payable" placeholder="Enter payable charges" class="form-control full_width tot_payable" readonly>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label">Pay Method</label>
                    <select class="form-control full_width" id="pay_with" name="pay_with">
                      <option value="Cash" selected> Cash </option>
                      <option value="Online"> Online </option>
                      <option value="Credit-Card"> Credit Card </option>
                      <option value="Bank-Transfer"> Bank Transfer </option>
                      <option value="Cheque"> Cheque </option>
                    </select>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label">Initial Deposit</label>
                    <input type="text" value="" id="amt_pay" name="amt_pay" placeholder="Enter total amount paid" class="form-control full_width only_numbers">
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label">Any comments</label>
                    <input type="text" value="" id="comments" name="comments" placeholder="Enter any description or comments" class="form-control full_width">
                  </div>
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