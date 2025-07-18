<div class="table-responsive">
  <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
    <thead>
      <tr class="info">
        <th>Sr #</th>
        <th>Type</th>
        <th>Property No.</th>
        <th>Floor</th>
        <th>Other<br>Charges</th>
        <th>Gross Rent</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>

    @if(isset($data->emirates_photo) && !empty($data->emirates_photo))
    @php $img_path = $data->emirates_photo; @endphp
    @else
    @php $img_path = ""; @endphp
    @endif

    @if (isset($data['records']) && count($data['records'])>0)
      @foreach ($data['records'] as $key => $item)

        @php
          $sr_no = $key + 1;
          $label_class = get_label_class($item['prop_status']);
          if ($data['records']->currentPage()>1) {
            $sr_no = ($data['records']->currentPage()-1)*$data['records']->perPage();
            $sr_no = $sr_no + $key + 1;
          }
        @endphp
        <tr>
          <td>{{ $sr_no }}</td>
          <td>{{ $item['prop_type'] }}</td>
          <td>{{ isset($item['unit_number']) ? $item['unit_number'] : "N/A" }}</td>
          <td>{{ $item['unit_floor'] }}</td>
          <td>
            <strong class="font-sm">Basic Rent: </strong>{{ default_value($item['unit_rent'], "num") }}<br>
            <strong class="font-sm">Dewa Charges: </strong>{{ default_value($item['dewa_charges'], "num") }}<br>
            <strong class="font-sm">Wifi Charges: </strong>{{ default_value($item['wifi_charges'], "num") }}<br>
            <strong class="font-sm">Misc Charges: </strong>{{ default_value($item['misc_charges'], "num") }}<br>
          </td>
          <td>{{ $item['prop_net_rent'] }}</td>
          <td><span class="{{$label_class}} label label-pill">{{$item['prop_status']}}</span></td>
          <td>
            <button type="button" class="btn btn-add btn-sm update_property_btn mb-3" title="Update Property" data-prop_id="{{$item['id']}}" data-action_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#"><i class="fa fa-pencil"></i></button>
            @if (in_array($item['prop_status'], ['Available']))
              <button type="button" class="btn btn-danger btn-sm delete_btn mb-3" title="Delete Property" data-delete_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#del_property_popup"><i class="fa fa-trash-o"></i> </button>
              <button type="button" class="btn btn-violet btn-sm reservation_btn mb-3" title="Reservation" data-prop_id="{{$item['id']}}" data-action_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#"><i class="fa fa-calendar-check-o"></i> </button>
            @endif
          </td>
        </tr>
      @endforeach
    @endif
    </tbody>
  </table>

  <div class="pagination_links" style="text-align: center;">
    @if (isset($data['records']) && count($data['records'])>0)
      {{ $data['records']->links('vendor.pagination.bootstrap-4') }}
    @else
      <div class="alert alert-primary">Don't have records!</div>
    @endif
  </div>
</div>
