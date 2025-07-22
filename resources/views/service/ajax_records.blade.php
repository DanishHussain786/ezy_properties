<div class="table-responsive">
  <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
    <thead>
      <tr class="info">
        <th>Sr #</th>
        <th>Title</th>
        <th>Description</th>
        <th>Valid Upto</th>
        <th>Type</th>
        <th>Amount</th>
        <th>Created at</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>

    @if (isset($data['records']) && count($data['records'])>0)
      @foreach ($data['records'] as $key => $item)
        @php
          $sr_no = $key + 1;
          if ($data['records']->currentPage()>1) {
            $sr_no = ($data['records']->currentPage()-1)*$data['records']->perPage();
            $sr_no = $sr_no + $key + 1;
          }
        @endphp
        <tr data-module_name="Service" data-row_id="{{ $item['id'] }}">
          <td>{{ $sr_no }}</td>
          <td>{{ $item['title'] }}</td>
          <td>{{ $item['description'] }}</td>
          <td>{{ $item['validity_type'] }}</td>
          <td>{{ $item['type'] }}</td>
          <td>{{ $item['amount'] }}</td>
          <td>{{ $item['created_at'] }}</td>
          <td>
            <button type="button" class="btn btn-add btn-sm update_service_btn mb-3" title="Update Service" data-item_id="{{$item['id']}}" data-action_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#"><i class="fa fa-pencil"></i></button>
            <button type="button" class="btn btn-danger btn-sm delete_sweetalert delete_btn mb-3" title="Delete Service" data-delete_url="{{ url($data['route_name'].'/'.$item['id']) }}"><i class="fa fa-trash-o"></i> </button>
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
