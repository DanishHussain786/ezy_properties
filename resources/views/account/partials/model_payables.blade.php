<div class="receipt">
  @php
    $first_name = 'N/A'; $last_name = 'N/A'; $monthly_rent = 0; $months = 0; $net_total = 0;
  @endphp

  @if ($data->booked_for_user()->exists())
    @php $first_name = $data->booked_for_user->first_name @endphp
    @php $last_name = $data->booked_for_user->last_name @endphp
  @endif

  <div class="guest-details">
    <h4>Guest Details</h4>
    <div class="row">
      <div class="col-xs-3"><strong>Booking Reference Id:</strong></div>
      <div class="col-xs-3">{{$data['booked_id']}}</div>
      <div class="col-xs-3"><strong>Check-in Date:</strong></div>
      <div class="col-xs-3">{{$data['checkin_date']}}</div>
    </div>
    <div class="row">
      <div class="col-xs-3"><strong>Name:</strong></div>
      <div class="col-xs-3">{{$first_name}} {{$last_name}}</div>
      <div class="col-xs-3"><strong>Check-out Date:</strong></div>
      <div class="col-xs-3">{{$data['checkout_date']}}</div>
    </div>
  </div>

  @php $monthly_rent = $data['rent'] @endphp
  @php $months = $data['for_months'] @endphp

  @if ($data['markup_rent'] > 0)
    @php $monthly_rent += $data['markup_rent']; @endphp
  @endif

  <table class="table table-bordered table-styles">
    <thead>
      <tr>
        <th>Description</th>
        <th>Unit</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Monthly Rent ({{$monthly_rent}} AED) </td>
        <td>{{$months}}</td>
        <td>+ {{$monthly_rent * $months}} AED</td>
        @php $net_total += $monthly_rent * $months @endphp
      </tr>
      @if ($data['admin_charges'] > 0)
      <tr>
        <td>Admin Charges ({{$data['admin_charges']}} AED) </td>
        <td>1</td>
        <td>+ {{$data['admin_charges']}} AED</td>
        @php $net_total += $data['admin_charges'] @endphp
      </tr>
      @endif  
      @if ($data['security_charges'] > 0)
      <tr>
        <td>Security Charges ({{$data['security_charges']}} AED) </td>
        <td>1</td>
        <td>+ {{$data['security_charges']}} AED</td>
        @php $net_total += $data['security_charges'] @endphp
      </tr>
      @endif
      @if ($data['disc_rent'] > 0)
      <tr>
        <td>Monthly Rent Discount ({{$data['disc_rent']}} AED) </td>
        <td>{{$months}}</td>
        <td>- {{$data['disc_rent']}} AED</td>
        @php $net_total -= ($data['disc_rent'] * $months) @endphp
      </tr>
      @endif
      <tr>
        <td><strong>Total</strong></td>
        <td><strong></strong></td>
        <td><strong>{{$net_total}} AED</strong></td>
      </tr>
    </tbody>
  </table>
</div>