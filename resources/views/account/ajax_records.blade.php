<div class="table-responsive">
  <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
    <thead>
      <tr class="info">
        <th>Sr #</th>
        <th>Booking Id</th>
        <th>Guest Name</th>
        <th>Discount</th>
        <th>Balance</th>
        <th>Total<br>Payable</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
                    
    @if (isset($data['records']) && count($data['records'])>0)
      @foreach ($data['records'] as $key => $item)
      
        @php
          $sr_no = $key + 1;
          //$init_dep = 0;
          //$last_paid = 'N/A';
          //if ($item->transaction_data()->exists()) {
          //  if ($item->transaction_data->type == 'Initial-Deposit') {
          //    $init_dep = $item->transaction_data->amount;
          //    $last_paid = $item->transaction_data->created_at;
          //  }
          //}
          
          if ($data['records']->currentPage()>1) {
            $sr_no = ($data['records']->currentPage()-1)*$data['records']->perPage();
            $sr_no = $sr_no + $key + 1;
          }
        @endphp
        <tr>
          <td>{{ $sr_no }}</td>
          <td>{{ $item['booked_id'] }}</td>
          <td>{{ $item->booked_for_user->first_name }} {{ $item->booked_for_user->last_name }}</td>
          <td>{{ $item['disc_rent'] }}</td>
          <td>{{ $item['balance'] }}</td>
          <td>{{ $item['total_payable'] }}</td>
          <td>
            <button type="button" class="btn btn-add btn-sm view_payables mb-3" title="View Payment Receipt" data-item_id="{{$item['id']}}" data-action_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#"><i class="fa fa-eye"></i></button>

            <button type="button" class="btn btn-success btn-sm initial_deposit_btn mb-3" title="Add Payment" data-total="{{$item['total_payable']}}" data-item_id="{{$item['id']}}" data-metadata="porp={{$item->property_data->id}},resu={{$item->booked_for_user->id}}"  data-toggle="modal" data-target="#"><i class="fa fa-money"></i> </button>

            {{--
            <button type="button" class="btn btn-purple btn-sm checkin_btn mb-3" title="Check In" data-item_id="{{$item['id']}}" data-metadata="porp={{$item->property_data->id}},resu={{$item->booked_for_user->id}},latot={{$item['total_payable']}}"  data-toggle="modal" data-target="#"><i class="fa fa-calendar-plus-o"></i> </button>
            --}}
          </td>
        </tr>
      @endforeach
    @endif
    </tbody>
  </table>
  
  <div class="pagination_links">
    @if (isset($data['records']) && count($data['records'])>0)
      {{ $data['records']->links('vendor.pagination.bootstrap-4') }}
    @else
      <div class="alert alert-primary">Don't have records!</div>
    @endif
  </div>
</div>