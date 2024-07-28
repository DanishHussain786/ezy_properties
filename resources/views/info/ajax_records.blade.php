<div class="table-responsive">
  <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
    <thead>
      <tr class="info">
        <th>Sr #</th>
        <th>User Id</th>
        <th>Full Name</th>
        <th>Gender</th>
        <th>Status</th>
        <th>Contact No</th>
        <th>Photo</th>
        <th>Emirates Id</th>
        <th>Passport Id</th>
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
          if ($item['status'] == 'Active')
            $status_class = 'label-custom';
          else if ($item['status'] == 'Block')
            $status_class = 'label-danger';
          if ($data['records']->currentPage()>1) {
            $sr_no = ($data['records']->currentPage()-1)*$data['records']->perPage();
            $sr_no = $sr_no + $key + 1;
          }
        @endphp
        <tr>
          <td>{{ $sr_no }}</td>
          <td>{{ $item['id'] }}</td>
          <td>{{ $item['first_name'] }} {{ $item['last_name'] }}</td>
          <td>{{ $item['gender'] }}</td>
          <td><span class="{{$status_class}} label label-default">{{ $item['status'] }}</span></td>
          <td>{{ $item['contact_no'] }}</td>
          <td>{{ $item['contact_no'] }}</td>
          <td>{{ $item['created_at'] }}</td>
          <td>{{ $item['created_at'] }}</td>
          <td>{{ $item['created_at'] }}</td>
          <td>
            <a href="{{ url($data['route_name'].'/'.$item['id'].'/edit') }}"> <button type="button" class="btn btn-add btn-sm mb-3" title="User Profile" data-toggle="modal" data-target="#"><i class="fa fa-pencil"></i></button></a>
            <a href="{{ url($data['route_name'].'/'.$item['id']) }}"> <button type="button" class="btn btn-info btn-sm mb-3" title="User Profile" data-toggle="modal" data-target="#"><i class="fa fa-user-circle"></i> </button> </a>
            <button type="button" class="btn btn-danger btn-sm mb-3 delete_btn" title="User Profile" data-delete_url="{{ url($data['route_name'].'/'.$item['id'])}}" data-toggle="modal" data-target="#del_user_popup"><i class="fa fa-trash-o"></i> </button>
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