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
          <td>
            {{-- @if (!$reservations) --}}
              <button type="button" class="btn btn-add btn-sm update_reservation_btn" title="Update Reservation" data-item_id="{{$item['id']}}" data-action_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#"><i class="fa fa-pencil"></i></button>
              <button type="button" class="btn btn-danger btn-sm delete_btn" title="Delete Reservation" data-delete_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#del_reservation_popup"><i class="fa fa-trash-o"></i> </button>
              <button type="button" class="btn btn-danger btn-sm delete_btn" title="Check In" data-delete_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#del_reservation_popup"><i class="fa fa-calendar-plus-o"></i> </button>
              {{-- <button type="button" class="btn btn-violet btn-sm reservation_btn" title="Reservation" data-prop_id="{{$item['id']}}" data-action_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#"><i class="fa fa-calendar-check-o"></i> </button> --}}
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