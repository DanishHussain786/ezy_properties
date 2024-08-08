<div class="table-responsive">
  <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
    <thead>
      <tr class="info">
        <th>Sr #</th>
        <th>Guest Name</th>
        <th>Check In/Out</th>
        <th>Property</th>
        <th>Others</th>
        <th>Charges</th>
        <th>Action</th>
        {{--
        <th>Check-Out</th>
        --}}
      </tr>
    </thead>
    <tbody>
                    
    @if (isset($data['records']) && count($data['records'])>0)
      @foreach ($data['records'] as $key => $item)
      
        @php
          $sr_no = $key + 1;
          //if ($item->reservations_data()->exists()) {
            //$reservations = true;
            //if ($item['reservations_data']['status'] == 'Reservation')
            //  $label_class = "label-primary";
            //else if ($item['reservations_data']['status'] == 'CheckIn')
            //  $label_class = "label-warning";
            //else if ($item['reservations_data']['status'] == 'CheckOut')
            //  $label_class = "label-custom";
            //else if ($item['reservations_data']['status'] == 'OverStay')
            //  $label_class = "label-danger";
          //}
          //else {
            //$label_class = "label-success";
            //$reservations = false;
          //}

          if ($data['records']->currentPage()>1) {
            $sr_no = ($data['records']->currentPage()-1)*$data['records']->perPage();
            $sr_no = $sr_no + $key + 1;
          }
        @endphp
        <tr>
          <td>{{ $sr_no }}</td>
          <td>{{ $item->booked_for_user->first_name }} {{ $item->booked_for_user->last_name }}</td>
          <td>
            <strong>Check In: </strong>{{ $item['checkin_date'] }}<br>
            <strong>Check Out: </strong>{{ $item['checkout_date'] }}
          </td>
          <td>
            <strong>Type: </strong>{{ default_value($item->property_data->prop_type, "str") }}<br>
            <strong>No: </strong>{{ default_value($item->property_data->prop_number, "str") }}<br>
            <strong>Floor: </strong>{{ default_value($item->property_data->prop_floor, "str") }}<br>
            <strong>Rent: </strong>{{ default_value($item->property_data->prop_rent, "str") }}
          </td>
          <td>
            <strong>Grace Rent: </strong>{{ default_value($item['grace_rent'], "str") }}<br>
            <strong>Dewa Charges: </strong>{{ default_value($item['dewa_charges'], "str") }}<br>
            <strong>Wifi Charges: </strong>{{ default_value($item['wifi_charges'], "str") }}<br>
            <strong>Admin Charges: </strong>{{ default_value($item['admin_charges'], "str") }}<br>
            <strong>Security Charges: </strong>{{ default_value($item['security_charges'], "str") }}
          </td>
          <td>{{ $item['net_total'] }}</td>
          {{--<td>{{ $item['prop_rent'] }}</td>
          @if (!$reservations)
          <td><span class="{{$label_class}} label label-pill">{{'Available'}}</span></td>
          @else
          <td><span class="{{$label_class}} label label-pill">{{$item['reservations_data']['status']}}</span></td>
          @endif
          --}}
          <td>
            {{-- @if (!$reservations) --}}
              <button type="button" class="btn btn-add btn-sm m-1 update_reservation_btn" title="Update Reservation" data-prop_id="{{$item['id']}}" data-action_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#"><i class="fa fa-pencil"></i></button>
              <button type="button" class="btn btn-danger btn-sm m-1 delete_btn" title="Delete Reservation" data-delete_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#del_property_popup"><i class="fa fa-trash-o"></i> </button>
              {{-- <button type="button" class="btn btn-violet btn-sm m-1 reservation_btn" title="Reservation" data-prop_id="{{$item['id']}}" data-action_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#"><i class="fa fa-calendar-check-o"></i> </button> --}}
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