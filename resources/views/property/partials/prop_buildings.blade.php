<div class="form-group col-sm-12 pad-x-5" style="text-align: left;">
  <button class="btn btn-success btn-sm" id="add_prop_units"><i class="fa fa-plus"></i> Add Building Units</button>
</div>
<div class="table">
  <table id="dataTableExample1" class="table table-bordered table-striped table-hover" style="margin: 0px 5px 0px 5px !important;">
    <thead>
      <tr class="info">
        <th>Property Id</th>
        <th>Type</th>
        <th>Ref No. </th>
        <th>Floor</th>
        <th>Rent</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <div class="dynamic_prop_units">
        @if (isset($data['records']) && count($data['records'])>0)
        @foreach ($data['records'] as $key => $item)
        <tr>
          <td>{{ $item['property_id'] }}</td>
          <td>{{ $item['unit_type'] }}</td>
          <td>{{ $item['unit_number'] }}</td>
          <td>{{ $item['unit_floor'] }}</td>
          <td>{{ $item['unit_rent'] }}</td>
          <td>
            <button type="button" class="btn btn-add btn-xs" data-toggle="modal" data-target="#update"><i
                class="fa fa-pencil"></i></button>
            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delt"><i
                class="fa fa-trash-o"></i> </button>
          </td>
        </tr>
        @endforeach
        @endif
      </div>
    </tbody>
  </table>
</div>
