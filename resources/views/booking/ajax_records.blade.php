<div class="table-responsive">
  <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
    <thead>
      <tr class="info">
        <th>Sr #</th>
        <th>Guest Name</th>
        <th>Check In/Out</th>
        <th>Property</th>
        <th>Others</th>
        <th>Status</th>
        <th>Charges</th>
        <th>Deposit</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
                    
    @if (isset($data['records']) && count($data['records'])>0)
      @foreach ($data['records'] as $key => $item)
      
        @php
          $sr_no = $key + 1;
          $label_class = get_label_class($item['status']);
          
          if ($data['records']->currentPage()>1) {
            $sr_no = ($data['records']->currentPage()-1)*$data['records']->perPage();
            $sr_no = $sr_no + $key + 1;
          }
        @endphp
        <tr>
          <td>{{ $sr_no }}</td>
          <td>{{ $item->booked_for_user->first_name }} {{ $item->booked_for_user->last_name }}</td>
          <td>
            <strong class="font-sm">Check In: </strong>{{ $item['checkin_date'] }}<br>
            <strong class="font-sm">Check Out: </strong>{{ $item['checkout_date'] }}
          </td>
          <td>
            <strong class="font-sm">Type: </strong>{{ default_value($item->property_data->prop_type, "str") }}<br>
            <strong class="font-sm">No: </strong>{{ default_value($item->property_data->prop_number, "str") }}<br>
            <strong class="font-sm">Floor: </strong>{{ default_value($item->property_data->prop_floor, "str") }}<br>
            <strong class="font-sm">Rent: </strong>{{ default_value($item->property_data->prop_rent, "str") }}
          </td>
          <td>
            <strong class="font-sm">Grace Rent: </strong>{{ default_value($item['grace_rent'], "num") }}<br>
            <strong class="font-sm">Dewa Charges: </strong>{{ default_value($item['dewa_charges'], "num") }}<br>
            <strong class="font-sm">Wifi Charges: </strong>{{ default_value($item['wifi_charges'], "num") }}<br>
            <strong class="font-sm">Admin Charges: </strong>{{ default_value($item['admin_charges'], "num") }}<br>
            <strong class="font-sm">Security Charges: </strong>{{ default_value($item['security_charges'], "num") }}
          </td>
          <td><span class="{{$label_class}} label label-pill">{{$item['status']}}</span></td>
          <td>{{ $item['net_total'] }}</td>
          <td>{{'0'}}</td>
          <td>
            {{-- @if (!$reservations) --}}
              @if (in_array($item['status'], ['Reservation']))
              <button type="button" class="btn btn-add btn-sm update_reservation_btn mb-3" title="Update Reservation" data-item_id="{{$item['id']}}" data-action_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#"><i class="fa fa-pencil"></i></button>
              @endif

              @if (in_array($item['status'], ['Reservation']))
              <button type="button" class="btn btn-danger btn-sm delete_btn mb-3" title="Delete Reservation" data-delete_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#del_reservation_popup"><i class="fa fa-trash-o"></i> </button>
              @endif

              @if (in_array($item['status'], ['Reservation']))
              <button type="button" class="btn btn-purple btn-sm checkin_btn mb-3" title="Check In" data-item_id="{{$item['id']}}" data-metadata="porp={{$item->property_data->id}},resu={{$item->booked_for_user->id}},latot={{$item['net_total']}}"  data-toggle="modal" data-target="#"><i class="fa fa-calendar-plus-o"></i> </button>
              @endif

              @if (in_array($item['status'], ['Reservation']))
              <button type="button" class="btn btn-success btn-sm initial_deposit_btn mb-3" title="Add Payment" data-total="{{$item['net_total']}}" data-item_id="{{$item['id']}}" data-metadata="porp={{$item->property_data->id}},resu={{$item->booked_for_user->id}}"  data-toggle="modal" data-target="#"><i class="fa fa-money"></i> </button>
              @endif
            {{--@else
              {{'N/A'}}
            @endif
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