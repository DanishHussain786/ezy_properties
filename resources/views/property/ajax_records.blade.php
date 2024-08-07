<div class="table-responsive">
  <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
    <thead>
      <tr class="info">
        <th>Sr #</th>
        <th>Type</th>
        <th>Property No.</th>
        <th>Floor</th>
        <th>Rent</th>
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
          $label_class = get_label_class($item['status']);
          //if ($item->reservations_data()->exists())
          //  $reservations = true;
          //else
          //  $reservations = false;

          if ($data['records']->currentPage()>1) {
            $sr_no = ($data['records']->currentPage()-1)*$data['records']->perPage();
            $sr_no = $sr_no + $key + 1;
          }
        @endphp
        <tr>
          <td>{{ $sr_no }}</td>
          <td>{{ $item['prop_type'] }}</td>
          <td>{{ isset($item['prop_number']) ? $item['prop_number'] : "N/A" }}</td>
          <td>{{ $item['prop_floor'] }}</td>
          <td>{{ $item['prop_rent'] }}</td>
          <td><span class="{{$label_class}} label label-pill">{{$item['status']}}</span></td>
          <td>
            @if (in_array($item['status'], ['Available']))
              <button type="button" class="btn btn-add btn-sm update_property_btn mb-3" title="Update Property" data-prop_id="{{$item['id']}}" data-action_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#"><i class="fa fa-pencil"></i></button>
              <button type="button" class="btn btn-danger btn-sm delete_btn mb-3" title="Delete Property" data-delete_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#del_property_popup"><i class="fa fa-trash-o"></i> </button>
              <button type="button" class="btn btn-violet btn-sm reservation_btn mb-3" title="Reservation" data-prop_id="{{$item['id']}}" data-action_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#"><i class="fa fa-calendar-check-o"></i> </button>
            @else
              {{'N/A'}}
            @endif
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